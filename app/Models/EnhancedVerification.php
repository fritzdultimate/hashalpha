<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnhancedVerification extends Model
{
    protected $fillable = [
        'user_id',
        'proof_of_funds_document',
        'additional_document',
        'notes',
        'status',
        'admin_note',
        'reviewed_by',
        'reviewed_at',
        'certificate_number',
        'certificate_issued_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'certificate_issued_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
