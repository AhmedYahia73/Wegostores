<?php

namespace App\Http\Controllers\api\v1\admin\SMSPackage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\SmsPackage;
use App\Models\UserSmsPackage;

class UserSMSPackageControlle extends Controller
{
    public function __construct(private SmsPackage $sms_packages,
    private UserSmsPackage $user_sms){}

    public function view(Request $request){
        $sms_packages = $this->sms_packages
        ->where('status', 1)
        ->get();
        $user_sms = $this->user_sms
        ->orderByDesc('id')
        ->get();

        return response()->json([
            'sms_packages' => $sms_packages,
            'user_sms' => $user_sms,
        ]);
    }

    public function user_sms(Request $request, $id){
        $user_sms = $this->user_sms
        ->where('id', $id)
        ->first();

        return response()->json([
            'user_sms' => $user_sms
        ]);
    } 

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required'] ,
            'sms_package_id' => ['required', 'exists:sms_packages,id'] ,
            'back_link' => ['required'] ,
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }

        $sms_packages = $this->sms_packages
        ->where('id', $request->sms_package_id)
        ->first();
        $from = date('Y-m-d');
        $to = Carbon::now()->addMonth($sms_packages->months)->format('Y-m-d');
        $this->user_sms
        ->create([
            'name' => $request->name,
            'msg_number' => $sms_packages->msg_number,
            'back_link' => $request->back_link,
            'sms_package_id' => $request->sms_package_id,
            'from' => $from,
            'to' => $to,
        ]);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => ['required'] ,
            'sms_package_id' => ['required', 'exists:sms_packages,id'] ,
            'back_link' => ['required'] ,
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }

        $sms_packages = $this->sms_packages
        ->where('id', $request->sms_package_id)
        ->first();
        $to = Carbon::parse($sms_packages)->addMonth($sms_packages->months)->format('Y-m-d');
        $this->user_sms
        ->create([
            'name' => $request->name,
            'msg_number' => $sms_packages->msg_number,
            'back_link' => $request->back_link,
            'sms_package_id' => $request->sms_package_id,
            'to' => $to,
        ]);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete(Request $request, $id){
        $this->user_sms
        ->where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
