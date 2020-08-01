<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lista;
use App\Models\Anime;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Api\UserController;
class MinhaListaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function getMinhaLista(Request $request){
        $user = Auth::user()->id; 
        $minhaLista = [];
        if($user){
            dd($request);
            $minhaLista = [];
            if($request->pagina == true){
                $minhaLista = Lista::join('Animes as ANIME', 'listas.anime_id','=','ANIME.id')
                ->where('listas.user_id', $user)
                ->select('ANIME.*')->paginate(200);
            }else{
                $minhaLista = Lista::join('Animes as ANIME', 'listas.anime_id','=','ANIME.id')
                ->where('listas.user_id', $user)
                ->select('ANIME.*')->paginate(4);
            }
           
        return response()->json($minhaLista, 200); 

        }
        return response()->json($minhaLista, 401); 
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = Auth::user()->id;
        if($user){
            $hasInLista = Lista::where('anime_id',$request->anime_id)->where('user_id',$user)->first();
            if(!$hasInLista){
                $lista = new Lista;
                $lista->user_id = $user;
                $lista->anime_id = $request->anime_id;
                $lista->save();
                $minhaLista = Lista::join('Animes as ANIME', 'listas.anime_id','=','ANIME.id')
                                    ->where('listas.user_id', $user)
                                    ->select('ANIME.*')->paginate(10);
                return response()->json(['error'=>false,'message'=>'Adicionado a sua lista!', 'lista' => $minhaLista], 200); 

            }
            return response()->json(['error'=>true,'message'=>'Já pertence a sua lista!'], 200); 

        } 
        return response()->json(['Não autorizada'], 401); 

    }
    public function remover(Request $request)
    {

        $user = Auth::user()->id;
        if($user){
            $hasInLista = Lista::where('anime_id',$request->anime_id)->where('user_id',$user)->first();
            if($hasInLista){
                $response = Lista::destroy($hasInLista->id);
                if($response){
                    $minhaLista = Lista::join('Animes as ANIME', 'listas.anime_id','=','ANIME.id')
                                    ->where('listas.user_id', $user)
                                    ->select('ANIME.*')->paginate(4);
                    return response()->json(['error'=>false,'message'=>'Removido da sua lista!', 'lista' => $minhaLista], 200); 
                }
                return response()->json(['error'=>true,'message'=>'Falha ao deletar!'], 200); 

            }
            return response()->json(['error'=>true,'message'=>'Não pertence a sua lista!'], 200); 

        } 
        return response()->json(['Não autorizada'], 401); 

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
