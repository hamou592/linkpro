@extends('admin.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-semibold text-gray-800">Content Details</h1>
        <a href="{{ route('contents.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg shadow text-gray-700 transition">
            ← Back
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-xl p-8 space-y-8">
        {{-- Client --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-1">Client</h2>
            <p class="text-gray-900 text-lg">{{ $content->client->name }}</p>
        </div>

        {{-- Name & Phone --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-1">Name</h2>
                <p class="text-gray-900">{{ $content->name }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-1">Phone</h2>
                <p class="text-gray-900">{{ $content->phone }}</p>
            </div>
        </div>

        {{-- Color --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-1">Color</h2>
            <div class="flex items-center gap-3">
                <span class="inline-block w-7 h-7 rounded-full border shadow" style="background: {{ $content->color }}"></span>
                <span class="text-gray-900">{{ $content->color }}</span>
            </div>
        </div>

        {{-- Logo --}}
        @if($content->logo_path)
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-1">Logo</h2>
            <div class="border rounded-lg p-4 bg-gray-50 flex justify-center">
                <img 
                    src="{{ asset('storage/' . $content->logo_path) }}" 
                    alt="Logo" 
                    class="h-24 cursor-pointer hover:scale-105 transition"
                    onclick="openModal('{{ asset('storage/' . $content->logo_path) }}','image')">
            </div>
        </div>
        @endif

        {{-- Background (Image or Video) --}}
        @if ($content->background_path)
            @php
                $ext = strtolower(pathinfo($content->background_path, PATHINFO_EXTENSION));
                $isVideo = in_array($ext, ['mp4','webm','ogg']);
            @endphp
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-1">Background</h2>
                <div class="border rounded-lg p-4 bg-gray-50 flex justify-center">
                    @if ($isVideo)
                        <video 
                            class="h-40 rounded-lg object-cover cursor-pointer hover:opacity-80 transition"
                            onclick="openModal('{{ asset('storage/' . $content->background_path) }}','video')"
                            muted
                        >
                            <source src="{{ asset('storage/' . $content->background_path) }}" type="video/{{ $ext }}">
                        </video>
                    @else
                        <img 
                            src="{{ asset('storage/' . $content->background_path) }}" 
                            alt="Background" 
                            class="h-40 rounded-lg object-cover cursor-pointer hover:scale-105 transition"
                            onclick="openModal('{{ asset('storage/' . $content->background_path) }}','image')">
                    @endif
                </div>
            </div>
        @endif

        {{-- Links --}}
        @php
            $links = is_array($content->links) ? $content->links : json_decode($content->links, true);
            $geo = is_array($content->geolocation) ? $content->geolocation : json_decode($content->geolocation, true);
            $icons = [
                'tiktok' => 'fab fa-tiktok',
                'facebook' => 'fab fa-facebook-f',
                'instagram' => 'fab fa-instagram',
                'youtube' => 'fab fa-youtube',
                'website' => 'fas fa-globe',
            ];
        @endphp
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Links</h2>
            <div class="space-y-3">
                @forelse($links ?? [] as $key => $link)
                    @if($link)
                        <a target="_blank" href="{{ $link }}" class="flex items-center gap-3 group">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 group-hover:bg-gray-200 transition">
                                <i class="{{ $icons[$key] ?? 'fas fa-link' }} text-lg text-gray-700"></i>
                            </div>
                            <span class="text-blue-600 hover:underline break-all">{{ $link }}</span>
                        </a>
                    @endif
                @empty
                    <p class="text-gray-500">No links provided</p>
                @endforelse
            </div>
        </div>

        {{-- Geolocation --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Geolocation</h2>
            @if(!empty($geo['latitude']) && !empty($geo['longitude']))
                <p class="text-gray-800 mb-2">Lat: {{ $geo['latitude'] }}, Lng: {{ $geo['longitude'] }}</p>
                <iframe
                    class="w-full h-64 rounded-lg"
                    src="https://maps.google.com/maps?q={{ $geo['latitude'] }},{{ $geo['longitude'] }}&z=15&output=embed">
                </iframe>
            @else
                <p class="text-gray-500">No geolocation data</p>
            @endif
        </div>
    </div>
</div>

{{-- MODAL --}}
<div id="mediaModal" class="fixed inset-0 hidden bg-black/80 items-center justify-center z-50 p-4">
    <span onclick="closeModal()" class="absolute top-4 right-6 text-white text-3xl cursor-pointer">&times;</span>
    <img id="modalImage" class="max-h-[80vh] max-w-full rounded-lg hidden shadow-xl">
    <video id="modalVideo" class="max-h-[80vh] max-w-full rounded-lg hidden shadow-xl" controls></video>
</div>

<script>
function openModal(src, type) {
    const modal = document.getElementById('mediaModal');
    const img = document.getElementById('modalImage');
    const video = document.getElementById('modalVideo');

    if (type === 'image') {
        img.src = src;
        img.classList.remove('hidden');
        video.classList.add('hidden');
    } else {
        video.src = src;
        video.classList.remove('hidden');
        img.classList.add('hidden');
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    const modal = document.getElementById('mediaModal');
    const video = document.getElementById('modalVideo');
    video.pause();
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endsection
