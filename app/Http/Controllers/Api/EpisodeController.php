<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Episode;
use App\Models\Player;

class EpisodeController extends Controller
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
    public function create(Request $request)
    {
     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
  
        $hasEpisode = Episode::where('episode_id', $request->episode_id)->first();
        if($hasEpisode){
            
            if($hasEpisode->episode_id != $request->episode_id){
                $hasEpisode->episode_id = $request->episode_id;
                
            }
            if($hasEpisode->anime_id != $request->anime_id){
                $hasEpisode->anime_id = $request->anime_id; 
                

            }
            if($hasEpisode->title != $request->nomeEpisode){
                $hasEpisode->title = $request->nomeEpisode;
                

            }
           
            if($hasEpisode->slug !=$request->slug){
                $hasEpisode->slug = $request->slug ;
                

            }
            $hasEpisode->ep_url = '';
            
            $hasEpisode->update();

            return Response()->json($hasEpisode);

        }else{
            $episode = new Episode;
            $episode->episode_id = $request->episode_id;
            $episode->anime_id = $request->anime_id;
            $episode->title = $request->nomeEpisode;
            $episode->ep_url = '';
            $episode->slug = $request->slug;
            $episode->save();
            return Response()->json($episode);

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
    public function storePlayer(Request $request)
    {

        $hasEpisode = Player::where('id_player', $request->id_player)->first();
        if($hasEpisode){
            
            if($hasEpisode->episode_id != $request->episode_id){
                $hasEpisode->episode_id = $request->episode_id;
                
            }
            if($hasEpisode->anime_id != $request->anime_id){
                $hasEpisode->anime_id = $request->anime_id; 
                

            }
            if($hasEpisode->title != $request->nomePlayer){
                $hasEpisode->title = $request->nomePlayer;
                

            }
            if($hasEpisode->ep_url != $request->endereco){
                $hasEpisode->ep_url = $request->endereco;

            }
            
            $hasEpisode->update();

            return Response()->json($hasEpisode);

        }else{
            $episode = new PLayer;
            $episode->episode_id = $request->episode_id;
            $episode->anime_id = $request->anime_id;
            $episode->id_player = $request->idPlayer;
            $episode->nomePlayer = $request->nomePlayer;
            $episode->ep_url = $request->endereco;
            $episode->save();
            return Response()->json($episode);

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
