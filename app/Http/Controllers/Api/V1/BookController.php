<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\BookRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\{
Book,
Author,
Genre,
Publisher,
Gallery
};
use App\Http\Resources\V1\{
Resource\BookResource,
Collection\BookCollection
};

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $model = Book::select('uuid', 'title', 'genre_id', 'author_id', 'publisher_id', 'gallery_id', 'slug', 'description', 'isbn', 'published_at', 'created_at')
            ->when($request->q, function ($query) use ($request) {
              
            return $query->where('title', 'LIKE', "%$request->q%")
            ->orWhere('isbn', 'LIKE', "%$request->q%")
            ->orWhereRelation('genre', 'genre_name', 'LIKE', "%$request->q%")
            ->orWhereRelation('author', 'author_name', 'LIKE', "%$request->q%")
            ->orWhereRelation('publisher', 'publisher_name', 'LIKE', "%$request->q%");
        })
            ->with(['genre', 'author', 'publisher', 'gallery'])
            ->paginate();
        return response()->json(new BookCollection($model), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BookRequest $request)
    {
        $author = Author::whereUuid($request->author_id)->firstOrFail();
        $genre = Genre::whereUuid($request->genre_id)->firstOrFail();
        $publisher = Publisher::whereUuid($request->publisher_id)->firstOrFail();
        $gallery = Gallery::whereUuid($request->gallery_id)->firstOrFail();
        $model = new Book;
        $model = $model->fill($request->except(['author_id', 'genre_id', 'publisher_id', 'gallery_id']));
        $model->author_id = $author->getKey();
        $model->genre_id = $genre->getKey();
        $model->publisher_id = $publisher->getKey();
        $model->gallery_id = $gallery->getKey();
        $model->save();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Book has been created.',
            'data' => new BookResource($model)
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
        $model = Book::whereUuid($id)->orWhere('slug', $id)->firstOrFail();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Book details fetched.',
            'data' => new BookResource($model)
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
    public function update(BookRequest $request, $id)
    {
        $author = Author::whereUuid($request->author_id)->firstOrFail();
        $genre = Genre::whereUuid($request->genre_id)->firstOrFail();
        $publisher = Publisher::whereUuid($request->publisher_id)->firstOrFail();
        $gallery = Gallery::whereUuid($request->gallery_id)->firstOrFail();
        $model = Book::whereUuid($id)->firstOrFail();
        $model = $model->fill($request->except(['author_id', 'genre_id', 'publisher_id', 'gallery_id']));
        $model->author_id = $author->getKey();
        $model->genre_id = $genre->getKey();
        $model->publisher_id = $publisher->getKey();
        $model->gallery_id = $gallery->getKey();
        $model->save();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Book has been updated.',
            'data' => new BookResource($model)
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
        $model = Book::whereUuid($id)->firstOrFail();
        $model->delete();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Book has been deleted.'
        ];
        return response()->json($response, 200);
    }


    public function collections(Request $request)
    {
        // return response()->json($request->authors);
        $model = Book::select('uuid', 'title', 'genre_id', 'author_id', 'publisher_id', 'gallery_id', 'slug', 'description', 'isbn', 'published_at', 'created_at')
        ->when($request->q, function ($query) use ($request) {              
            return $query->where('title', 'LIKE', "%$request->q%")
            ->orWhere('isbn', 'LIKE', "%$request->q%");
        })
        ->when($request->publishers, function ($query) use ($request) {
            return $query->whereHas('publishers', function($subQuery) use($request) {
                return $subQuery->whereIn('slug', $request->publishers);
            });
        })
        ->when($request->genres, function ($query) use ($request) {
            return $query->whereHas('genre', function($subQuery) use($request) {
                return $subQuery->whereIn('slug', $request->genres);
            });
        })
        ->when($request->authors, function ($query) use ($request) {
            return $query->whereHas('author', function($subQuery) use($request) {
                return $subQuery->whereIn('slug', $request->authors);
            });
        })
        ->with(['genre', 'author', 'publisher', 'gallery'])
        ->paginate(100);
        return response()->json(new BookCollection($model), 200);
    }
}
