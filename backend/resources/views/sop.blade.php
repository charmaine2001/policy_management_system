<x-app-layout>
    <x-slot name="header">
        {{ __('User SOP') }}
    </x-slot>

    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-[32px] overflow-hidden border border-gray-100">
            <div class="px-10 py-12 prose prose-zimnat max-w-none">
                <div class="mb-12 border-b border-gray-100 pb-8">
                    <h1 class="text-4xl font-black text-gray-900 uppercase tracking-tighter mb-4">User SOP: System Architecture</h1>
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Standard Operating Procedure & Handover Guide</p>
                </div>

                <div class="space-y-12">
                    <section>
                        <h2 class="text-xl font-black text-zimnat-blue uppercase tracking-widest mb-6 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-sm">01</span>
                            The Big Picture
                        </h2>
                        <p class="text-gray-600 leading-relaxed mb-6 font-medium">
                            The Zimnat Policy System is built using a **Centralized Brain** (Backend) and **Multiple Faces** (Frontend).
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100">
                                <p class="font-black text-[10px] text-zimnat-blue uppercase tracking-widest mb-2">The Brain</p>
                                <p class="text-xs font-bold text-gray-700">Laravel handles all the logic, security, and data management.</p>
                            </div>
                            <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100">
                                <p class="font-black text-[10px] text-zimnat-green uppercase tracking-widest mb-2">The Memory</p>
                                <p class="text-xs font-bold text-gray-700">SQLite stores every policy and query securely.</p>
                            </div>
                            <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100">
                                <p class="font-black text-[10px] text-orange-500 uppercase tracking-widest mb-2">The Interface</p>
                                <p class="text-xs font-bold text-gray-700">Flutter (Mobile) and Blade (Web) allow users to interact.</p>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-zimnat-blue uppercase tracking-widest mb-6 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-sm">02</span>
                            Technology Stack
                        </h2>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-4">
                                <div class="w-2 h-2 rounded-full bg-zimnat-green mt-1.5 flex-shrink-0"></div>
                                <div>
                                    <p class="text-sm font-black text-gray-900 uppercase tracking-tight">Backend: PHP 8 + Laravel</p>
                                    <p class="text-xs text-gray-500 mt-1 font-medium">Industry-standard framework for enterprise-grade security and reliability.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="w-2 h-2 rounded-full bg-zimnat-green mt-1.5 flex-shrink-0"></div>
                                <div>
                                    <p class="text-sm font-black text-gray-900 uppercase tracking-tight">Mobile: Dart + Flutter</p>
                                    <p class="text-xs text-gray-500 mt-1 font-medium">Google's framework for high-performance cross-platform mobile apps.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="w-2 h-2 rounded-full bg-zimnat-green mt-1.5 flex-shrink-0"></div>
                                <div>
                                    <p class="text-sm font-black text-gray-900 uppercase tracking-tight">Styling: Tailwind CSS</p>
                                    <p class="text-xs text-gray-500 mt-1 font-medium">Modern utility-first CSS for slick, branded interfaces.</p>
                                </div>
                            </li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-zimnat-blue uppercase tracking-widest mb-6 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-sm">03</span>
                            SDLC Model: Agile
                        </h2>
                        <p class="text-sm text-gray-600 leading-relaxed font-medium">
                            We use the **Agile/Scrum** model. This means we build the application in small, iterative steps. Every feature (like Policy Management) is a "User Story" that is completed and tested before moving to the next. This ensures the application is always "demo-ready."
                        </p>
                    </section>

                    <section class="p-8 rounded-[24px] bg-zimnat-blue/5 border border-zimnat-blue/10">
                        <h2 class="text-lg font-black text-zimnat-blue uppercase tracking-widest mb-4">UX Improvement Advice</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-[10px] font-black text-zimnat-blue uppercase mb-2">Technical</p>
                                <p class="text-xs text-gray-600 font-bold leading-relaxed">Implement push notifications and real-time chat sync for instant communication.</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-zimnat-green uppercase mb-2">Design</p>
                                <p class="text-xs text-gray-600 font-bold leading-relaxed">Add dark mode support and biometric authentication (FaceID) for mobile.</p>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="mt-16 pt-8 border-t border-gray-100 flex justify-between items-center">
                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.2em]">Zimnat Policy System v1.0</p>
                    <button onclick="window.print()" class="px-6 py-3 bg-gray-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-zimnat-blue transition-all">
                        Download PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>