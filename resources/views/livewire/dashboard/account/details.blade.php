<div class="halpha-space-y-6 halpha-max-w-xl">

    {{-- Header --}}
    <div>
        <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
            Account Settings
        </h1>
        <p class="halpha-text-xs halpha-text-gray-400">
            Manage your personal and contact information
        </p>
    </div>

    @include('layouts.dashboard.settings._nav')

    {{-- Account Info --}}
    <form wire:submit.prevent="save" class="halpha-space-y-6">

        <div class="halpha-card halpha-p-4 halpha-space-y-4">

            {{-- Name --}}
            <div>
                <label class="halpha-text-xs halpha-text-gray-400">Full Name</label>
                <input
                    type="text"
                    wire:model.defer="name"
                    class="halpha-input"
                    placeholder="Your full name"
                />
            </div>

            {{-- Email --}}
            <div>
                <label class="halpha-text-xs halpha-text-gray-400">Email Address</label>
                <input
                    type="email"
                    wire:model.defer="email"
                    class="halpha-input"
                    placeholder="you@example.com"
                />

                @if(!auth()->user()->hasVerifiedEmail())
                    <p class="halpha-text-xs halpha-text-warning halpha-mt-1">
                        Email not verified
                    </p>
                @endif
            </div>

            {{-- Phone --}}
            <div>
                <label class="halpha-text-xs halpha-text-gray-400">Phone Number</label>
                <input
                    type="text"
                    wire:model.defer="phone"
                    class="halpha-input"
                    placeholder="+234..."
                />
            </div>

            {{-- Country + Timezone --}}
            <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-4">
                <div>
                    <label class="halpha-text-xs halpha-text-gray-400">Country</label>
                    <input
                        type="text"
                        wire:model.defer="country"
                        class="halpha-input"
                        placeholder="NG"
                    />
                </div>

                <div>
                    <label class="halpha-text-xs halpha-text-gray-400">Timezone</label>
                    <input
                        type="text"
                        wire:model.defer="timezone"
                        class="halpha-input"
                        placeholder="Africa/Lagos"
                    />
                </div>
            </div>

        </div>

        {{-- Save --}}
        <button
            type="submit"
            wire:loading.attr="disabled"
            class="halpha-bg-accent-2 halpha-text-white halpha-px-4 halpha-py-2 halpha-rounded halpha-text-xs disabled:halpha-opacity-60 disabled:halpha-cursor-not-allowed"
        >
            <span wire:loading.remove wire:target="save">Save Changes</span>
            <span wire:loading wire:target="save">Saving</span>
        </button>

    </form>

    {{-- Read-only Meta --}}
    <div class="halpha-card halpha-p-4">
        <p class="halpha-text-xs halpha-text-gray-400">
            Account ID
        </p>
        <p class="halpha-text-xs halpha-text-white halpha-mt-1">
            {{ auth()->user()->id }}
        </p>
    </div>

</div>
