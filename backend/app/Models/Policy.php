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

    public function policyType()
    {
        return $this->belongsTo(PolicyType::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
