<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Regency;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function roleManagement($userId)
    {
        $user = User::find($userId);
        $roles = Role::all()->pluck('name');

        return view('admin.users.role-management', compact('user', 'roles'));
    }

    public function assignRole(Request $request, User $user)
    {
        $roleName = $request->role;
        $role = Role::findByName($roleName); // Ensure role exists
        $user->assignRole($role);
        return back()->with('success', 'Role assigned successfully.');
    }

    public function removeRole(User $user, $roleName)
    {
        $user->removeRole($roleName);
        return back()->with('success', 'Role removed successfully.');
    }

    public function index()
    {
        return view('admin.users.index', [
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|numeric|unique:users,nik', // Assuming 'nik' is unique
            'email' => 'required|email|unique:users,email', // Ensures email is unique in the users table
            'password' => 'required|string|min:8',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'phone' => 'required|numeric',
            'religion' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'status_perkawinan' => 'required|string',
            'suku' => 'required|string',
        ]);

        $validatedData['address'] = json_encode([
            'address' => $request->address,
            'province' => $request->province,
            'regency' => $request->regency,
            'district' => $request->district
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']); // Encrypt password

        User::create($validatedData);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $province = Province::find($user->province);
        $regency = Regency::find($user->regency);
        $district = District::find($user->district);

        // dd($province);

        return view('admin.users.show', [
            'user' => $user,
            'programs' => Kelas::where('user_id', $user->id)->get(),
            'payments' => Payment::where('user_id', $user->id)->get(),
            'provinceName' => $province->name ?? '-',
            'regencyName' => $regency->name ?? '-',
            'districtName' => $district->name ?? '-',
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $address = json_decode($user->address, true);

        // dd($user->province, $address);
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
        } else {
            $province = Province::find($user->province);
        }

        $provinceName = $province ? $province->name : null;
        if ($province) {
            $regencies = Regency::where('province_id', $province->id)->get();
        }

        if (isset($address['regency']) && !is_null($address['regency'])) {
            $regency = Regency::where('id', $address['regency'])->first();
        } else {
            $regency = Regency::where('id', $user->regency)->first();
        }

        $regencyId = $regency ? $regency->id : null;
        $regencyName = $regency ? $regency->name : null;
        if ($regency) {
            $districts = District::where('regency_id', $regency->id)->get();
        }

        if (isset($address['district']) && !is_null($address['district'])) {
            $district = District::where('id', $address['district'])->first();
        } else {
            $district = District::where('id', $user->district)->first();
        }

        $districtId = $district ? $district->id : null;
        $districtName = $district ? $district->name : null;

        return view('admin.users.edit', compact('user', 'provinceName', 'regencyName', 'regencyId', 'districtName', 'districtId', 'provinces', 'regencies', 'districts'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate unique fields
        $request->validate([
            'phone' => 'required|numeric|unique:users,phone,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        // Handle file uploads
        $this->handleFileUpload($request, $user, 'url_pas_foto', 'profile-photos');
        $this->handleFileUpload($request, $user, 'url_ktp', 'upload-image');
        $this->handleFileUpload($request, $user, 'url_kk', 'upload-image');
        $this->handleFileUpload($request, $user, 'url_ijazah', 'upload-image');
        $this->handleFileUpload($request, $user, 'url_bilhaq', 'upload-image');

        // Prepare data for update
        $updateData = $this->prepareUpdateData($request);

        // Update password if provided
        if (!empty($request->password)) {
            $updateData['password'] = bcrypt($request->password);
        }

        // Update user data
        $user->update($updateData);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
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

    public function generatePDF($id)
    {
        $user = User::findOrFail($id);
        $province = Province::find($user->province);
        $regency = Regency::find($user->regency);
        $district = District::find($user->district);

        $pdf = FacadePdf::loadView('admin.exports.user', [
            'user' => $user,
            'programs' => Kelas::where('user_id', $user->id)->get(),
            'payments' => Payment::where('user_id', $user->id)->get(),
            'provinceName' => $province->name ?? '-',
            'regencyName' => $regency->name ?? '-',
            'districtName' => $district->name ?? '-',
        ]);

        return $pdf->download('user_data.pdf');
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



    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
