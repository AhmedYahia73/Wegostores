<?php

namespace App\Http\Controllers\api\v1\admin\UserSubscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\UserSubscription;

class UserSubscriptionController extends Controller
{
    public function __construct(private UserSubscription $user_subscription){}

    public function view(Request $request){
        $user_subscription = $this->user_subscription 
        ->get(); 

        return response()->json([
            'user_subscription' => $user_subscription, 
        ]);
    }

    public function my_package(Request $request){ 
        $user_subscription = $this->user_subscription
        ->get();

        return response()->json([
            'user_subscription' => $user_subscription,
        ]);
    }

    public function user_subscription(Request $request, $id){
        $user_subscription = $this->user_subscription
        ->where('id', $id)
        ->first();

        return response()->json([
            'user_subscription' => $user_subscription
        ]);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required'] ,
            'back_link' => ['required'] ,
            'from' => ['required', 'date'] ,
            'to' => ['required', 'date'] ,
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
 
        $this->user_subscription
        ->create([
            'name' => $request->name,
            'back_link' => $request->back_link,
            'from' => $request->from,
            'to' => $request->to,
        ]);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => ['required'] ,
            'from' => ['required', 'date'] ,
            'to' => ['required', 'date'] ,
            'back_link' => ['required'] ,
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
 
        $this->user_subscription
        ->where('id', $id)
        ->update([
            'name' => $request->name,
            'back_link' => $request->back_link,
            'to' => $request->to,
        ]);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete(Request $request, $id){
        $this->user_subscription
        ->where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
