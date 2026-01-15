<div class="halpha-space-y-6 halpha-max-w-xl-">

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

    <div class="halpha-grid md:halpha-grid-cols-2 halpha-gap-5">
        {{-- Account Info --}}
        <form wire:submit.prevent="save" class="halpha-space-y-6">

            <div class="halpha-card halpha-p-4 halpha-space-y-4">

                {{-- Name --}}
                <div>
                    <label class="halpha-text-xs halpha-text-gray-400">Username</label>
                    <input disabled type="text" wire:model.defer="name" class="halpha-input disabled:halpha-opacity-50" placeholder="Your full name" />
                </div>

                {{-- Email --}}
                <div>
                    <label class="halpha-text-xs halpha-text-gray-400">Email Address</label>
                    <input disabled type="email" wire:model.defer="email" class="halpha-input disabled:halpha-opacity-50" placeholder="you@example.com" />

                    @if(!auth()->user()->hasVerifiedEmail())
                        <p class="halpha-text-xs halpha-text-warning halpha-mt-1">
                            Email not verified
                        </p>
                    @endif
                </div>

                {{-- Phone --}}
                <div>
                    <label class="halpha-text-xs halpha-text-gray-400">Phone Number</label>
                    <input type="text" wire:model.defer="phone" class="halpha-input" placeholder="" />
                </div>

                {{-- Country + Timezone --}}
                <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-4">
                    <div>
                        <label class="halpha-text-xs halpha-text-gray-400">Country</label>
                        <input type="text" wire:model.defer="country" class="halpha-input" placeholder="" />
                    </div>

                    <div>
                        <label class="halpha-text-xs halpha-text-gray-400">Timezone</label>
                        <input type="text" wire:model.defer="timezone" class="halpha-input" placeholder="UTC" />
                    </div>
                </div>

            </div>

            {{-- Save --}}
            <button type="submit" wire:loading.attr="disabled"
                class="halpha-bg-accent-2 halpha-text-white halpha-px-4 halpha-py-2 halpha-rounded halpha-text-xs disabled:halpha-opacity-60 disabled:halpha-cursor-not-allowed">
                <span wire:loading.remove wire:target="save">Save Changes</span>
                <span wire:loading wire:target="save">Saving</span>
            </button>

        </form>

        {{-- Password --}}
        <form wire:submit.prevent="updatePassword" class="halpha-space-y-4">

            <div class="halpha-card halpha-p-4 halpha-space-y-4">
                <h2 class="halpha-text-sm halpha-text-white">
                    Change Password
                </h2>

                <div>
                    <label class="halpha-text-xs halpha-text-gray-400">
                        Current Password
                    </label>
                    <input type="password" wire:model.defer="currentPassword" class="halpha-input" placeholder="••••••••" />
                

                    @error('currentPassword')
                        <p class="halpha-text-xs halpha-text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="halpha-text-xs halpha-text-gray-400">
                        New Password
                    </label>
                    <input type="password" wire:model.defer="newPassword" class="halpha-input"
                        placeholder="Minimum 8 characters" />

                    @error('newPassword')
                        <p class="halpha-text-xs halpha-text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="halpha-text-xs halpha-text-gray-400">
                        Confirm New Password
                    </label>
                    <input type="password" wire:model.defer="newPassword_confirmation" class="halpha-input"
                        placeholder="Repeat new password" />

                    @error('newPassword_confirmation')
                        <p class="halpha-text-xs halpha-text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <button type="submit" wire:loading.attr="disabled"
                class="halpha-bg-accent-2 halpha-text-white halpha-px-4 halpha-py-2 halpha-rounded halpha-text-xs disabled:halpha-opacity-60 disabled:halpha-cursor-not-allowed">
                <span wire:loading.remove wire:target="updatePassword">
                    Update Password
                </span>
                <span wire:loading wire:target="updatePassword">
                    Updating
                </span>
            </button>
        </form>


        {{-- Read-only Meta --}}
        <div class="halpha-card halpha-p-4">
            <p class="halpha-text-xs halpha-text-gray-400">
                Account ID
            </p>
            <p class="halpha-text-xs halpha-text-white halpha-mt-1">
                {{ auth()->user()->affiliate_code }}
            </p>
        </div>


        {{-- Danger Zone --}}
        <div class="halpha-card halpha-p-4 halpha-border halpha-border-red-500/30">
            <h3 class="halpha-text-sm halpha-text-error">
                Danger Zone
            </h3>

            <p class="halpha-text-xs halpha-text-gray-400 halpha-mt-1">
                Deleting your account will permanently remove all data.
                This action cannot be undone.
            </p>

            <button wire:click="$dispatch('confirm-delete-account')" class="halpha-text-xs halpha-text-red-600 halpha-mt-3">
                Delete Account
            </button>
        </div>
    </div>

    <x-confirmation-modal event="confirm-delete-account" wireConfirm="deleteAccount" title="Delete Account"
        message="This action is irreversible. All your data will be permanently deleted." />


</div>