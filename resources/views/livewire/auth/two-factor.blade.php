<div class="halpha-flex halpha-items-center halpha-justify-center halpha-bg-black halpha-px-4 halpha-py-12">
    <div class="halpha-w-full halpha-max-w-md halpha-mx-auto">
        <div
            class="halpha-bg-gradient-to-b halpha-from-[#0b0b0b] halpha-to-transparent halpha-rounded-2xl halpha-shadow-xl halpha-overflow-hidden">

            <div class="halpha-p-3 sm:halpha-p-6 halpha-text-center">
                <div class="halpha-flex halpha-flex-col halpha-items-center halpha-gap-3">
                    <div
                        class="halpha-w-14 halpha-h-14 halpha-rounded-full halpha-bg-gray-800 halpha-flex halpha-items-center halpha-justify-center">
                        <svg class="halpha-w-6 halpha-h-6 halpha-text-gray-200" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>

                    <h3 class="halpha-text-2xl halpha-text-gray-200 halpha-font-semibold">Enter verification code</h3>
                    <p class="halpha-text-sm halpha-text-gray-400">The code was sent to your email address.</p>
                </div>

                <form wire:submit.prevent="verify" class="halpha-mt-6">
                    <input wire:model.defer="code" type="text" maxlength="6"
                        class="halpha-w-full halpha-text-center halpha-text-2xl halpha-bg-transparent halpha-border halpha-border-gray-700 halpha-py-3 halpha-rounded-lg halpha-text-gray-100"
                        placeholder="Enter 6-digit code" />

                    @error('code')
                        <span class="halpha-text-red-500 halpha-text-sm">{{ $message }}</span>
                    @enderror

                    <button wire:loading.attr="disabled" type="submit" wire:target="verify"
                        class="halpha-w-full halpha-py-3 halpha-rounded-full halpha-font-bold halpha-bg-gray-200 halpha-text-gray-800 halpha-mt-8 hover:halpha-opacity-95"
                        wire:loading.class="hover:halpha-opacity-100 halpha-opacity-50">
                        <span wire:loading.remove wire:target="verify">Verify</span>
                        <x-codicon-loading wire:loading wire:target="verify"
                            class="halpha-w-5 halpha-h-5 halpha-animate-spin" />
                    </button>
                    <div
                        class="halpha-mt-4 halpha-flex halpha-items-center halpha-justify-between halpha-text-sm halpha-text-gray-400">
                        <div x-data="resendCountdown({{ $resendAvailableUntil ?? 'null' }})" x-init="init()"
                            class="halpha-flex halpha-items-center halpha-gap-4">
                            <button 
                                type="button" 
                                wire:click="resend" 
                                :disabled="disabled"
                                :class="disabled ? 'halpha-opacity-50 halpha-cursor-not-allowed' : 'halpha-underline halpha-cursor-pointer'"
                                class="halpha-text-sm"
                            >
                                <span wire:loading.remove wire:target="resend">
                                    <span x-show="!disabled" x-cloak>Resend code</span>
                                    <span x-show="disabled" x-cloak>
                                        Resend again in <strong x-text="format(remaining)"></strong>
                                    </span>
                                </span>
                                <span wire:loading wire:target="resend">Resending</span>
                            </button>

                        </div>
                        <a href="{{ route('login') }}" class="halpha-underline">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@once
    <script>
        function resendCountdown(serverUntil) {
            return {
                until: serverUntil || null,
                remaining: 0,
                disabled: false,
                timer: null,

                init() {
                    this.updateRemaining();

                    // start ticking only if we have remaining > 0
                    if (this.remaining > 0) {
                        this.disabled = true;
                        this.start();
                    }
                    window.addEventListener('resend-start', (e) => {
                        console.log(e?.detail?.until)
                        this.until = e?.detail?.until ?? this.until;
                        this.updateRemaining();
                        if (this.remaining > 0) {
                            this.disabled = true;
                            this.start();
                        }
                    });
                },

                updateRemaining() {
                    if (!this.until) {
                        this.remaining = 0;
                        this.disabled = false;
                        return;
                    }
                    const nowSec = Math.floor(Date.now() / 1000);
                    this.remaining = Math.max(0, this.until - nowSec);
                    this.disabled = this.remaining > 0;
                },

                start() {
                    // clear existing
                    if (this.timer) cancelAnimationFrame(this.timer);

                    const tick = () => {
                        this.updateRemaining();
                        if (this.remaining <= 0) {
                            this.disabled = false;
                            // stop
                            return;
                        }
                        // schedule next frame in ~1s
                        this.timer = setTimeout(tick, 900);
                    };

                    tick();
                },

                // show mm:ss or ss
                format(s) {
                    if (!s || s <= 0) return '00:00';
                    const mm = Math.floor(s / 60);
                    const ss = s % 60;
                    return mm > 0 ? String(mm).padStart(2, '0') + ':' + String(ss).padStart(2, '0') : '00:' + String(ss).padStart(2, '0');
                }
            }
        }
    </script>
@endonce