@extends('admin.layout')

@section('content')
<div class="flex flex-col sm:flex-row items-center justify-between mb-6 gap-4">
    <h1 class="text-3xl font-semibold text-gray-800">Clients</h1>
    <a href="{{ route('clients.create') }}"
       class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
       + Add Client
    </a>
</div>

<form method="GET" class="mb-6">
    <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
        <input
            name="search"
            value="{{ request('search') }}"
            placeholder="Search by name, email or phone..."
            class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-300 focus:outline-none"
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
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Name</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Email</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Phone</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Activite</th>
                <th class="px-4 py-3 text-right text-sm font-medium text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clients as $client)
            <tr class="border-t hover:bg-gray-50 transition">
                <td class="px-4 py-3 text-sm text-gray-800">{{ $client->name }}</td>
                <td class="px-4 py-3 text-sm text-gray-800">{{ $client->email }}</td>
                <td class="px-4 py-3 text-sm text-gray-800">{{ $client->phone }}</td>
                <td class="px-4 py-3 text-sm text-gray-800">{{ $client->activite }}</td>
                <td class="px-4 py-3 text-sm text-right space-x-2">
                    <a href="{{ route('clients.edit', $client) }}"
                       class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition">
                       Edit
                    </a>
                    <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button
                            onclick="return confirm('Are you sure you want to delete this client?')"
                            class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition"
                        >
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                    No clients found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $clients->links() }}
</div>
@endsection
