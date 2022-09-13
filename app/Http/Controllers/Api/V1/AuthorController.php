<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AuthorRequest;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Http\Resources\V1\{
Resource\AuthorResource,
Collection\AuthorCollection
};

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $model = Author::select('uuid', 'author_name', 'email', 'phone_number', 'address', 'created_at')
            ->when($request->q, function ($query) use ($request) {
            return $query->where('author_name', 'LIKE', "%$request->q%")
            ->orWhere('email', 'LIKE', "%$request->q%")
            ->orWhere('phone_number', 'LIKE', "%$request->q%");
        })
            ->paginate(10);
        return response()->json(new AuthorCollection($model), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AuthorRequest $request)
    {
        $model = new Author;
        $model = $model->fill($request->all());
        $model->save();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Author has been created.',
            'data' => new AuthorResource($model)
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
        $model = Author::whereUuid($id)->firstOrFail();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Author details has been fetched.',
            'data' => new AuthorResource($model)
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
    public function update(AuthorRequest $request, $id)
    {
        $model = Author::whereUuid($id)->firstOrFail();
        $model = $model->fill($request->all());
        $model->save();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Author has been updated.',
            'data' => new AuthorResource($model)
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
        $model = Author::whereUuid($id)->firstOrFail();
        $model->delete();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Author has been deleted.'
        ];
        return response()->json($response, 200);
    }

    public function options()
    {
        $authors = Author::select('uuid', 'author_name')->where('status', ITEM_STATUS_ACTIVE)->get();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Author options are prepared.',
            'data' => $authors
        ];
        return response()->json($response);
    }
}
