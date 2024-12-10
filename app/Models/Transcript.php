<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transcript extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        switch ($this->mustawa) {
            case 'Robi':
                return $this->belongsTo(MustawaRobi::class, 'course_id');
            case 'Tamhidy':
                return $this->belongsTo(MustawaTamhidy::class, 'course_id');
            case 'Awwal':
                return $this->belongsTo(MustawaAwwal::class, 'course_id');
            case 'Tsani':
                return $this->belongsTo(MustawaTsani::class, 'course_id');
            case 'Tsalits':
                return $this->belongsTo(MustawaTsalits::class, 'course_id');
            default:
                return null;
        }
    }
}
