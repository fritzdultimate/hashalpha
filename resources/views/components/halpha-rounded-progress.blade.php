@props([
    'startedAt',
    'durationDays',
    'now' => null,
    'size' => 56,
    'stroke' => 6,
    'animate' => true,
])

@php
    use Carbon\Carbon;
    $now = $now ? Carbon::parse($now) : Carbon::now();
    $started = $startedAt ? Carbon::parse($startedAt) : null;

    // If duration not provided, consider flexible -> show indeterminate
    $isFlexible = is_null($durationDays);

    // compute percent elapsed
    if ($isFlexible || !$started) {
        $pct = null; // can't compute
        $daysLeft = null;
        $expired = false;
    } else {
        $durationSeconds = $durationDays * 86400;
        $elapsed = max(0, $started->diffInSeconds($now, false));
        $pct = $durationSeconds > 0 ? min(100, round(($elapsed / $durationSeconds) * 100, 1)) : null;
        $secondsLeft = max(0, $durationSeconds - $elapsed);
        $daysLeft = floor($secondsLeft / 86400);
        $expired = ($elapsed >= $durationSeconds);
    }


    $radius = ($size - $stroke) / 2;
    $circumference = 2 * pi() * $radius;
    $dash = $pct !== null ? ($circumference * (1 - ($pct / 100))) : $circumference;
@endphp

<div
    class="halpha-rounded-progress halpha-inline-flex halpha-flex-row-reverse halpha-items-center halpha-gap-3"
    role="group"
    aria-label="Stake progress"
    data-halpha-progress-pct="{{ $pct ?? '' }}"
    data-halpha-progress-expired="{{ $expired ? '1' : '0' }}"
>
    <svg
        viewBox="0 0 {{ $size }} {{ $size }}"
        width="{{ $size }}"
        height="{{ $size }}"
        class="halpha-w-{{ $size }} halpha-h-{{ $size }}"
        aria-hidden="true"
    >
        
        <circle
            cx="{{ $size / 2 }}"
            cy="{{ $size / 2 }}"
            r="{{ $radius }}"
            stroke="rgba(148,163,184,0.08)"
            stroke-width="{{ $stroke }}"
            fill="none"
            class="halpha-rounded-progress__bg"
        />
        @if($pct !== null)
            <circle
                cx="{{ $size / 2 }}"
                cy="{{ $size / 2 }}"
                r="{{ $radius }}"
                stroke="var(--halpha-accent-2)"
                stroke-width="{{ $stroke }}"
                stroke-linecap="round"
                stroke-dasharray="{{ $circumference }}"
                stroke-dashoffset="{{ $dash }}"
                fill="none"
                transform="rotate(-90 {{ $size / 2 }} {{ $size / 2 }})"
                class="halpha-rounded-progress__bar"
                style="{{ $animate ? 'transition: stroke-dashoffset 700ms cubic-bezier(.2,.9,.25,1), stroke 300ms ease;' : '' }}"
            />
        @else
            {{-- flexible/indeterminate: show subtle spinner path --}}
            <path
                d="M {{ $size/2 + $radius }} {{ $size/2 }} A {{ $radius }} {{ $radius }} 0 1 1 {{ $size/2 - 0.01 }} {{ $size/2 }}"
                stroke="var(--halpha-accent-2)"
                stroke-width="{{ $stroke }}"
                stroke-linecap="round"
                fill="none"
                class="halpha-rounded-progress__indeterminate"
                style="animation: halpha-rot 1.2s linear infinite;"
            />
        @endif
    </svg>

    <div class="halpha-flex halpha-flex-col halpha-text-left">
        @if($pct !== null)
            <div class="halpha-text-sm halpha-font-semibold halpha-text-white halpha-leading-none">
                {{ $pct }}%
            </div>
            <div class="halpha-text-xs halpha-text-gray-400">
                @if($expired)
                    Expired
                @else
                    {{ $daysLeft }}d left
                @endif
            </div>
        @else
            <div class="halpha-text-sm halpha-font-semibold halpha-text-white halpha-leading-none">Flexible</div>
            <div class="halpha-text-xs halpha-text-gray-400">No expiry</div>
        @endif
    </div>
</div>

