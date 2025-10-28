{{-- 2) Staking Plans (responsive) --}}
<section class="pd-top-0">
    <div class="container-default w-container">
        <div class="heading-and-content-grid mg-bottom-24px">
            <div class="inner-container _564px _100-tablet">
                <h2 class="display-2 heading-color-gradient mg-bottom-0">Staking Plans</h2>
                <p class="color-neutral-100 mg-bottom-16px !halpha-text-gray-400">Choose a plan that fits your capital and risk appetite. Transparent fees and clearly defined payout cadence.</p>
            </div>
        </div>

        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 lg:halpha-grid-cols-3 halpha-gap-6">
            @php
                $plans = [
                ['name'=>'Starter','apy'=>'6-8%','min'=>'$50','features'=>['Pooled Validator','Daily rewards','No lock-in']],
                ['name'=>'Pro','apy'=>'9-12%','min'=>'$1,000','features'=>['Dedicated validator slots','Priority withdrawals','Referral bonus']],
                ['name'=>'Institutional','apy'=>'12%+','min'=>'$50,000','features'=>['Custom SLA','On-premise audits','White-glove support']],
                ];
            @endphp

            @foreach($plans as $p)
                <div class="halpha-rounded-[20px] halpha-p-6 halpha-bg-gradient-to-br halpha-from-[#071025] halpha-to-[#08131a] halpha-flex halpha-flex-col halpha-justify-between">
                <div>
                    <div class="halpha-flex halpha-justify-between halpha-items-center">
                    <h4 class="halpha-text-xl halpha-font-bold halpha-text-white">{{ $p['name'] }}</h4>
                    <div class="halpha-text-right">
                        <div class="halpha-text-sm halpha-text-gray-300">Est. APY</div>
                        <div class="halpha-text-2xl halpha-font-extrabold halpha-text-white">{{ $p['apy'] }}</div>
                    </div>
                    </div>

                    <p class="halpha-text-sm halpha-text-gray-300 halpha-mt-4">Min: {{ $p['min'] }}</p>

                    <ul class="halpha-mt-4 halpha-list-none halpha-space-y-2">
                    @foreach($p['features'] as $feat)
                        <li class="halpha-text-sm halpha-text-gray-300">• {{ $feat }}</li>
                    @endforeach
                    </ul>
                </div>

                <div class="halpha-mt-6 halpha-flex halpha-gap-3 halpha-flex-col sm:halpha-flex-row">
                    <a href="/staking" class="btn-primary w-full sm:!halpha-w-auto">{{ $p['name'] }} — Join</a>
                    <a href="/pricing" class="btn-secondary w-full sm:!halpha-w-auto">See details</a>
                </div>
                </div>
            @endforeach

        </div>
    </div>
</section>