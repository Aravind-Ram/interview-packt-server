<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\PublisherRequest;
use Illuminate\Http\Request;
use App\Models\Publisher;
use App\Http\Resources\V1\{
Resource\PublisherResource,
Collection\PublisherCollection
};

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $model = Publisher::select('uuid', 'publisher_name', 'email', 'phone_number', 'address', 'created_at')
            ->when($request->q, function ($query) use ($request) {
                return $query->where('publisher_name', 'LIKE', "%$request->q%")
                ->orWhere('email', 'LIKE', "%$request->q%")
                ->orWhere('phone_number', 'LIKE', "%$request->q%");
            })
            ->paginate();
        return response()->json(new PublisherCollection($model), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PublisherRequest $request)
    {
        $model = new Publisher;
        $model = $model->fill($request->all());
        $model->save();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Publisher has been created.',
            'data' => new PublisherResource($model)
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
        $model = Publisher::whereUuid($id)->firstOrFail();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Publisher details fetched.',
            'data' => new PublisherResource($model)
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
    public function update(PublisherRequest $request, $id)
    {
        $model = Publisher::whereUuid($id)->firstOrFail();
        $model = $model->fill($request->all());
        $model->save();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Publisher has been updated.',
            'data' => new PublisherResource($model)
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
        $model = Publisher::whereUuid($id)->firstOrFail();
        $model->delete();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Publisher has been deleted.'
        ];
        return response()->json($response, 200);
    }

    public function options()
    {
        $publishers = Publisher::select('uuid', 'slug', 'publisher_name')->where('status', ITEM_STATUS_ACTIVE)->get();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Publishers options are prepared.',
            'data' => $publishers
        ];
        return response()->json($response);
    }
}