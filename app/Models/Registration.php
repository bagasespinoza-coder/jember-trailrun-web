<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'identity_number',
        'gender',
        'pob',
        'dob',
        'usia',
        'address',
        'community',
        'whatsapp_number',
        'email',
        'instagram_handle',
        
        // --- TAMBAHKAN 2 BARIS INI ---
        'bib_name',
        'bib_number',

        'category',
        'jersey_size',
        'blood_type',
        'medical_history',
        'emergency_contact_name',
        'emergency_contact_relation',
        'emergency_contact_phone',
        'order_id',
        'payment_status', 
        'snap_token',
        'gross_amount',
        'paid_at',
        'payment_proof',
    ];

    protected $casts = [
        'dob' => 'date',
        'paid_at' => 'datetime',
        'gross_amount' => 'integer',
    ];

    public const MAX_QUOTA = 300;

    public function getAgeAttribute(): int
    {
        return $this->dob ? $this->dob->age : 0;
    }

    public static function paidCount(): int
    {
        return static::where('payment_status', 'paid')->count();
    }

    public static function remainingQuota(): int
    {
        return max(0, self::MAX_QUOTA - static::paidCount());
    }

    public static function isQuotaFull(): bool
    {
        return static::paidCount() >= self::MAX_QUOTA;
    }
}