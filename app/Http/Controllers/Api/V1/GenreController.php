<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\GenreRequest;
use Illuminate\Http\Request;
use App\Models\Genre;
use App\Http\Resources\V1\{
Resource\GenreResource,
Collection\GenreCollection
};

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $model = Genre::select('uuid', 'genre_name', 'description', 'created_at')
            ->when($request->q, function ($query) use ($request) {
            return $query->where('genre_name', 'LIKE', "%$request->q%");
        })->paginate();
        return response()->json(new GenreCollection($model), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GenreRequest $request)
    {
        $model = new Genre;
        $model = $model->fill($request->all());
        $model->save();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Genre has been created.',
            'data' => new GenreResource($model)
        ];
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = Genre::whereUuid($id)->firstOrFail();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Genre details are fetched.',
            'data' => new GenreResource($model)
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GenreRequest $request, $id)
    {
        $model = Genre::whereUuid($id)->firstOrFail();
        $model = $model->fill($request->all());
        $model->save();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Genre has been updated.',
            'data' => new GenreResource($model)
        ];
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $model = Genre::whereUuid($id)->firstOrFail();
        $model->delete();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Genre has been deleted.'
        ];
        return response()->json($response, 200);
    }

    public function options(Request $request)
    {

        $genres = Genre::select('uuid', 'slug', 'genre_name')->where('status', ITEM_STATUS_ACTIVE)->get();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Genre options are prepared.',
            'data' => $genres
        ];
        return response()->json($response);
    }
}
