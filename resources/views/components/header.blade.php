<header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-4">
                <a href="/" class="flex items-center gap-3">
                    <img src="/images/logo.svg" alt="{{ env('APP_NAME') }}" class="h-8 w-auto">
                    <span class="font-semibold text-lg leading-6">{{ env('APP_NAME') }}</span>
                </a>
                <nav class="hidden sm:flex items-center gap-2 text-sm text-gray-600">
                    <a href="/dashboard" class="px-3 py-2 rounded-md hover:bg-gray-100">Overview</a>
                    <a href="/invest" class="px-3 py-2 rounded-md hover:bg-gray-100">Invest</a>
                    <a href="/withdraw" class="px-3 py-2 rounded-md hover:bg-gray-100">Withdraw</a>
                </nav>
            </div>


            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-3">
                    <div class="text-right">
                        <div class="text-xs text-gray-500">Wallet Balance</div>
                        <div class="font-medium">
                            ${{ number_format(auth()->check() ? auth()->user()->wallet_balance ?? 0 : 0, 2) }}</div>
                    </div>
                </div>


                <div x-data="{open:false}" class="relative">
                    <button @click="open = !open"
                        class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">
                        <img src="/images/avatar-placeholder.png" alt="avatar" class="h-7 w-7 rounded-full" />
                        <span class="hidden sm:inline">{{ auth()->check() ? auth()->user()->name : 'Guest' }}</span>
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06-.02L10 10.854l3.71-3.664a.75.75 0 111.04 1.082l-4.22 4.166a.75.75 0 01-1.04 0L5.25 8.27a.75.75 0 01-.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>


                    <div x-show="open" @click.outside="open=false" x-cloak
                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black/5">
                        <div class="py-1">
                            <a href="/profile" class="block px-4 py-2 text-sm hover:bg-gray-50">Profile</a>
                            <a href="/settings" class="block px-4 py-2 text-sm hover:bg-gray-50">Settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50">Log
                                    out</button>
                            </form>
                        </div>
                    </div>
                </div>


                {{-- mobile menu button --}}
                <div class="sm:hidden" x-data="{open:false}">
                    <button @click="$dispatch('toggle-mobile')" class="p-2 rounded-md">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>