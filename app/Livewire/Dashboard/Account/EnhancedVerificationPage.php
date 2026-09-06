<?php

namespace App\Livewire\Dashboard\Account;

use App\Mail\EnhancedVerificationSubmittedMail;
use App\Models\CustomSetting;
use App\Models\EnhancedVerification;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class EnhancedVerificationPage extends Component
{
    use WithFileUploads;

    public $proof_of_funds_document;
    public $additional_document;
    public $notes;
    public $loading = false;

    public function getThresholdProperty()
    {
        return (float) CustomSetting::get('enhanced_verification_threshold', 5000);
    }

    public function submit()
    {
        $this->validate([
            'proof_of_funds_document' => 'required|file|max:8192',
            'additional_document' => 'nullable|file|max:8192',
            'notes' => 'nullable|string|max:2000',
        ]);
        $this->resetErrorBag();

        $existing = auth()->user()->enhancedVerification;
        abort_if($existing && $existing->status !== 'rejected', 403);

        $verification = EnhancedVerification::create([
            'user_id' => auth()->id(),
            'proof_of_funds_document' => $this->proof_of_funds_document->store('enhanced-verification', 'local'),
            'additional_document' => $this->additional_document?->store('enhanced-verification', 'local'),
            'notes' => $this->notes,
            'status' => 'pending',
        ]);

        if ($verification) {
            auth()->user()->update([
                'enhanced_verification_status' => 'pending',
                'enhanced_verification_submitted_at' => now(),
            ]);
            auth()->user()->refresh();

            session()->flash('success', 'Your documents are under review. We\'ll notify you once a decision is made.');

            $this->reset(['proof_of_funds_document', 'additional_document', 'notes']);

            Mail::to(auth()->user()->email)->send(new EnhancedVerificationSubmittedMail(auth()->user()));
        }
    }

    protected function messages()
    {
        return [
            'proof_of_funds_document.required' => 'Please upload a proof-of-funds document.',
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.account.enhanced-verification', [
            'verification' => auth()->user()->enhancedVerification,
        ]);
    }
}
