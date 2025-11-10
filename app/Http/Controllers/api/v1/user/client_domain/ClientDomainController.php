<?php

namespace App\Http\Controllers\api\v1\user\client_domain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ClientDomain;

class ClientDomainController extends Controller
{
    public function __construct(private ClientDomain $domain){}

    public function client(Request $request){
        $domains = $this->domain
        ->where('is_client', 1)
        ->get()
        ->map(function($item){
            return [
                'img' => url('storage/' . $item->img),
                'alt' => $item->alt,
                'website' => $item->website, 
            ];
        });

        return response()->json([
            'domains' => $domains
        ]);
    }

    public function domains(Request $request){
        $domains = $this->domain
        ->get()
        ->map(function($item){
            return [
                'img' => url('storage/' . $item->img),
                'alt' => $item->alt,
                'website' => $item->website, 
            ];
        });

        return response()->json([
            'domains' => $domains
        ]);
    }

    public function client_domains(Request $request){
        $domains = $this->domain
        ->where('is_client', 1)
        ->get()
        ->map(function($item){
            return [
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
            'client_domains' => $domains
        ]);
    }
}
