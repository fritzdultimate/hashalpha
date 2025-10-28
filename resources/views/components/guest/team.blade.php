{{-- 6) Team (responsive) --}}
    <section class="pd-top-0 halpha-hiddenk">
        <div class="container-default w-container">
            <div class="heading-and-content-grid mg-bottom-24px">
                <div class="inner-container _564px _100-tablet">
                    <h2 class="display-2 heading-color-gradient mg-bottom-0">Team & Governance</h2>
                    <p class="color-neutral-100 mg-bottom-16px !halpha-text-gray-400">
                        Experienced ops, security and blockchain engineers — full bios in About → Team.
                    </p>
                </div>
            </div>

            <div class="halpha-grid halpha-grid-cols-1 sm:halpha-grid-cols-2 lg:halpha-grid-cols-3 halpha-gap-6">
                @php
                    $team = [
                        ['name' => 'Ada Nwosu', 'role' => 'Head of Ops', 'img' => 'https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c058/64da812c6c0e42f6e7be039c_john-carter-thumbnail-cryptomatic-webflow-ecommerce-template.jpg'],
                        ['name' => 'Emeka Obi', 'role' => 'Lead Validator Engineer', 'img' => 'https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c058/64da812c6c0e42f6e7be039c_john-carter-thumbnail-cryptomatic-webflow-ecommerce-template.jpg'],
                        ['name' => 'Chioma Okeke', 'role' => 'Head, Compliance', 'img' => 'https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c058/64da812c6c0e42f6e7be039c_john-carter-thumbnail-cryptomatic-webflow-ecommerce-template.jpg'],
                    ];
                @endphp

                @foreach($team as $m)
                    <div class="halpha-rounded-[16px] halpha-p-6 halpha-bg-[#07101a] halpha-text-center">
                        <img src="{{ $m['img'] }}" alt="{{ $m['name'] }}"
                            class="halpha-w-28 halpha-h-28 md:halpha-w-32 md:halpha-h-32 halpha-rounded-full halpha-object-cover halpha-mx-auto">
                        <h4 class="halpha-mt-4 halpha-text-white">{{ $m['name'] }}</h4>
                        <p class="halpha-text-sm halpha-text-gray-300">{{ $m['role'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="halpha-mt-6">
                <a href="/about#team" class="btn-secondary w-button">Meet the full team</a>
            </div>
        </div>
    </section>