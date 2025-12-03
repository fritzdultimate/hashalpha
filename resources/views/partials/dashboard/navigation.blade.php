<nav
    class="halpha-flex-1 halpha-overflow-auto halpha-py-4 [&::-webkit-scrollbar]:halpha-w-2 [&::-webkit-scrollbar-thumb]:halpha-bg-[#383838] [&::-webkit-scrollbar-thumb]:halpha-rounded-full [&::-webkit-scrollbar-track]:halpha-bg-transparent hover:[&::-webkit-scrollbar-thumb]:halpha-bg-[#505050] halpha-scrollbar-thin halpha-scrollbar-thumb-[#383838] halpha-scrollbar-track-transparent">
    @foreach ($navs as $nav)
        @php
            $activeDashboard = isset($nav['route']) ? request()->routeIs(($nav['route']) . '*') : false;
        @endphp
        @if (isset($nav['children']))
            <div 
                x-data="{ isDropdownOpen: {{ $activeDashboard ? 'true' : 'false' }} }" 
                @keydown.window.escape="isDropdownOpen = false" 
                class="halpha-w-full"
            >
                <button type="button" :aria-expanded="isDropdownOpen ? 'true' : 'false'"
                    aria-controls="nav-children-{{ $loop->index ?? \Illuminate\Support\Str::random(6) }}"
                    class="halpha-flex halpha-items-center halpha-gap-3 halpha-px-6 halpha-py-5 halpha-text-sm hover:halpha-bg-[#292929] halpha-w-full"
                    :class="{
                        'halpha-text-accent-2': isDropdownOpen,
                        'halpha-text-[#bababa]': !isDropdownOpen
                    }" 
                    @click="isDropdownOpen = !isDropdownOpen"
                >
                    <x-dynamic-component :component="$nav['icon']" class="halpha-w-5 halpha-h-5" />
                    <span x-show="!sidebarCollapsed">{{ $nav['label'] }}</span>
                    <x-ri-arrow-down-s-line x-show="!isDropdownOpen" x-cloak class="halpha-w-5 halpha-h-5 halpha-ml-auto" />
                    <x-ri-arrow-up-s-line x-show="isDropdownOpen" x-cloak class="halpha-w-5 halpha-h-5 halpha-ml-auto" />
                </button>

                <ul 
                    id="nav-children-{{ $loop->index ?? \Illuminate\Support\Str::random(6) }}" 
                    x-cloak 
                    x-show="isDropdownOpen"
                    x-collapse x-transition:enter="halpha-transition halpha-ease-out halpha-duration-200"
                    x-transition:enter-start="halpha-opacity-0" 
                    x-transition:enter-end="halpha-opacity-100"
                    x-transition:leave="halpha-transition halpha-ease-in halpha-duration-150"
                    x-transition:leave-start="halpha-opacity-100" 
                    x-transition:leave-end="halpha-opacity-0"
                    class="halpha-text-sm halpha-text-[#bdbdbd] halpha-overflow-hidden"
                >
                    @foreach($nav['children'] ?? [] as $child)
                        @php
                            $activeDashboard = url()->current() === url($child['url']);
                        @endphp
                        <li>
                            <a href="{{ $child['url'] }}"
                                class="halpha-flex halpha-items-center halpha-gap-3 halpha-px-3 halpha-py-5 halpha-text-sm hover:halpha-bg-[#292929] halpha-w-full halpha-pl-10"
                                :class="{
                                    'halpha-bg-[#292929] halpha-text-[#bababa] halpha-border-r halpha-border-accent-2': {{ $activeDashboard ? 'true' : 'false' }}
                                }"
                            >
                                {{ $child['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <a href="{{ $nav['url'] }}" @class([
                'halpha-flex halpha-items-center halpha-gap-3 halpha-px-6 halpha-py-5 halpha-text-sm hover:halpha-bg-[#292929] halpha-text-[#bababa]',
                'halpha-bg-[#292929] !halpha-text-[#e3e3e3] halpha-border-r halpha-border-accent-2' => $activeDashboard,
            ])>
                <x-dynamic-component :component="$nav['icon']" class="halpha-w-5 halpha-h-5" />
                <span x-show="!sidebarCollapsed">{{ $nav['label'] }}</span>
            </a>
        @endif
    @endforeach


</nav>