<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'user_id'];

    protected $hidden = ['updated_at'];

    // Relacionamento com User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}