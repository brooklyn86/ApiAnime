<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Episode;

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
        $edicao = 0;
        if($hasEpisode){
            if($hasEpisode->episode_id != $request->episode_id){
                $hasEpisode->episode_id = $request->episode_id;
                $edicao = 1;
            }
            if($hasEpisode->anime_id != $request->anime_id){
                $hasEpisode->anime_id = $request->anime_id; 
                $edicao = 1;

            }
            if($hasEpisode->title != $request->title){
                $hasEpisode->title = $request->title;
                $edicao = 1;

            }
            if($hasEpisode->ep_url != $request->url){
                $hasEpisode->ep_url = $request->url;
                $edicao = 1;

            }
            if($edicao == 1){
                $hasEpisode->save();
            }
            return Response()->json($hasEpisode);

        }else{
            $episode = new Episode;
            $episode->episode_id = $request->id;
            $episode->anime_id = $request->anime_id;
            $episode->title = $request->title;
            $episode->ep_url = $request->url;
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
