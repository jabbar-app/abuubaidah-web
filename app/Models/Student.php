<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }


    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function lughoh()
    {
        return $this->belongsTo(Lughoh::class, 'lughoh_id'); // Specify the correct foreign key
    }

    public function generateNIM()
    {
        $year = date('y'); // Last two digits of the current year
        $programCode = 1; // Replace with your actual program code
        $semester = now()->month <= 6 ? '1' : '2'; // 1 for odd, 2 for even semester

        // Find the last sequential number used for this program, year, and semester
        $lastStudent = self::where('nim', 'like', "$year$programCode$semester%")
            ->orderBy('nim', 'desc')
            ->first();

        // If there are no previous records, start from 964
        $lastSequentialNumber = $lastStudent ? substr($lastStudent->nim, -5) : '00063';

        // Increment the last sequential number
        $newSequentialNumber = str_pad((int)$lastSequentialNumber + 1, 5, '0', STR_PAD_LEFT);

        return "$year$programCode$semester$newSequentialNumber";
    }

    // private function getSequentialNumber($lughohCode, $year, $semester)
    // {
    //     $lastNim = Student::where('nim', 'like', "{$year}{$lughohCode}%{$semester}")
    //         ->orderBy('nim', 'desc')
    //         ->first()
    //         ->nim ?? "00{$lughohCode}0963"; // Default if no NIM exists yet

    //     $lastSeqNumber = substr($lastNim, 4, 4); // Extract sequential number part
    //     $newSeqNumber = (int)$lastSeqNumber + 1;

    //     return str_pad($newSeqNumber, 4, '0', STR_PAD_LEFT); // Ensure it's 4 digits
    // }
}
