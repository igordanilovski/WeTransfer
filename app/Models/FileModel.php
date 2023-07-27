<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileModel extends Model
{
    use HasFactory;

    protected $table = 'files';
    protected $primaryKey = 'id';

    protected $fillable = [
        'original_name',
        'hashed_name',
        'slug',
        'folder',
        'extension',
    ];

    public function link(): BelongsTo
    {
        return $this->belongsTo(LinkModel::class);
    }
}
