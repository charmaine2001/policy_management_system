<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Policy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('policies.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="policy_number" class="block text-sm font-medium text-gray-700">Policy Number</label>
                                <input type="text" name="policy_number" id="policy_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-zimnat-blue focus:ring-zimnat-blue" required>
                                @error('policy_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-700">Client</label>
                                <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-zimnat-blue focus:ring-zimnat-blue" required>
                                    <option value="">Select Client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email }})</option>
                                    @endforeach
                                </select>
                                @error('user_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="policy_type_id" class="block text-sm font-medium text-gray-700">Policy Type</label>
                                <select name="policy_type_id" id="policy_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-zimnat-blue focus:ring-zimnat-blue" required>
                                    <option value="">Select Type</option>
                                    @foreach($policyTypes as $type)
                                        <option value="{{ $type->id }}" data-standard="{{ $type->standard_price }}" data-premium="{{ $type->premium_price }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('policy_type_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="plan_type" class="block text-sm font-medium text-gray-700">Plan Type</label>
                                <select name="plan_type" id="plan_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-zimnat-blue focus:ring-zimnat-blue" required>
                                    <option value="Standard">Standard</option>
                                    <option value="Premium">Premium</option>
                                </select>
                                @error('plan_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="final_price" class="block text-sm font-medium text-gray-700">Final Price</label>
                                <input type="number" step="0.01" name="final_price" id="final_price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-zimnat-blue focus:ring-zimnat-blue" required>
                                @error('final_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-zimnat-blue focus:ring-zimnat-blue" required>
                                @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="renewal_date" class="block text-sm font-medium text-gray-700">Renewal Date</label>
                                <input type="date" name="renewal_date" id="renewal_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-zimnat-blue focus:ring-zimnat-blue" required>
                                @error('renewal_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-zimnat-blue focus:ring-zimnat-blue" required>
                                    <option value="Active">Active</option>
                                    <option value="Expired">Expired</option>
                                    <option value="Pending Renewal">Pending Renewal</option>
                                </select>
                                @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Policy
                            </button>
                            <a href="{{ route('policies.index') }}" class="ml-2 text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('policy_type_id');
            const planSelect = document.getElementById('plan_type');
            const priceInput = document.getElementById('final_price');

            function updatePrice() {
                const selectedOption = typeSelect.options[typeSelect.selectedIndex];
                if (!selectedOption || !selectedOption.value) {
                    priceInput.value = '';
                    return;
                }

                const plan = planSelect.value;
                const price = plan === 'Premium' ? selectedOption.dataset.premium : selectedOption.dataset.standard;
                priceInput.value = price;
            }

            typeSelect.addEventListener('change', updatePrice);
            planSelect.addEventListener('change', updatePrice);
        });
    </script>
</x-app-layout>
