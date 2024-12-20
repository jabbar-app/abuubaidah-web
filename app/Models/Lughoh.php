<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lughoh extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // In Tahsin, Bilhaq, and Tahfiz models
    public function program()
    {
        return $this->morphOne(Program::class, 'programmable');
    }


    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function admin()
    {
        return $this->hasMany(User::class);
    }


    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
