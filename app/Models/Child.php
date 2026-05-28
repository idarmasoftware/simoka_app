<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Child extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'therapis_id',
        'nama_lengkap',
        'tanggal_lahir',
        'jenis_kelamin',
        'catatan_medis',
        'is_active',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function therapis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'therapis_id');
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
