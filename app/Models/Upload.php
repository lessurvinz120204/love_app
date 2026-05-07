<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = [
        'type',
        'title',
        'content',
        'file_path',
        'original_name',
    ];
}