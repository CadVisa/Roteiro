<?php

namespace App\Http\Controllers\interno;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigurationRequest;
use App\Models\Configuration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ConfigurationController extends Controller
{
    public function index()
    {
        $configuration = Configuration::first();

        return view('interno.configuracao.index', ['menu' => 'configuracao', 'configuration' => $configuration]);
    }

    public function edit()
    {
        $configuration = Configuration::first();
        return view('interno.configuracao.edit', ['menu' => 'configuracao', 'configuration' => $configuration]);
    }

    public function update(ConfigurationRequest $request){

        DB::beginTransaction();

        try{

            $request->validated();

            $configuration = Configuration::first();            

            $configuration->update([
                'versao_sistema' => $request->versao_sistema,
                'usa_api' => $request->usa_api,
                'email_sistema' => $request->email_sistema,
                'exibe_card' => $request->exibe_card,
                'exibe_info_rodape' => $request->exibe_info_rodape,
            ]);

            DB::commit();

            return redirect()->route('configuration.index', ['menu' => 'configuracao', 'configuration' => $configuration])->with('success','As configurações foram atualizadas com sucesso!');

        }catch (Exception){

            DB::rollBack();

            return back()->withInput()->with('error','As configurações não puderam ser editadas!');

        }
    }

    public function ativar(Request $request, Configuration $configuration)
    {
        DB::beginTransaction();

        try {

            $configuration = Configuration::first();

            $configuration->update([
                'status_sistema' => 'Ativo',
            ]);

            DB::commit();

            Session::flush();

            Auth::logout();

            return redirect()->route('login')->with('success','Sistema ativado com sucesso!');

        } catch (Exception $e) {

            DB::rollBack();

            return back()->withInput()->with('error','O sistema não pôde ser ativado!');

        }
    }

    public function suspender(Request $request, Configuration $configuration)
{
    DB::beginTransaction();

    try {
        $configuration = Configuration::first();

        $configuration->update([
            'status_sistema' => 'Suspenso',
        ]);

        DB::commit();

        Session::flush();
        Auth::logout();

        return redirect()->route('login')->with('success', 'Sistema suspenso com sucesso!');

    } catch (Exception $e) {
        DB::rollBack();

        return back()->withInput()->with('error', 'O sistema não pôde ser suspenso!');
    }
}
}
