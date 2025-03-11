@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-6 text-center">All Contacts</h1>

    @include('partials.flash')

    @include('partials.errors')

    <div class="flex justify-end mb-4">
        <a href="{{ route('contacts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Contact</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-blue-700 text-white">
                <tr>
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">Name</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Phone</th>
                    <th class="py-3 px-4">Message</th>
                    <th class="py-3 px-4">Created At</th>
                    <th class="py-3 px-4">Updated At</th>
                    <th class="py-3 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                    <tr class="text-center border-t hover:bg-gray-50">
                        <td class="py-2 px-4">{{ $contact['id'] }}</td>
                        <td class="py-2 px-4">{{ $contact['name'] }}</td>
                        <td class="py-2 px-4">{{ $contact['email'] }}</td>
                        <td class="py-2 px-4">{{ $contact['phone'] }}</td>
                        <td class="py-2 px-4">
                            {{ \Illuminate\Support\Str::limit($contact['message'], 50) }}
                            @if (strlen($contact['message']) > 50)
                                <a href="{{ route('contacts.show', $contact['id']) }}" class="text-blue-500 hover:underline">Read More</a>
                            @endif
                        </td>
                        <td class="py-2 px-4">{{ $contact['created_at'] }}</td>
                        <td class="py-2 px-4">{{ $contact['updated_at'] }}</td>
                        <td class="py-2 px-4 flex justify-center space-x-2">
                            <a href="{{ route('contacts.show', $contact['id']) }}" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">View</a>
                            <a href="{{ route('contacts.edit', $contact['id']) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</a>
                            <form action="{{ route('contacts.destroy', $contact['id']) }}" method="POST" onsubmit="return confirm('Are you sure to delete this contact?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-4 text-center text-gray-500">No contacts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection