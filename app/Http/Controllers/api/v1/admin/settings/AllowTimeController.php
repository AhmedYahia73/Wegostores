<?php

namespace App\Http\Controllers\api\v1\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Setting;

class AllowTimeController extends Controller
{
    public function __construct(private Setting $settings){}

    public function view(){
        // /admin/v1/allow_time
        $allow_time = $this->settings
        ->where('name', 'allow_time')
        ->first();
        if (empty($allow_time)) {
            $data = [
                'days' => 0,
                'fine' => 0
            ];
            $data = json_encode($data);
            $allow_time = $this->settings
            ->create([
                'name' => 'allow_time',
                'value' => $data,
            ]);
        }
        $allow_time = json_decode($allow_time->value);

        return response()->json([
            'allow_time' => $allow_time
        ]);
    }

    public function modify(Request $request){
        // /admin/v1/allow_time/update
        // Keys
        // days, fine
        $validator = Validator::make($request->all(), [
            'days' => 'required|numeric',
            'fine' => 'required|numeric',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        $allow_time = $this->settings
        ->where('name', 'allow_time')
        ->first();
        $data = [
            'days' => $request->days,
            'fine' => $request->fine,
        ];
        $data = json_encode($data);
        if (empty($allow_time)) {
            $allow_time = $this->settings
            ->create([
                'name' => 'allow_time',
                'value' => $data,
            ]);
        }
        else{
            $allow_time->update([
                'name' => 'allow_time',
                'value' => $data,
            ]);
        }
        $allow_time = json_decode($allow_time->value);

        return response()->json([
            'allow_time' => $allow_time
        ]);
    }
}
