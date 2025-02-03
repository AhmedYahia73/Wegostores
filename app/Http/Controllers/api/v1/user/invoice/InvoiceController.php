<?php

namespace App\Http\Controllers\api\v1\user\invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Plan;
use App\Models\Setting;

class InvoiceController extends Controller
{
    public function __construct(private Plan $plans, private Setting $settings){}

    public function invoice(Request $request){
        // /user/v1/invoice
        $plan = $this->plans
        ->where('id', $request->user()->plan_id)
        ->first();
        $start_date = $request->user()->start_date;
        $expire_date = $request->user()->expire_date;
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
        $days = $allow_time->days ?? 0;
        $fine = $allow_time->fine ?? 0;
        $allow_date = null;
        if (!empty($expire_date)) {
            $expire_date =  Carbon::parse($expire_date);
            $allow_date = (clone $expire_date)->addDays($days);
            $expire_date = $expire_date->format('Y-m-d');
            $allow_date = $allow_date->format('Y-m-d');
        } 

        return response()->json([
            'plan' => $plan,
            'start_date' => $start_date,
            'expire_date' => $expire_date,
            'allow_date' => $allow_date,
            'fine' => $fine,
        ]);
    }
}
