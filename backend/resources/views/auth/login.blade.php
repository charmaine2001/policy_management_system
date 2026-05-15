<x-guest-layout>
    <div class="mb-12 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-white border border-gray-100 mb-6 shadow-sm group-hover:shadow-md transition-all">
            <svg class="w-10 h-10 text-zimnat-blue" viewBox="0 0 24 24" fill="none"><path d="M12 2L3 7V17L12 22L21 17V7L12 2Z" fill="currentColor"/></svg>
        </div>
        <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Zimnat Portal</h2>
        <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.4em] mt-2">Professional Access</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-8">
        @csrf

        <!-- Email Address -->
        <div class="space-y-3">
            <label for="email" class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Work Email</label>
            <div class="group relative">
                <input id="email" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus 
                       class="block w-full px-6 py-5 bg-gray-50 border border-gray-100 rounded-[24px] text-sm font-bold text-gray-700 focus:bg-white focus:border-zimnat-blue focus:ring-4 focus:ring-zimnat-blue/5 transition-all outline-none placeholder:text-gray-300"
                       placeholder="name@zimnat.co.zw"
                >
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-3">
            <div class="flex items-center justify-between ml-1">
                <label for="password" class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Password</label>
            </div>
            <div class="group relative">
                <input id="password" 
                       type="password" 
                       name="password" 
                       required 
                       class="block w-full px-6 py-5 bg-gray-50 border border-gray-100 rounded-[24px] text-sm font-bold text-gray-700 focus:bg-white focus:border-zimnat-blue focus:ring-4 focus:ring-zimnat-blue/5 transition-all outline-none placeholder:text-gray-300"
                       placeholder="••••••••"
                >
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between px-1">
            <label class="flex items-center">
                <input id="remember_me" type="checkbox" class="w-5 h-5 rounded-lg border-gray-200 text-zimnat-blue focus:ring-zimnat-blue" name="remember">
                <span class="ms-3 text-[10px] font-black text-gray-400 uppercase tracking-widest cursor-pointer">Stay Connected</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-[10px] font-black text-zimnat-blue uppercase tracking-widest hover:text-zimnat-green transition-colors" href="{{ route('password.request') }}">
                    Recover
                </a>
            @endif
        </div>

        <button type="submit" class="w-full flex items-center justify-center px-6 py-6 bg-zimnat-blue text-white rounded-[24px] font-black text-xs uppercase tracking-[0.3em] hover:bg-zimnat-blue-dark transition-all shadow-xl shadow-zimnat-blue/20 active:scale-[0.98]">
            Sign In to Dashboard
        </button>
    </form>
</x-guest-layout>
