<?php

namespace App\Services\Api;

use App\Http\Requests\FilmPostRequest;
use App\Models\Api\FilmGenre;
use App\Models\Api\Films;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;

class FilmsServices
{
    public function showAllFilms($request): \Illuminate\Http\JsonResponse
    {
        $perPage = $request->input('limit', 5);

        $films = Films::query()
            ->with('genres')
            ->paginate($perPage);

        return response()->json([
            'status'    => true,
            'data'      => [
                'current_page'  => $films->currentPage(),
                'data'          => $films->map(function ($film) {
                    return [
                        'id'            => $film->id,
                        'name'          => $film->name,
                        'link_poster'   => $film->link_poster,
                        'genres'        => $film->genres->pluck('name'),
                    ];
                }),
                'limit'         => $films->perPage(),
                'total'         => $films->total(),
                'last_page'     => $films->lastPage(),
                'curren_page'   => $films->currentPage()
            ],
            'message' => 'Films retrieved successfully.'
        ]);
    }

    public function showFilms($id): \Illuminate\Http\JsonResponse
    {
        $film = Films::query()->find($id);

        if(!$film){
            return response()->json([
                'status'    => false,
                'message'   => 'Movie not found.'
            ], 404);
        }

        $data                   = $film->toArray();
        $data['genres']         = $film->genres->pluck('name')->toArray();
        $data['link_poster']    = asset($film->link_poster);

        return response()->json([
            'status'    => true,
            'data'      => $data,
            'message'   => 'Find movie successfully.'
        ], 200);
    }

    public function storeFilms($film): \Illuminate\Http\JsonResponse
    {
        try{
            DB::beginTransaction();
            $request = new FilmPostRequest();

            $rules = $request->rules();
            $messages = $request->messages();

            $validator = Validator::make($film->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'status'    =>  false,
                    'message'   =>  $validator
                        ->errors()
                        ->getMessages()
                ] ,400);
            }

            $filmModel =	new Films();

            $filmModel->fill([
                'name'          => $film->name
            ]);

            if(!$film->hasFile('link_poster')){
                $filmModel->fill([
                    'link_poster' => asset('img/default_poster_min.webp')
                ]);
            }

            $filmModel->save();

            $genresId = explode(',', $film->genre);

            foreach ($genresId as $id){
                FilmGenre::query()->insert([
                    'fk_film'   => $filmModel->id,
                    'fk_genre'  => $id
                ]);
            }

            if($film->hasFile('link_poster')){
                $this->saveLogo($film->file('link_poster'), $filmModel->id);
            }

            DB::commit();

            return response()->json([
                'status'    => true,
                'message'   => 'Create film successfully.'
            ], 201);

        }catch ( \Throwable $e ){
            DB::rollback();
            return response()->json([
                'status'    => false,
                'message'   => $e->getMessage()
            ],400);
        }
    }

    private function saveLogo($logo, $filmModelId): string
    {
        $fileName = $filmModelId . '_' . time() . '.' . $logo->getClientOriginalExtension();

        $path = public_path('/uploads/films/'. $filmModelId .'/');

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true, true);
        }

        $logo->move($path, $fileName);

        Films::query()
            ->where([
                'id' => $filmModelId
            ])
            ->update([
                'link_poster' => asset('/uploads/films/'. $filmModelId .'/'.$fileName)
            ]);

        $this->_saveLogo($path, $fileName);

        return asset('/uploads/films/'. $filmModelId .'/'.$fileName);
    }

    private function _saveLogo($path, $fileName): void
    {
        try{
            $manager = new ImageManager(Driver::class);

            $image = $manager->read($path.$fileName);

            $image->resize(200, 200);

            $image->save($path.$fileName);

        }catch (\Throwable $e){
            response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
            return;
        }
    }

    public function updateFilms($film, $id): \Illuminate\Http\JsonResponse
    {
        try{
            DB::beginTransaction();

            $filmModel = Films::query()->find($id);

            if(!$filmModel){
                return response()->json([
                    'status'    =>  false,
                    'message'   =>  'Not found.'
                ] ,404);
            }

            $request    = new FilmPostRequest();
            $rules      = $request->rules();
            $messages   = $request->messages();

            $validator  = Validator::make($film->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'status'    =>  false,
                    'message'   =>  $validator
                        ->errors()
                        ->getMessages()
                ] ,400);
            }

            $filmModel->fill([
                'name'          => $film->name
            ]);

            $filmModel->update();

            FilmGenre::query()
                ->where([
                    'fk_film'   => $filmModel->id
                ])
                ->delete();

            $genresId = explode(',', $film->genre);

            foreach ($genresId as $id){
                FilmGenre::query()->insert([
                    'fk_film'   => $filmModel->id,
                    'fk_genre'  => $id
                ]);
            }

            if($film->hasFile('link_poster')){
                $this->deletePoster($filmModel->id ,$filmModel->link_poster);

                $filmModel->link_poster = $this->saveLogo($film->file('link_poster'), $filmModel->id);
            }

            DB::commit();

            return response()->json([
                'status'    => true,
                'data'      => [
                    'name'              => $filmModel->name,
                    'status_published'  => $filmModel->status_published,
                    'link_poster'       => $filmModel->link_poster,
                    'genre'             => $filmModel->genres->pluck('name')->toArray()
                ],
                'message'   => 'Update success.'
            ], 200);

        }catch ( \Throwable $e ){
            DB::rollback();
            return response()->json([
                'status'    => false,
                'message'   => $e->getMessage()
            ],400);
        }
    }

    public function deletePoster($id, $namePoster): void
    {
        $linkName = explode('/', $namePoster);

        $path = public_path('/uploads/films/'. $id .'/'.end($linkName));

        if (File::exists($path)) {
            File::delete($path);
        }
    }

    public function destroyFilms($id): \Illuminate\Http\JsonResponse
    {
        $filmModel = Films::query()->findOrFail($id);

        if(!$filmModel){
            return response()->json([
                'status' => false,
                'message' => 'Not found!'
            ], 404);
        }

        $this->deletePoster($filmModel->id ,$filmModel->link_poster);
        $filmModel->delete();

        return response()->json([
            'status'    => true,
            'message'   => 'Film delete success!'
        ], 204);
    }

    public function publicFilms($id): \Illuminate\Http\JsonResponse
    {
        $filmModel = Films::query()->findOrFail($id);

        if(!$filmModel){
            return response()->json([
                'status' => false,
                'message' => 'Not found!'
            ], 404);
        }

        $filmModel->fill([
            'status_published' => '1'
        ]);

        $filmModel->update();

        return response()->json([
            'status'    => true,
            'data'      => [
                'name'              => $filmModel->name,
                'status_published'  => $filmModel->status_published,
                'link_poster'       => $filmModel->link_poster,
                'genre'             => $filmModel->genres->pluck('name')->toArray()
            ],
            'message'   => 'Public movies success!'
        ], 200);
    }

    public function unPublicFilms($id): \Illuminate\Http\JsonResponse
    {

        $filmModel = Films::query()->findOrFail($id);

        if(!$filmModel){
            return response()->json([
                'status' => false,
                'message' => 'Not found!'
            ], 404);
        }

        $filmModel->fill([
            'status_published' => '0'
        ]);

        $filmModel->update();

        return response()->json([
            'status'    => true,
            'data'      => [
                'name'              => $filmModel->name,
                'status_published'  => $filmModel->status_published,
                'link_poster'       => $filmModel->link_poster,
                'genre'             => $filmModel->genres->pluck('name')->toArray()
            ],
            'message'   => 'Un-public movies success!'
        ], 200);
    }
}
