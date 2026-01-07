<div class="halpha-space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="halpha-text-xl md:halpha-text-3xl halpha-font-semibold halpha-text-white">
            System Status & Network Health
        </h1>
        <p class="halpha-text-xs md:halpha-text-sm halpha-text-gray-400">
            Real-time operational transparency across validator infrastructure
        </p>
    </div>

    {{-- PLATFORM STATUS --}}
    <div class="halpha-card halpha-p-4 halpha-rounded-xl halpha-bg-gray-900 halpha-border halpha-border-gray-800">
        <div class="halpha-flex halpha-items-center halpha-gap-2">
            <div class="halpha-flex halpha-items-center halpha-text-sm halpha-font-semibold halpha-text-white halpha-gap-2">
                <span class="halpha-flex halpha-items-center halpha-gap-0.5">
                    <x-heroicon-s-check-circle class="halpha-w-5 halpha-h-5 halpha-text-green-300" />
                    <span class="halpha-text-base">Operational Status:</span>
                </span>
                <span class="halpha-flex halpha-items-center halpha-gap-1">
                    <x-heroicon-s-check-circle class="halpha-w-3 halpha-h-3 halpha-text-green-300" />
                    <span>Operational</span>
                </span>
            </div>
        </div>

        <div class="halpha-text-xs halpha-text-gray-500 halpha-mt-1">
            Last updated: April 27, 2024, 10:23 UTC
        </div>
    </div>

    {{-- VALIDATOR NETWORK STATUS --}}
    <div class="halpha-card halpha-p-4 halpha-rounded-xl">
        <h3 class="halpha-text-sm halpha-font-semibold halpha-text-white halpha-mb-3">
            Validator Network Status
        </h3>

        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-3 halpha-gap-4 halpha-text-xs">
            <div>
                <div class="halpha-text-gray-400">Active Validators</div>
                <div class="halpha-text-white halpha-font-semibold">145</div>
            </div>

            <div>
                <div class="halpha-text-gray-400">Validators in Rotation</div>
                <div class="halpha-text-white halpha-font-semibold">12</div>
            </div>

            <div>
                <div class="halpha-text-gray-400">Syncing / Maintenance</div>
                <div class="halpha-text-white halpha-font-semibold">3</div>
            </div>
        </div>

        <div class="halpha-flex halpha-items-center halpha-gap-2 halpha-mt-3">
            <span class="halpha-text-green-400">✔</span>
            <span class="halpha-text-xs halpha-text-gray-400">
                Cluster operating within normal parameters
            </span>
        </div>
    </div>

    {{-- NETWORK PARTICIPATION --}}
    <div class="halpha-card halpha-p-4 halpha-rounded-xl">
        <h3 class="halpha-text-sm halpha-font-semibold halpha-text-white halpha-mb-3">
            Network Participation Status
        </h3>

        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-3 halpha-gap-4 halpha-text-xs">
            <div>
                <div class="halpha-text-gray-400">Ethereum Network</div>
                <div class="halpha-text-green-400 halpha-font-semibold">Connected</div>
            </div>

            <div>
                <div class="halpha-text-gray-400">Finality</div>
                <div class="halpha-text-white halpha-font-semibold">Normal</div>
            </div>

            <div>
                <div class="halpha-text-gray-400">Missed Proposals (24h)</div>
                <div class="halpha-text-white halpha-font-semibold">Within tolerance</div>
            </div>
        </div>

        <div class="halpha-text-xs halpha-text-gray-500 halpha-mt-2">
            Penalty events: None
        </div>
    </div>

    {{-- PERFORMANCE & RELIABILITY --}}
    <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-4">

        <div class="halpha-card halpha-p-4 halpha-rounded-xl">
            <h3 class="halpha-text-sm halpha-font-semibold halpha-text-white halpha-mb-3">
                Performance & Reliability
            </h3>

            <div class="halpha-space-y-2 halpha-text-xs">
                <div class="halpha-flex halpha-justify-between">
                    <span class="halpha-text-gray-400">Network uptime (rolling)</span>
                    <span class="halpha-text-white">30.9%</span>
                </div>

                <div class="halpha-flex halpha-justify-between">
                    <span class="halpha-text-gray-400">90-day uptime</span>
                    <span class="halpha-text-white">99.8%</span>
                </div>

                <div class="halpha-flex halpha-justify-between">
                    <span class="halpha-text-gray-400">Slashing events</span>
                    <span class="halpha-text-green-400">None</span>
                </div>
            </div>

            <p class="halpha-text-[11px] halpha-text-gray-500 halpha-mt-3">
                Metrics reflect network-level participation, not individual accounts.
            </p>
        </div>

        {{-- REWARD DISTRIBUTION --}}
        <div class="halpha-card halpha-p-4 halpha-rounded-xl">
            <h3 class="halpha-text-sm halpha-font-semibold halpha-text-white halpha-mb-3">
                Reward Distribution Status
            </h3>

            <div class="halpha-space-y-2 halpha-text-xs">
                <div class="halpha-flex halpha-justify-between">
                    <span class="halpha-text-gray-400">Reward accrual</span>
                    <span class="halpha-text-green-400">Active</span>
                </div>

                <div class="halpha-flex halpha-justify-between">
                    <span class="halpha-text-gray-400">Distribution engine</span>
                    <span class="halpha-text-green-400">Operational</span>
                </div>

                <div class="halpha-flex halpha-justify-between">
                    <span class="halpha-text-gray-400">Last cycle processed</span>
                    <span class="halpha-text-white">Apr 27, 2024 — 09:00 UTC</span>
                </div>
            </div>
        </div>

    </div>

    {{-- INFRASTRUCTURE UPDATES --}}
    <div class="halpha-card halpha-p-4 halpha-rounded-xl">
        <h3 class="halpha-text-sm halpha-font-semibold halpha-text-white halpha-mb-3">
            Infrastructure Updates
        </h3>

        <ul class="halpha-space-y-2 halpha-text-xs halpha-text-gray-400">
            <li>April 24, 2024 — Validator cluster maintenance concluded</li>
            <li>April 20, 2024 — Routine key rotation completed</li>
            <li>April 17, 2024 — Validator cluster upgrade completed</li>
        </ul>

        <a href="#" class="halpha-text-xs halpha-text-accent-2 hover:underline halpha-mt-3 inline-block">
            View public validator keys →
        </a>
    </div>

    {{-- INCIDENT HISTORY --}}
    <div class="halpha-card halpha-p-4 halpha-rounded-xl">
        <h3 class="halpha-text-sm halpha-font-semibold halpha-text-white halpha-mb-3">
            Incident History
        </h3>

        <div class="halpha-text-xs halpha-text-gray-400 halpha-space-y-1">
            <div>Incident ID: <span class="halpha-text-white">INC-2026-001</span></div>
            <div>Status: <span class="halpha-text-green-400">Resolved</span></div>
            <div>Impact: Temporary delay in reward settlement</div>
            <div>Resolved: April 27, 2024 — 09:00 UTC</div>
        </div>
    </div>

</div>
