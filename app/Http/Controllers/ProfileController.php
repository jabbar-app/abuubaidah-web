<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Regency;
use App\Models\District;
use App\Models\Province;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
  /**
   * Display the user's profile form.
   */
  public function edit(Request $request): View
  {
    $user = $request->user();
    $address = json_decode($user->address, true);
    $provinces = Province::all();
    $regencies = collect(); // Initialize an empty collection
    $districts = collect(); // Initialize an empty collection

    $provinceName = null;
    $regencyName = null;
    $districtName = null;
    $regencyId = null; // Initialize $regencyId
    $districtId = null; // Initialize $districtId

    if (isset($address['province']) && !is_null($address['province'])) {
      $province = Province::find($address['province']);
      $provinceName = $province ? $province->name : null;

      // If province is found, load its regencies
      if ($province) {
        $regencies = Regency::where('province_id', $province->id)->get();
      }
    }

    if (isset($address['regency']) && !is_null($address['regency'])) {
      $regency = Regency::where('id', $address['regency'])->first(); // Assuming $address['regency'] contains the id
      $regencyId = $regency ? $regency->id : null;
      $regencyName = $regency ? $regency->name : null;

      // If regency is found, load its districts
      if ($regency) {
        $districts = District::where('regency_id', $regency->id)->get();
      }
    }

    if (isset($address['district']) && !is_null($address['district'])) {
      $district = District::where('id', $address['district'])->first(); // Assuming $address['district'] contains the id
      $districtId = $district ? $district->id : null;
      $districtName = $district ? $district->name : null;
    }

    // dd($regencyId);

    return view('profile.edit', [
      'user' => $user,
      'provinceName' => $provinceName,
      'regencyName' => $regencyName,
      'regencyId' => $regencyId,
      'districtName' => $districtName,
      'districtId' => $districtId,
      'provinces' => $provinces,
      'regencies' => $regencies,
      'districts' => $districts,
    ]);
  }

  /**
   * Update the user's profile information.
   */
  // public function update(ProfileUpdateRequest $request): RedirectResponse
  // {
  //     $request->user()->fill($request->validated());

  //     if ($request->user()->isDirty('email')) {
  //         $request->user()->email_verified_at = null;
  //     }

  //     $request->user()->save();

  //     return Redirect::route('profile.edit')->with('status', 'Data profil berhasil diperbaharui!');
  // }

  public function update(Request $request)
  {
    $user = auth()->user();
    $ktp = '';
    $kk = '';
    $ijazah = '';
    $bilhaq = '';

    if ($request->hasFile('url_pas_foto')) {
      $request->validate([
        'url_pas_foto' => 'image|mimes:jpeg,png,jpg|max:2048', // Add validation rules for the profile photo
      ]);

      // Handle the profile photo upload
      $profilePhotoPath = $request->file('url_pas_foto')->store('profile-photos', 'public');

      // Delete old profile photo if exists
      if ($user->url_pas_foto) {
        Storage::disk('public')->delete($user->url_pas_foto);
      }

      // Update the user's profile photo
      $user->url_pas_foto = $profilePhotoPath;
      $user->update(['url_pas_foto' => $user->url_pas_foto]);
    }

    if ($request->hasFile('url_ktp')) {
      $ktp = $request->file('url_ktp')->store('upload-image', 'public');
      if ($user->url_ktp) {
        Storage::disk('public')->delete($user->url_ktp);
      }

      $user->update([
        'url_ktp' => $ktp,
      ]);
    } elseif ($request->hasFile('url_kk')) {
      $kk = $request->file('url_kk')->store('upload-image', 'public');
      if ($user->url_kk) {
        Storage::disk('public')->delete($user->url_kk);
      }

      $user->update([
        'url_kk' => $kk,
      ]);
    } elseif ($request->hasFile('url_ijazah')) {
      $ijazah = $request->file('url_ijazah')->store('upload-image', 'public');
      if ($user->url_ijazah) {
        Storage::disk('public')->delete($user->url_ijazah);
      }

      $user->update([
        'url_ijazah' => $ijazah,
      ]);
    } elseif ($request->hasFile('url_bilhaq')) {
      $bilhaq = $request->file('url_bilhaq')->store('upload-image', 'public');
      if ($user->url_bilhaq) {
        Storage::disk('public')->delete($user->url_bilhaq);
      }

      $user->update([
        'url_bilhaq' => $bilhaq,
      ]);
    } else {
      $user->update([
        'name' => $request->name,
        'nik' => $request->nik,
        'email' => $request->email,
        'phone' => $request->phone,
        'tempat_lahir' => $request->tempat_lahir,
        'tanggal_lahir' => $request->tanggal_lahir,
        'status_perkawinan' => $request->status_perkawinan,
        'agama' => $request->agama,
        'suku' => $request->suku,
        'address' => $request->address,
        'province' => $request->province,
        'regency' => $request->regency,
        'district' => $request->district,
        'ukuran_almamater' => $request->ukuran_almamater,
        'nama_sd' => $request->nama_sd,
        'lulus_sd' => $request->lulus_sd,
        'nama_smp' => $request->nama_smp,
        'lulus_smp' => $request->lulus_smp,
        'nama_sma' => $request->nama_sma,
        'lulus_sma' => $request->lulus_sma,
        'perguruan_tinggi' => $request->perguruan_tinggi,
        'status_ayah' => $request->status_ayah,
        'nama_ayah' => $request->nama_ayah,
        'pekerjaan_ayah' => $request->pekerjaan_ayah,
        'penghasilan_ayah' => $request->penghasilan_ayah,
        'telp_ayah' => $request->telp_ayah,
        'status_ibu' => $request->status_ibu,
        'nama_ibu' => $request->nama_ibu,
        'pekerjaan_ibu' => $request->pekerjaan_ibu,
        'penghasilan_ibu' => $request->penghasilan_ibu,
        'telp_ibu' => $request->telp_ibu,
        'url_ktp' => $ktp,
        'url_kk' => $kk,
        'url_ijazah' => $ijazah,
        'url_bilhaq' => $bilhaq,
      ]);
    }

    return redirect()->back()->with('success', 'Profile updated successfully!');
  }

  /**
   * Delete the user's account.
   */
  public function destroy(Request $request): RedirectResponse
  {
    $request->validateWithBag('userDeletion', [
      'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();

    Auth::logout();

    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return Redirect::to('/');
  }
}
