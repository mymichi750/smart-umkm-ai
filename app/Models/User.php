<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'premium_level',
        'premium_pending_level',
        'premium_proof_path',
        'trial_ends_at',
        'store_id',
        'phone',
        'is_premium',
        'bank_name',
        'bank_account',
        'bank_account_name',
        'qris_image',
        'qris_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'premium_level'     => 'integer',
            'trial_ends_at'     => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /** Apakah user sedang dalam masa trial aktif. */
    public function isOnTrial(): bool
    {
        return $this->trial_ends_at !== null && $this->trial_ends_at->isFuture();
    }

    /** Apakah user boleh mengakses fitur AI (trial aktif ATAU premium >= 2). */
    public function canUseAi(): bool
    {
        return $this->isOnTrial() || ($this->premium_level ?? 1) >= 2;
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
    public function customerCashierTokens()
    {
        return $this->hasMany(CustomerCashierToken::class);
    }
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
