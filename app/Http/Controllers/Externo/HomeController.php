<?php

namespace App\Http\Controllers\Externo;

use App\Http\Controllers\Controller;
use App\Models\EstabelecimentoAcesso;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $ip = Request::ip();
        $hoje = Carbon::today();

        EstabelecimentoAcesso::firstOrCreate([
            'ip' => $ip,
            'data' => $hoje
        ]);

        $acessos = EstabelecimentoAcesso::where('ip', $ip)->count();

        return view('externo.index', ['menu' => 'home', 'acessos' => $acessos]);
    }

    public function politicaPrivacidade()
    {
        return view('externo.politica_privacidade', ['menu' => 'home']);
    }

    public function termosUso()
    {
        return view('externo.termos_uso', ['menu' => 'home']);
    }
}
