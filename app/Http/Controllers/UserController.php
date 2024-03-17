<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Regency;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        return view('admin.users.show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
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

        return view('admin.users.edit', compact('user', 'provinceName', 'regencyName', 'regencyId', 'districtName', 'districtId', 'provinces', 'regencies', 'districts'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|nullable|string|min:8',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'phone' => 'required|numeric',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'status_perkawinan' => 'required|string',
            'suku' => 'required|string|max:255',
        ]);

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $validatedData['address'] = json_encode([
            'address' => $request->address,
            'province' => $request->province,
            'regency' => $request->regency,
            'district' => $request->district
        ]);
        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
