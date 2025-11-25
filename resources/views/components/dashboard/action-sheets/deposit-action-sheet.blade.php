<!-- Bottom sheet overlay (same overlay used for modal) -->
<div
  x-show="panelOpen"
  x-transition.opacity
  class="halpha-fixed halpha-inset-0 halpha-bg-black/50 halpha-z-40"
  style="display: none;"
  @click="closePanel()"
  aria-hidden="true"
></div>

<!-- Slide-up panel / centered modal -->
<aside
    x-show="panelOpen"
    x-transition:enter="halpha-transition halpha-duration-300 halpha-ease-out"
    x-transition:enter-start="halpha-translate-y-full halpha-scale-95 halpha-opacity-0"
    x-transition:enter-end="halpha-translate-y-0 halpha-scale-100 halpha-opacity-100"
    x-transition:leave="halpha-transition halpha-duration-250 halpha-ease-in"
    x-transition:leave-start="halpha-translate-y-0 halpha-scale-100 halpha-opacity-100"
    x-transition:leave-end="halpha-translate-y-full halpha-scale-95 halpha-opacity-0"
    class="
        halpha-fixed
        halpha-left-0 halpha-right-0 halpha-bottom-0
        halpha-z-50 halpha-bg-gray-800 halpha-rounded-t-xl
        halpha-px-4 halpha-py-2 halpha-max-h-[85vh] halpha-overflow-auto
        halpha-w-full

        
        md:halpha-top-1/2 md:halpha-left-1/2 md:halpha-right-auto md:halpha-bottom-auto
        md:halpha-w-[min(640px,90%)] md:halpha-max-h-[80vh]
        md:halpha-rounded-xl md:halpha-p-6
        md:halpha-transform md:halpha--translate-x-1/2 md:halpha--translate-y-1/2
    "
    style="display: none;"
    role="dialog"
    aria-modal="true"
    :aria-label="`Deposit ${selected?.label ?? ''}`"
    @keydown.escape.window="closePanel()"
>
    <div class="halpha-w-full halpha-flex halpha-justify-center halpha-mb-3">
        <span class="halpha-w-10 halpha-h-1 halpha-bg-gray-700 halpha-rounded-full"></span>
    </div>

    <!-- header -->
    <div class="halpha-flex halpha-justify-between halpha-items-center halpha-mb-3">
        <div class="halpha-flex halpha-items-center halpha-gap-3">
            <span class="halpha-w-8 halpha-h-8 halpha-rounded-full halpha-flex halpha-items-center halpha-justify-center" :class="selected?.bg">
                <span class="icon" :class="selected?.icon"></span>
            </span>
            <div>
                <div class="halpha-font-semibold halpha-text-white" x-text="selected?.currency?.toUpperCase()"></div>
                <div class="halpha-text-xs halpha-text-gray-400" x-text="selected?.label"></div>
            </div>
        </div>

        <!-- Countdown -->
            <div
                x-show="step === 'address'"
                x-init="startCountdown()"
                class="halpha-text-xs halpha-font-semibold halpha-text-gray-300"
            >
                <span x-text="display"></span>
            </div>
        </div>

    <!-- STEPS -->
    <div x-show="step === 'form'">
        <x-dashboard.action-sheets.steps.form :wallets="$wallets" />
    </div>

    <!-- OTP step -->
    <div x-show="step === 'otp'">
        <x-dashboard.action-sheets.steps.otp />
    </div>

    <!-- Address & status -->
    <div x-show="step === 'address'">
        <x-dashboard.action-sheets.steps.address-status />
    </div>
</aside>
