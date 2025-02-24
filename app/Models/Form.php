<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $table = 'forms';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function section() {
        return $this->hasMany(Section::class, 'forms_id', 'id');
    }
}
