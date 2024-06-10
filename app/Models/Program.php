<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // In Program model
    public function programmable()
    {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class);
    }


    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function help()
    {
        return $this->hasMany(Help::class);
    }

    public function student()
    {
        return $this->hasMany(Student::class);
    }

    public function course()
    {
        return $this->hasMany(Course::class);
    }
}
