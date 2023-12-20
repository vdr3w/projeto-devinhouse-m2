<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory, SoftDeletes;

        protected $fillable = [
        'name',
        'email',
        'date_birth',
        'cpf',
        'contact',
        'user_id',
        'city',
        'neighborhood',
        'number',
        'street',
        'state',
        'cep'
    ];

        protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

        public function workouts()
    {
        return $this->belongsTo(Workout::class);
    }
}