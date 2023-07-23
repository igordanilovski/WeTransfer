<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'opened_at'
    ];
}
