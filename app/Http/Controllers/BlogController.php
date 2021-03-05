<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        //
    }

    /* methods */

    public function getBlogs() {
        $blogs = Blog::all();

        return response()->json([
            'sucess' => true,
            'data' => $blogs
        ], 200);
    }

    public function getBlog($idBlog) {
        $blog = Blog::where('id', $idBlog)->first();

        return response()->json([
            'success' => true,
            'data' => $blog
        ], 200);
    }

    public function postBlog(Request $request) {
        $validations = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Algunos datos son requeridos o no cumplen con los requerimientos para realizar esta operacion',
                'code' => 422
            ], 422);
        }

        $data = $request->all();

        $blog = Blog::create($data);

        return response()->json([
            'success' => true,
            'data' => $blog
        ], 201);
    }

    public function putBlog(Request $request, $idBlog) {
        $blog = Blog::where('id', $idBlog)->first();

        if ($request->has('title')) {
            $blog->title = $request['title'];
        }

        if ($request->has('description')) {
            $blog->description = $request['description'];
        }

        if ($request->has('image')) {
            $blog->image = $request['image'];
        }

        if (!$blog->isDirty()) {
            return response()->json([
                'error' => 'Se debe ingresar por lo menos un valor diferente al actualizar',
                'code' => 422
            ], 422);
        }

        $blog->save();

        return response()->json([
            'sucess' => true,
            'data' => $blog
        ], 201);
    }
}
