<div class="halpha-space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="halpha-text-xl md:halpha-text-3xl halpha-font-semibold halpha-text-white">
            Validator Network
        </h1>
        <p class="halpha-text-xs md:halpha-text-sm halpha-text-gray-400">
            Active validators participating in the HashAlpha infrastructure
        </p>
    </div>

    {{-- SUMMARY --}}
    <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-3 halpha-gap-4">
        <div class="halpha-card halpha-p-4 halpha-rounded-xl">
            <div class="halpha-text-xs halpha-text-gray-400">Total Validators</div>
            <div class="halpha-text-xl halpha-font-semibold halpha-text-white">145</div>
        </div>

        <div class="halpha-card halpha-p-4 halpha-rounded-xl">
            <div class="halpha-text-xs halpha-text-gray-400">Active</div>
            <div class="halpha-text-xl halpha-font-semibold halpha-text-green-400">142</div>
        </div>

        <div class="halpha-card halpha-p-4 halpha-rounded-xl">
            <div class="halpha-text-xs halpha-text-gray-400">In Maintenance</div>
            <div class="halpha-text-xl halpha-font-semibold halpha-text-yellow-400">3</div>
        </div>
    </div>

    {{-- VALIDATOR TABLE --}}
    <div class="halpha-card halpha-rounded-xl">

        <h3 class="halpha-text-sm halpha-font-semibold halpha-text-gray-400 halpha-bg-card-soft halpha-p-4 halpha-uppercase">
            Validators
        </h3>

        <div class="halpha-overflow-x-auto">
            <table class="halpha-w-full halpha-text-xs">
                <thead class="halpha-bg-card-soft halpha-text-gray-400">
                    <tr>
                        <th class="halpha-text-left halpha-p-3">Validator</th>
                        <th class="halpha-text-left halpha-p-3">Status</th>
                        <th class="halpha-text-left halpha-p-3">Uptime</th>
                        <th class="halpha-text-left halpha-p-3">Region</th>
                        <th class="halpha-text-left halpha-p-3">Risk</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-800">
                    @foreach(range(1,5) as $i)
                        <tr class="hover:halpha-bg-card-soft halpha-cursor-pointer">
                            <td class="halpha-p-3 halpha-text-white">
                                Validator #{{ $i }}
                            </td>
                            <td class="halpha-p-3 halpha-text-green-400">
                                Active
                            </td>
                            <td class="halpha-p-3 halpha-text-white">
                                99.8%
                            </td>
                            <td class="halpha-p-3 halpha-text-gray-400">
                                EU
                            </td>
                            <td class="halpha-p-3 halpha-text-green-400">
                                Low
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>
