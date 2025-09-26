@extends('admin.layout')

@section('content')
<div class="flex flex-col sm:flex-row items-center justify-between mb-6 gap-4">
    <h1 class="text-3xl font-semibold text-gray-800">Contents</h1>
    <a href="{{ route('contents.create') }}"
       class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
       + Add Content
    </a>
</div>

<form method="GET" class="mb-6">
    <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
        <input
            name="search"
            value="{{ request('search') }}"
            placeholder="Search by content or client..."
            class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-300 focus:outline-none"
        >
        <button
            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow transition"
        >
            Search
        </button>
    </div>
</form>

<div class="overflow-x-auto bg-white shadow rounded-lg">
    <table class="min-w-full table-auto">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Client</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Name</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Phone</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Color</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">QR</th>
                <th class="px-4 py-3 text-right text-sm font-medium text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contents as $content)
            @php
                $clientSlug = strtolower(str_replace(' ', '', $content->client->name));
                $qrUrl = "http://127.0.0.1:8000/" . $clientSlug;
                $qrImg = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrUrl);
            @endphp
            <tr class="border-t hover:bg-gray-50 transition">
                <td class="px-4 py-3 text-sm text-gray-800">{{ $content->client->name }}</td>
                <td class="px-4 py-3 text-sm text-gray-800">{{ $content->name }}</td>
                <td class="px-4 py-3 text-sm text-gray-800">{{ $content->phone }}</td>
                <td class="px-4 py-3 text-sm text-gray-800">
                    <span class="inline-block w-5 h-5 rounded-full border" style="background: {{ $content->color }}"></span>
                    {{ $content->color }}
                </td>
                <td class="px-4 py-3 text-sm text-gray-800">
                    <button 
                        type="button" 
                        onclick="showQrModal('{{ $qrImg }}', '{{ $qrUrl }}')"
                        class="text-blue-600 hover:text-blue-800"
                        title="Show QR Code"
                    >
                        <i class="fas fa-qrcode text-xl"></i>
                    </button>
                </td>
                <td class="px-4 py-3 text-sm text-right space-x-2">
                    <a href="{{ route('contents.show', $content) }}"
                       class="inline-block px-3 py-1 bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200 transition">
                       Details
                    </a>
                    <a href="{{ route('contents.edit', $content) }}"
                       class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition">
                       Edit
                    </a>
                    <form action="{{ route('contents.destroy', $content) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button
                            onclick="return confirm('Are you sure you want to delete this content?')"
                            class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition"
                        >
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                    No contents found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $contents->links() }}
</div>

{{-- QR MODAL --}}
<div id="qrModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg p-6 max-w-sm w-full text-center relative">
        <button onclick="closeQrModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Scan this QR Code</h2>
        <img id="qrImage" src="" alt="QR Code" class="mx-auto w-40 h-40 mb-2">
        <a id="qrLink" href="#" target="_blank" class="text-blue-600 hover:underline break-all"></a>
    </div>
</div>

<script>
    function showQrModal(imgSrc, url) {
        document.getElementById('qrImage').src = imgSrc;
        document.getElementById('qrLink').textContent = url;
        document.getElementById('qrLink').href = url;
        document.getElementById('qrModal').classList.remove('hidden');
        document.getElementById('qrModal').classList.add('flex');
    }
    function closeQrModal() {
        document.getElementById('qrModal').classList.add('hidden');
        document.getElementById('qrModal').classList.remove('flex');
    }
    document.getElementById('qrModal').addEventListener('click', function(e){
        if(e.target.id === 'qrModal'){ closeQrModal(); }
    });
</script>
@endsection
