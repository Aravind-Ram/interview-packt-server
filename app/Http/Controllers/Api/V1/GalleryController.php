<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\GalleryRequest;
use App\Models\Gallery;
use App\Http\Resources\V1\Resource\GalleryResource;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;


class GalleryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $model = Gallery::select('uuid', 'file_path', 'file_type', 'created_at')->paginate();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Galleries are fetched.',
            'data' => GalleryResource::collection($model)
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GalleryRequest $request)
    {
        $model = new Gallery;
        if ($request->uuid) {
            $model = Gallery::whereUuid($request->uuid)->firstOrFail();
            Storage::delete($model->file_path);
        }
        $model->file_path = $request->file_path->store('books');
        $model->save();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'File has been uploaded.',
            'data' => new GalleryResource($model)
        ];
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = Gallery::whereUuid($id)->firstOrFail();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Author has been updated.',
            'data' => new GalleryResource($model)
        ];
        return response()->json($response, 200);
    }


}
