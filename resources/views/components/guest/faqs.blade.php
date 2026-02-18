
<section class="halpha-bg-[rgba(255,255,255,0.01)]">
    <div class="container-default w-container">
        <div class="heading-and-content-grid mg-bottom-24px">
            <div class="inner-container _564px _100-tablet">
                <h2 class="display-2 heading-color-gradient mg-bottom-0">FAQ</h2>
                <p class="color-neutral-100 mg-bottom-16px !halpha-text-gray-400">
                    Understanding HashAlpha’s Infrastructure Model
                </p>
            </div>
        </div>

        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-6">
            @php
                $faqs = [
                    [
                        'q' => 'What is HashAlpha building?',
                        'a' => [
                            'HashAlpha is developing a multi-layer digital infrastructure ecosystem anchored by validator operations and expanding into scalable infrastructure services.',
                            'Validators are the foundation — not the ceiling.',
                            'Phase 2 extends our architecture to support diversified operational layers and long-term network participation.'
                        ]
                    ],
                    [
                        'q' => 'Is HashAlpha only a staking platform?',
                        'a' => [
                            'No.',
                            'While validator operations remain core, HashAlpha is evolving into a broader infrastructure operator. This includes infrastructure optimization, performance engineering, and scalable hosting frameworks designed for long-term ecosystem participation.'
                        ]
                    ],
                    [
                        'q' => 'How is the infrastructure structured?',
                        'a' => [
                            'Our architecture is built on:',
                            [
                                'Distributed validator operations',
                                'Multi-region redundancy',
                                'Infrastructure isolation protocols',
                                'Automated failover systems',
                                'Real-time monitoring and performance analytics'
                            ],
                            'The objective is resilience, not short-term amplification.'
                        ]
                    ],
                    [
                        'q' => 'How does HashAlpha approach scalability?',
                        'a' => [
                            'Scalability is achieved through layered infrastructure design. Instead of increasing exposure within a single vertical, we are expanding operational layers to reduce concentration risk and support diversified participation.',
                            'Phase 2 focuses on structured expansion rather than aggressive growth.'
                        ]
                    ],
                    [
                        'q' => 'How is risk managed?',
                        'a' => [
                            'We apply operational risk controls including:',
                            [
                                'Slashing mitigation systems',
                                'Relay diversification',
                                'Infrastructure redundancy',
                                'Monitoring and alert automation',
                                'Defined response procedures'
                            ],
                            'Risk cannot be eliminated — but it can be engineered and managed.'
                        ]
                    ],
                    [
                        'q' => 'Are returns fixed?',
                        'a' => [
                            'No.',
                            'Participation outcomes depend on network conditions, validator performance, and infrastructure efficiency. HashAlpha does not promise fixed or guaranteed returns.',
                            'Our focus is sustainable participation, not yield marketing.'
                        ]
                    ],
                    [
                        'q' => 'What does Phase 2 represent?',
                        'a' => [
                            'Phase 2 marks the transition from validator-centric operations to a broader infrastructure ecosystem.',
                            'This includes:',
                            [
                                'Enhanced operational layers',
                                'Expanded hosting capabilities',
                                'Revenue diversification',
                                'Scalable infrastructure frameworks'
                            ],
                            'Deployment details will be introduced progressively..'
                        ]
                    ],
                    [
                        'q' => 'Who is HashAlpha designed for?',
                        'a' => [
                            'HashAlpha is built for:',
                            [
                                'Long-term digital asset participants',
                                'Infrastructure-focused operators',
                                'Strategic partners',
                                'Institutional stakeholders'
                            ],
                            'We are infrastructure-first, participation-aligned, and growth-disciplined.'
                        ]
                    ]
                ];
                $active = isset($showing) ? $showing : 10;
            @endphp

            @foreach ($faqs as $faq)
                @continue($loop->index >= $active)
                <div>
                    <h5 class="halpha-text-white halpha-font-semibold">{{ $faq['q'] }}</h5>

                    @foreach ($faq['a'] as $texts)
                        @if (is_array($texts))
                            <ul class="halpha-list-disc">
                                @foreach ($texts as $text)
                                    <li class="halpha-text-gray-300 halpha-text-sm halpha-font-medium">{{ $text }}</li>
                                @endforeach
                            </ul>

                            @continue
                        @endif
                        <p class="halpha-text-sm halpha-text-gray-300">
                            {{ $texts }}
                        </p>
                    @endforeach
                </div>
            @endforeach
        </div>

        @if($active < count($faqs))
            <div class="halpha-mt-6">
                <a href="/support" class="btn-primary w-button">See full FAQ & Support</a>
            </div>
        @endif
    </div>
</section>