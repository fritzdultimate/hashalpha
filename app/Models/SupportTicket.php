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
        'meta',
        'ticket_number'
    ];
    protected $casts = ['meta'=>'array'];
}
