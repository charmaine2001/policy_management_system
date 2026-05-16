<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Policy extends Model
{
    use HasFactory;

    protected $fillable = [
        'policy_number',
        'user_id',
        'policy_type_id',
        'plan_type',
        'final_price',
        'start_date',
        'renewal_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->user();
    }

    public function type()
    {
        return $this->belongsTo(PolicyType::class, 'policy_type_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
