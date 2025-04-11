<?php

namespace App\Http\Controllers\interno;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardRequest;
use App\Models\Card;
use App\Services\LogService;
use Exception;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function index()
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_cards',
            'descricao' => 'Usuário acessou a página inicial dos cards.',
        ]);

        $cards = Card::orderBy('card_ordem')->paginate(env('PAGINACAO'));

        return view('interno.card.index', ['menu' => 'cards', 'cards' => $cards]);
    }

    public function create()
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_cards',
            'descricao' => 'Usuário acessou a página para adicionar um novo card.',
        ]);

        return view('interno.card.create', [
            'menu' => 'cards'
        ]);
    }

    public function store(CardRequest $request)
    {

        DB::beginTransaction();

        try {

            $request->validated();

            $card = Card::create([
                'card_icone' => $request->card_icone,
                'card_titulo' => $request->card_titulo,
                'card_descricao' => $request->card_descricao,
                'card_ordem' => $request->card_ordem,
                'card_status' => $request->card_status
            ]);

            DB::commit();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_cards',
                'descricao' => 'Usuário cadastrou um novo card.',
                'observacoes' => 'Card: ' . $card->card_titulo,
            ]);

            return redirect()->route('card.index', ['menu' => 'cards'])->with('success', 'Card cadastrado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_cards',
                'descricao' => 'Erro ao cadastrar um card.',
                'observacoes' => 'Erro: ' . $e->getMessage(),
            ]);
            return back()->withInput()->with('error', 'Card não cadastrado!');
        }
    }

    public function show(Card $card)
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_cards',
            'descricao' => 'Usuário acessou a página para visualizar um card.',
            'observacoes' => 'Card: ' . $card->card_titulo,
        ]);

        return view('interno.card.show', ['menu' => 'cards', 'card' => $card]);
    }

    public function edit(Card $card)
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_cards',
            'descricao' => 'Usuário acessou a página para editar as informações de um card.',
            'observacoes' => 'Card: ' . $card->card_titulo,
        ]);

        return view('interno.card.edit', ['menu' => 'cards', 'card' => $card]);
    }

    public function update(CardRequest $request, Card $card)
    {

        DB::beginTransaction();

        try {

            $request->validated();

            $card->update([
                'card_icone' => $request->card_icone,
                'card_titulo' => $request->card_titulo,
                'card_descricao' => $request->card_descricao,
                'card_ordem' => $request->card_ordem,
                'card_status' => $request->card_status
            ]);

            DB::commit();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_cards',
                'descricao' => 'Usuário editou as informações de um card.',
                'observacoes' => 'Card: ' . $card->card_titulo,
            ]);


            return redirect()->route('card.show', ['card' => $card->id, 'menu' => 'cards'])->with('success', 'Card editado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_cards',
                'descricao' => 'Erro ao editar um card.',
                'observacoes' => 'Card: ' . $card->card_titulo . ' | Erro: ' . $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Card não editado!');
        }
    }

    public function destroy(Card $card)
    {
        DB::beginTransaction();

        try {

            $card->delete();

            DB::commit();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_cards',
                'descricao' => 'Usuário excluiu um card.',
                'observacoes' => 'Card: ' . $card->card_titulo,
            ]);

            return redirect()->route('card.index', ['menu' => 'cards'])->with('success', 'Card excluído com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_cards',
                'descricao' => 'Erro ao excluir um card.',
                'observacoes' => 'Card: ' . $card->card_titulo . ' | Erro: ' . $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Card não excluído!');
        }
    }
}
