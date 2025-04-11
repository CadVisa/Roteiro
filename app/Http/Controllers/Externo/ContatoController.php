<?php

namespace App\Http\Controllers\externo;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContatoRequest;
use App\Mail\ContatoMail;
use App\Models\Contato;
use App\Services\LogService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ContatoController extends Controller
{
    public function index()
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_contato',
            'descricao' => 'Usuário acessou a página de contato.',
        ]);
        
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

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_contato',
                'descricao' => 'Usuário enviou uma mensagem de contato.',
                'observacoes' => 'Nome: ' . $request->nome . ' | E-mail: ' . $request->email . ' | Mensagem: ' . $request->descricao,
            ]);

            $emailSistema = session('config')->email_sistema ?? 'vetfacil@hotmail.com';

            Mail::to($emailSistema)->send(new ContatoMail($contato));            

            return redirect()->route('contato.index', ['menu' => 'contato'])->with('success', 'Obrigado por entrar em contato! Sua mensagem foi enviada com sucesso!');

        } catch (Exception $e) {
            DB::rollBack();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_contato',
                'descricao' => 'Erro ao enviar mensagem de contato.',
                'observacoes' => 'Nome: ' . $request->nome . ' | E-mail: ' . $request->email . ' | Mensagem: ' . $request->descricao .' | Erro: ' . $e->getMessage(),
            ]);
            
            return back()->withInput()->with('error', 'Mensagem não enviada!');
        }
    }
}
