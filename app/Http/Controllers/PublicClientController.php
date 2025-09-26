<?php
namespace App\Http\Controllers;

use App\Models\Client;

class PublicClientController extends Controller
{
    public function show($name){
        $client = Client::where('name',$name)->with('contents')->firstOrFail();
        return view('public.client', compact('client'));
    }
}
