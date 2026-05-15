<x-app-layout>
    <x-slot name="header">
        {{ __('Edit User: ' . $user->name) }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-zimnat-green">
                <div class="p-6">
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label class="block text-zimnat-blue text-sm font-bold mb-2 italic" for="name">Name</label>
                            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border-zimnat-blue" required value="{{ old('name', $user->name) }}">
                            @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-zimnat-blue text-sm font-bold mb-2 italic" for="email">Email</label>
                            <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border-zimnat-blue" required value="{{ old('email', $user->email) }}">
                            @error('email') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-zimnat-blue text-sm font-bold mb-2 italic" for="role">Role</label>
                            <select name="role" id="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border-zimnat-blue">
                                <option value="client" {{ $user->role == 'client' ? 'selected' : '' }}>Client</option>
                                <option value="policy_officer" {{ $user->role == 'policy_officer' ? 'selected' : '' }}>Policy Officer</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mt-8 mb-4 border-t pt-4">
                            <p class="text-sm text-gray-600 italic">Leave password blank if you don't want to change it.</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-zimnat-blue text-sm font-bold mb-2 italic" for="password">New Password</label>
                            <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border-zimnat-blue">
                            @error('password') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-zimnat-blue text-sm font-bold mb-2 italic" for="password_confirmation">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border-zimnat-blue">
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-zimnat-blue hover:bg-blue-800 text-white font-bold py-2 px-4 rounded italic transition duration-200">
                                Update User
                            </button>
                            <a href="{{ route('users.index') }}" class="text-zimnat-blue hover:text-blue-800 font-bold italic">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
