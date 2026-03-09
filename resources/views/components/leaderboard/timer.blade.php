<div x-data="{
            end: {{ $end ? 'new Date(\'' . $end . '\').getTime()' : 'null' }},
            now: new Date().getTime(),
            timer: null,

            init() {
                if (!this.end) return;

                this.timer = setInterval(() => {
                    this.now = new Date().getTime();
                }, 1000);
            },

            get remaining() {
                if (!this.end) return 'No active challenge';

                let diff = this.end - this.now;

                if (diff <= 0) return 'Challenge ended';

                let d = Math.floor(diff / (1000*60*60*24));
                let h = Math.floor((diff % (1000*60*60*24))/(1000*60*60));
                let m = Math.floor((diff % (1000*60*60))/(1000*60));
                let s = Math.floor((diff % (1000*60))/1000);

                // 🔥 Smart formatting
                if (d > 0) {
                    return `${d} day${d > 1 ? 's' : ''} ${h} hour${h !== 1 ? 's' : ''}`;
                }

                if (h > 0) {
                    return `${h} hour${h > 1 ? 's' : ''} ${m} minute${m !== 1 ? 's' : ''}`;
                }

                if (m > 0) {
                    return `${m} minute${m > 1 ? 's' : ''}`;
                }

                return `${s} second${s !== 1 ? 's' : ''}`;
            }
        }" class="halpha-card halpha-p-4 halpha-text-center">
    <p class="halpha-text-xs halpha-text-gray-400">Time Remaining</p>

    <h2 class="halpha-text-accent-2 halpha-font-bold halpha-text-lg">
        <span x-text="remaining" class="halpha-capitalize"></span>
    </h2>
</div>