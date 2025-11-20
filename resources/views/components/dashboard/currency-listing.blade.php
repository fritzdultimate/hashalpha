<!-- @props([
    'groupedWallets' => []
]) -->

<div x-data="depositPanel()" x-init="init()" class="halpha-w-full halpha-max-w-lg halpha-mx-auto halpha-space-y-4">
    @foreach ($groupedWallets as $letter => $items)
        <div>
            <div class="halpha-text-xs halpha-font-semibold halpha-text-gray-400 halpha-mb-2">{{ $letter }}</div>

            <!-- List -->
            <ul class="halpha-space-y-2">
                @foreach ($items as $wallet)
                    <li class="halpha-flex halpha-items-center halpha-gap-3 halpha-p-2 halpha-rounded-md halpha-cursor-pointer halpha-transition halpha-bg-transparent hover:halpha-bg-gray-700 focus:halpha-outline-none"
                        tabindex="0" role="button" @click="openPanel({{ json_encode($wallet) }})"
                        @keydown.enter="openPanel({{ json_encode($wallet) }})"
                        aria-label="Select {{ $wallet['currency'] }} - {{ $wallet['label'] }}">
                        <span
                            class="halpha-w-6 halpha-h-6 {{ $wallet['bg'] }} halpha-rounded-full halpha-flex halpha-justify-center halpha-items-center">
                            <span class="icon {{ $wallet['icon'] }}"></span>
                        </span>
                        <div class="halpha-flex-1">
                            <div class="halpha-flex halpha-items-baseline halpha-justify-between">
                                <span
                                    class="halpha-font-semibold halpha-text-white halpha-text-sm halpha-uppercase">{{ $wallet['currency'] }}</span>
                                <span class="halpha-text-xs halpha-text-gray-500">Deposit available</span>
                            </div>
                            <div class="halpha-text-xs halpha-text-gray-400 halpha-mt-0.5 halpha-capitalize">
                                {{ $wallet['label'] }}</div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach

    <!-- Bottom sheet overlay -->
    <div x-show="panelOpen" x-transition.opacity class="halpha-fixed halpha-inset-0 halpha-bg-black/50 halpha-z-40"
        style="display: none;" @click="closePanel()" aria-hidden="true"></div>

    <!-- Slide-up panel -->
    <aside 
        x-show="panelOpen" 
        x-transition:enter="halpha-transition halpha-duration-300 halpha-ease-out"
        x-transition:enter-start="halpha-translate-y-full" 
        x-transition:enter-end="halpha-translate-y-0"
        x-transition:leave="halpha-transition halpha-duration-250 halpha-ease-in"
        x-transition:leave-start="halpha-translate-y-0" 
        x-transition:leave-end="halpha-translate-y-full"
        class="halpha-fixed halpha-left-0 halpha-right-0 halpha-bottom-0 halpha-z-50 halpha-bg-gray-800 halpha-rounded-t-xl halpha-p-4 halpha-max-h-[85vh] halpha-overflow-auto"
        style="display: none;" 
        role="dialog" 
        aria-modal="true" 
        :aria-label="`Deposit ${selected?.label ?? ''}`"
    >
        <!-- header -->
        <div class="halpha-flex halpha-justify-between halpha-items-center halpha-mb-3">
            <div class="halpha-flex halpha-items-center halpha-gap-3">
                <span
                    class="halpha-w-8 halpha-h-8 halpha-rounded-full halpha-flex halpha-items-center halpha-justify-center"
                    :class="selected?.bg">
                    <span class="icon" :class="selected?.icon"></span>
                </span>
                <div>
                    <div class="halpha-font-semibold halpha-text-white" x-text="selected?.currency?.toUpperCase()">
                    </div>
                    <div class="halpha-text-xs halpha-text-gray-400" x-text="selected?.label"></div>
                </div>
            </div>

            <button class="halpha-text-gray-300 halpha-text-xl" @click="closePanel()"
                aria-label="Close">&times;</button>
        </div>

        <!-- STEPS -->
        <div x-show="step === 'form'">
            <form @submit.prevent="submitForm" class="halpha-space-y-3">
                <div>
                    <label class="halpha-text-xs halpha-text-gray-300">Currency</label>
                    <input type="text" x-model="form.currency" readonly
                        class="halpha-w-full halpha-mt-1 halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-gray-700 halpha-text-white halpha-border halpha-border-transparent" />
                </div>

                <div>
                    <label for="network" class="halpha-text-xs halpha-text-gray-300">Network</label>
                    <select id="network" x-model="form.network"
                        class="halpha-w-full halpha-mt-1 halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-gray-700 halpha-text-white">
                        <template x-for="n in networks" :key="n">
                            <option x-text="n" :value="n"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <label for="amount" class="halpha-text-xs halpha-text-gray-300">Amount</label>
                    <input id="amount" type="number" x-model="form.amount" min="0" step="any" required
                        class="halpha-w-full halpha-mt-1 halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-gray-700 halpha-text-white" />
                </div>

                <div class="halpha-flex halpha-items-center halpha-justify-between halpha-gap-2">
                    <button type="submit"
                        class="halpha-flex-1 halpha-py-2 halpha-rounded halpha-bg-indigo-600 halpha-text-white halpha-font-medium">Continue</button>
                    <button type="button" @click="closePanel()"
                        class="halpha-px-4 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-600 halpha-text-gray-300">Cancel</button>
                </div>

                <div x-show="error" class="halpha-text-sm halpha-text-red-400" x-text="error"></div>
            </form>
        </div>

        <!-- OTP step -->
        <div x-show="step === 'otp'">
            <div class="halpha-space-y-3">
                <div>
                    <div class="halpha-text-sm halpha-text-gray-300">Enter the OTP sent to your phone/email</div>
                </div>

                <div>
                    <label class="halpha-text-xs halpha-text-gray-300">OTP</label>
                    <input type="text" maxlength="6" x-model="otp"
                        class="halpha-w-full halpha-mt-1 halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-gray-700 halpha-text-white" />
                </div>

                <div class="halpha-flex halpha-items-center halpha-gap-2">
                    <button @click="verifyOtp"
                        class="halpha-flex-1 halpha-py-2 halpha-rounded halpha-bg-indigo-600 halpha-text-white">Verify</button>
                    <button @click="resendOtp"
                        class="halpha-px-4 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-600 halpha-text-gray-300">Resend</button>
                </div>

                <div x-show="error" class="halpha-text-sm halpha-text-red-400" x-text="error"></div>
            </div>
        </div>

        <!-- Address & status -->
        <div x-show="step === 'address'">
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
                        <div class="halpha-text-xs halpha-text-gray-400">Status: <span
                                class="halpha-font-medium halpha-text-white" x-text="status"></span></div>
                        <div class="halpha-text-xs halpha-text-gray-400" x-show="progress !== null"
                            x-text="progress+'%'"></div>
                    </div>

                    <div class="halpha-w-full halpha-bg-gray-700 halpha-rounded halpha-h-2">
                        <div class="halpha-h-2 halpha-rounded" :style="`width: ${progress ?? 0}%`"
                            class="halpha-bg-indigo-600"></div>
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
                    class="halpha-text-sm halpha-text-yellow-400 halpha-mt-2"
                    x-text="`Deposit was ${status}. You can try again.`"></div>
            </div>
        </div>

    </aside>

