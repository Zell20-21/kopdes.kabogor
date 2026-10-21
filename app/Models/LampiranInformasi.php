<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LampiranInformasi extends Model
{
    use HasFactory;

    protected $table = 'app_lampiran_informasi';

    protected $fillable = [
        'judul',
        'keterangan',
        'file_name',
        'file_path',
        'file_size',
        'file_type',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Scope query to only active attachments.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Get URL to view / download the file.
     */
    public function getUrlAttribute(): string
    {
        return route('informasi.file', $this->file_path);
    }
}
