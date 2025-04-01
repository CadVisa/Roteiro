<?php

namespace App\Http\Controllers\Interno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function index()
    {
        return view('interno.adm.index', ['menu' => 'dashboard']);
    }
}
