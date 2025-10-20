<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $fillable = ['user_id', 'titulo', 'contenido'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}
