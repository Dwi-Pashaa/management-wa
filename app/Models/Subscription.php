<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $table = 'subscriptions';
    protected $fillable = ['title', 'slug', 'limit'];

    public function subscribtionUser() 
    {
        return $this->hasMany(SubscriptionUser::class, 'subscriptions_id', 'id');     
    }
}
