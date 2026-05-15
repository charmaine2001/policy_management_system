<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Policy') }}: {{ $policy->policy_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('policies.update', $policy) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="policy_number" class="block text-sm font-medium text-gray-700">Policy Number</label>
                                <input type="text" name="policy_number" id="policy_number" value="{{ old('policy_number', $policy->policy_number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('policy_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                                <select name="client_id" id="client_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ $client->id == $policy->client_id ? 'selected' : '' }}>{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="insurance_type" class="block text-sm font-medium text-gray-700">Insurance Type</label>
                                <input type="text" name="insurance_type" id="insurance_type" value="{{ old('insurance_type', $policy->insurance_type) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label for="premium_amount" class="block text-sm font-medium text-gray-700">Premium Amount</label>
                                <input type="number" step="0.01" name="premium_amount" id="premium_amount" value="{{ old('premium_amount', $policy->premium_amount) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $policy->start_date) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label for="renewal_date" class="block text-sm font-medium text-gray-700">Renewal Date</label>
                                <input type="date" name="renewal_date" id="renewal_date" value="{{ old('renewal_date', $policy->renewal_date) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="Active" {{ $policy->status == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Expired" {{ $policy->status == 'Expired' ? 'selected' : '' }}>Expired</option>
                                    <option value="Pending Renewal" {{ $policy->status == 'Pending Renewal' ? 'selected' : '' }}>Pending Renewal</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Policy
                            </button>
                            <a href="{{ route('policies.index') }}" class="ml-2 text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
