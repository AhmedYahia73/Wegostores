<?php

namespace App\Http\Controllers\api\v1\admin\client_domain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\UploadImage;

use App\Models\ClientDomain;

class ClientDomainController extends Controller
{
    public function __construct(private ClientDomain $client_domain){}
    use UploadImage;

    public function view(Request $request){
        $client_domain = $this->client_domain
        ->get()
        ->map(function($item){
            return [
                'id' => $item->id,
                'img' => url('storage/' . $item->img),
                'alt' => $item->alt,
                'website' => $item->website,
                'facaebook' => $item->facaebook,
                'app_status' => $item->app_status,
                'is_client' => $item->is_client,
                'ios' => $item->ios,
                'android' => $item->android,
            ];
        });

        return response()->json([
            'client_domain' => $client_domain
        ]);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'img' => ['required'],
            'alt' => ['required'],
            'website' => ['required'],
            'facaebook' => ['required'],
            'app_status' => ['required', 'boolean'],
            'is_client' => ['required', 'boolean'],
            'ios' => ['sometimes'],
            'android' => ['sometimes'],
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        
        $domainRequest = $validator->validated();
        $domainRequest['img'] = $this->imageUpload(request:$request,inputName:'img',destinationPath:'admin/client_domain');
        $this->client_domain
        ->create($domainRequest);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'alt' => ['required'],
            'website' => ['required'],
            'facaebook' => ['required'],
            'app_status' => ['required', 'boolean'],
            'is_client' => ['required', 'boolean'],
            'ios' => ['sometimes'],
            'android' => ['sometimes'],
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }

        $domainRequest = $validator->validated();
        $client_domain = $this->client_domain
        ->where("id", $id)
        ->first();
        if(!$request->img){
            return response()->json([
                'errors' => 'id is wrong'
            ], 400);
        }
        if ($request->img && !is_string($request->img)) {
            $image = $this->imageUpdate($request, $client_domain,'img','admin/client_domain');
            $domainRequest['img'] = $image;
        }
        $client_domain
        ->update($domainRequest);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete(Request $request, $id){
        $this->client_domain
        ->where("id", $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
