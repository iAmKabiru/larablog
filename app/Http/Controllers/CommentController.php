<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index($id): \Illuminate\Http\JsonResponse
    {
        $comments = Comment::where('blog_id', $id)->get();
        return ResponseHelper::successWithData('Comments fetched successfully', $comments);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'blog_id' => 'required',
            'body' => 'required'
        ]);

        if ($validator->fails()){
            return ResponseHelper::fail($validator->messages()->first(), 422);
        }

        $data = $validator->validated();
        $data['user_id'] = auth()->id();

        $create = Comment::create($data);

        if (!$create){
            return ResponseHelper::fail('Comment not created');
        }

        return ResponseHelper::successWithData('Comment created successfully', $create);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'body' => 'nullable'
        ]);

        if ($validator->fails()){
            return ResponseHelper::fail($validator->messages()->first(), 422);
        }

        $comment = Comment::find($id);
        $update = $comment->update($validator->validated());

        if (!$update){
            return ResponseHelper::fail('Comment not updated');
        }

        return ResponseHelper::successWithData('Comment updated successfully', $update);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $comment = Comment::find($id);

        if (!$comment){
            return ResponseHelper::fail('Comment not found', 404);
        }

        $delete = $comment->delete();
        if (!$delete){
            return ResponseHelper::fail('Comment not deleted');
        }

        return ResponseHelper::success('Comment deleted successfully');
    }
}
