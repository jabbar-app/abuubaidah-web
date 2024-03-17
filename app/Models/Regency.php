<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    // Hubungan one-to-many dengan District
    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
