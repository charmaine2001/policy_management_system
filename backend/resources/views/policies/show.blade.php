<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Policy Details: {{ $policy->policy_number }}
            </h2>
            <a href="{{ route('policies.index') }}" class="text-gray-600 hover:text-gray-900">Back to List</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Client Name</p>
                                <p class="font-medium">{{ $policy->client->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Insurance Type</p>
                                <p class="font-medium">{{ $policy->insurance_type }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Premium Amount</p>
                                <p class="font-medium">${{ number_format($policy->premium_amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $policy->status == 'Active' ? 'bg-green-100 text-green-800' : ($policy->status == 'Expired' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $policy->status }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Start Date</p>
                                <p class="font-medium">{{ $policy->start_date }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Renewal Date</p>
                                <p class="font-medium text-blue-600">{{ $policy->renewal_date }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Documents</h3>
                        @if($policy->documents->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($policy->documents as $doc)
                                    <li class="py-3 flex justify-between items-center">
                                        <div class="flex items-center">
                                            <svg class="h-6 w-6 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $doc->file_name }} ({{ strtoupper($doc->file_type) }})</span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                                            <form action="{{ route('documents.destroy', $doc) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Are you sure?')">Remove</button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 italic text-sm">No documents uploaded yet.</p>
                        @endif
                    </div>
                </div>

                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Upload Document</h3>
                        <form action="{{ route('documents.store', $policy) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="document" class="block text-sm font-medium text-gray-700 mb-2">Select File (JPG, PNG, PDF)</label>
                                <input type="file" name="document" id="document" class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100" required>
                                @error('document') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                                Upload
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
