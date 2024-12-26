<?php

namespace App\Http\Controllers;

use App\Services\FilmsServices;
use Illuminate\Http\Request;

class FilmsController extends Controller
{
    protected FilmsServices $filmsServices;

    public function __construct(FilmsServices $filmsServices){
        $this->filmsServices = $filmsServices;
    }

    public function index(){
        return $this->filmsServices->indexFilms();
    }

    public function showAll(){
        return $this->filmsServices->showAllFilms();
    }

    public function store(Request $request){
        return $this->filmsServices->storeFilms($request);
    }

    public function show($id){
        return $this->filmsServices->showFilms($id);
    }

    public function update(Request $request, $id){
        return $this->filmsServices->updateFilms($request, $id);
    }

    public function destroy($id){
        return $this->filmsServices->destroyFilms($id);
    }

    public function public($id){
        return $this->filmsServices->publicFilms($id);
    }

    public function unPublic($id){
        return $this->filmsServices->unPublicFilms($id);
    }
}
