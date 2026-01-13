
<div class="halpha-space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="halpha-text-xl md:halpha-text-3xl halpha-font-semibold halpha-text-white">
            Validator Network
        </h1>
        <p class="halpha-text-xs md:halpha-text-sm halpha-text-gray-400">
            Active validators participating in the HashAlpha infrastructure
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
            <div class="halpha-text-xl halpha-font-semibold halpha-text-white">128</div>
        </div>

        <div class="halpha-card halpha-p-4 halpha-rounded-xl">
            <div class="halpha-text-xs halpha-text-gray-400">Active</div>
            <div class="halpha-text-xl halpha-font-semibold halpha-text-green-400">125</div>
        </div>

        <div class="halpha-card halpha-p-4 halpha-rounded-xl">
            <div class="halpha-text-xs halpha-text-gray-400">In Maintenance</div>
            <div class="halpha-text-xl halpha-font-semibold halpha-text-yellow-400">3</div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="halpha-card halpha-rounded-xl">
        <h3 class="halpha-text-sm halpha-font-semibold halpha-text-gray-400 halpha-bg-card-soft halpha-p-4 halpha-uppercase">
            Validators
        </h3>

        <div class="halpha-overflow-x-auto">
            <table class="halpha-w-full halpha-text-xs">
                <thead class="halpha-bg-card-soft halpha-text-gray-400">
                    <tr>
                        <th class="halpha-p-3 halpha-text-left">Validator</th>
                        <th class="halpha-p-3">Status</th>
                        <th class="halpha-p-3">Uptime</th>
                        <th class="halpha-p-3">Region</th>
                        <th class="halpha-p-3">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-800">
                    @foreach($this->validators as $v)
                        <tr class="hover:halpha-bg-card-soft">
                            <td class="halpha-p-3 halpha-text-white">
                                {{ $v['name'] }}
                            </td>

                            <td class="halpha-p-3 halpha-text-green-400">
                                {{ ucfirst($v['status']) }}
                            </td>

                            <td class="halpha-p-3 halpha-text-white">
                                {{ $v['uptime'] }}
                            </td>

                            <td class="halpha-p-3 halpha-text-gray-400">
                                {{ $v['region'] }}
                            </td>

                            <td class="halpha-p-3">
                                <button
                                    wire:click="viewValidator({{ json_encode($v) }})"
                                    class="halpha-text-accent-2 hover:underline"
                                >
                                    View details
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
