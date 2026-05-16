<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Query Details
            </h2>
            <a href="{{ route('queries.index') }}" class="text-gray-600 hover:text-gray-900">Back to List</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="border-b pb-4 mb-4">
                    <h3 class="text-lg font-semibold">{{ $query->subject }}</h3>
                    <p class="text-sm text-gray-500">From: {{ $query->client->name }} ({{ $query->client->email }}) on {{ $query->created_at }}</p>
                </div>
                
                <div class="mb-6 p-4 bg-gray-50 rounded">
                    <h4 class="text-sm font-bold text-gray-700 uppercase mb-2">Message:</h4>
                    <p class="text-gray-800">{{ $query->message }}</p>
                </div>

                <form action="{{ route('queries.update', $query) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-zimnat-blue focus:ring-zimnat-blue">
                            <option value="Open" {{ $query->status == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="In Progress" {{ $query->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Resolved" {{ $query->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="response" class="block text-sm font-medium text-gray-700 mb-2">Response</label>
                        <textarea name="response" id="response" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-zimnat-blue focus:ring-zimnat-blue" required placeholder="Type your response here...">{{ $query->response }}</textarea>
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Save Response & Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
