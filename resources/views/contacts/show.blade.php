@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-6 text-center">Contact Details</h1>

    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow-md">
        <p class="mb-2"><strong>ID:</strong> {{ $contact['id'] }}</p>
        <p class="mb-2"><strong>Name:</strong> {{ $contact['name'] }}</p>
        <p class="mb-2"><strong>Email:</strong> {{ $contact['email'] }}</p>
        <p class="mb-2"><strong>Phone:</strong> {{ $contact['phone'] }}</p>
        <p class="mb-4"><strong>Message:</strong> {{ $contact['message'] }}</p>
        <p class="mb-2"><strong>Created At:</strong> {{ $contact['created_at'] }}</p>
        <p class="mb-2"><strong>Updated At:</strong> {{ $contact['updated_at'] }}</p>
        <div class="flex justify-end space-x-2">
            <a href="{{ route('contacts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
            <a href="{{ route('contacts.edit', $contact['id']) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Edit</a>
            <form action="{{ route('contacts.destroy', $contact['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this contact?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
            </form>
        </div>
    </div>
@endsection