<style>
    @keyframes halpha-rot {
        0% { transform: rotate(0deg); transform-origin: center; stroke-opacity: 1; }
        50% { stroke-opacity: 0.6; }
        100% { transform: rotate(360deg); transform-origin: center; stroke-opacity: 1; }
    }

    .halpha-rounded-progress { min-width: 120px; }

    .halpha-rounded-progress[data-halpha-progress-expired="1"] .halpha-rounded-progress__bar {
        stroke: rgba(148,163,184,0.28) !important;
    }

    .halpha-rounded-progress:hover .halpha-rounded-progress__bar {
        filter: drop-shadow(0 6px 18px rgba(3,105,161,0.12));
    }
</style>

@script
<script>
    (function () {
        // animate on mount (for cases where server rendered dash offset is static)
        window.addEventListener('DOMContentLoaded', () => {
            console.log(document.querySelectorAll('[data-halpha-progress-pct]'))
        })
        
        document.querySelectorAll('[data-halpha-progress-pct]').forEach(el => {
        const pctAttr = el.getAttribute('data-halpha-progress-pct');
        if (!pctAttr) return;
        const pct = Number(pctAttr);
        const svgBar = el.querySelector('.halpha-rounded-progress__bar');
        if (!svgBar) return;

        // compute circumference from dasharray attr
        const dasharray = Number(svgBar.getAttribute('stroke-dasharray'));
        const targetOffset = dasharray * (1 - (pct / 100));

        // set initial offset to full then animate to target (nice slide from 0%)
        svgBar.style.strokeDashoffset = dasharray;
        // slight delay to allow CSS render
        requestAnimationFrame(() => {
            svgBar.style.transition = 'stroke-dashoffset 700ms cubic-bezier(.2,.9,.25,1)';
            svgBar.style.strokeDashoffset = String(targetOffset);
        });
        });

        // optional: live update (if you want percent to tick every X seconds)
        // To enable: call halphaRoundedProgressLive(el, startedAtISO, durationDays)
        window.halphaRoundedProgressLive = function (el, startedAtISO, durationDays, interval = 1000) {
        if (!el) return;
        const svgBar = el.querySelector('.halpha-rounded-progress__bar');
        if (!svgBar) return;

        function update() {
            const now = new Date();
            const started = new Date(startedAtISO);
            if (isNaN(started)) return;
            const durationMs = durationDays * 86400 * 1000;
            const elapsed = Math.max(0, now - started);
            let pct = null;
            if (durationMs > 0) {
            pct = Math.min(100, Math.round( (elapsed / durationMs) * 100 * 10) / 10 );
            }
            const dasharray = Number(svgBar.getAttribute('stroke-dasharray'));
            if (pct === null) {
            svgBar.style.strokeDashoffset = dasharray;
            } else {
            const targetOffset = dasharray * (1 - (pct / 100));
            svgBar.style.strokeDashoffset = String(targetOffset);
            // update label inside (if present)
            const pctLabel = el.querySelector('.halpha-text-sm.halpha-font-semibold');
            const daysLeftLabel = el.querySelector('.halpha-text-xs.halpha-text-gray-400');
            if (pctLabel) pctLabel.textContent = pct + '%';
            if (daysLeftLabel) {
                const secondsLeft = Math.max(0, durationMs - elapsed);
                const daysLeft = Math.floor(secondsLeft / (86400 * 1000));
                daysLeftLabel.textContent = (secondsLeft <= 0) ? 'Expired' : `${daysLeft}d left`;
            }
            }
        }

        update();
        const timer = setInterval(update, interval);
        return () => clearInterval(timer); // returns stop function
        };
    })();
    </script>

    <script>
        document.querySelectorAll('[data-halpha-progress-pct]').forEach(el => {
            // read data attributes from your blade props
            const started = el.getAttribute('data-started-at');
            const duration = el.getAttribute('data-duration-days');

            if (started && duration) {
            // attach the live updater; store stop function if needed
            const stop = window.halphaRoundedProgressLive(el, started, Number(duration), 1000);
            // optionally store it: el._halphaStop = stop;
            }
        });
        console.log(document.querySelectorAll('[data-halpha-progress-pct]'))
    </script>
@endscript