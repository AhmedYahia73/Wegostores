<?php

namespace App\Http\Controllers\api\v1\admin\SMSPackage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\SmsPackage;

class SMSPackageController extends Controller
{
    public function __construct(private SmsPackage $sms_packages){}

    public function view(Request $request){
        $sms_packages = $this->sms_packages
        ->get();

        return response()->json([
            'sms_packages' => $sms_packages
        ]);
    }

    public function sms_package(Request $request, $id){
        $sms_package = $this->sms_packages
        ->where('id', $id)
        ->first();

        return response()->json([
            'sms_package' => $sms_package
        ]);
    }

    public function status(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'status' => ['required', 'boolean'] ,
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        $sms_package = $this->sms_packages
        ->where('id', $id)
        ->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => 'You update status success'
        ]);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required'] ,
            'description' => ['sometimes'] ,
            'months' => ['required', 'numeric'] ,
            'price' => ['required', 'numeric'] ,
            'discount' => ['required', 'numeric'] ,
            'discount_type' => ['required'] ,
            'status' => ['required', 'boolean'] ,
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        $smsRequest = $validator->validated();
        $this->sms_packages
        ->create($smsRequest);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => ['required'] ,
            'description' => ['sometimes'] ,
            'months' => ['required', 'numeric'] ,
            'price' => ['required', 'numeric'] ,
            'discount' => ['required', 'numeric'] ,
            'discount_type' => ['required'] ,
            'status' => ['required', 'boolean'] ,
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        $smsRequest = $validator->validated();
        $this->sms_packages
        ->where('id', $id)
        ->update($smsRequest);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function delete(Request $request, $id){
        $this->sms_packages
        ->where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
