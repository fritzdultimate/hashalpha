<div class="halpha-space-y-3 halpha-flex halpha-flex-col halpha-justify-center halpha-items-center halpha-py-5">
    <div 
        x-show="loadingAddress"
        x-transition.opacity.duration.600ms
        class="halpha-absolute halpha-inset-0 halpha-flex halpha-items-center halpha-justify-center halpha-bg-black/80 halpha-z-50"
    >
        <div class="halpha-flex halpha-flex-col halpha-items-center halpha-gap-3">
            <x-ri-loader-4-fill class="halpha-w-10 halpha-h-10 halpha-animate-spin halpha-text-indigo-500" />

            <div class="halpha-text-gray-300 halpha-text-sm halpha-font-medium">
                Loading deposit details…
            </div>
        </div>
    </div>

    <div 
        x-show="!loadingAddress"
        x-transition.opacity.duration.500ms
        class="halpha-space-y-3 halpha-flex halpha-flex-col halpha-justify-center halpha-items-center halpha-py-5 halpha-w-full"
    >
        <div x-show="status !== 'finished' && status !== 'confirmed' && status !== 'cancelled' && status !== 'expired'" class="halpha-space-y-3 halpha-flex halpha-flex-col halpha-justify-center halpha-items-center halpha-py-5 halpha-w-full">
            <!-- Progress bar + status -->
            <div class="halpha-space-y-2 halpha-w-full">
                <div class="halpha-flex halpha-items-center halpha-justify-between">
                    <div class="halpha-text-xs halpha-text-gray-400">Status: <span class="halpha-font-medium halpha-text-white"
                            x-text="status"></span></div>
                    <div class="halpha-text-xs halpha-text-gray-400" x-show="progress !== null" x-text="progress+'%'"></div>
                </div>

                <div class="halpha-w-full halpha-bg-gray-700 halpha-rounded halpha-h-2">
                    <div class="halpha-h-2 halpha-rounded halpha-bg-indigo-600" :style="`width: ${progress ?? 0}%`">
                    </div>
                </div>
            </div>

            <div class="halpha-text-center">
                <div class="halpha-flex halpha-items-center halpha-text-lg halpha-font-semibold halpha-text-white halpha-gap-2">
                    <div class="">Deposit</div>
                    <div class="halpha-text-lg halpha-font-semibold halpha-text-white" x-text="pay_amount + ' ' + form.currency.toUpperCase()"></div>
                </div>
                <span class="halpha-font-semibold halpha-text-xs halpha-text-gray-400"><span x-text="network"></span> Network</span>
            </div>

            <div>
                <livewire:qr-code />
            </div>

            <div class="halpha-w-full">
                <div class="halpha-mt-2 halpha-flex halpha-items-center halpha-justify-between halpha-gap-2">
                    <div class="halpha-flex-1 halpha-break-all halpha-bg-gray-700 halpha-p-2 halpha-rounded halpha-text-center halpha-border halpha-border-gray-600 halpha-text-sm">
                        <div x-text="address ? address.slice(0, 12) + '...' + address.slice(-12) : 'Generating...'"></div>
                    </div>
                    <button @click="copyAddress"
                        class="halpha- halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-600 halpha-text-gray-200 halpha-text-sm hover:halpha-text-gray-700 hover:halpha-bg-white halpha-transition-all halpha-duration-700">Copy</button>
                </div>
            </div>

            <div class="halpha-mt-3 halpha-space-y-2 halpha-w-full">
                <div class="halpha-flex halpha-gap-2 halpha-mt-2">
                    <button @click="cancelDeposit"
                        class="halpha-flex-1 halpha-py-2 halpha-rounded halpha-border halpha-border-red-600 halpha-text-red-400" x-text="cancelling ? 'Please wait' : 'Cancel'">Cancel</button>
                    <button @click="closePanel"
                        class="halpha-flex-1 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-600 halpha-text-gray-300">Done</button>
                </div>
            </div>
        </div>

        <div>
            <div x-show="status === 'finished' || status === 'confirmed'" class="halpha-text-sm halpha-text-green-400 halpha-mt-2">
                Deposit confirmed — thank you!
            </div>
            <div x-show="status === 'cancelled' || status === 'expired'"
                class="halpha-text-sm halpha-text-yellow-400 halpha-mt-2" x-text="`Deposit was ${status}. You can try again.`">
            </div>
        </div>
    </div>  
</div>