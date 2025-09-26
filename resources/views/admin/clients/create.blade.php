@extends('admin.layout')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Add New Client</h1>

    <form method="POST" action="{{ route('clients.store') }}" class="bg-white shadow rounded-lg p-6 space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Name</label>
            <input 
                type="text" 
                name="name" 
                value="{{ old('name') }}" 
                placeholder="Enter client name"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                required
            >
            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Email -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Email</label>
            <input 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                placeholder="Enter client email"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
            >
            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Phone -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Phone</label>
            <input 
                type="text" 
                name="phone" 
                value="{{ old('phone') }}" 
                placeholder="Enter client phone number"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
            >
            @error('phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Activite -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Activité</label>
            <input 
                type="text" 
                name="activite" 
                value="{{ old('activite') }}" 
                placeholder="Enter client's activity"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
            >
            @error('activite') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('clients.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">Cancel</a>
            <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create</button>
        </div>
    </form>
</div>
@endsection
