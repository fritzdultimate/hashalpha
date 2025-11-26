
function depositPanel() {
    return {
        panelOpen: false,
        selected: {currency: '', label: ''},
        networks: ['Mainnet', 'ERC20', 'BEP20', 'TRC20'],
        // network: 'Maka',
        form: { currency: '', network: '', amount: '' },
        step: 'form', // 'form' | 'otp' | 'address'
        error: null,
        otp: '',
        depositId: null,
        address: null,
        status: 'pending',
        progress: 0,
        pollInterval: null,
        pay_amount: 0.00,
        total: 20 * 60,
        time: 0,
        created_at: null,
        loadingAddress: true,

        init() {
            this.$watch('step', (value) => {
                this.$wire.set('step', value);

                window.dispatchEvent(new CustomEvent('focus-input'));

                if(value === 'address') {
                    setTimeout(() => {
                        this.loadingAddress = false;
                        this.startCountdown(this.created_at);
                    }, 6000)
                }
            });

            this._depositStepListener = (event) => {
                if (!event || !event.detail) return;
                const s = event.detail.step;
                if (!s) return;
                this.step = s;

                
                if (event.detail.depositId) {
                    this.depositId = event.detail.depositId;
                }

                console.log('init', this.depositId);
                if (s === 'address' && this.depositId) {
                    const { address, pay_amount } = event.detail;
                    this.address = address;
                    this.pay_amount = pay_amount;
                    console.log("address", address);
                    console.log("amount", pay_amount);
                    this.startPolling();
                }
            };
            window.addEventListener('deposit:step', this._depositStepListener);
        },

        openPanel(wallet) {
            this.selected = wallet;
            this.form.currency = wallet.currency;
            // set sensible default network if you have one per coin
            this.form.network = this.networks[0];
            this.form.amount = '';
            this.step = 'form' //'form'; //form
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

        startCountdown(createdAt) {
            const created = new Date(createdAt).getTime();
            const now = Date.now();

            const elapsed = Math.floor((now - created) / 1000);
            this.time = Math.max(0, this.total - elapsed);
            
            setInterval(() => {
                if (this.time > 0) this.time--
            }, 1000)
        },

        get display() {
            const m = String(Math.floor(this.time / 60)).padStart(2, '0')
            const s = String(this.time % 60).padStart(2, '0')
            return `${m}:${s}`
        },

        closePanel() {
            this.$wire.set('otp', null);
            window.dispatchEvent(new CustomEvent('reset-otp'));

            this.panelOpen = false;
            this.stopPolling();
            Livewire.dispatch('resetValues');


            setTimeout(() => {
                this.selected = {currency: '', label: ''};
            }, 300);
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

            this.pollInterval = setInterval(async () => {
                try {
                    const res = await fetch(`/api/deposit/status/${this.depositId}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await res.json();
                    console.log(data);
                    if (data.details.payment_status) this.status = data.details.payment_status;
                    if (data.details.progress) this.progress = data.details.progress;
                    if (data.details.pay_address) this.address = data.details.pay_address;
                    if (data.details.created_at) this.created_at = data.details.created_at;


                    if (this.status === 'confirmed' || this.status === 'finished' || this.status === 'cancelled' || this.status === 'expired') {
                        this.created_at = null;
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
                const res = await fetch(`/api/deposit/cancel/${this.depositId}`, {
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