<section class="halpha-py-5 md:halpha-py-12">
    <div class="container-default w-container">
        <div class="inner-container _1000px _100-tablet">
            <h2 class="display-2 heading-color-gradient mg-bottom-6">Referral Commission — 10 Level System</h2>
            <p class="!halpha-text-gray-400 mg-bottom-6">
                Earn commissions on 10 levels of referrals. See the breakdown below — values animate in for emphasis.
            </p>

            {{-- Component --}}
            <div
                x-data="referralLevelsComponent()"
                x-init="init()"
                class="halpha-relative halpha-w-full halpha-max-w-[1100px]d halpha-mx-auto halpha-mt-10"
                role="region"
                aria-label="Referral commission levels"
            >

                {{-- Card --}}
                <div class="halpha-mt-3 halpha-rounded-[12px] halpha-p-6 halpha-bg-gradient-to-b halpha-from-[#04060a] halpha-to-[#071021] halpha-border halpha-border-[#505050] halpha-shadow-[0_6px_30px_rgba(2,6,12,0.6)] halpha-relative">
                    
                    <div class="halpha-absolute -halpha-top-3 md:-halpha-top-4 halpha-right-[36%] md:halpha-right-[49%]">
                        <span class="halpha-inline-block halpha-bg-[#07121a] halpha-text-[#e6f7f0] halpha-px-6 md:halpha-py-1 halpha-rounded-full halpha-border halpha-border-[#2b3944] halpha-text-base md:halpha-text-xl halpha-shadow-sm">
                            Level
                        </span>
                    </div>

                    
                    <div class="halpha-overflow-x-auto halpha-no-scrollbar">
                        <div class="halpha-min-w-[920px] md:halpha-min-w-0">
                            {{-- level numbers --}}
                            <div class="halpha-grid halpha-grid-cols-10 halpha-gap-6 halpha-items-end halpha-text-center">
                                <template x-for="(lvl, idx) in levels" :key="idx">
                                    <div class="halpha-flex halpha-flex-col halpha-items-center">
                                        <div class="halpha-text-base md:halpha-text-xl !halpha-text-gray-300"> 
                                            <span x-text="idx+1"></span> 
                                        </div>
                                    </div>
                                </template>
                            </div>

                            {{-- connector line & ticks --}}
                            <div class="halpha-relative halpha-mt-6 halpha-mb-6 halpha-h-8">
                                {{-- main thin line --}}
                                <div class="halpha-absolute halpha-left-6 halpha-right-6 halpha-top-1/2 halpha-h-[1px] halpha-bg-[#1b2930]"></div>

                                {{-- ticks --}}
                                <div class="halpha-grid halpha-grid-cols-10 halpha-gap-6 halpha-items-center halpha-h-full">
                                    <template x-for="(lvl, idx) in levels" :key="idx">
                                        <div class="halpha-flex halpha-justify-center halpha-items-start">
                                            <div class="halpha-h-10 halpha-w-[1px] halpha-bg-[#24323a]"></div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            {{-- commission percents row --}}
                            <div class="halpha-grid halpha-grid-cols-10 halpha-gap-6 halpha-items-start halpha-text-center">
                                <template x-for="(lvl, idx) in levels" :key="idx">
                                    <div class="halpha-flex halpha-flex-col halpha-items-center">
                                        <div 
                                            class="halpha-text-base md:halpha-text-xl halpha-font-semibold halpha-text-[#e6f7f0] halpha-px-2 halpha-py-2 halpha-rounded" 
                                            :class="{'halpha-shadow-[0_6px_30px_rgba(0,230,176,0.08)] halpha-bg-gradient-to-b halpha-from-[#001f16] halpha-to-[#00261c]': hovered === idx || active === idx}"
                                            @mouseenter="hovered = idx" 
                                            @mouseleave="hovered = null" 
                                            @click="active = (active === idx ? null : idx)"
                                            tabindex="0"
                                            :aria-label="`Level ${idx+1} commission ${displayValues[idx]}`"
                                            role="button"
                                        >
                                            <span x-text="displayValues[idx]"></span>
                                        </div>
                                        <!-- <div class="halpha-text-xs halpha-text-gray-400 halpha-mt-2">Commission %</div> -->
                                    </div>
                                </template>
                            </div>

                        </div> {{-- min-w wrapper --}}
                    </div> 


                    
                    <div class="halpha-mt-3 md:halpha-mt-[6px] halpha-absolute halpha-right-[30%] md:halpha-right-[46%]">
                        <span class="halpha-inline-block halpha-bg-[#07121a] halpha-text-[#e6f7f0] halpha-px-4 md:halpha-py-1 halpha-rounded-full halpha-border halpha-border-[#2b3944] halpha-text-base md:halpha-text-xl">
                            Commission %
                        </span>
                    </div>
                </div> {{-- card --}}

                
                <p class="halpha-sr-only halpha-text-gray-300" x-text="`Levels 1 to 10 commissions shown: ${displayValues.join(', ')}`"></p>
            </div>

            <div class="halpha-flex halpha-flex-col halpha-py-5">
                <h4>Example:</h4>
                <p class="!halpha-text-gray-300">
                    If your direct referral invests 5 ETH, you earn 4% immediately — paid in the same token or USDT equivalent.
                </p>
            </div>
        </div>
    </div>
</section>

 
@once
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function referralLevelsComponent() {
            return {
                levels: [4, 2, 1, 1, 0.5, 0.5, 0.5, 0.25, 0.15, 0.10],
                // displayed text (animated)
                displayValues: [],
                // animation state
                hovered: null,
                active: null,
                speed: 800, // ms duration for animate-in
                init() {
                    // initialize display values to 0% and animate to target
                    this.displayValues = this.levels.map(_ => '0%');

                    // animate each value with a slight stagger
                    this.levels.forEach((target, i) => {
                        // convert to number (in case decimals)
                        const t = Number(target);
                        // start after small delay for stagger
                        setTimeout(() => this.animateValue(i, 0, t, this.speed), i * 70);
                    });
                },
                animateValue(index, start, end, duration) {
                    const startTime = performance.now();
                    const step = (time) => {
                        const progress = Math.min((time - startTime) / duration, 1);
                        // ease-out cubic
                        const eased = 1 - Math.pow(1 - progress, 3);
                        const value = start + (end - start) * eased;

                        // format: keep two decimal max (but avoid .00)
                        const formatted = Number.isInteger(end) ? Math.round(value) + '%' : (Math.round(value * 100) / 100).toString().replace(/\.0+$/,'') + '%';

                        this.displayValues.splice(index, 1, formatted);
                        if (progress < 1) {
                            requestAnimationFrame(step);
                        } else {
                            // ensure final exact
                            const final = Number.isInteger(end) ? Math.round(end) + '%' : (end % 1 === 0 ? Math.round(end) + '%' : end + '%');
                            this.displayValues.splice(index, 1, final);
                        }
                    };
                    requestAnimationFrame(step);
                }
            }
        }
    </script>
@endonce
<style>
    .halpha-no-scrollbar::-webkit-scrollbar { display: none; }
    .halpha-no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
