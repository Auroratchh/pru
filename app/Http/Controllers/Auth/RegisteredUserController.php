<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
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
        $request->validate([
            'nombre'                => ['required', 'string', 'max:255'],
            'apellidoPaterno'       => ['required','string',],
            'fechaNacimiento'       => ['required','date_format:d/m/Y'],
            'idSexo'                => ['required'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password'              => ['required', 'string', 'min:6', 'confirmed']
        ]);

        $fechaNacimiento    = "";
        if(!empty($request->fechaNacimiento)) {
            $fechaNacimiento =  Carbon::CreateFromFormat('d/m/Y', $request->fechaNacimiento);
        }

        $user = User::create([
            'idRol'                 => 2,
            'nombre'                => mb_strtoupper($request->nombre),
            'apellidoPaterno'       => mb_strtoupper($request->apellidoPaterno),
            'apellidoMaterno'       => mb_strtoupper($request->apellidoMaterno),

            'celular'               => $request->celular,
            'idSexo'                => $request->idSexo,
            'fechaNacimiento'       => $fechaNacimiento,
            'email'                 => $request->email,
            'password'              => Hash::make($request->password),
            'passwordVisible'       => $request->password
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
