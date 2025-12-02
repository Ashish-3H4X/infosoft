<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        {{-- Page header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <p class="text-xs font-semibold tracking-[0.2em] text-slate-400 uppercase">
                    Users
                </p>
                <h2 class="mt-1 text-2xl font-bold text-slate-900">
                    Team Members
                </h2>
            </div>

            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center px-4 py-2 rounded-full
                      bg-indigo-600 text-white text-sm font-medium shadow-sm
                      hover:bg-indigo-700 focus:outline-none focus:ring-2
                      focus:ring-indigo-500 focus:ring-offset-2">
                + Add User
            </a>
        </div>

        {{-- Users table card --}}
        <div class="bg-white/90 backdrop-blur border border-slate-100 rounded-2xl shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-slate-700">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/80">
                            <th class="py-3 px-4 text-left text-xs font-semibold tracking-wide text-slate-500 uppercase">
                                Name
                            </th>
                            <th class="py-3 px-4 text-left text-xs font-semibold tracking-wide text-slate-500 uppercase">
                                Email
                            </th>
                            <th class="py-3 px-4 text-left text-xs font-semibold tracking-wide text-slate-500 uppercase">
                                Role
                            </th>
                            <th class="py-3 px-4 text-right text-xs font-semibold tracking-wide text-slate-500 uppercase">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach($users as $user)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <span class="font-medium text-slate-900">
                                        {{ $user->name }}
                                    </span>
                                </td>

                                <td class="py-3 px-4 whitespace-nowrap">
                                    <span class="text-slate-600">
                                        {{ $user->email }}
                                    </span>
                                </td>

                                <td class="py-3 px-4 whitespace-nowrap">
                                    @if($user->is_admin)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full
                                                     bg-emerald-50 text-emerald-600 text-xs font-semibold">
                                            Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full
                                                     bg-slate-100 text-slate-600 text-xs font-medium">
                                            User
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3 px-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-4">

                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                           class="text-xs font-medium text-indigo-600 hover:text-indigo-700 hover:underline">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $user->id) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-xs font-medium text-rose-600 hover:text-rose-700 hover:underline">
                                                Delete
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if($users->count() === 0)
                            <tr>
                                <td colspan="4" class="py-6 px-4 text-center text-sm text-slate-400">
                                    No users found.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
