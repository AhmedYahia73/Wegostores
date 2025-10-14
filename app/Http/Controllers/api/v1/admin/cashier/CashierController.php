<?php

namespace App\Http\Controllers\api\v1\admin\cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Pos;

class CashierController extends Controller
{
    public function pos_login(Request $request){
        $validator = Validator::make($request->all(), [
            'restuarant_id' => 'required',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        $resurant = Pos::
        where("restuarant_id", $request->restuarant_id)
        ->where("status", 1)
        ->first();
        if(empty($request)){
            return response()->json([
                "errors" => "Resurant ID is wrong"
            ], 400);
        }

        return response()->json([
            "front_end" => $resurant->front_end . "/api/cashier/auth/login",
            "back_end" => $resurant->back_end, 
        ]);
    }
}
