<?php

namespace App\Services;

class FilmsServices
{
    public function indexFilms(){
        dd('indexFilms');
    }

    public function showAllFilms(){
        dd('showAllFilms');
    }

    public function showFilms($id){
        dd('showFilms');
    }

    public function storeFilms($request){
        dd('storeFilms');
    }

    public function updateFilms($request, $id){
        dd('showFilms');
    }

    public function destroyFilms($id){
        dd('showFilms');
    }

    public function publicFilms($id){
        dd('publicFilms');
    }

    public function unPublicFilms($id){
        dd('unPublicFilms');
    }
}
