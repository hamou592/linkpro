@extends('admin.layout')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Add New Content</h1>

    <form method="POST" action="{{ route('contents.store') }}" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 space-y-5">
        @csrf

        <!-- Client -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Client</label>
            <select id="clientSelect" name="client_id" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <option value="">-- Select a Client --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}"
                            data-name="{{ $client->name }}"
                            data-phone="{{ $client->phone }}"
                            {{ old('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
            @error('client_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Name -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Name</label>
            <input type="text" id="clientName" name="name" readonly value="{{ old('name') }}" class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-2">
        </div>

        <!-- Phone -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Phone</label>
            <input type="text" id="clientPhone" name="phone" readonly value="{{ old('phone') }}" class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-2">
        </div>

        <!-- Color -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Color</label>
            <input type="text" name="color" value="{{ old('color') }}" placeholder="#000000" class="w-full border border-gray-300 rounded-lg px-4 py-2">
        </div>

        <!-- Logo -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Logo</label>
            <input type="file" name="logo" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            @error('logo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Background -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Background (image or video)</label>
            <input type="file" name="background" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            @error('background') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Links -->
        <div class="space-y-3">
            <label class="block mb-1 text-gray-700 font-medium">Links (enter full URLs)</label>
            <input type="text" name="links[tiktok]" value="{{ old('links.tiktok') }}" placeholder="TikTok URL (https://...)" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            <input type="text" name="links[facebook]" value="{{ old('links.facebook') }}" placeholder="Facebook URL (https://...)" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            <input type="text" name="links[instagram]" value="{{ old('links.instagram') }}" placeholder="Instagram URL (https://...)" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            <input type="text" name="links[youtube]" value="{{ old('links.youtube') }}" placeholder="YouTube URL (https://...)" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            <input type="text" name="links[website]" value="{{ old('links.website') }}" placeholder="Website URL (https://...)" class="w-full border border-gray-300 rounded-lg px-4 py-2">
        </div>

        <!-- Geolocation -->
        <div class="space-y-3">
            <label class="block mb-1 text-gray-700 font-medium">Geolocation (latitude & longitude)</label>
            <input type="text" name="geolocation[latitude]" value="{{ old('geolocation.latitude') }}" placeholder="Latitude (e.g. 35.6895)" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            <input type="text" name="geolocation[longitude]" value="{{ old('geolocation.longitude') }}" placeholder="Longitude (e.g. 139.6917)" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            <p class="text-sm text-gray-500 mt-1">If you fill both latitude and longitude, a Google Maps link will be saved for this content.</p>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('contents.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Cancel</a>
            <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create</button>
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
    // initialize on page load (for old values)
    syncClient();
});
</script>
@endsection
