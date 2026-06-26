<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        return view('login');
    }

    public function mostrarRegistro()
    {
        return view('register');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'nombres'   => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'telefono'  => 'nullable|string|max:20',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
        ]);

        $user = User::create([
            'name'         => trim($request->nombres . ' ' . $request->apellidos),
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'tipo_usuario' => 'paciente',
            'telefono'     => $request->telefono,
        ]);

        Auth::login($user);

        return redirect()->route('paciente.home');
    }

    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();

            $usuario = Auth::user();

            if ($usuario->tipo_usuario === 'administrador') {
                return redirect()->route('admin.home');
            }

            if ($usuario->tipo_usuario === 'medico') {
                return redirect()->route('medico.home');
            }

            return redirect()->route('paciente.home');
        }

        return back()->withErrors([
            'email' => 'El correo o la contraseña no son correctos.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
