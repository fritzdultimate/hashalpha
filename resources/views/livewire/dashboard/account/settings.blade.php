<div class="halpha-space-y-6 halpha-max-w-xl">

    {{-- Header --}}
    <div>
        <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
            Security Settings
        </h1>
        <p class="halpha-text-xs halpha-text-gray-400">
            Control how your account is protected
        </p>
    </div>


    @include('layouts.dashboard.settings._nav')


    {{-- Security Options --}}
    <form class="halpha-space-y-6" wire:submit.prevent="save">
        <div class="halpha-card halpha-p-4 halpha-space-y-5">

            {{-- 2FA --}}
            <div class="halpha-flex halpha-justify-between halpha-items-start">
                <div>
                    <p class="halpha-text-sm halpha-text-white">Two-Factor Authentication</p>
                    <p class="halpha-text-xs halpha-text-gray-400">
                        Require a verification code during login and withdrawals
                    </p>
                </div>

                <label class="halpha-relative halpha-inline-flex halpha-items-center halpha-cursor-pointer">
                    <input type="checkbox" wire:model.live="twoFactor" class="halpha-sr-only halpha-peer">
                    <div class="halpha-w-9 halpha-h-5 halpha-bg-gray-700 peer-checked:halpha-bg-accent-2 halpha-rounded-full"></div>
                    <div class="halpha-absolute halpha-left-1 halpha-top-1 halpha-bg-white halpha-w-3 halpha-h-3 halpha-rounded-full peer-checked:halpha-translate-x-4 halpha-transition"></div>
                </label>
            </div>

            {{-- Login Alerts --}}
            <div class="halpha-flex halpha-justify-between halpha-items-start">
                <div>
                    <p class="halpha-text-sm halpha-text-white">Login Alerts</p>
                    <p class="halpha-text-xs halpha-text-gray-400">
                        Get notified when a new device logs into your account
                    </p>
                </div>

                <label class="halpha-relative halpha-inline-flex halpha-items-center halpha-cursor-pointer">
                    <input type="checkbox" wire:model.live="loginAlerts" class="halpha-sr-only halpha-peer">
                    <div class="halpha-w-9 halpha-h-5 halpha-bg-gray-700 peer-checked:halpha-bg-accent-2 halpha-rounded-full"></div>
                    <div class="halpha-absolute halpha-left-1 halpha-top-1 halpha-bg-white halpha-w-3 halpha-h-3 halpha-rounded-full peer-checked:halpha-translate-x-4 halpha-transition"></div>
                </label>
            </div>

            {{-- Withdrawal Confirmation --}}
            <div class="halpha-flex halpha-justify-between halpha-items-start">
                <div>
                    <p class="halpha-text-sm halpha-text-white">Withdrawal Confirmation</p>
                    <p class="halpha-text-xs halpha-text-gray-400">
                        Require extra confirmation before withdrawals
                    </p>
                </div>

                <label class="halpha-relative halpha-inline-flex halpha-items-center halpha-cursor-pointer">
                    <input type="checkbox" wire:model.live="withdrawalConfirmation" class="halpha-sr-only halpha-peer">
                    <div class="halpha-w-9 halpha-h-5 halpha-bg-gray-700 peer-checked:halpha-bg-accent-2 halpha-rounded-full"></div>
                    <div class="halpha-absolute halpha-left-1 halpha-top-1 halpha-bg-white halpha-w-3 halpha-h-3 halpha-rounded-full peer-checked:halpha-translate-x-4 halpha-transition"></div>
                </label>
            </div>

        </div>

        {{-- Save --}}
        <button
            class="halpha-bg-accent-2 halpha-text-white halpha-px-4 halpha-py-2 halpha-rounded halpha-text-xs disabled:halpha-opacity-60 disabled:halpha-cursor-not-allowed"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove wire:target="save">Save Changes</span>
            <span wire:loading wire:target="save">Saving</span>
        </button>
    </form>

    {{-- Danger Zone --}}
    <div class="halpha-card halpha-p-4 halpha-border halpha-border-red-500/30">
        <h3 class="halpha-text-sm halpha-text-error">Danger Zone</h3>

        <p class="halpha-text-xs halpha-text-gray-400 halpha-mt-1">
            These actions are irreversible
        </p>

        <button
            wire:click="$dispatch('confirm-logout-all')"
            class="halpha-text-xs halpha-text-red-600 halpha-mt-3">
            Log out from all devices
        </button>
    </div>

    <x-confirmation-modal
        event="confirm-logout-all"
        wireConfirm="logoutAll"
        title="Confirm Logout"
        message="This will log you out from all devices immediately."
    />

</div>
