<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormCompleted extends Model
{
    use HasFactory;
    protected $table = 'form_completeds';
    protected $guarded = [];

    public function section() 
    {
        return $this->hasMany(FormCompletedSection::class, 'form_completed_id', 'id');    
    }
}
