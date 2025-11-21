
function depositPanel() {
    return {
        panelOpen: false,
        selected: {currency: '', label: ''},
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
            
            this.$wire.set('currency', wallet.currency);
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
                this.selected = {currency: '', label: ''};
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

function currencySelector({ initial = {}, items = [] } = {}) {
    return {
        open: false,
        items: items,
        // selected: {
        //     currency: initial.currency ?? (items[0] ? items[0].currency : ''),
        //     label: initial.label ?? (items[0] ? items[0].label : ''),
        //     icon: initial.icon ?? (items[0] ? items[0].icon : ''),
        //     bg: initial.bg ?? (items[0] ? items[0].bg : '')
        // },
        activeIndex: -1,

        toggle() {
            this.open = !this.open;
            if (this.open) {
                // position for keyboard nav
                this.$nextTick(() => {
                    this.activeIndex = this.items.findIndex(i => i.currency === this.selected.currency);
                    if (this.activeIndex === -1) this.activeIndex = 0;
                    const el = document.getElementById(`option-${this.items[this.activeIndex].currency}`);
                    if (el) el.scrollIntoView({ block: 'nearest' });
                });
            }
        },

        openList() {
            this.open = true;
            this.$nextTick(() => {
                this.activeIndex = this.items.findIndex(i => i.currency === this.selected.currency);
            });
        },

        close() {
            this.open = false;
            this.activeIndex = -1;
        },

        // select(item) {
        //     this.selected = {...item};
        //     this.close();
        //     // dispatch an event so parent form can react if needed
        //     this.$el.dispatchEvent(new CustomEvent('currency-changed', { detail: this.selected }));
        // },

        focusNext() {
            if (!this.open) { this.openList(); return; }
            this.activeIndex = Math.min(this.activeIndex + 1, this.items.length - 1);
            this.scrollActiveIntoView();
        },

        focusPrev() {
            if (!this.open) { this.openList(); return; }
            this.activeIndex = Math.max(0, this.activeIndex - 1);
            this.scrollActiveIntoView();
        },

        scrollActiveIntoView() {
            this.$nextTick(() => {
                if (this.activeIndex >= 0 && this.items[this.activeIndex]) {
                    const id = `option-${this.items[this.activeIndex].currency}`;
                    const el = document.getElementById(id);
                    if (el) el.scrollIntoView({ block: 'nearest' });
                }
            });
        },

        handleKey(e) {
            // open/close with space/enter
            if (['Enter', ' '].includes(e.key)) {
                e.preventDefault();
                this.toggle();
                return;
            }
            if (e.key === 'ArrowDown') { this.focusNext(); return; }
            if (e.key === 'ArrowUp') { this.focusPrev(); return; }
            if (e.key === 'Escape') { this.close(); return; }
            if (e.key === 'Home') { this.activeIndex = 0; this.scrollActiveIntoView(); return; }
            if (e.key === 'End') { this.activeIndex = this.items.length - 1; this.scrollActiveIntoView(); return; }
            if (e.key === 'Tab') { this.close(); return; }

            // letter key quick jump
            if (e.key.length === 1 && /^[a-z0-9]$/i.test(e.key)) {
                const query = e.key.toLowerCase();
                const found = this.items.findIndex(it => it.currency[0].toLowerCase() === query || it.label[0].toLowerCase() === query);
                if (found !== -1) {
                    this.activeIndex = found;
                    this.select(this.items[found]);
                }
            }
        }
    }
}