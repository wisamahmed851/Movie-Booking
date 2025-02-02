<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $genres = Genre::all();
        return view('admin.genre.index', compact('genres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.genre.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                    'data' => null
                ]);
            }

            $genre = Genre::create([
                'name' => $request->name,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Genre is created',
                'data' => null
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'Error',
                'message' => $ex->getMessage(),
                'data' => null
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {


        $genre = Genre::find($id);

        if (!$genre) {
            return redirect()->route('genres.index')->with('error', 'Genre not found.');
        }

        return view('admin.genre.edit', compact('genre'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try {
            $genre = Genre::find($id);
            if (!$genre) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Genre not found',
                    'data' => null
                ]);
            }
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                    'data' => null
                ]);
            }

            $genre->name = $request->name;
            $genre->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Genre is updated',
                'data' => null
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'Error',
                'message' => $ex->getMessage(),
                'data' => null
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function status(string $id)
    {
        try{
            $genre = Genre::find($id);
            $genre->status = ($genre->status == 1) ? 0 : 1;
            $genre->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Genre status is updated',
                'data' => null
            ]);
        }catch(Exception $ex){
            return response()->json([
                'status' => 'Error',
                'message' => $ex->getMessage(),
                'data' => null
            ]);
        }
    }

    public function destroy(string $id)
    {
        try {
            $genre = Genre::find($id);
            $genre->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Genre is deleted',
                'data' => null
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'Error',
                'message' => $ex->getMessage(),
                'data' => null
            ]);
        }
    }
}
