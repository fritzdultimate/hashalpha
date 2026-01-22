<?php

namespace App\Livewire\Dashboard\Account;

use App\Mail\KycSubmittedMail;
use App\Models\KycVerification;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class Kyc extends Component
{
    use WithFileUploads;

    public $address, $country, $date_of_birth;
    public $document_type = 'passport';
    public $document_front, $document_back;
    public $loading = false;

    public function submit() {
        $this->validate([
            'address' => 'required|string|max:255|min:6',
            'country' => 'required|string',
            'date_of_birth' => 'required|date',
            'document_type' => 'required',
            'document_front' => 'required|image|max:4096',
        ]);
        $this->resetErrorBag();

        abort_if(auth()->user()->kyc && auth()->user()->kyc->status != 'rejected', 403);

        $kyc = KycVerification::create([
            'user_id' => auth()->id(),
            'address' => $this->address,
            'country' => $this->country,
            'date_of_birth' => $this->date_of_birth,
            'document_type' => $this->document_type,
            'document_front' => $this->document_front->store('kyc', 'local'),
            'document_back' => $this->document_back?->store('kyc', 'local'),
            'status' => 'pending',
        ]);

        if($kyc) {
            auth()->user()->update([
                'kyc_status' => 'pending',
                'kyc_submitted_at' => now()
            ]);
            auth()->user()->refresh();
            session()->flash('success', 'KYC submitted successfully.');

            $this->reset([
                'address',
                'country',
                'date_of_birth',
                'document_front',
                'document_type',
                'document_back'
            ]);

            Mail::to(auth()->user()->email)->send(new KycSubmittedMail(auth()->user()));
        }
    }

    protected function messages() {
        return [
            'address.required' => 'Please provide your full address.',
            'address.min' => 'Please provide your full address.',
            'country.required' => 'Please specify your country of residence.',
            'date_of_birth.required' => 'Your date of birth is required for verification.',
            'document_front.required' => 'Please upload the front image of your identification document.',
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.account.kyc', [
            'kyc' => auth()->user()->kyc
        ]);
    }
}
