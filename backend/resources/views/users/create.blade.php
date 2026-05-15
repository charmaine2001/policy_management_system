<x-app-layout>
    <x-slot name="header">
        {{ __('Add New User') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-zimnat-green">
                <div class="p-6">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-zimnat-blue text-sm font-bold mb-2 italic" for="name">Name</label>
                            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border-zimnat-blue" required value="{{ old('name') }}">
                            @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-zimnat-blue text-sm font-bold mb-2 italic" for="email">Email</label>
                            <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border-zimnat-blue" required value="{{ old('email') }}">
                            @error('email') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-zimnat-blue text-sm font-bold mb-2 italic" for="role">Role</label>
                            <select name="role" id="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border-zimnat-blue">
                                <option value="client">Client</option>
                                @if(auth()->user()->role === 'admin')
                                    <option value="policy_officer">Policy Officer</option>
                                    <option value="admin">Admin</option>
                                @endif
                            </select>
                            @error('role') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-zimnat-blue text-sm font-bold mb-2 italic" for="password">Password</label>
                            <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border-zimnat-blue" required>
                            @error('password') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-zimnat-blue text-sm font-bold mb-2 italic" for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border-zimnat-blue" required>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-zimnat-blue hover:bg-blue-800 text-white font-bold py-2 px-4 rounded italic transition duration-200">
                                Create User
                            </button>
                            <a href="{{ route('users.index') }}" class="text-zimnat-blue hover:text-blue-800 font-bold italic">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
