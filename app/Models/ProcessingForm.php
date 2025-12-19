<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessingForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id', 'user_id', 'status', 'note'
    ];

    public function form() {
        return $this->belongsTo(Form::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
