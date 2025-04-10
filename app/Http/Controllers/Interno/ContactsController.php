<?php

namespace App\Http\Controllers\interno;

use App\Http\Controllers\Controller;
use App\Models\Contato;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
}
