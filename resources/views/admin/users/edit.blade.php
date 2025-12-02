<x-app-layout>
    <div class="max-w-md mx-auto py-8 px-4">

        <h2 class="text-xl font-bold mb-6">Edit User</h2>

        <div class="bg-white rounded shadow p-6">

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-4">
                    <label class="text-sm text-gray-600">Name</label>
                    <input type="text" name="name"
                           class="w-full mt-1 border rounded px-3 py-2"
                           value="{{ $user->name }}"
                           required>
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email"
                           class="w-full mt-1 border rounded px-3 py-2"
                           value="{{ $user->email }}"
                           required>
                </div>

                {{-- Admin Toggle --}}
                <div class="mb-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_admin" class="rounded"
                            {{ $user->is_admin ? 'checked' : '' }}>
                        <span class="text-sm">Admin</span>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
                    Update User
                </button>

            </form>

        </div>

    </div>
</x-app-layout>
