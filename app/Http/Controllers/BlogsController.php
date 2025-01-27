<?php

namespace App\Http\Controllers;

use App\Models\BlogDetails;
use App\Models\Blogs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogsController extends Controller
{
    //
    public function index()
    {
        $blogs = Blogs::with('blogDetails')->get();
        return view('admin.blogs.index', compact('blogs'));
    }
    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'cover_image' => 'required|image',
            'long_description' => 'required|string'
        ]);

        $blog = Blogs::create([
            'title' => $request->title
        ]);

        $blogDetails = BlogDetails::create([
            'blog_id' => $blog->id,
            'short_description' => $request->short_description,
            'cover_image' => $request->cover_image->store('blog_images', 'public'),
            'long_description' => $request->long_description
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Blog created successfully!',
            'blog' => $blog,
        ]);
    }
    public function edit($id)
    {
        $blog = Blogs::with('blogDetails')->find($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image update
            'long_description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 422);
        }

        // Find the blog and associated details
        $blog = Blogs::find($id);
        if (!$blog) {
            return response()->json(['status' => 'error', 'message' => 'Blog not found'], 404);
        }

        $blogDetails = $blog->blogDetails;
        if (!$blogDetails) {
            return response()->json(['status' => 'error', 'message' => 'Blog details not found'], 404);
        }

        // Update the blog title
        $blog->title = $request->title;
        $blog->save();

        // Handle cover image update
        if ($request->hasFile('cover_image')) {
            // Delete the old image if it exists
            if ($blogDetails->cover_image && Storage::disk('public')->exists($blogDetails->cover_image)) {
                Storage::disk('public')->delete($blogDetails->cover_image);
            }

            // Upload and store the new image
            $newImagePath = $request->file('cover_image')->store('blog_images', 'public');
            $blogDetails->cover_image = $newImagePath;
        }

        // Update other details
        $blogDetails->short_description = $request->short_description;
        $blogDetails->long_description = $request->long_description;

        // Save all changes
        $blogDetails->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Blog updated successfully!',
            'blog' => $blog,
        ]);
    }




    public function status($id)
    {
        try {
            $blog = Blogs::find($id);
            $blog->status = ($blog->status === "1") ? 0 : 1;
            $blog->save();
            return response()->json([
                'status' => 'success',
                'message' => 'blog status is updated',
                'data' => null
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    public function list()
    {
        $blogs = Blogs::with('blogDetails')->where('status', 1)->get();
        return view('frontend.blogs.blogs', compact('blogs'));
    }

    public function details($id)
    {
        $blog = Blogs::with(['blogDetails', 'comments' => function ($query) {
            $query->where('approved', "1")->where('status', "1"); // Updated condition
        }])->find($id);

        return view('frontend.blogs.blogDetail', compact('blog'));
    }
}
