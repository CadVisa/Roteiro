<?php

namespace App\Http\Controllers\Externo;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\LogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_login',
            'descricao' => 'Usuário acessou a página de login.',
        ]);

        return view('externo.login');
    }

    public function loginProcess(LoginRequest $request)
    {

        $request->validated();

        $authenticated = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        if (!$authenticated) {

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_login',
                'descricao' => 'Usuário informou as credenciais inválidas.',
                'observacoes' => 'E-mail: ' . $request->email . ' | Senha: ' . $request->password . ' | IP: ' . $request->ip(),
            ]);

            return back()->withInput()->with('error', 'E-mail ou senha inválido!');
        }

        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_login',
            'descricao' => 'Usuário logado com sucesso.',
        ]);

        return redirect()->route('administrador.index');
    }

    public function destroy()
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_logout',
            'descricao' => 'Usuário deslogado com sucesso.',
        ]);

        Session::flush();
        Auth::logout();

        return redirect()->route('home');
    }
}
