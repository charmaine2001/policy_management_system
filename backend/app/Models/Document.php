<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'policy_id',
        'file_path',
        'file_name',
        'file_type',
    ];

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }
}
