<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'department',
        'factory',
        'content',
        'damage_description',
        'completion_date',
        'priority_level',
        'processing_department',
    
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approveForms()
    {
        return $this->hasMany(ApproveForm::class);
    }

    public function processingForms() 
    {
        return $this->hasMany(ProcessingForm::class);
    }

    
}
