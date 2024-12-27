<?php

namespace App\Services\Api;

use App\Http\Requests\GenrePostRequest;
use App\Models\Api\Genres;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GenresServices
{
    public function getGenres($request): \Illuminate\Http\JsonResponse
    {
        $perPage = $request->input('limit', 5);

        $genres = Genres::query()
            ->with(['films' => function ($query) {
                $query->where('status_published', '1'); // Фильтр по статусу фильмов
            }])
            ->paginate($perPage);

        return response()->json([
            'status'    => true,
            'data'      => [
                'current_page'  => $genres->currentPage(),
                'data'          => $genres->map(function ($genre) {
                    return [
                        'id'            => $genre->id,
                        'name'          => $genre->name,
                        'link_poster'   => $genre->link_poster,
                        'genres'        => $genre->films->pluck('name'),
                    ];
                }),
                'limit'         => $genres->perPage(),
                'total'         => $genres->total(),
                'last_page'     => $genres->lastPage(),
                'curren_page'   => $genres->currentPage()
            ],
            'message' => 'Genres retrieved successfully.'
        ]);
    }

    public function storeGenres($genre): \Illuminate\Http\JsonResponse
    {
        try{
            DB::beginTransaction();

            $request    = new GenrePostRequest();
            $rules      = $request->rules();
            $validator  = Validator::make($genre->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'    =>  false,
                    'message'   =>  $validator
                        ->errors()
                        ->getMessages()
                ] ,400);
            }

            $genreModel = new Genres();

            $genreModel->fill([
                'name' => $genre->name,
            ]);

            $genreModel->save();

            DB::commit();

            return response()->json([
                'status'    => true,
                'message'   => 'Created successfully.'
            ], 201);

        }catch ( \Throwable $e ){
            DB::rollback();
            return response()->json([
                'status'    => false,
                'message'   => $e->getMessage()
            ],400);
        }
    }

    public function showGenres($id): \Illuminate\Http\JsonResponse
    {
        $genre = Genres::query()->find($id);

        if(!$genre){
            return response()->json([
                'status'    => false,
                'message'   => 'Movie not found.'
            ], 404);
        }

        $data                   = $genre->toArray();
        $data['films']          = $genre->films()
            ->where('status_published', '1')
            ->pluck('name')
            ->toArray();

        return response()->json([
            'status'    => true,
            'data'      => $data,
            'message'   => 'Find genre successfully.'
        ], 200);
    }

    public function updateGenres($genre, $id): \Illuminate\Http\JsonResponse
    {
        $genreModel = Genres::query()->find($id);

        if(!$genreModel){
            return response()->json([
                'status'    =>  false,
                'message'   =>  'Genre not found.'
            ] ,404);
        }

        $request    = new GenrePostRequest();
        $rules      = $request->rules();
        $validator  = Validator::make($genre->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  false,
                'message'   =>  $validator
                    ->errors()
                    ->getMessages()
            ] ,400);
        }

        $genreModel->fill([
            'name' => $genre->name,
        ]);

        $genreModel->update();

        return response()->json([
            'status'    => true,
            'data'      => [
                'id'    => $genreModel->id,
                'name'  => $genreModel->name,
                'films' => $genreModel->films->pluck('name')
            ],
            'message'   => 'Update successfully.'
        ], 200);
    }

    public function destroyGenres($id): \Illuminate\Http\JsonResponse
    {
        $genreModel = Genres::query()->find($id);

        if(!$genreModel){
            return response()->json([
                'status'    =>  false,
                'message'   =>  'Genre not found.'
            ] ,404);
        }

        $genreModel->delete();

        return response()->json([
            'status'    => true,
            'message'   => 'Deleted successfully.'
        ], 204);
    }

}
