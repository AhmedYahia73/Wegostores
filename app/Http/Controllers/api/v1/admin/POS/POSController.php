<?php

namespace App\Http\Controllers\api\v1\admin\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Pos;

class POSController extends Controller
{
    public function view(Request $request){
        $resurants = Pos:: 
        get(); 

        return response()->json([
            "resurants" => $resurants,
        ]);
    }
    
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'front_end' => 'required',
            'back_end' => 'required',
            'restuarant_id' => 'required',
            'status' => 'required|boolean',
            'name' => 'required',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        $resurants = Pos:: 
        create([
            "front_end" => $request->front_end,
            "back_end" => $request->back_end,
            "restuarant_id" => $request->restuarant_id,
            "status" => $request->status,
            "name" => $request->name,
        ]); 

        return response()->json([
            "success" => "You add data success",
        ]);
    }
    
    public function modify(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'front_end' => 'sometimes',
            'back_end' => 'sometimes',
            'restuarant_id' => 'sometimes',
            'status' => 'sometimes|boolean',
            'name' => 'sometimes',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        $resurant = Pos::
        where("id", $id)
        ->first();
        $resurant->update([
            "front_end" => $request->front_end ?? $resurant->front_end,
            "back_end" => $request->back_end ?? $resurant->back_end,
            "restuarant_id" => $request->restuarant_id ?? $resurant->restuarant_id,
            "status" => $request->status ?? $resurant->status,
            "name" => $request->name ?? $resurant->name,
        ]); 

        return response()->json([
            "success" => "You update data success",
        ]);
    }
    
    public function delete(Request $request, $id){
        $resurants = Pos::
        where("id", $id)
        ->delete();

        return response()->json([
            "success" => "You delete data success",
        ]);
    }
}
