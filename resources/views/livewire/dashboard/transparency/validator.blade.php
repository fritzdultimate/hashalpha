
<div class="halpha-space-y-6">

    <style>
        p.text-sm.text-gray-700.leading-5 {
            display: none !important;
        }
    </style>

    {{-- Header --}}
    <div>
        <h1 class="halpha-text-xl md:halpha-text-3xl halpha-font-semibold halpha-text-white">
            Validator Network
        </h1>
        <p class="halpha-text-xs md:halpha-text-sm halpha-text-gray-400">
            Validators operated by the infrastructure team, now contributing to the {{ env('APP_NAME') }} network.
        </p>
    </div>

    {{-- FILTERS --}}
    <div class="halpha-flex halpha-flex-wrap halpha-gap-3">
        <input
            wire:model.debounce.300ms.live="search"
            placeholder="Search validator…"
            class="halpha-bg-card-soft halpha-border halpha-border-gray-800 halpha-rounded halpha-px-3 halpha-py-2 halpha-text-xs halpha-text-white"
        />

        <select wire:model.live="status" class="halpha-bg-card-soft halpha-text-xs halpha-rounded halpha-px-3 halpha-py-2">
            <option value="all">All Status</option>
            <option value="active">Active</option>
            <option value="maintenance">Maintenance</option>
        </select>

        <select wire:model.live="region" class="halpha-bg-card-soft halpha-text-xs halpha-rounded halpha-px-3 halpha-py-2">
            <option value="all">All Regions</option>
            <option value="EU">EU</option>
            <option value="US">US</option>
        </select>
    </div>

    {{-- SUMMARY --}}
    <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-3 halpha-gap-4">
        <div class="halpha-card halpha-p-4 halpha-rounded-xl">
            <div class="halpha-text-xs halpha-text-gray-400">Total Validators</div>
            <div class="halpha-text-xl halpha-font-semibold halpha-text-white">135</div>
        </div>

        <div class="halpha-card halpha-p-4 halpha-rounded-xl">
            <div class="halpha-text-xs halpha-text-gray-400">Active</div>
            <div class="halpha-text-xl halpha-font-semibold halpha-text-green-400">133</div>
        </div>

        <div class="halpha-card halpha-p-4 halpha-rounded-xl">
            <div class="halpha-text-xs halpha-text-gray-400">In Maintenance</div>
            <div class="halpha-text-xl halpha-font-semibold halpha-text-yellow-400">2</div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="halpha-card halpha-rounded-xl">
        <h3 class="halpha-text-sm halpha-font-semibold halpha-text-gray-400 halpha-bg-card-soft halpha-p-4 halpha-uppercase">
            Validators
        </h3>

        <div class="halpha-hidden md:halpha-block halpha-overflow-x-auto">
            <table class="halpha-w-full halpha-text-xs">
                <thead class="halpha-bg-card-soft halpha-text-gray-400">
                    <tr>
                        <th class="halpha-p-3 halpha-text-left">Validator</th>
                        <th class="halpha-p-3 halpha-text-left">Public Key</th>
                        <th class="halpha-p-3">Status</th>
                        <th class="halpha-p-3">Uptime</th>
                        <th class="halpha-p-3">Deployment model</th>
                        <th class="halpha-p-3 halpha-text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="halpha-divide-y halpha-divide-gray-800">
                    @foreach($validators as $v)
                        <tr class="hover:halpha-bg-card-soft halpha-transition">
                            <td class="halpha-p-3">
                                <p class="halpha-text-white halpha-font-medium">
                                    {{ $v->label ?? 'Validator #' . $v->id }}
                                </p>
                                <p class="halpha-text-[10px] halpha-text-gray-500">
                                    Index #{{ $v->validator_index ?? '—' }}
                                </p>
                            </td>

                            <td class="halpha-p-3 halpha-text-gray-400 halpha-font-mono">
                                {{ Str::limit($v->public_key, 18) }}
                            </td>

                            <td class="halpha-p-3 halpha-text-center">
                                <span class="
                                    halpha-inline-flex halpha-items-center halpha-px-2 halpha-py-0.5 halpha-rounded-full
                                    halpha-text-[10px]
                                    @if($v->status === 'active') halpha-bg-green-500/10 halpha-text-green-400
                                    @elseif($v->status === 'pending') halpha-bg-yellow-500/10 halpha-text-yellow-400
                                    @else halpha-bg-red-500/10 halpha-text-red-400
                                    @endif
                                ">
                                    {{ ucfirst($v->status) }}
                                </span>
                            </td>

                            <td class="halpha-p-3 halpha-flex halpha-flex-col halpha-items-center halpha-text-center">
                                <div class="halpha-w-24 halpha-bg-gray-800 halpha-rounded-full halpha-h-1.5">
                                    <div
                                        class="halpha-bg-green-500 halpha-h-1.5 halpha-rounded-full"
                                        style="width: {{ $v->meta['uptime'] ?? 99 }}%">
                                    </div>
                                </div>
                                <p class="halpha-text-[10px] halpha-text-gray-400 mt-1">
                                    {{ $v->meta['uptime'] ?? '99.9' }}%
                                </p>
                            </td>

                            <td class="halpha-p-3 halpha-text-gray-400 halpha-text-center">
                                {{ $v->meta['region'] ?? 'Distributed' }}
                            </td>

                            <td class="halpha-p-3 halpha-text-right">
                                <a
                                    target="_blank"
                                    href="https://beaconcha.in/validator/{{ $v->public_key }}"
                                    class="halpha-text-accent-2 hover:underline text-xs"
                                >
                                    Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="md:halpha-hidden halpha-space-y-3">
            @foreach($validators as $v)
                <div class="halpha-card halpha-p-4 halpha-space-y-3">

                    <div class="halpha-flex halpha-justify-between halpha-items-center">
                        <div>
                            <p class="halpha-text-white halpha-text-sm halpha-font-medium">
                                {{ $v->label ?? 'Validator #' . $v->id }}
                            </p>
                            <p class="halpha-text-[10px] halpha-text-gray-500 halpha-font-mono">
                                {{ Str::limit($v->public_key, 22) }}
                            </p>
                        </div>

                        <span class="
                            halpha-text-[10px] halpha-px-2 halpha-py-0.5 halpha-rounded-full
                            @if($v->status === 'active') halpha-bg-green-500/10 halpha-text-green-400
                            @elseif($v->status === 'pending') halpha-bg-yellow-500/10 halpha-text-yellow-400
                            @else halpha-bg-red-500/10 halpha-text-red-400
                            @endif
                        ">
                            {{ ucfirst($v->status) }}
                        </span>
                    </div>

                    <div class="halpha-grid halpha-grid-cols-2 halpha-gap-3 halpha-text-xs">
                        <div>
                            <p class="halpha-text-gray-500">Uptime</p>
                            <p class="halpha-text-white">
                                {{ $v->meta['uptime'] ?? '99.9' }}%
                            </p>
                        </div>

                        <div>
                            <p class="halpha-text-gray-500">Deployment model</p>
                            <p class="halpha-text-white">
                                {{ $v->meta['region'] ?? 'Distributed' }}
                            </p>
                        </div>
                    </div>

                    <a href="https://beaconcha.in/validator/{{ $v->public_key }}"
                        target="_blank"
                        class="halpha-text-xs halpha-text-accent-2 hover:halpha-underline"
                    >
                        View validator details →
                    </a>

                </div>
            @endforeach
        </div>

        {{-- pagination --}}
        <div
            class="halpha-flex halpha-flex-col md:halpha-flex-row halpha-items-center halpha-justify-between halpha-gap-3 halpha-p-4 halpha-border-t halpha-border-white/5 halpha-border-red-600 halpha-border">
            <div class="halpha-text-xs halpha-text-muted halpha-hidden">Showing {{ $validators->firstItem() ?? 0 }} to
                {{ $validators->lastItem() ?? 0 }} of {{ $validators->total() ?? count($validators) }}</div>
            <div class="halpha-text-sm halpha-pagination halpha-flex halpha-items-center halpha-gap-2 halpha-w-full">{{ $validators->links() }}</div>
        </div>     

    </div>

    {{-- DETAILS MODAL --}}
    @if($showDetails && $selectedValidator)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">
            <div class="halpha-card halpha-rounded-xl halpha-w-full max-w-lg">

                <div class="halpha-flex halpha-justify-between halpha-items-center halpha-bg-card-soft halpha-p-4">
                    <h3 class="halpha-text-sm halpha-font-semibold halpha-text-white">
                        {{ $selectedValidator['name'] }}
                    </h3>

                    <button wire:click="closeModal" class="halpha-text-gray-400 hover:text-white">
                        ✕
                    </button>
                </div>

                <div class="halpha-p-4 halpha-space-y-2 halpha-text-xs">
                    <div class="halpha-flex halpha-justify-between">
                        <span class="halpha-text-gray-400">Public Key</span>
                        <span class="halpha-text-white">{{ $selectedValidator['pubkey'] }}</span>
                    </div>

                    <div class="halpha-flex halpha-justify-between">
                        <span class="halpha-text-gray-400">Client</span>
                        <span class="halpha-text-white">{{ $selectedValidator['client'] }}</span>
                    </div>

                    <div class="halpha-flex halpha-justify-between">
                        <span class="halpha-text-gray-400">Risk Level</span>
                        <span class="halpha-text-green-400">{{ $selectedValidator['risk'] }}</span>
                    </div>

                    <a
                        href="https://beaconcha.in/validator/{{ $selectedValidator['pubkey'] }}"
                        target="_blank"
                        class="halpha-text-accent-2 text-xs hover:underline mt-3 inline-block"
                    >
                        View on Beacon Explorer →
                    </a>
                </div>
            </div>
        </div>
    @endif

</div>
