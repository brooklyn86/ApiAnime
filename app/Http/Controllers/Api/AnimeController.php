<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anime;
class AnimeController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hasAnime = Anime::where('id_api', $request->id)->first();
        $edicao = 0;
        if($hasAnime){
            if($hasAnime->id_api != $request->id){
                $hasAnime->id_api = $request->id;
                $edicao = 1;
            }
            if($hasAnime->title != $request->nome){
                $hasAnime->title = $request->nome;
                $edicao = 1;
            }
            if($hasAnime->link != $request->link){
                $hasAnime->link = $request->link;
                $edicao = 1;
            }
            if($hasAnime->slug != $request->slug){
                $hasAnime->slug = $request->slug;
                $edicao = 1;
            }
            if($hasAnime->formato != $request->formato){
                $hasAnime->formato = $request->formato;
                $edicao = 1;
            }
            if($hasAnime->genero != $request->genero){
                $hasAnime->genero = $request->genero;
                $edicao = 1;
            }
            if( $hasAnime->tipo_ep != $request->tipo_ep){
                $hasAnime->tipo_ep = $request->tipo_ep;
                $edicao = 1;
            }
            if($hasAnime->status_anime != $request->status_anime){
                $hasAnime->status_anime = $request->status_anime;
                $edicao = 1;
            }
            if($hasAnime->ano_lancamento != $request->ano_lancamento){
                $hasAnime->ano_lancamento = $request->ano_lancamento;
                $edicao = 1;
            }
            if($hasAnime->image_dafault != $request->image_dafault){
                $hasAnime->image_dafault = $request->image_dafault;
                $edicao = 1;
            }
            if( $hasAnime->sinopse != $request->sinopse){
                $hasAnime->sinopse = $request->sinopse;
                $edicao = 1;
            }
            if($edicao == 1){
                $hasAnime->save();
            }
            return Response()->json($hasAnime);

        }else{
            $anime = new Anime;
            $anime->id_api = $request->id;
            $anime->title = $request->nome;
            $anime->link = $request->link;
            $anime->slug = $request->slug;
            $anime->formato = $request->formato;
            $anime->genero = $request->genero;
            $anime->tipo_ep = $request->tipo_ep;
            $anime->status_anime = $request->status_anime;
            $anime->ano_lancamento = $request->ano_lancamento ;
            $anime->image_dafault = $request->image_dafault;
            $anime->sinopse = $request->sinopse;
            $anime->save();
            return Response()->json($anime);

        }

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
