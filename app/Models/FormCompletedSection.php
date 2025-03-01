<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormCompletedSection extends Model
{
    use HasFactory;
    protected $table = 'form_completed_sections';
    protected $guarded = [];

    public function form() 
    {
        return $this->belongsTo(FormCompleted::class, 'form_completed_id', 'id');    
    }
}
