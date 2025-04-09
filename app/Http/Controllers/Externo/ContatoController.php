<?php

namespace App\Http\Controllers\externo;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContatoRequest;
use App\Mail\ContatoMail;
use App\Models\Contato;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContatoController extends Controller
{
    public function index()
    {
        return view('externo.contato', ['menu' => 'contato']);
    }

    public function store(ContatoRequest $request)
    {
        DB::beginTransaction();

        try {

            $request->validated();

            $contato = Contato::create([
                'ip' => $request->ip(),
                'data_mensagem' => now(),
                'nome' => $request->nome,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'descricao' => $request->descricao,
                'status' => 'Pendente',

            ]);

            DB::commit();

            $emailSistema = session('config')->email_sistema ?? 'vetfacil@hotmail.com';

            Mail::to($emailSistema)->send(new ContatoMail($contato));            

            return redirect()->route('contato.index', ['menu' => 'contato'])->with('success', 'Obrigado por entrar em contato. Sua mensagem foi enviada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withInput()->with('error', 'Mensagem não enviada!');
        }
    }
}
