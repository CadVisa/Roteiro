<?php

namespace App\Http\Controllers\interno;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardRequest;
use App\Models\Card;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function index()
    {
        $cards = Card::orderBy('card_ordem')->paginate(env('PAGINACAO'));

        return view('interno.card.index', ['menu' => 'cards', 'cards' => $cards]);
    }

    public function create()
    {
        return view('interno.card.create', [
            'menu' => 'cards'
        ]);
    }

    public function store(CardRequest $request){

        DB::beginTransaction();

        try{

            $request->validated();

            Card::create([
                'card_icone' => $request->card_icone,
                'card_titulo' => $request->card_titulo,
                'card_descricao' => $request->card_descricao,
                'card_ordem' => $request->card_ordem,
                'card_status' => $request->card_status
            ]);

            DB::commit();

            return redirect()->route('card.index', ['menu' => 'cards'])->with('success','Card cadastrado com sucesso!');

        }catch (Exception $e){

            DB::rollBack();

            return back()->withInput()->with('error','Card não cadastrado!');
        }
    }

    public function show(Card $card)
    {
        return view('interno.card.show', ['menu' => 'cards', 'card' => $card]);
    }

    public function edit(Card $card)
    {
        return view('interno.card.edit', ['menu' => 'cards', 'card' => $card]);
    }

    public function update(CardRequest $request, Card $card){

        DB::beginTransaction();

        try{

            $request->validated();

            $card->update([
                'card_icone' => $request->card_icone,
                'card_titulo' => $request->card_titulo,
                'card_descricao' => $request->card_descricao,
                'card_ordem' => $request->card_ordem,
                'card_status' => $request->card_status
            ]);

            DB::commit();

            return redirect()->route('card.show', ['card' => $card->id, 'menu' => 'cards'])->with('success','Card editado com sucesso!');

        }catch (Exception){

            DB::rollBack();

            return back()->withInput()->with('error','Card não editado!');

        }
    }

    public function destroy(Card $card)
    {
        DB::beginTransaction();

        try{

            $card->delete();

            DB::commit();

            return redirect()->route('card.index', ['menu' => 'cards'])->with('success','Card excluído com sucesso!');

        }catch (Exception){

            DB::rollBack();

            return back()->withInput()->with('error','Card não excluído!');

        }
    }
}
