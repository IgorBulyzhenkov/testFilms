<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\FilmsServices;
use Illuminate\Http\Request;

class FilmsController extends Controller
{
    protected FilmsServices $filmsServices;

    public function __construct(FilmsServices $filmsServices){
        $this->filmsServices = $filmsServices;
    }

    public function showAll(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->filmsServices->showAllFilms($request);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->filmsServices->storeFilms($request);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        return $this->filmsServices->showFilms($id);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        return $this->filmsServices->updateFilms($request, $id);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        return $this->filmsServices->destroyFilms($id);
    }

    public function public($id): \Illuminate\Http\JsonResponse
    {
        return $this->filmsServices->publicFilms($id);
    }

    public function unPublic($id): \Illuminate\Http\JsonResponse
    {
        return $this->filmsServices->unPublicFilms($id);
    }
}
