<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use Illuminate\Http\Request;
use App\Models\ComentBlog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ComentBlogController extends Controller
{
    /**
     * Store a new comment.
     */
    public function index(Request $request)
    {
        // Fetch all blogs
        $blogs = Blogs::all();

        // Handle AJAX request for filtering
        if ($request->ajax()) {
            $query = ComentBlog::query();

            if ($request->has('blogId') && $request->blogId != '') {
                $query->where('blog_id', $request->blogId); // Filter by blogId
            }

            $ComentBlogs = $query->get();

            // Render the rows using the partial
            $rowsHtml = view('admin.comentsBlogs.partials.table', compact('ComentBlogs'))->render();

            return response()->json([
                'rowsHtml' => $rowsHtml,
                'status' => 'success',
            ]);
        }

        // Normal page load
        $ComentBlogs = ComentBlog::with('blog')->get();
        return view('admin.comentsBlogs.index', compact('ComentBlogs', 'blogs'));
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
                    'status' => 1, // Default to active
                ]);

                // Return a success response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Comment added successfully! Wait for admin approval.',
                    'comment' => $coment,
                    'blog_id' => $request['blog_id'], // Include blog_id in the response
                ], 201);
            } else {
                return response()->json(['status' => 'error', 'message' => 'You must be logged in to comment.']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function show($id)
    {
        $comment = ComentBlog::find($id);
        if (!$comment) {
            return response()->json(['status' => 'error', 'message' => 'Comment not found.']);
        }

        $blog = $comment->blog; // Assuming the relationship `blog()` is defined in Comment model
        return response()->json([
            'status' => 'success',
            'data' => [
                'comment' => $comment,
                'blog' => $blog
            ]
        ]);
    }

    public function approve($id)
    {
        $comment = ComentBlog::findOrFail($id);
        if ($comment->approved == 1) {
            $comment->approved = 0;
            $message = 'Comment unapproved successfully.';
        } else {
            $comment->approved = 1;
            $message = 'Comment approved successfully.';
        }
        $comment->save();

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'newApprove' => $comment->approved
        ]);
    }
    public function status($id)
    {
        try {
            $coment = ComentBlog::find($id);
            if ($coment->status == 1) {
                $coment->status = 0;
                $message = 'Comment deactivated successfully!';
            } else {
                $coment->status = 1;
                $message = 'Comment activated successfully!';
            }
            $coment->save();
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'coment' => $coment
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
