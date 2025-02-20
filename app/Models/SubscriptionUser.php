<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionUser extends Model
{
    use HasFactory;
    protected $table = 'subscription_users';
    protected $fillable = ['users_id', 'subscriptions_id', 'limit', 'used'];

    public function user() 
    {
        return $this->belongsTo(User::class, 'users_id', 'id');     
    }
}
