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
        session(['previous_url' => url()->previous()]);

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

        // Handle file uploads
        $this->handleFileUpload($request, $user, 'url_pas_foto', 'profile-photos');
        $this->handleFileUpload($request, $user, 'url_ktp', 'upload-image');
        $this->handleFileUpload($request, $user, 'url_kk', 'upload-image');
        $this->handleFileUpload($request, $user, 'url_ijazah', 'upload-image');
        $this->handleFileUpload($request, $user, 'url_bilhaq', 'upload-image');

        // Prepare data for update
        $updateData = $this->prepareUpdateData($request);

        // Update user data
        $user->update($updateData);

        return redirect(session('previous_url', '/dashboard'))->with('success', 'Profile updated successfully!');
    }

    protected function handleFileUpload($request, $user, $fieldName, $storagePath)
    {
        if ($request->hasFile($fieldName)) {
            $request->validate([$fieldName => 'image|mimes:jpeg,png,jpg|max:2048']);

            // Get the file from the request
            $file = $request->file($fieldName);

            // Define the file's destination path
            $destinationPath = public_path($storagePath);

            // Create the directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }

            // Generate a unique file name
            $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Move the file to the public directory
            $file->move($destinationPath, $fileName);

            // Define the file path relative to the public directory
            $filePath = $storagePath . '/' . $fileName;

            // Delete old file if it exists
            if (!empty($user->$fieldName) && file_exists(public_path($user->$fieldName))) {
                unlink(public_path($user->$fieldName));
            }

            // Update the user's field with the new file path
            $user->update([$fieldName => $filePath]);
        }
    }


    protected function prepareUpdateData($request)
    {
        $fields = [
            'nik', 'phone', 'email', 'name', 'tempat_lahir', 'tanggal_lahir',
            'status_perkawinan', 'agama', 'suku', 'address', 'province', 'regency',
            'district', 'ukuran_almamater', 'nama_sd', 'lulus_sd', 'nama_smp',
            'lulus_smp', 'nama_sma', 'lulus_sma', 'perguruan_tinggi', 'status_ayah',
            'nama_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'telp_ayah',
            'status_ibu', 'nama_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'telp_ibu',
        ];

        $updateData = [];

        foreach ($fields as $field) {
            if (!empty($request->$field)) {
                $updateData[$field] = $request->$field;
            }
        }

        return $updateData;
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
