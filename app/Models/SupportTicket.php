<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model {
    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'type',
        'priority',
        'status',
        'description',
        'closed_at',
        'ticket_number'
    ];
    protected $casts = ['meta'=>'array'];

    public function messages() {
        return $this->hasMany(SupportTicketMessage::class);
    }
}
