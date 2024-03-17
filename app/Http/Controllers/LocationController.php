<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // Fungsi untuk mengembalikan semua provinsi
    public function getProvinces()
    {
        $provinces = Province::all();
        return response()->json($provinces);
    }

    // Fungsi untuk mengembalikan kabupaten/kota berdasarkan ID provinsi
    public function getRegencies($provinceId)
    {
        $regencies = Regency::where('province_id', $provinceId)->get();
        return response()->json($regencies);
    }

    // Fungsi untuk mengembalikan kecamatan berdasarkan ID kabupaten/kota
    public function getDistricts($regencyId)
    {
        $districts = District::where('regency_id', $regencyId)->get();
        return response()->json($districts);
    }
}
