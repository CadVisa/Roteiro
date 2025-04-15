<?php

namespace App\Http\Controllers\Interno;

use App\Http\Controllers\Controller;
use App\Http\Requests\CnaeRequest;
use App\Http\Requests\PerguntaRequest;
use App\Models\Cnae;
use App\Models\Movimento;
use App\Models\Pergunta;
use App\Services\LogService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CnaeController extends Controller
{
    public function index(Request $request)
    {
        $codigo_pesquisa = $request->codigo_pesquisa;
        $descricao_pesquisa = $request->descricao_pesquisa;
        $grau_pesquisa = $request->grau_pesquisa;
        $competencia_pesquisa = $request->competencia_pesquisa;
        $revisao_pesquisa = $request->revisao_pesquisa;

        $query = Cnae::orderBy('descricao_cnae');

        if ($codigo_pesquisa) {
            $query->where('codigo_cnae', 'like', '%' . $codigo_pesquisa . '%')->orWhere('codigo_limpo', 'like', '%' . $codigo_pesquisa . '%');
        }

        if ($descricao_pesquisa) {
            $query->where('descricao_cnae', 'like', '%' . $descricao_pesquisa . '%');
        }

        if ($grau_pesquisa) {
            $query->where('grau_cnae', $grau_pesquisa);
        }

        if ($competencia_pesquisa) {
            $query->where('competencia', $competencia_pesquisa);
        }

        if ($revisao_pesquisa) {
            if ($revisao_pesquisa == 1) {
                // CNAEs que possuem pelo menos um movimento do tipo "Edição"
                $query->whereHas('movimentos', function ($q) {
                    $q->where('tipo_movimento', 'Edição');
                });
            } elseif ($revisao_pesquisa == 2) {
                // CNAEs que NÃO possuem movimentos do tipo "Edição"
                $query->whereDoesntHave('movimentos', function ($q) {
                    $q->where('tipo_movimento', 'Edição');
                });
            }
        }

        $cnaes = $query->paginate(env('PAGINACAO'))->withQueryString();

        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_cnaes',
            'descricao' => 'Usuário acessou a página inicial dos CNAEs.',
        ]);

        return view('interno.cnae.index', [
            'menu' => 'cnaes',
            'codigo_pesquisa' => $codigo_pesquisa,
            'descricao_pesquisa' => $descricao_pesquisa,
            'grau_pesquisa' => $grau_pesquisa,
            'competencia_pesquisa' => $competencia_pesquisa,
            'revisao_pesquisa' => $revisao_pesquisa,
            'cnaes' => $cnaes
        ]);
    }

    public function create()
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_cnaes',
            'descricao' => 'Usuário acessou a página para adicionar um CNAE.',
        ]);

        return view('interno.cnae.create', [
            'menu' => 'cnaes'
        ]);
    }

    public function store(CnaeRequest $request)
    {

        DB::beginTransaction();

        try {

            $request->validated();

            $codigo_limpo = preg_replace('/[^0-9]/', '', $request->codigo_cnae);

            $cnae = Cnae::create([
                'codigo_cnae' => $request->codigo_cnae,
                'codigo_limpo' => $codigo_limpo,
                'descricao_cnae' => $request->descricao_cnae,
                'grau_cnae' => $request->grau_cnae,
                'competencia' => $request->competencia,
                'notas_s_compreende' => $request->notas_s_compreende,
                'notas_n_compreende' => $request->notas_n_compreende


            ]);

            Movimento::create([
                'base_cnae_id' => $cnae->id,
                'user_id' => Auth::id(),
                'tipo_movimento' => 'Adição',
                'data_movimento' => now(),
                'descricao_movimento' => 'CNAE cadastrado',
            ]);

            DB::commit();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_cnaes',
                'descricao' => 'Usuário adicionou um novo CNAE.',
                'observacoes' => 'CNAE: ' . $cnae->codigo_cnae,
            ]);

            return redirect()->route('cnae.index', ['menu' => 'cnaes'])->with('success', 'Atividade econômica ' . $request->codigo_cnae . ' cadastrada com sucesso!');
        } catch (Exception $e) {

            DB::rollBack();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_cnaes',
                'descricao' => 'CNAE não adicionado.',
                'observacoes' => 'CNAE: ' . $request->codigo_cnae . ' | Erro: ' . $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Atividade econômica ' . $request->codigo_cnae . ' não cadastrada!');
        }
    }

    public function show(Cnae $cnae)
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_cnaes',
            'descricao' => 'Usuário acessou a página para visualizar um CNAE.',
            'observacoes' => 'CNAE: ' . $cnae->codigo_cnae,
        ]);

        $perguntas = $cnae->perguntas()->paginate(env('PAGINACAO'));

        $movimentos = $cnae->movimentos()->paginate(env('PAGINACAO'));

        return view('interno.cnae.show', ['menu' => 'cnaes', 'cnae' => $cnae, 'perguntas' => $perguntas, 'movimentos' => $movimentos]);
    }

    public function edit(Cnae $cnae)
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_cnaes',
            'descricao' => 'Usuário acessou a página para editar as informações de um CNAE.',
            'observacoes' => 'CNAE: ' . $cnae->codigo_cnae,
        ]);

        return view('interno.cnae.edit', ['menu' => 'cnaes', 'cnae' => $cnae]);
    }

    public function update(CnaeRequest $request, Cnae $cnae)
    {

        DB::beginTransaction();

        try {

            $request->validated();

            $codigo_limpo = preg_replace('/[^0-9]/', '', $request->codigo_cnae);

            $cnae->update([
                'codigo_cnae' => $request->codigo_cnae,
                'codigo_limpo' => $codigo_limpo,
                'descricao_cnae' => $request->descricao_cnae,
                'grau_cnae' => $request->grau_cnae,
                'competencia' => $request->competencia,
            ]);

            Movimento::create([
                'base_cnae_id' => $cnae->id,
                'user_id' => Auth::id(),
                'tipo_movimento' => 'Edição',
                'data_movimento' => now(),
                'descricao_movimento' => 'CNAE editado',
            ]);

            DB::commit();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_cnaes',
                'descricao' => 'Usuário editou as informações de um CNAE.',
                'observacoes' => 'CNAE: ' . $cnae->codigo_cnae,
            ]);

            return redirect()->route('cnae.show', ['cnae' => $cnae->id, 'menu' => 'cnaes'])->with('success', 'Atividade econômica ' . $request->codigo_cnae . ' editada com sucesso!');
        } catch (Exception $e) {

            DB::rollBack();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_cnaes',
                'descricao' => 'CNAE não editado.',
                'observacoes' => 'CNAE: ' . $cnae->codigo_cnae . ' | Erro: ' . $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Atividade econômica ' . $request->codigo_cnae . ' não editada!');
        }
    }

    public function editNotas(Cnae $cnae)
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_cnaes',
            'descricao' => 'Usuário acessou a página para editar as notas explicativas de um CNAE.',
            'observacoes' => 'CNAE: ' . $cnae->codigo_cnae,
        ]);

        return view('interno.cnae.edit-notas', ['menu' => 'cnaes', 'cnae' => $cnae]);
    }

    public function updateNotas(Request $request, Cnae $cnae)
    {
        DB::beginTransaction();

        try {

            $cnae->update([
                'notas_s_compreende' => $request->notas_s_compreende,
                'notas_n_compreende' => $request->notas_n_compreende
            ]);

            Movimento::create([
                'base_cnae_id' => $cnae->id,
                'user_id' => Auth::id(),
                'tipo_movimento' => 'Edição',
                'data_movimento' => now(),
                'descricao_movimento' => 'Notas explicativas editadas',
            ]);

            DB::commit();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_cnaes',
                'descricao' => 'Usuário editou as informações das notas explicativas de um CNAE.',
                'observacoes' => 'CNAE: ' . $cnae->codigo_cnae,
            ]);

            return redirect()->route('cnae.show', ['cnae' => $cnae->id, 'menu' => 'cnaes'])->with('success', 'Notas explicativas da atividade econômica ' . $cnae->codigo_cnae . ' editadas com sucesso!');
        } catch (Exception $e) {

            DB::rollBack();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_cnaes',
                'descricao' => 'Notas explicativas não editadas.',
                'observacoes' => 'CNAE: ' . $cnae->codigo_cnae . ' | Erro: ' . $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Notas explicativas da atividade econômica ' . $cnae->codigo_cnae . ' não editadas!');
        }
    }

    public function createQuestion(Request $request, Cnae $cnae)
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_cnaes',
            'descricao' => 'Usuário acessou a página para adicionar uma pergunta a um CNAE.',
            'observacoes' => 'CNAE: ' . $cnae->codigo_cnae,
        ]);

        return view('interno.cnae.create-question', [
            'menu' => 'cnaes',
            'cnae' => $cnae
        ]);
    }

    public function storeQuestion(PerguntaRequest $request, Cnae $cnae)
    {

        DB::beginTransaction();

        try {

            $request->validated();

            $pergunta = Pergunta::create([
                'cnae_id' => $cnae->id,
                'pergunta' => $request->pergunta,
                'competencia' => $request->competencia,
                'grau_sim' => $request->grau_sim,
                'grau_nao' => $request->grau_nao,
            ]);

            Movimento::create([
                'base_cnae_id' => $cnae->id,
                'user_id' => Auth::id(),
                'tipo_movimento' => 'Adição',
                'data_movimento' => now(),
                'descricao_movimento' => 'Pergunta cadastrada',
            ]);

            DB::commit();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_cnaes',
                'descricao' => 'Usuário cadastrou uma pergunta a um CNAE.',
                'observacoes' => 'CNAE: ' . $cnae->codigo_cnae . ' | Pergunta: ' . $pergunta->pergunta,
            ]);

            return redirect()->route('cnae.show', ['cnae' => $cnae->id, 'menu' => 'cnaes'])->with('success', 'Pergunta da atividade econômica ' . $cnae->codigo_cnae . ' cadastrada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_cnaes',
                'descricao' => 'Pergunta não cadastrada.',
                'observacoes' => 'CNAE: ' . $cnae->codigo_cnae . ' | Pergunta: ' . $request->pergunta . ' | Erro: ' . $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Pergunta da atividade econômica ' . $cnae->codigo_cnae . ' não cadastrada!');
        }
    }

    public function editQuestion(Pergunta $pergunta)
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_cnaes',
            'descricao' => 'Usuário acessou a página para editar as informações de uma pergunta de um CNAE.',
            'observacoes' => 'CNAE: ' . $pergunta->cnae->codigo_cnae . ' | Pergunta: ' . $pergunta->pergunta,
        ]);

        return view('interno.cnae.edit-question', ['menu' => 'cnaes', 'pergunta' => $pergunta]);
    }

    public function updateQuestion(PerguntaRequest $request, Pergunta $pergunta)
    {

        DB::beginTransaction();

        try {

            $request->validated();

            $pergunta->update([
                'pergunta' => $request->pergunta,
                'competencia' => $request->competencia,
                'grau_sim' => $request->grau_sim,
                'grau_nao' => $request->grau_nao,
            ]);

            Movimento::create([
                'base_cnae_id' => $pergunta->cnae->id,
                'user_id' => Auth::id(),
                'tipo_movimento' => 'Edição',
                'data_movimento' => now(),
                'descricao_movimento' => 'Pergunta editada',
            ]);

            DB::commit();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_cnaes',
                'descricao' => 'Usuário editou as informações de uma pergunta de um CNAE.',
                'observacoes' => 'CNAE: ' . $pergunta->cnae->codigo_cnae . ' | Pergunta: ' . $pergunta->pergunta,
            ]);

            return redirect()->route('cnae.show', ['cnae' => $pergunta->cnae_id, 'menu' => 'cnaes'])->with('success', 'Pergunta da atividade econômica ' . $pergunta->cnae->codigo_cnae . ' editada com sucesso!');
        } catch (Exception $e) {

            DB::rollBack();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_cnaes',
                'descricao' => 'Pergunta não editada.',
                'observacoes' => 'CNAE: ' . $pergunta->cnae->codigo_cnae . ' | Pergunta: ' . $pergunta->pergunta . ' | Erro: ' . $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Pergunta da atividade econômica ' . $pergunta->cnae->codigo_cnae . ' não editada!');
        }
    }

    public function destroy(Cnae $cnae)
    {
        DB::beginTransaction();

        try {

            $cnae->delete();

            DB::commit();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_cnaes',
                'descricao' => 'Usuário excluiu um CNAE.',
                'observacoes' => 'CNAE: ' . $cnae->codigo_cnae,
            ]);

            return redirect()->route('cnae.index', ['menu' => 'cnaes'])->with('success', 'Atividade econômica ' . $cnae->codigo_cnae . ' excluída com sucesso!');
        } catch (Exception $e) {

            DB::rollBack();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_cnaes',
                'descricao' => 'Erro ao excluir um CNAE.',
                'observacoes' => 'CNAE: ' . $cnae->codigo_cnae . ' | Erro: ' . $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Atividade econômica ' . $cnae->codigo_cnae . ' não excluída!');
        }
    }

    public function destroyQuestion(Pergunta $pergunta)
    {
        DB::beginTransaction();

        try {

            $pergunta->delete();

            DB::commit();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_cnaes',
                'descricao' => 'Usuário excluiu uma pergunta de um CNAE.',
                'observacoes' => 'CNAE: ' . $pergunta->cnae->codigo_cnae . ' | Pergunta: ' . $pergunta->pergunta,
            ]);

            return redirect()->route('cnae.show', ['cnae' => $pergunta->cnae_id, 'menu' => 'cnaes'])->with('success', 'Pergunta da atividade econômica ' . $pergunta->cnae->codigo_cnae . ' excluída com sucesso!');
        } catch (Exception $e) {

            DB::rollBack();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_cnaes',
                'descricao' => 'Erro ao excluir uma pergunta de um CNAE.',
                'observacoes' => 'CNAE: ' . $pergunta->cnae->codigo_cnae . ' | Pergunta: ' . $pergunta->pergunta . ' | Erro: ' . $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Pergunta da atividade econômica ' . $pergunta->cnae->codigo_cnae . ' não excluída!');
        }
    }

    public function gerarPDF(Request $request)
    {
        $codigo_pesquisa = $request->codigo_pesquisa;
        $descricao_pesquisa = $request->descricao_pesquisa;
        $grau_pesquisa = $request->grau_pesquisa;
        $competencia_pesquisa = $request->competencia_pesquisa;
        $revisao_pesquisa = $request->revisao_pesquisa;

        $query = Cnae::orderBy('descricao_cnae');

        if ($codigo_pesquisa) {
            $query->where('codigo_cnae', 'like', '%' . $codigo_pesquisa . '%')->orWhere('codigo_limpo', 'like', '%' . $codigo_pesquisa . '%');
        }

        if ($descricao_pesquisa) {
            $query->where('descricao_cnae', 'like', '%' . $descricao_pesquisa . '%');
        }

        if ($grau_pesquisa) {
            $query->where('grau_cnae', $grau_pesquisa);
        }

        if ($competencia_pesquisa) {
            $query->where('competencia', $competencia_pesquisa);
        }

        if ($revisao_pesquisa) {
            if ($revisao_pesquisa == 1) {
                // CNAEs que possuem pelo menos um movimento do tipo "Edição"
                $query->whereHas('movimentos', function ($q) {
                    $q->where('tipo_movimento', 'Edição');
                });
            } elseif ($revisao_pesquisa == 2) {
                // CNAEs que NÃO possuem movimentos do tipo "Edição"
                $query->whereDoesntHave('movimentos', function ($q) {
                    $q->where('tipo_movimento', 'Edição');
                });
            }
        }

        $cnaes = $query->get();

        if ($cnaes->isEmpty()) {

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '2',
                'chave' => 'pg_cnaes',
                'descricao' => 'Tentou gerar o relatório sem informações.',
            ]);

            return back()->withInput()->with('error', 'Sem informações para gerar o relatório!');
        }

        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_cnaes',
            'descricao' => 'Usuário gerou relatório dos CNAEs.',
        ]);

        $nomePdf = 'Relatório_CNAEs.pdf';

        $pdf = Pdf::loadView('interno.relatorios.cnaes-1', [
            'codigo_pesquisa' => $codigo_pesquisa,
            'descricao_pesquisa' => $descricao_pesquisa,
            'grau_pesquisa' => $grau_pesquisa,
            'competencia_pesquisa' => $competencia_pesquisa,
            'revisao_pesquisa' => $revisao_pesquisa,
            'cnaes' => $cnaes
        ]);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
            'dpi' => 96,
            'isPhpEnabled' => true,
        ]);

        return $pdf->download($nomePdf);
        //return $pdf->stream($nomePdf);
    }
}
