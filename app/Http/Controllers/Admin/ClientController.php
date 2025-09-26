<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function index(Request $request){
        $query = Client::query();

        if($search = $request->input('search')){
            $query->where('name','like',"%$search%")
                  ->orWhere('email','like',"%$search%")
                  ->orWhere('phone','like',"%$search%");
        }

        $clients = $query->orderBy('created_at','desc')->paginate(10);
        return view('admin.clients.index', compact('clients'));
    }

    public function create(){
        return view('admin.clients.create');
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'activite' => 'nullable|string',
        ]);

        Client::create($data);

        return redirect()->route('clients.index')->with('success','Client created successfully');
    }

    public function edit(Client $client){
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'activite' => 'nullable|string',
        ]);

        $client->update($data);

        return redirect()->route('clients.index')->with('success','Client updated successfully');
    }

    public function destroy(Client $client){
        $client->delete();
        return redirect()->route('clients.index')->with('success','Client deleted successfully');
    }
}
