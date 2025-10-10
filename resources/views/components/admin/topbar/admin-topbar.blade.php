<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-mark class="block w-auto h-9" />
                </a>
            </div>

            <!-- Topbar Navigation -->
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>

                <x-nav-link href="{{ route('admin.students.index') }}" :active="request()->routeIs('admin.students.*')">
                    {{ __('Étudiants') }}
                </x-nav-link>

                <x-nav-link href="{{ route('admin.inscriptions.index') }}" :active="request()->routeIs('admin.inscriptions.*')">
                    {{ __('Inscriptions') }}
                </x-nav-link>

                <x-nav-link href="{{ route('admin.paiements.index') }}" :active="request()->routeIs('admin.paiements.*')">
                    {{ __('Paiements') }}
                </x-nav-link>

                <x-nav-link href="{{ route('admin.recus.index') }}" :active="request()->routeIs('admin.recus.*')">
                    {{ __('Reçus') }}
                </x-nav-link>

                <x-nav-link href="{{ route('admin.parametres.index') }}" :active="request()->routeIs('admin.parametres.*')">
                    {{ __('Paramètres') }}
                </x-nav-link>
            </div>

            <!-- User Menu -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Profile Dropdown -->
                <div class="relative ml-3">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                    <img class="object-cover w-8 h-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
                                        {{ Auth::user()->name }}
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('profile.show') }}">{{ __('Profile') }}</x-dropdown-link>
                            <div class="border-t border-gray-200"></div>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger for Mobile -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-100 rounded-md focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">{{ __('Dashboard') }}</x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('admin.students.index') }}" :active="request()->routeIs('admin.students.*')">{{ __('Étudiants') }}</x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('admin.inscriptions.index') }}" :active="request()->routeIs('admin.inscriptions.*')">{{ __('Inscriptions') }}</x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('admin.paiements.index') }}" :active="request()->routeIs('admin.paiements.*')">{{ __('Paiements') }}</x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('admin.recus.index') }}" :active="request()->routeIs('admin.recus.*')">{{ __('Reçus') }}</x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('admin.parametres.index') }}" :active="request()->routeIs('admin.parametres.*')">{{ __('Paramètres') }}</x-responsive-nav-link>
        </div>
    </div>
</nav>
