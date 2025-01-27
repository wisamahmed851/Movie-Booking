<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComentBlog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ComentBlogController extends Controller
{
    /**
     * Store a new comment.
     */
    public function index(){
        $ComentBlogs  = ComentBlog::all();
        return view('admin.comentsBlogs.index', compact('ComentBlogs'));
    }
    public function store(Request $request)
    {
        try {
            if (Auth::check()) {
                // Validate the incoming data
                $validator = Validator::make($request->all(), [
                    'blog_id' => 'required|exists:blogs,id',
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'coment' => 'required|string',
                ]);

                if ($validator->fails()) {
                    return response()->json(['status' => 'error', 'message' => $validator->errors()]);
                }

                // Create the comment
                $coment = ComentBlog::create([
                    'blog_id' => $request['blog_id'],
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'coment' => $request['coment'],
                    'approved' => 0, // Default to unapproved
                ]);

                // Return a success response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Comment added successfully! Wait for admin approval.',
                    'comment' => $coment,
                    'blog_id' => $request['blog_id'], // Include blog_id in the response
                ], 201);
            }else{
                return response()->json(['status' => 'error', 'message' => 'You must be logged in to comment.']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
