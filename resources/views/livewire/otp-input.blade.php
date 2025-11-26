<div x-data="otpComponent()" class="halpha-space-y-2 halpha-w-full" x-init="init()">

    <div class="halpha-flex halpha-gap-3">
        @for ($i = 0; $i < 4; $i++)
            <input 
                x-ref="otp{{ $i }}"
                x-model="boxes[{{ $i }}]"
                x-on:input="handleInput($event, {{ $i }})"
                x-on:keydown.backspace="handleBackspace($event, {{ $i }})"
                maxlength="1"
                inputmode="numeric"
                pattern="[0-9]*"
                class="halpha-w-10 halpha-h-12 halpha-text-center halpha-text-lg halpha-rounded halpha-bg-gray-700 halpha-text-white halpha-flex-1"
            />
        @endfor
    </div>

    
    <input type="hidden" wire:model.live="otp" x-ref="hiddenOtp" />

    <p class="halpha-text-xs halpha-text-gray-400 halpha-mt-1 text-center">
        Didn't get the code?
        <button class="halpha-text-blue-400" wire:click="$dispatch('resendOtp')">
            Resend
        </button>
    </p>
</div>

<script>
function otpComponent() {
    return {
        handleParentEvent() {
            // this.$refs.otp2.focus();
            alert('focus')
        },


        boxes: ['', '', '', ''],
        get combined() {
            return this.boxes.join('');
        },
        syncToLivewire() {
            this.$refs.hiddenOtp.value = this.combined;
            this.$refs.hiddenOtp.dispatchEvent(new Event('input', { bubbles: true }));
        },

        handleInput(e, index) {
            const val = e.target.value.replace(/\D/g, '');
            this.boxes[index] = val;

            if (val && index < 3) {
                this.$refs[`otp${index + 1}`].focus();
            }

            this.syncToLivewire();
        },
        handleBackspace(e, index) {
            if (!this.boxes[index] && index > 0) {
                this.$refs[`otp${index - 1}`].focus();

                this.syncToLivewire();
            }
            this.syncToLivewire();
        },
        init() {
            this._parentHandler = (e) => this.handleParentEvent(e.detail);
            window.addEventListener('focus-input', this._parentHandler);

            window.addEventListener('reset-otp', () => {
                alert('otp reset');
                this.boxes = ['', '', '', ''];
                this.syncToLivewire();
                // focus first input
                this.$refs.otp0.focus();
            });

            const initial = this.$refs.hiddenOtp ? this.$refs.hiddenOtp.value : '';
            if (initial) {
                for (let i=0;i<4;i++){
                    this.boxes[i] = initial[i] ?? '';
                    if (this.boxes[i] && this.$refs[`otp${i}`]) this.$refs[`otp${i}`].value = this.boxes[i];
                }
            }
            for (let i=0;i<4;i++){ if (!this.boxes[i]){ this.$refs[`otp${i}`].focus(); break; } }
        }
    }
}
</script>
