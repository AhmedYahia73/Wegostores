<?php

namespace App\Http\Controllers\api\v1\user\invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Plan;

class InvoiceController extends Controller
{
    public function __construct(private Plan $plans){}

    public function invoice(Request $request){
        // /user/v1/invoice
        $plan = $this->plans
        ->where('id', $request->user()->plan_id)
        ->first();
        $start_date = $request->user()->start_date;
        $expire_date = $request->user()->expire_date;

        return response()->json([
            'plan' => $plan,
            'start_date' => $start_date,
            'expire_date' => $expire_date,
        ]);
    }
}
