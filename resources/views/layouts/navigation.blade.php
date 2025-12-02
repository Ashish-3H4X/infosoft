<nav 
    x-data="{ open: false }"
    class="fixed top-0 inset-x-0 z-50 backdrop-blur-lg bg-white/70 dark:bg-gray-800/60 
           border-b border-white/30 dark:border-gray-700 shadow-sm transition-all"
>

    <!-- Primary Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left Section -->
            <div class="flex items-center">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-logo class="h-9 w-auto drop-shadow-md" />
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden sm:flex sm:space-x-8 sm:ml-10">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    @if(auth()->check() && auth()->user()->is_admin)

                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            Admin Dashboard
                        </x-nav-link>

                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            Manage Users
                        </x-nav-link>

                        <x-nav-link :href="route('admin.users.create')" :active="request()->routeIs('admin.users.create')">
                            Add User
                        </x-nav-link>

                    @endif

                </div>
            </div>

            <!-- Right Section (Dropdown) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div x-data="{ dropdown: false }" class="relative">

                    <!-- Trigger -->
                    <button 
                        @click="dropdown = !dropdown"
                        class="flex items-center gap-2 px-4 py-2 bg-white/70 dark:bg-gray-700/60 
                               border border-gray-200 dark:border-gray-600 rounded-xl shadow-sm 
                               hover:bg-white/90 dark:hover:bg-gray-700 transition text-sm font-medium"
                    >
                        <span class="text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                        <svg class="w-6 h-4" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div 
                        x-show="dropdown"
                        @click.outside="dropdown = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"

                        class="absolute right-0 mt-3 w-52 bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl 
                               border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl 
                               py-2 z-50"
                    >

                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        @if(auth()->user()->is_admin)
                            <x-dropdown-link :href="route('admin.dashboard')">Admin Dashboard</x-dropdown-link>
                            <x-dropdown-link :href="route('admin.users.index')">Manage Users</x-dropdown-link>
                            <x-dropdown-link :href="route('admin.users.create')">Add User</x-dropdown-link>
                        @endif

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button 
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 
                                       dark:hover:bg-red-600/20 rounded-lg transition"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                            >
                                Log Out
                            </button>
                        </form>

                    </div>

                </div>
            </div>

            <!-- Mobile Button -->
            <div class="flex items-center sm:hidden">
                <button 
                    @click="open = ! open"
                    class="p-2 rounded-lg text-gray-600 hover:bg-gray-200/60 dark:text-gray-300 dark:hover:bg-gray-700/60"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }"
                              class="inline-flex"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{ 'hidden': !open, 'inline-flex': open }"
                              class="hidden"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg">

        <div class="pt-3 pb-3 space-y-1 border-t border-gray-200 dark:border-gray-700">

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            @if(auth()->check() && auth()->user()->is_admin)

                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    Admin Dashboard
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    Manage Users
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.users.create')" :active="request()->routeIs('admin.users.create')">
                    Add User
                </x-responsive-nav-link>

            @endif

        </div>

        <!-- User Info -->
        <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700 px-4">

            <div>
                <div class="text-base font-medium text-gray-800 dark:text-gray-200">
                    {{ Auth::user()->name }}
                </div>
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">

                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>

            </div>

        </div>

    </div>

</nav>
