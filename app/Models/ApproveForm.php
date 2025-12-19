<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApproveForm extends Model
{
    protected $fillable = ['form_id', 'manager_id', 'status', 'note','role'];

    public function form() {
        return $this->belongsTo(Form::class);
    }

    public function manager() {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
