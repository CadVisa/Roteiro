<?php

namespace App\Http\Controllers\Externo;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        return view('externo.login');
    }

    public function loginProcess(LoginRequest $request)
    {

        $request->validated();

        $authenticated = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        if (!$authenticated) {

            return back()->withInput()->with('error', 'E-mail ou senha inválido!');
        }

        return redirect()->route('administrador.index');
    }

    public function destroy()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('home');
    }
}
