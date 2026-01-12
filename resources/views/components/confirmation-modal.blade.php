<div
    x-data="{ show: false }"
    x-on:{{ $event }}.window="show = true"
    x-on:keydown.escape.window="show = false"
    x-cloak
>
    <!-- Backdrop -->
    <div
        x-show="show"
        x-transition.opacity
        class="halpha-fixed halpha-inset-0 halpha-bg-black/70 halpha-backdrop-blur-sm halpha-z-50"
        @click.self="show = false"
    >
        <!-- Modal -->
        <div
            x-show="show"
            x-transition:enter="halpha-transition halpha-duration-200 halpha-ease-out"
            x-transition:enter-start="halpha-opacity-0 halpha-scale-95"
            x-transition:enter-end="halpha-opacity-100 halpha-scale-100"
            x-transition:leave="halpha-transition halpha-duration-150 halpha-ease-in"
            x-transition:leave-start="halpha-opacity-100 halpha-scale-100"
            x-transition:leave-end="halpha-opacity-0 halpha-scale-95"
            class="halpha-min-h-screen halpha-flex halpha-items-center halpha-justify-center halpha-px-4"
        >
            <div class="halpha-card halpha-w-full halpha-max-w-md halpha-p-6 halpha-rounded-xl">

                <!-- Icon -->
                <div class="halpha-flex halpha-items-center halpha-justify-center halpha-w-12 halpha-h-12 halpha-rounded-full halpha-bg-red-500/10 halpha-text-red-500 halpha-mb-4">
                    ⚠️
                </div>

                <!-- Title -->
                <h3 class="halpha-text-lg halpha-font-semibold halpha-text-white halpha-mb-2">
                    {{ $title ?? 'Confirm Action' }}
                </h3>

                <!-- Message -->
                <p class="halpha-text-sm halpha-text-gray-400 halpha-leading-relaxed">
                    {{ $message ?? 'This action cannot be undone. Please confirm to proceed.' }}
                </p>

                <!-- Actions -->
                <div class="halpha-flex halpha-gap-3 halpha-mt-6">
                    <button
                        @click="show = false"
                        type="button"
                        class="halpha-text-red-300 halpha-flex-1"
                    >
                        Cancel
                    </button>

                    <button
                        type="button"
                        class="halpha-bg-accent-2 halpha-flex-1 halpha-text-base halpha-px-4 halpha-py-1 halpha-rounded"
                        @click="
                            show = false;
                            $wire.{{ $wireConfirm }}();
                        "
                    >
                        Confirm
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
