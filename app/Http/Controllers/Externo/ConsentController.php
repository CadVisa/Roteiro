<?php

namespace App\Http\Controllers\externo;

use App\Http\Controllers\Controller;
use App\Models\Consent;
use Illuminate\Http\Request;

class ConsentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'token' => 'nullable|string|max:255',
            'accepted' => 'required|boolean',
        ]);

        Consent::create([
            'token'       => $data['token'],
            'ip'          => $request->ip(),
            'user_agent'  => $request->userAgent(),
            'accepted'    => $data['accepted'],
        ]);

        return response()->json(['status' => 'ok']);
    }
}
