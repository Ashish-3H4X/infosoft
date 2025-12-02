<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-4">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold">Users</h2>

            <a href="{{ route('admin.users.create') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                + Add User
            </a>
        </div>

        <div class="bg-white rounded shadow p-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b text-left">
                        <th class="py-2">Name</th>
                        <th class="py-2">Email</th>
                        <th class="py-2">Role</th>
                        <th class="py-2 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b">
                            <td class="py-2">{{ $user->name }}</td>
                            <td class="py-2">{{ $user->email }}</td>
                            <td class="py-2">
                                @if($user->is_admin)
                                    <span class="text-green-600 text-xs font-semibold">Admin</span>
                                @else
                                    <span class="text-gray-600 text-xs">User</span>
                                @endif
                            </td>

                            <td class="py-2 text-right space-x-2">

                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="text-indigo-600 hover:underline text-xs">
                                    Edit
                                </a>

                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:underline text-xs">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach

                    @if($users->count() == 0)
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-500">
                                No users found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
