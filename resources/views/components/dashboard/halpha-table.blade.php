<!-- @props([
    'columns' => [],
    'rows' => null,
    'empty' => 'No records found.',
    'showPagination' => true,
    'perPageOptions' => [10, 25, 50],
    'responsiveCollapse' => true,
]) -->



<div {{ $attributes->merge(['class' => 'halpha-w-full halpha-bg-card-bg halpha-rounded halpha-border halpha-border-white/5 halpha-overflow-hidden']) }}>
    <div
        class="halpha-flex halpha-items-center halpha-justify-between halpha-gap-3 halpha-p-4 halpha-border-b halpha-border-white/5">
        <div class="halpha-flex halpha-items-center halpha-gap-3 halpha-flex-
          1         ">
            <div class="halpha-relative halpha-flex-1">
                <input x-data x-model="search" @input="$dispatch('table-search', $event.target.value)" type="search"
                    placeholder="Search..."
                    class="halpha-w-full halpha-py-2 halpha-px-3 halpha-rounded halpha-border halpha-border-white/5 halpha-bg-transparent halpha-text-sm" />
            </div>


            <div class="halpha-flex halpha-items-center halpha-gap-2">
                <select x-on:change="$dispatch('table-perpage', $event.target.value)"
                    class="halpha-text-sm halpha-py-1 halpha-px-2 halpha-rounded halpha-border halpha-border-white/5">
                    @foreach($perPageOptions as $opt)
                        <option value="{{ $opt }}">{{ $opt }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="halpha-flex halpha-items-center halpha-gap-2">
            {{-- Extra actions slot --}}
            {{ $actions ?? '' }}
        </div>
    </div>

    <!-- Table -->

    <div class="halpha-overflow-x-auto">
        <table class="halpha-w-full halpha-text-left halpha-min-w-full">
            <thead
                class="halpha-text-xs halpha-text-muted halpha-uppercase halpha-tracking-wide halpha-bg-card-bg halpha-border-b halpha-border-white/5">
                <tr>
                    @foreach($columns as $col)
                        <th class="halpha-py-3 halpha-px-4 {{ $col['width'] ?? '' }}">{{ $col['label'] }}</th>
                    @endforeach
                    @if(isset($slotColumns))
                        {{ $slotColumns }}
                    @endif
                </tr>
            </thead>


            <tbody class="halpha-text-sm">
                @if($rows && count($rows) > 0)
                    @foreach($rows as $row)
                        <tr class="halpha-border-b halpha-border-white/3 hover:halpha-bg-[#1f1f1f]">
                            @foreach($columns as $col)
                                <td class="halpha-py-3 halpha-px-4 halpha-align-top">
                                    @php
                                        $key = $col['key'];
                                    @endphp


                                    {{-- enable dot-notion for nested values e.g. user.name --}}
                                    @php
                                        $value = null;
                                        if (is_array($row)) {
                                            $value = data_get($row, $key);
                                        } else {
                                            $value = data_get($row, $key);
                                        }
                                    @endphp


                                    {{ $col['render'] ?? $value }}
                                </td>
                            @endforeach


                            {{-- extra row actions slot --}}
                            @if(isset($rowActions))
                                <td class="halpha-py-3 halpha-px-4">{{ $rowActions->with(['row' => $row]) }}</td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="halpha-py-6 halpha-px-4 halpha-text-center"
                            colspan="{{ count($columns) + (isset($rowActions) ? 1 : 0) }}">{{ $empty }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination & summary slot -->

    @if($showPagination && $rows && method_exists($rows, 'links'))
        <div
            class="halpha-flex halpha-items-center halpha-justify-between halpha-gap-3 halpha-p-4 halpha-border-t halpha-border-white/5">
            <div class="halpha-text-xs halpha-text-muted">Showing {{ $rows->firstItem() ?? 0 }} to
                {{ $rows->lastItem() ?? 0 }} of {{ $rows->total() ?? count($rows) }}</div>
            <div>{{ $rows->links() }}</div>
        </div>
    @endif
</div>