<x-app-layout>
    <div class="max-w-md mx-auto py-10 px-4 sm:px-6 lg:px-8">

        {{-- Page Title --}}
        <div class="mb-8">
            <p class="text-xs font-semibold tracking-[0.2em] text-slate-400 uppercase">
                Create User
            </p>
            <h2 class="text-2xl font-bold text-slate-900 mt-1">
                Add New User
            </h2>
        </div>

        {{-- Card --}}
        <div class="bg-white/90 backdrop-blur border border-slate-100 rounded-2xl shadow-sm p-6">

            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="text-sm font-medium text-slate-600">Full Name</label>
                    <input type="text" name="name"
                           class="mt-1 w-full px-3 py-2 border border-slate-200 rounded-lg
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           required>
                </div>

                {{-- Email --}}
                <div>
                    <label class="text-sm font-medium text-slate-600">Email Address</label>
                    <input type="email" name="email"
                           class="mt-1 w-full px-3 py-2 border border-slate-200 rounded-lg
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           required>
                </div>

                {{-- Password --}}
                <div>
                    <label class="text-sm font-medium text-slate-600">Password</label>
                    <input type="password" name="password"
                           class="mt-1 w-full px-3 py-2 border border-slate-200 rounded-lg
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           required>
                </div>

                {{-- Admin checkbox --}}
                <div class="flex items-center gap-2">
                    <input type="checkbox"
                           name="is_admin"
                           class="rounded text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm text-slate-700">Grant Admin Access</span>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold
                               hover:bg-indigo-700 shadow-sm transition-all">
                    Create User
                </button>

            </form>

        </div>
    </div>
</x-app-layout>
