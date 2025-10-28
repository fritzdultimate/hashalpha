@extends('layouts.guest')

@section('content')
<section class="halpha-py-8">
    <div class="container-default w-container">
        <div class="inner-container _1000px _100-tablet">
            <h1 class="display-2 heading-color-gradient">Validator Explorer</h1>
            <p class="!halpha-text-gray-400">Search and inspect validators we operate. Public keys are shown in masked format; follow on-chain links for full public key details.</p>
        </div>

        <div x-data="validatorExplorer()" x-init="init()" class="halpha-mt-6">
            <!-- Controls -->
            <div class="halpha-flex halpha-flex-col sm:halpha-flex-row halpha-gap-3 halpha-items-center">
                <input x-model="q" @input.debounce.300="load(1)" placeholder="Search by index, key or status" class="halpha-input halpha-w-full sm:halpha-w-2/3">
                <select x-model="status" @change="load(1)" class="halpha-input">
                    <option value="">All status</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="slashed">Slashed</option>
                </select>
                <button @click="load(1)" class="btn-primary w-button">Search</button>
            </div>

            <!-- List -->
            <div class="halpha-overflow-x-auto halpha-mt-6">
                <table class="halpha-w-full halpha-text-sm halpha-text-gray-300">
                    <thead class="halpha-text-left halpha-text-gray-400">
                        <tr>
                        <th class="halpha-p-3">Index</th>
                        <th class="halpha-p-3">Public Key</th>
                        <th class="halpha-p-3">Balance</th>
                        <th class="halpha-p-3">Effective</th>
                        <th class="halpha-p-3">Missed</th>
                        <th class="halpha-p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="val in validators" :key="val.index">
                        <tr class="halpha-border-t halpha-border-[#111316] hover:halpha-bg-[#07121a]/30 halpha-cursor-pointer" @click="openDetail(val)">
                            <td class="halpha-p-3" x-text="val.index"></td>
                            <td class="halpha-p-3"><code x-text="maskKey(val.pubkey)"></code></td>
                            <td class="halpha-p-3" x-text="val.balance + ' ETH'"></td>
                            <td class="halpha-p-3" x-text="val.effective + ' ETH'"></td>
                            <td class="halpha-p-3" x-text="val.missed"></td>
                            <td class="halpha-p-3"><span :class="statusBadge(val.status)" x-text="val.status"></span></td>
                        </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="halpha-flex halpha-justify-between halpha-items-center halpha-mt-4">
                <div class="halpha-text-sm halpha-text-gray-400">
                    Showing <span x-text="meta.from"></span> - <span x-text="meta.to"></span> of <span x-text="meta.total"></span>
                </div>
                <div>
                    <button @click="load(page-1)" :disabled="page===1" class="btn-secondary w-button">Prev</button>
                    <button @click="load(page+1)" :disabled="page>=meta.last_page" class="btn-primary w-button">Next</button>
                </div>
            </div>

            <!-- Detail modal -->
            <div x-show="detail" x-cloak class="halpha-fixed halpha-inset-0 halpha-bg-black/60 halpha-flex halpha-justify-center halpha-items-center halpha-p-4">
                <div class="halpha-bg-[#07121a] halpha-rounded-[12px] halpha-max-w-3xl halpha-w-full halpha-p-6 halpha-relative">
                    <button @click="detail=null" class="halpha-absolute halpha-top-3 halpha-right-3 halpha-text-gray-300">✕</button>
                    <h3 class="halpha-text-xl halpha-text-white">Validator <span x-text="detail.index"></span></h3>
                    <p class="halpha-text-sm halpha-text-gray-300">Key: <code x-text="detail.pubkey"></code></p>

                    <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-4 halpha-mt-4">
                        <div>
                            <div class="halpha-text-sm halpha-text-gray-300">Balance</div>
                            <div class="halpha-text-lg halpha-text-white" x-text="detail.balance + ' ETH'"></div>
                        </div>
                        <div>
                            <div class="halpha-text-sm halpha-text-gray-300">Missed attestations</div>
                            <div class="halpha-text-lg halpha-text-white" x-text="detail.missed"></div>
                        </div>
                    </div>

                    <div class="halpha-mt-4">
                        <a :href="detail.onchainUrl" target="_blank" class="btn-secondary w-button">View on Beacon Explorer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
  function validatorExplorer() {
        return {
            q: '',
            status: '',
            page: 1,
            meta: {from:0,to:0,total:0,last_page:1},
            validators: [],
            detail: null,
            init() { this.load(1) },
            async load(page = 1) {
                this.page = page;
                // Replace with your API endpoint:
                // e.g. /api/transparency/validators?q=...&status=...&page=...
                const res = await fetch(`/api/transparency/validators?q=${encodeURIComponent(this.q)}&status=${this.status}&page=${page}`);
                if (!res.ok) { console.error('fetch failed'); return; }
                const data = await res.json();
                // expected structure: {data: [...], meta: {from,to,total,last_page}}
                this.validators = data.data;
                this.meta = data.meta;
            },
            maskKey(pk) {
                if (!pk) return '';
                return pk.slice(0,8) + '…' + pk.slice(-6);
            },
            openDetail(val) {
                // fetch detail if needed from API or use object
                this.detail = {
                    ...val,
                    onchainUrl: `https://beaconcha.in/validator/${val.index}`
                };
            },
            statusBadge(s) {
                return s === 'active' ? 'halpha-text-green-300' : (s === 'slashed' ? 'halpha-text-red-400' : 'halpha-text-yellow-300');
            }
        }
  }
</script>
@endsection
