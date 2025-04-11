<?php

namespace App\Http\Controllers\interno;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contato;
use App\Services\LogService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ContactsController extends Controller
{
    public function index(Request $request)
    {
        $data_pesquisa = $request->data_pesquisa;
        $nome_pesquisa = $request->nome_pesquisa;
        $ip_pesquisa = $request->ip_pesquisa;
        $status_pesquisa = $request->status_pesquisa;

        $query = Contato::orderByDesc('id');

        if ($data_pesquisa) {
            $query->whereDate('data_mensagem', Carbon::parse($data_pesquisa)->format('Y-m-d'));
        }

        if ($nome_pesquisa) {
            $query->where('nome', 'like', '%' . $nome_pesquisa . '%');
        }

        if ($ip_pesquisa) {
            $query->where('ip', 'like', '%' . $ip_pesquisa . '%');
        }

        if ($status_pesquisa) {
            $query->where('status', $status_pesquisa);
        }

        $contatos = $query->paginate(env('PAGINACAO'))->withQueryString();

        $ips = Contato::orderByDesc('id')->distinct()->pluck('ip');

        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_contacts',
            'descricao' => 'Usuário acessou a página inicial dos contatos.',
        ]);

        return view('interno.contact.index', [
            'menu' => 'contacts',
            'data_pesquisa' => $data_pesquisa,
            'nome_pesquisa' => $nome_pesquisa,
            'ip_pesquisa' => $ip_pesquisa,
            'status_pesquisa' => $status_pesquisa,
            'contatos' => $contatos,
            'ips' => $ips,
        ]);
    }

    public function show(Contato $contato)
    {
        if ($contato->status == 'Pendente') {
            $contato->update([
                'status' => 'Visualizado',
            ]);
            $news_contacts = Contato::where('status', 'Pendente')->count();
            Session::put('news_contacts', $news_contacts);
        }

        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_contacts',
            'descricao' => 'Usuário acessou a página para visualizar as informações de um contato.',
            'observacoes' => 'Contato: ' . $contato->ip,
        ]);

        return view('interno.contact.show', [
            'menu' => 'contacts',
            'contato' => $contato,
        ]);
    }

    public function edit(Contato $contato)
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_contacts',
            'descricao' => 'Usuário acessou a página para editar as informações de um contato.',
            'observacoes' => 'Contato: ' . $contato->ip,
        ]);

        return view('interno.contact.edit', ['menu' => 'contacts', 'contato' => $contato]);
    }

    public function update(ContactRequest $request, Contato $contato)
    {

        DB::beginTransaction();

        try {

            $request->validated();

            $contato->update([
                'observacoes' => $request->observacoes,
                'status' => $request->status,
            ]);

            $news_contacts = Contato::where('status', 'Pendente')->count();
            Session::put('news_contacts', $news_contacts);

            DB::commit();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_contacts',
                'descricao' => 'Usuário editou as informações de um contato.',
                'observacoes' => 'Contato: ' . $contato->ip,
            ]);

            return redirect()->route('contact.show', ['contato' => $contato->id, 'menu' => 'contacts'])->with('success', 'Contato editado com sucesso!');
        } catch (Exception $e) {

            DB::rollBack();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_contacts',
                'descricao' => 'Contato não editado.',
                'observacoes' => 'ID: ' . $contato->id . ' | Erro: ' . $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Contato não editado!');
        }
    }
}
