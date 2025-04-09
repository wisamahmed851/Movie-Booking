<?php

namespace App\Http\Controllers;

use App\Models\City;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $cities = City::all();
        return view('admin.city.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.city.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

            $language = City::create([
                'name' => $request->name,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'City created successfully!',
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
    public function edit(string $id)
    {
        //
        $city = City::find($id);
        if (!$city) {
            return redirect()->back()->with('error', 'City not found.');
        }
        return view('admin.city.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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

            $language = City::find($id);
            $language->name = $request->name;
            $language->save();
            return response()->json([
                'status' => 'success',
                'message' => 'City updated successfully!',
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
        try {

            $cities = City::find($id);
            $cities->status = ($cities->status == 1) ? 0 : 1;
            $cities->save();
            return response()->json([
                'status' => 'success',
                'message' => 'City status updated successfully!',
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

    public function destroy(string $id)
    {
        try {
            $city = City::find($id);
            $city->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'City deleted successfully!',
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
