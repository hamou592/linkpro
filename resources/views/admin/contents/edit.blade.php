@extends('admin.layout')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Edit Content</h1>

    <form method="POST" action="{{ route('contents.update', $content->id) }}" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 space-y-5">
        @csrf
        @method('PUT')

        <!-- Client -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Client</label>
            <select id="clientSelect" name="client_id" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <option value="">-- Select a Client --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}"
                            data-name="{{ $client->name }}"
                            data-phone="{{ $client->phone }}"
                            {{ $content->client_id == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
            @error('client_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Name -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Name</label>
            <input type="text" id="clientName" name="name" readonly value="{{ old('name', $content->name) }}" class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-2">
        </div>

        <!-- Phone -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Phone</label>
            <input type="text" id="clientPhone" name="phone" readonly value="{{ old('phone', $content->phone) }}" class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-2">
        </div>

        <!-- Color -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Color</label>
            <input type="text" name="color" value="{{ old('color', $content->color) }}" placeholder="#000000" class="w-full border border-gray-300 rounded-lg px-4 py-2">
        </div>

        <!-- Current Logo -->
        @if($content->logo_path)
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Current Logo</label>
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $content->logo_path) }}" alt="Logo" class="h-16">
                </div>
            </div>
        @endif

        <!-- Logo -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Change Logo</label>
            <input type="file" name="logo" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            @error('logo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Current Background -->
        @if($content->background_path)
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Current Background</label>
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $content->background_path) }}" alt="Background" class="h-20 rounded-lg object-cover">
                </div>
            </div>
        @endif

        <!-- Background -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Change Background</label>
            <input type="file" name="background" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            @error('background') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        @php
            $links = $content->links ?? [];
            $geo = $content->geolocation ?? [];
        @endphp

        <!-- Links -->
        <div class="space-y-3">
            <label class="block mb-1 text-gray-700 font-medium">Links (enter full URLs)</label>
            <input type="text" name="links[tiktok]" value="{{ old('links.tiktok', $links['tiktok'] ?? '') }}" placeholder="TikTok URL" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            <input type="text" name="links[facebook]" value="{{ old('links.facebook', $links['facebook'] ?? '') }}" placeholder="Facebook URL" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            <input type="text" name="links[instagram]" value="{{ old('links.instagram', $links['instagram'] ?? '') }}" placeholder="Instagram URL" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            <input type="text" name="links[youtube]" value="{{ old('links.youtube', $links['youtube'] ?? '') }}" placeholder="YouTube URL" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            <input type="text" name="links[website]" value="{{ old('links.website', $links['website'] ?? '') }}" placeholder="Website URL" class="w-full border border-gray-300 rounded-lg px-4 py-2">
        </div>

        <!-- Geolocation -->
        <div class="space-y-3">
            <label class="block mb-1 text-gray-700 font-medium">Geolocation (latitude & longitude)</label>
            <input type="text" name="geolocation[latitude]" value="{{ old('geolocation.latitude', $geo['latitude'] ?? '') }}" placeholder="Latitude" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            <input type="text" name="geolocation[longitude]" value="{{ old('geolocation.longitude', $geo['longitude'] ?? '') }}" placeholder="Longitude" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            @if(!empty($geo['link']))
                <p class="text-sm text-gray-500">Saved map link: <a target="_blank" href="{{ $geo['link'] }}" class="text-blue-600">{{ $geo['link'] }}</a></p>
            @endif
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('contents.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Cancel</a>
            <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const clientSelect = document.getElementById('clientSelect');

    function syncClient() {
        const selected = clientSelect.options[clientSelect.selectedIndex];
        document.getElementById('clientName').value = selected?.dataset?.name || '';
        document.getElementById('clientPhone').value = selected?.dataset?.phone || '';
    }

    clientSelect.addEventListener('change', syncClient);
    // initialize on page load
    syncClient();
});
</script>
@endsection
