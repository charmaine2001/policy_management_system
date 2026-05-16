<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'standard_price',
        'premium_price',
        'default_terms',
    ];

    public function policies()
    {
        return $this->hasMany(Policy::class);
    }
}
