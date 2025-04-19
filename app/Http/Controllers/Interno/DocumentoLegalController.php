<?php

namespace App\Http\Controllers\interno;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocPoliticaRequest;
use App\Http\Requests\DocTermosRequest;
use App\Http\Requests\DocumentoRequest;
use App\Models\DocumentoLegal;
use App\Services\LogService;
use Dom\Document;
use Exception;
use Illuminate\Support\Facades\DB;

class DocumentoLegalController extends Controller
{
    public function index()
    {
        $documentos = DocumentoLegal::orderByDesc('id')->paginate(env('PAGINACAO'));

        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_documentos',
            'descricao' => 'Acessou a página inicial dos documentos.',
        ]);

        return view('interno.documento.index', [
            'menu' => 'documentos',
            'documentos' => $documentos
        ]);
    }

    public function create()
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_documentos',
            'descricao' => 'Acessou a página para adicionar um documento legal.',
        ]);

        return view('interno.documento.create', [
            'menu' => 'documentos'
        ]);
    }

    public function store(DocumentoRequest $request)
    {
        DB::beginTransaction();

        try {

            $request->validated();

            $documento = DocumentoLegal::create([
                'termos_uso' => $request->termos_uso,
                'politica_privacidade' => $request->politica_privacidade
            ]);

            DB::commit();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_documentos',
                'descricao' => 'Adicionou um documento legal.',
                'observacoes' => 'ID: ' . $documento->id,
            ]);

            return redirect()->route('documento.index', ['menu' => 'documentos'])->with('success', 'Documento legal cadastrado com sucesso!');
        } catch (Exception $e) {

            DB::rollBack();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_documentos',
                'descricao' => 'Documento legal não cadastrado.',
                'observacoes' => 'Erro: ' . $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Documento legal não cadastrado!');
        }
    }

    public function showTermos(DocumentoLegal $documento)
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_documentos',
            'descricao' => 'Acessou a página para visualizar os termos de uso.',
            'observacoes' => 'ID: ' . $documento->id,
        ]);

        return view('interno.documento.showTermos', ['menu' => 'documentos', 'documento' => $documento]);
    }

    public function editTermos(DocumentoLegal $documento)
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_documentos',
            'descricao' => 'Acessou a página para editar as informações dos termos de uso.',
            'observacoes' => 'ID: ' . $documento->id,
        ]);

        return view('interno.documento.editTermos', ['menu' => 'documentos', 'documento' => $documento]);
    }

    public function updateTermos(DocTermosRequest $request, DocumentoLegal $documento)
    {

        DB::beginTransaction();

        try {

            $request->validated();


            $documento->update([
                'termos_uso' => $request->termos_uso,
            ]);

            DB::commit();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_documentos',
                'descricao' => 'Editou as informações dos termos de uso.',
                'observacoes' => 'ID: ' . $documento->id,
            ]);

            return redirect()->route('documento.showTermos', ['documento' => $documento->id, 'menu' => 'documentos'])->with('success', 'Termos de uso editados com sucesso!');
        } catch (Exception $e) {

            DB::rollBack();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_documentos',
                'descricao' => 'Termos de uso não editados.',
                'observacoes' => 'ID: ' . $documento->id . ' | Erro: ' . $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Termos de uso não editados!');
        }
    }

    public function showPolitica(DocumentoLegal $documento)
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_documentos',
            'descricao' => 'Acessou a página para visualizar as políticas de privacidade.',
            'observacoes' => 'ID: ' . $documento->id,
        ]);

        return view('interno.documento.showPolitica', ['menu' => 'documentos', 'documento' => $documento]);
    }

    public function editPolitica(DocumentoLegal $documento)
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_documentos',
            'descricao' => 'Acessou a página para editar as informações das politicas de privacidade.',
            'observacoes' => 'ID: ' . $documento->id,
        ]);

        return view('interno.documento.editPolitica', ['menu' => 'documentos', 'documento' => $documento]);
    }

    public function updatePolitica(DocPoliticaRequest $request, DocumentoLegal $documento)
    {

        DB::beginTransaction();

        try {

            $request->validated();


            $documento->update([
                'politica_privacidade' => $request->politica_privacidade,
            ]);

            DB::commit();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_documentos',
                'descricao' => 'Editou as informações das politicas de privacidade.',
                'observacoes' => 'ID: ' . $documento->id,
            ]);

            return redirect()->route('documento.showPolitica', ['documento' => $documento->id, 'menu' => 'documentos'])->with('success', 'Políticas de privacidade editadas com sucesso!');
        } catch (Exception $e) {

            DB::rollBack();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_documentos',
                'descricao' => 'Políticas de privacidade não editadas.',
                'observacoes' => 'ID: ' . $documento->id . ' | Erro: ' . $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Políticas de privacidade não editadas!');
        }
    }
}
