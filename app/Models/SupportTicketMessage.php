<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicketMessage extends Model {
    protected $guarded = [];
    protected $casts = ['meta'=>'array'];

    public function ticket() {
        return $this->belongsTo(SupportTicket::class);
    }
}
