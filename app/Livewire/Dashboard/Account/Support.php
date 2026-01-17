<?php

namespace App\Livewire\Dashboard\Account;

use App\Models\SupportTicket;
use App\Models\SupportTicketMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Support extends Component {
    public $category = 'general';
    public $subject, $message;


    public function submit() {
        $this->validate([
            'subject'  => 'required|string|max:255',
            'message'  => 'required|string|min:10',
            'category' => 'required|in:general,wallet,withdrawal,security',
        ]);

        DB::transaction(function () {

            $ticket = SupportTicket::create([
                'user_id' => auth()->id(),
                'ticket_number' => $this->generateTicketNumber(),
                'subject' => $this->subject,
                'description' => $this->message,
                'status' => 'open',
                'priority' => 'medium',
            ]);

            SupportTicketMessage::create([
                'support_ticket_id' => $ticket->id,
                'user_id' => auth()->id(),
                'message' => $this->message,
                'is_staff' => false,
            ]);
        });

        $this->reset(['subject', 'message', 'category']);

        $this->dispatch('toast', payload:[
            'type' => 'success',
            'message' => 'Support ticket submitted successfully.',
        ]);


        // create ticket
    }

    protected function generateTicketNumber(): string {
        return 'TKT-' . now()->format('Y') . '-' . strtoupper(Str::random(6));
    }

    public function confirmSubmit() {
        $this->dispatch('confirm-support-submit');
    }


    public function render(){
        $tickets = SupportTicket::where('user_id', auth()->id())
            ->latest()
            ->get();
        return view('livewire.dashboard.account.support', [
            'tickets' => $tickets,
        ]);
    }
}