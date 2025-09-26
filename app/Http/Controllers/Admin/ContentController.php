<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $query = Content::with('client');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%$search%")
                  ->orWhereHas('client', function ($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
        }

        $contents = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contents.index', compact('contents'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('admin.contents.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'color' => 'nullable|string',
            'logo' => 'nullable|image|max:10240', // max 10MB
            'background' => 'nullable|file|max:51200', // allow video/image up to 50MB
            'links' => 'nullable|array',
            'links.*' => 'nullable|url',
            'geolocation' => 'nullable|array',
            'geolocation.latitude' => 'nullable|numeric',
            'geolocation.longitude' => 'nullable|numeric',
        ]);

        $client = Client::findOrFail($data['client_id']);

        $content = new Content();
        $content->client_id = $client->id;
        // name & phone are taken from the selected client (default)
        $content->name = $client->name;
        $content->phone = $client->phone;
        $content->color = $data['color'] ?? null;

        // files
        if ($request->hasFile('logo')) {
            $content->logo_path = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('background')) {
            $content->background_path = $request->file('background')->store('backgrounds', 'public');
        }

        // Links: filter empty values and store as array (model casts to JSON)
        $links = $request->input('links', []);
        if (is_array($links)) {
            $filtered = array_filter($links, function ($v) {
                return $v !== null && trim($v) !== '';
            });
            $content->links = count($filtered) ? $filtered : null;
        } else {
            $content->links = null;
        }

        // Geolocation: if lat & lng provided, create link and store as an object
        $geo = $request->input('geolocation', []);
        if (!empty($geo['latitude']) && !empty($geo['longitude'])) {
            $lat = (string) $geo['latitude'];
            $lng = (string) $geo['longitude'];
            $link = "https://maps.google.com/?q={$lat},{$lng}";
            $content->geolocation = [
                'latitude' => $lat,
                'longitude' => $lng,
                'link' => $link,
            ];
        } else {
            $content->geolocation = null;
        }

        $content->save();

        return redirect()->route('contents.index')->with('success', 'Content created');
    }

    public function edit(Content $content)
    {
        $clients = Client::all();
        return view('admin.contents.edit', compact('content', 'clients'));
    }

    public function update(Request $request, Content $content)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'color' => 'nullable|string',
            'logo' => 'nullable|image|max:10240',
            'background' => 'nullable|file|max:51200',
            'links' => 'nullable|array',
            'links.*' => 'nullable|url',
            'geolocation' => 'nullable|array',
            'geolocation.latitude' => 'nullable|numeric',
            'geolocation.longitude' => 'nullable|numeric',
        ]);

        $client = Client::findOrFail($data['client_id']);

        $content->client_id = $client->id;
        $content->name = $client->name;
        $content->phone = $client->phone;
        $content->color = $data['color'] ?? null;

        // Replace logo: delete old file if exists
        if ($request->hasFile('logo')) {
            if ($content->logo_path) {
                Storage::disk('public')->delete($content->logo_path);
            }
            $content->logo_path = $request->file('logo')->store('logos', 'public');
        }

        // Replace background: delete old file if exists
        if ($request->hasFile('background')) {
            if ($content->background_path) {
                Storage::disk('public')->delete($content->background_path);
            }
            $content->background_path = $request->file('background')->store('backgrounds', 'public');
        }

        // Links
        $links = $request->input('links', []);
        if (is_array($links)) {
            $filtered = array_filter($links, function ($v) {
                return $v !== null && trim($v) !== '';
            });
            $content->links = count($filtered) ? $filtered : null;
        } else {
            $content->links = null;
        }

        // Geolocation
        $geo = $request->input('geolocation', []);
        if (!empty($geo['latitude']) && !empty($geo['longitude'])) {
            $lat = (string) $geo['latitude'];
            $lng = (string) $geo['longitude'];
            $link = "https://maps.google.com/?q={$lat},{$lng}";
            $content->geolocation = [
                'latitude' => $lat,
                'longitude' => $lng,
                'link' => $link,
            ];
        } else {
            $content->geolocation = null;
        }

        $content->save();

        return redirect()->route('contents.index')->with('success', 'Content updated');
    }

    public function show(Content $content)
    {
        return view('admin.contents.show', compact('content'));
    }

    public function destroy(Content $content)
    {
        // optionally delete stored files
        if ($content->logo_path) {
            Storage::disk('public')->delete($content->logo_path);
        }
        if ($content->background_path) {
            Storage::disk('public')->delete($content->background_path);
        }

        $content->delete();
        return redirect()->route('contents.index')->with('success', 'Content deleted');
    }
}
