<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Registration extends Model
{
    use HasFactory;

    /**
     * Proteksi Mass Assignment ($fillable)
     * Hanya kolom di bawah ini yang boleh diisi secara massal lewat Registration::create()
     */
    protected $fillable = [
        'full_name',
        'identity_number',
        'gender',
        'pob',
        'dob',
        'address',
        'community',
        'whatsapp_number',
        'email',
        'instagram_handle',
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
    ];

    /**
     * Casting tipe data otomatis
     */
    protected $casts = [
        'dob' => 'date',
        'paid_at' => 'datetime',
        'gross_amount' => 'integer'
    ];

    /// Const Total Kuota Event
    public const MAX_QUOTA = 300;

    /**
     * Accessor: Hitung Usia Otomatis dari DOB
     */
    public function getAgeAttribute(): int
    {
        return Carbon::parse($this->dob)->age;
    }

    /**
     * Scope: Hitung Pendaftar Lunas (Paid)
     */
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