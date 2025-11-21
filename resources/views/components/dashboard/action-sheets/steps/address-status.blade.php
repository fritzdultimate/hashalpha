<div class="halpha-space-y-3">
    <div>
        <div class="halpha-text-xs halpha-text-gray-400">Send exactly</div>
        <div class="halpha-text-lg halpha-font-semibold halpha-text-white"
            x-text="form.amount + ' ' + form.currency.toUpperCase()"></div>
    </div>

    <div>
        <div class="halpha-text-xs halpha-text-gray-400">Deposit address</div>
        <div class="halpha-mt-2 halpha-flex halpha-items-center halpha-justify-between halpha-gap-2">
            <div class="halpha-flex-1 halpha-break-all halpha-bg-gray-700 halpha-p-3 halpha-rounded">{{--
                show as text --}}
                <div x-text="address ?? 'Generating...'"></div>
            </div>
            <button @click="copyAddress"
                class="halpha-ml-2 halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-600 halpha-text-gray-200">Copy</button>
        </div>
    </div>

    <!-- Progress bar + status -->
    <div class="halpha-mt-3 halpha-space-y-2">
        <div class="halpha-flex halpha-items-center halpha-justify-between">
            <div class="halpha-text-xs halpha-text-gray-400">Status: <span class="halpha-font-medium halpha-text-white"
                    x-text="status"></span></div>
            <div class="halpha-text-xs halpha-text-gray-400" x-show="progress !== null" x-text="progress+'%'"></div>
        </div>

        <div class="halpha-w-full halpha-bg-gray-700 halpha-rounded halpha-h-2">
            <div class="halpha-h-2 halpha-rounded" :style="`width: ${progress ?? 0}%`" class="halpha-bg-indigo-600">
            </div>
        </div>

        <div class="halpha-flex halpha-gap-2 halpha-mt-2">
            <button @click="cancelDeposit"
                class="halpha-flex-1 halpha-py-2 halpha-rounded halpha-border halpha-border-red-600 halpha-text-red-400">Cancel</button>
            <button @click="closePanel"
                class="halpha-flex-1 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-600 halpha-text-gray-300">Done</button>
        </div>
    </div>

    <div x-show="status === 'confirmed'" class="halpha-text-sm halpha-text-green-400 halpha-mt-2">Deposit
        confirmed — thank you!</div>
    <div x-show="status === 'cancelled' || status === 'expired'"
        class="halpha-text-sm halpha-text-yellow-400 halpha-mt-2" x-text="`Deposit was ${status}. You can try again.`">
    </div>
</div>