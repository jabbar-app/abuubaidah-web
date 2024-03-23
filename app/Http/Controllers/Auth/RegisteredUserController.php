<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|numeric|unique:users,nik', // Assuming 'nik' is unique
            'email' => 'required|email|unique:users,email', // Ensures email is unique in the users table
            'password' => 'required|string|min:8',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'phone' => 'required|numeric|unique:users,phone',
            'religion' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'status_perkawinan' => 'required|string',
            'suku' => 'required|string',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone.unique' => 'No. WhatsApp sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'phone.required' => 'No. WhatsApp wajib diisi.',
            'religion.required' => 'Agama wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'status_perkawinan.required' => 'Status perkawinan wajib diisi.',
            'suku.required' => 'Suku wajib diisi.',
            'validation.min.string'=> 'Password harus minimal 8 karakter.',
            // Add more custom messages as needed
        ]);

        $validatedData['address'] = json_encode([
            'address' => $request->address,
            'province' => $request->province,
            'regency' => $request->regency,
            'district' => $request->district
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']); // Encrypt password

        $user = User::create($validatedData);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
