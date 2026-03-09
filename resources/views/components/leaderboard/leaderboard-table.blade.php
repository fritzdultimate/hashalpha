{{-- Table --}}
<div class="halpha-card halpha-p-4 halpha-space-y-3">

    @forelse($leaderboard as $entry)
        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)" x-show="show"
            x-transition:enter="halpha-transition halpha-duration-300"
            x-transition:enter-start="halpha-opacity-0 halpha-translate-y-2"
            x-transition:enter-end="halpha-opacity-100 halpha-translate-y-0">

            @php
                $name = $entry->user->name ?? 'U';
                $initials = strtoupper(substr($name, 0, 1));

                // simple color generator based on name
                $colors = ['halpha-bg-indigo-500', 'halpha-bg-pink-500', 'halpha-bg-green-500', 'halpha-bg-yellow-500', 'halpha-bg-blue-500', 'halpha-bg-purple-500'];
                $color = $colors[crc32($name) % count($colors)];

                $rankStyles = match ($entry->rank) {
                    1 => 'halpha-bg-gradient-to-r halpha-from-yellow-400/20 halpha-to-yellow-600/10 halpha-border-yellow-400/40 halpha-shadow-[0_0_25px_rgba(255,215,0,0.3)] halpha-scale-[1.02]',
                    2 => 'halpha-bg-gradient-to-r halpha-from-gray-300/10 halpha-to-gray-500/10 halpha-border-gray-400/30 halpha-shadow-[0_0_20px_rgba(200,200,200,0.2)]',
                    3 => 'halpha-bg-gradient-to-r halpha-from-orange-400/10 halpha-to-orange-600/10 halpha-border-orange-400/30 halpha-shadow-[0_0_20px_rgba(255,140,0,0.2)]',
                    default => 'halpha-bg-card-soft halpha-border-transparent'
                };

                $isLocked = $entry->score >= 7 && $entry->rank < 4;

                if ($category->type === 'fastest' && $isLocked) {
                    $rankStyles = 'halpha-bg-gradient-to-r halpha-from-green-500/20 halpha-to-emerald-500/10 halpha-border-green-400/40 halpha-shadow-[0_0_25px_rgba(34,197,94,0.3)]';
                }

                $crown = match ($entry->rank) {
                    1 => '👑',
                    2 => '🥈',
                    3 => '🥉',
                    default => null
                };

            @endphp

            <div
                class="halpha-relative halpha-flex halpha-justify-between halpha-items-center halpha-p-3 halpha-rounded-xl halpha-border {{ $rankStyles }}">

                @if($category->type === 'fastest' && $isLocked)
                    <div class="halpha-absolute halpha-top-0 halpha-right-2 halpha-text-yellow-400">
                        🔒
                    </div>
                @endif



                <div class="halpha-flex halpha-items-center halpha-gap-3">

                    @if($crown)
                        <div class="absolute -top-2 -left-2 text-lg">
                            {{ $crown }}
                        </div>
                    @endif

                    @if (!$crown)
                        <div class="halpha-flex halpha-items-center halpha-gap-1">

                            <span class="halpha-text-accent-2 halpha-font-bold">
                                #{{ $entry->rank }}
                            </span>

                            @if($entry->rank_change > 0)
                                <span class="halpha-text-green-400 halpha-text-xs halpha-font-semibold">
                                    ▲ +{{ $entry->rank_change }}
                                </span>
                            @elseif($entry->rank_change < 0)
                                <span class="halpha-text-red-400 halpha-text-xs halpha-font-semibold">
                                    ▼ {{ $entry->rank_change }}
                                </span>
                            @else
                                <span class="halpha-text-gray-400 halpha-text-xs">
                                    •
                                </span>
                            @endif

                        </div>
                    @endif

                    {{-- Avatar --}}
                    <div
                        class="halpha-w-10 halpha-h-10 halpha-rounded-full {{ $color }} halpha-flex halpha-items-center halpha-justify-center halpha-text-white halpha-font-bold halpha-text-sm shadow">
                        {{ $initials }}
                    </div>

                    {{-- User Info --}}
                    <div>
                        <p class="halpha-text-sm halpha-text-white">
                            {{ mask($entry->user->name) }}
                        </p>
                        <p class="halpha-text-[10px] halpha-text-gray-400">
                            {{ mask_email($entry->user->email) }}
                        </p>
                    </div>

                </div>

                {{-- Score --}}
                @if($category->type === 'fastest' && false)

                    @if($entry->score <= 7)
                        <span class="halpha-text-green-400 halpha-font-bold halpha-text-xs">
                            ✅
                        </span>
                    @else
                        <span class="halpha-text-gray-300 halpha-text-sm">
                            {{ number_format($entry->score) }}/7
                        </span>
                    @endif

                @else
                @endif
                <div class="halpha-text-right">

                    @if($entry->rank <= 3)

                        @php
                            $scoreStyles = match ($entry->rank) {
                                1 => 'halpha-bg-gradient-to-r halpha-from-yellow-300 halpha-to-yellow-500 halpha-text-transparent halpha-bg-clip-text halpha-drop-shadow-[0_0_6px_rgba(255,215,0,0.6)]',
                                2 => 'halpha-bg-gradient-to-r halpha-from-gray-300 to-gray-500 halpha-text-transparent halpha-bg-clip-text halpha-drop-shadow-[0_0_5px_rgba(200,200,200,0.5)]',
                                3 => 'halpha-bg-gradient-to-r halpha-from-orange-300 halpha-to-orange-500 halpha-text-transparent halpha-bg-clip-text halpha-drop-shadow-[0_0_5px_rgba(255,140,0,0.5)]',
                            };


                            $badgeBg = match ($entry->rank) {
                                1 => 'halpha-bg-yellow-400/10 halpha-border-yellow-400/30',
                                2 => 'halpha-bg-gray-300/10 halpha-border-gray-400/30',
                                3 => 'halpha-bg-orange-400/10 halpha-border-orange-400/30',
                            };
                        @endphp


                        <div class="halpha-inline-block halpha-px-3 halpha-py-1 halpha-rounded-lg halpha-border {{ $badgeBg }}">

                            <p class="halpha-text-sm halpha-font-bold {{ $scoreStyles }}">

                                @if($category->type === 'volume')
                                    ${{ format_compact($entry->score) }}
                                @else
                                    {{ number_format($entry->score) }}
                                @endif

                            </p>

                        </div>

                    @else

                        {{-- normal users --}}
                        <p class="halpha-text-sm halpha-text-white halpha-font-semibold">
                            @if($category->type === 'volume')
                                ${{ number_format($entry->score, 2) }}
                            @else
                                {{ number_format($entry->score) }}
                            @endif
                        </p>

                    @endif

                </div>


            </div>
        </div>
    @empty
        <p class="halpha-text-gray-400 text-xs">No data yet</p>
    @endforelse


</div>