</div>

<script>
    function depositPanel() {
        return {
            panelOpen: false,
            selected: null,
            networks: ['Mainnet', 'ERC20', 'BEP20', 'TRC20'], // default networks - replace dynamically if you want
            form: { currency: '', network: '', amount: '' },
            step: 'form', // 'form' | 'otp' | 'address'
            error: null,
            otp: '',
            depositId: null,
            address: null,
            status: 'pending',
            progress: 0,
            pollInterval: null,

            init() {
                // nothing for now
            },

            openPanel(wallet) {
                this.selected = wallet;
                this.form.currency = wallet.currency;
                // set sensible default network if you have one per coin
                this.form.network = this.networks[0];
                this.form.amount = '';
                this.step = 'form';
                this.error = null;
                this.otp = '';
                this.depositId = null;
                this.address = null;
                this.status = 'pending';
                this.progress = 0;
                this.panelOpen = true;
                // focus first input after transition
                setTimeout(() => {
                    const el = document.querySelector('#amount');
                    if (el) el.focus();
                }, 350);
            },

            closePanel() {
                this.panelOpen = false;
                this.stopPolling();
                // small reset after closing
                setTimeout(() => {
                    this.selected = null;
                }, 300);
            },

            async submitForm() {
                this.error = null;

                if (!this.form.amount || parseFloat(this.form.amount) <= 0) {
                    this.error = 'Enter a valid amount';
                    return;
                }

                // disable button UI would be nice — omitted for brevity
                try {
                    // POST to your server to initiate deposit and send OTP
                    const res = await fetch('/deposit/initiate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            currency: this.form.currency,
                            network: this.form.network,
                            amount: this.form.amount
                        })
                    });

                    const data = await res.json();

                    if (!res.ok || !data.success) {
                        this.error = data.message || 'Failed to initiate deposit';
                        return;
                    }

                    this.depositId = data.deposit_id;
                    // server indicates OTP step next (or maybe direct address)
                    if (data.otp_required) {
                        this.step = 'otp';
                    } else if (data.address) {
                        this.address = data.address;
                        this.step = 'address';
                        this.startPolling();
                    } else {
                        // fallback
                        this.step = 'address';
                        this.startPolling();
                    }

                } catch (e) {
                    this.error = 'Network error. Try again.';
                    console.error(e);
                }
            },

            async verifyOtp() {
                this.error = null;
                if (!this.otp || this.otp.length < 4) {
                    this.error = 'Enter the OTP';
                    return;
                }

                try {
                    const res = await fetch('/deposit/verify-otp', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            deposit_id: this.depositId,
                            otp: this.otp
                        })
                    });

                    const data = await res.json();

                    if (!res.ok || !data.success) {
                        this.error = data.message || 'OTP validation failed';
                        return;
                    }

                    // server returns the deposit address and maybe initial status
                    this.address = data.address;
                    this.status = data.status || 'pending';
                    this.progress = data.progress ?? 0;
                    this.step = 'address';

                    // start polling for updates
                    this.startPolling();

                } catch (e) {
                    this.error = 'Network error while verifying OTP';
                    console.error(e);
                }
            },

            async resendOtp() {
                this.error = null;
                try {
                    const res = await fetch('/deposit/resend-otp', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({ deposit_id: this.depositId })
                    });
                    const data = await res.json();
                    if (!res.ok || !data.success) {
                        this.error = data.message || 'Failed to resend OTP';
                    }
                } catch (e) {
                    this.error = 'Network error';
                    console.error(e);
                }
            },

            copyAddress() {
                if (!this.address) return;
                navigator.clipboard?.writeText(this.address).then(() => {
                    // simple UX hint
                    alert('Address copied');
                }).catch(() => {
                    this.error = 'Copy failed';
                });
            },

            startPolling() {
                // stop any previous poll
                this.stopPolling();

                if (!this.depositId) return;

                // poll every 4 seconds - server should return latest status and progress
                this.pollInterval = setInterval(async () => {
                    try {
                        const res = await fetch(`/deposit/status/${this.depositId}`, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        const data = await res.json();
                        // expected: { status: 'pending'|'confirmed'|'cancelled'|'expired', progress: number }
                        if (data.status) this.status = data.status;
                        if (typeof data.progress !== 'undefined') this.progress = data.progress;
                        if (data.address) this.address = data.address;

                        if (this.status === 'confirmed' || this.status === 'cancelled' || this.status === 'expired') {
                            // stop polling when final state
                            this.stopPolling();
                        }
                    } catch (e) {
                        console.error('poll error', e);
                    }
                }, 4000);
            },

            stopPolling() {
                if (this.pollInterval) {
                    clearInterval(this.pollInterval);
                    this.pollInterval = null;
                }
            },

            async cancelDeposit() {
                if (!this.depositId) {
                    this.closePanel();
                    return;
                }
                try {
                    const res = await fetch(`/deposit/cancel/${this.depositId}`, {
                        method: 'POST', headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        }
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.status = 'cancelled';
                        this.progress = 0;
                        this.stopPolling();
                    } else {
                        this.error = data.message || 'Failed to cancel';
                    }
                } catch (e) {
                    this.error = 'Network error';
                    console.error(e);
                }
            },
        }
    }
</script>