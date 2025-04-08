<?php

namespace App\Http\Controllers\externo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContatoController extends Controller
{
    public function index()
    {
        return view('externo.contato', ['menu' => 'contato']);
    }
}
