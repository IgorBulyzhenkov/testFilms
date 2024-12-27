<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\GenresServices;
use Illuminate\Http\Request;

class GenresController extends Controller
{
    protected GenresServices $genresServices;

    public function __construct(GenresServices $genresServices){
        $this->genresServices = $genresServices;
    }

    public function showAll(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->genresServices->getGenres($request);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->genresServices->storeGenres($request);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        return $this->genresServices->showGenres($id);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        return $this->genresServices->updateGenres($request, $id);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        return $this->genresServices->destroyGenres($id);
    }

}
