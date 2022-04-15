<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $blogs = Blog::withCount('comments')->get();
        return ResponseHelper::successWithData('Blogs fetched successfully', $blogs);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $blog = Blog::whereId($id)->withCount('comments')->first();

        if (!$blog){
            return ResponseHelper::fail('Blog not found', 404);
        }

        return ResponseHelper::successWithData('Blogs fetched successfully', $blog);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
            'image_code' => 'required'
        ]);

        if ($validator->fails()){
            return ResponseHelper::fail($validator->messages()->first(), 422);
        }

        $create = Blog::create($validator->validated());

        if (!$create){
            return ResponseHelper::fail('Blog not created');
        }

        return ResponseHelper::successWithData('Blog created successfully', $create);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable',
            'body' => 'nullable',
            'image_code' => 'nullable'
        ]);

        if ($validator->fails()){
            return ResponseHelper::fail($validator->messages()->first(), 422);
        }

        $blog = Blog::find($id);
        $update = $blog->update($validator->validated());

        if (!$update){
            return ResponseHelper::fail('Blog not updated');
        }

        return ResponseHelper::success('Blog updated successfully');
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $blog = Blog::find($id);

        if (!$blog){
            return ResponseHelper::fail('Blog not found', 404);
        }

        $delete = $blog->delete();
        if (!$delete){
            return ResponseHelper::fail('Blog not deleted');
        }

        return ResponseHelper::success('Blog deleted successfully');
    }
}
