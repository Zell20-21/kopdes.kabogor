<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'app_md_user';

    protected $primaryKey = 'id_user';

    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
        'pswd',
    ];

    public function getAuthIdentifierName(): string
    {
        return 'id_user';
    }

    public function getAuthPasswordName(): string
    {
        return 'pswd';
    }

    public function getAuthPassword(): string
    {
        return (string) ($this->pswd ?? '');
    }

    public function getNameAttribute(): string
    {
        return (string) ($this->name_user ?? $this->login_user ?? 'User');
    }

    public function getEmailAttribute(): ?string
    {
        return $this->email_user ?? ($this->login_user.'@kdkmp.bogor.go.id');
    }

    public function isSuperAdmin(): bool
    {
        return in_array($this->level_user, [1, 2, 12, 13]);
    }

    public function isOperatorKecamatan(): bool
    {
        return $this->level_user == 14;
    }

    public function isOperatorDesa(): bool
    {
        return $this->level_user == 15;
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->level_user) {
            1, 2 => 'Administrator',
            12 => 'Admin KOP Kabupaten Bogor',
            13 => 'Desk KOP Kabupaten Bogor',
            14 => 'Operator Koperasi Kecamatan',
            15 => 'Operator Koperasi Desa/Kelurahan',
            default => 'Pengguna KMP',
        };
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'id_company', 'id_kopkec');
    }

    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class, 'id_branch', 'id_kopkel');
    }

    public function koperasi(): HasOne
    {
        return $this->hasOne(Koperasi::class, 'id_kel', 'id_branch');
    }
}
