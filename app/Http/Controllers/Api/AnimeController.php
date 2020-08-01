<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anime;
use App\Models\Episode;
use App\Models\Player;
use DB;
use Requests as api;
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
    public function getMelhoresAnimes(){
        $response = api::get('http://one.zetai.info/odata/Animesdb?%24select=Id%2CNome%2CImagem%2CRank&%24orderby=Rank%20desc&%24skip=0&%24inlinecount=allpages');
        $resposta = json_decode($response->body);

        return Response()->json($resposta);
    }
    public function getRecentesAnime(){
        $response = api::get('http://one.zetai.info/api/animes/recentes');
        $resposta = json_decode($response->body);
        return Response()->json($resposta);

    }
    public function getNextEpisodebyAnime(Request $request){
        $anime = Anime::where('id_api',$request->anime)->first();
        $episode = Episode::where('anime_id',$request->anime)
        ->where('episode_id','<>', $request->id)
        
        ->orderBy('title','desc')->latest()->limit(4)->get();
        if($episode){
            return Response()->json(['error' => false, 'episode' => $episode,'anime' => $anime]);
        }
        return Response()->json(['error' => true, 'episode' => []]);


    }

    public function returnAnimes(Request $request){
        $anime = Anime::orderBy('title','asc');

        if(isset($request->search)){
            $anime->where('title', 'like', '%'.$request->search.'%');
            
        }else if(isset($request->search) && isset($request->q)){
            $anime->orWhere('title', 'like', $request->q.'%');

        }
        else if(isset($request->q)){
            $anime->where('title', 'like', $request->q.'%');
        }

        return Response()->json($anime->paginate(42));

    }

    public function returnAutoCompleteAnimes(Request $request){
        $anime = Anime::orderBy('title','asc')->get();


        return Response()->json($anime);

    }
    public function getLancamento(){
        $anime = DB::table('episodes')->join('animes', 'episodes.anime_id','animes.id_api')
        ->where('animes.status_anime','EM LANÇAMENTO')
        ->select(
            'animes.*',
            'animes.title as animeTitle',
            'animes.slug as episodeSlug',
            'episodes.*',

        )
        ->inRandomOrder()->paginate(20);
        return Response()->json($anime);
    }

    public function getEpisodeAnime(Request $request){
        $episode = Episode::where('episode_id', $request->id)->first();
        $players = Player::where('episode_id', $request->id)->get();
        if($episode){
            return Response()->json(['error' => false, 'episode' => $episode, 'players' => $players]);
        }
        return Response()->json(['error' => true, 'episode' => []]);


    }
    public function getAnime(Request $request){
        $episode = Anime::where('id_api', $request->id)->first();
        if($episode){
            return Response()->json(['error' => false, 'anime' => $episode]);
        }
        return Response()->json(['error' => true, 'episode' => []]);


    }
    public function getEpisodebyAnime(Request $request){
        $episode = Episode::where('anime_id', $request->id)->orderBy('title','desc')->paginate(1000);
        if($episode){
            return Response()->json($episode);
        }
        return Response()->json(['error' => true, 'episode' => []]);


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hasAnime = Anime::where('id_api', $request->anime_id)->first();
        $edicao = 0;
        if($hasAnime){
            if($hasAnime->id_api != $request->anime_id){
                $hasAnime->id_api = $request->anime_id;
                $edicao = 1;
            }
            if($hasAnime->title != $request->nomeAnime){
                $hasAnime->title = $request->nomeAnime;
                $edicao = 1;
            }
            if($hasAnime->link != $request->link){
                $hasAnime->link = $request->link;
                $edicao = 1;
            }
            
            $sanitizaString = $this->sanitizeString(strtolower($request->nomeAnime));

            if($hasAnime->slug != $sanitizaString){
               
                $hasAnime->slug =$sanitizaString;
                $edicao = 1;
            }
            if($hasAnime->formato != 'Anime'){
                
                $hasAnime->formato = 'Anime';
                $edicao = 1;
            }
            if($hasAnime->genero != $request->categoria){
                $hasAnime->genero = $request->categoria;
                $edicao = 1;
            }
            if( $hasAnime->tipo_ep != $request->rank){
                $hasAnime->tipo_ep = $request->rank;
                $edicao = 1;
            }
            if($hasAnime->status_anime != $request->status_anime){
                $hasAnime->status_anime =1;
                $edicao = 1;
            }
            if($hasAnime->ano_lancamento != $request->ano){
                $hasAnime->ano_lancamento = $request->ano;
                $edicao = 1;
            }
            if($hasAnime->image_dafault != $request->imagem){
                $hasAnime->image_dafault = $request->imagem;
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
            $anime->id_api = $request->anime_id;
            $anime->title = $request->nomeAnime;
            $anime->link = '';
            $anime->slug =  $this->sanitizeString(strtolower($request->nomeAnime));
            $anime->formato = 'Anime';
            $anime->genero = $request->categoria;
            $anime->tipo_ep = $request->rank;
            $anime->status_anime = 1;
            $anime->ano_lancamento = $request->ano ;
            $anime->image_dafault = $request->imagem;
            $anime->sinopse = $request->sinopse;
            $anime->save();
            return Response()->json($anime);

        }

    }
    function sanitizeString($str) {
        $str = preg_replace('/[áàãâä]/ui', 'a', $str);
        $str = preg_replace('/[éèêë]/ui', 'e', $str);
        $str = preg_replace('/[íìîï]/ui', 'i', $str);
        $str = preg_replace('/[óòõôö]/ui', 'o', $str);
        $str = preg_replace('/[úùûü]/ui', 'u', $str);
        $str = preg_replace('/[ç]/ui', 'c', $str);
        // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
        $str = preg_replace('/[^a-z0-9]/i', '_', $str);
        $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
        return $str;
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
