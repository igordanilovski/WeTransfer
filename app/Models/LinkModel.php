<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LinkModel extends Model
{
    use HasFactory;

    protected $table = 'links';
    protected $primaryKey = 'id';

    protected $fillable = [
        'slug',
        'opened_at'
    ];

    public function files(): HasMany
    {
        return $this->hasMany(FileModel::class, 'link_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
