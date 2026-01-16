@props([
    'columns' => [],
    'rows' => null,
    'empty' => 'No records found.',
    'showPagination' => true,
    'perPageOptions' => [10, 25, 50],
    'responsiveCollapse' => true,
    'title' => 'Latest Transactions',
    'rowActionsView' => null
])


<section class="halpha-block halpha-space-y-5">
    <h1 class="halpha-text-xl halpha-font-semibold !halpha-text-accent">{{ $title }}</h1>

    <div {{ $attributes->merge(['class' => 'halpha-w-full halpha-bg-card-bg halpha-rounded halpha-border halpha-border-white/5 halpha-overflow-hidden']) }}>
        <div class="halpha-flex halpha-items-center halpha-justify-between halpha-gap-3 halpha-p-4 halpha-border-b halpha-border-white/5">
            <div class="halpha-flex halpha-items-center halpha-gap-3 halpha-flex-1">
                <div class="halpha-relative halpha-flex-1" x-data="{search: ''}">
                    <input x-data x-model="search" @input="$dispatch('table-search', { value: $event.target.value })" type="search"
                        placeholder="Search..."
                        class="halpha-w-full halpha-py-2 halpha-px-3 halpha-rounded halpha-border halpha-border-white/5 halpha-bg-transparent halpha-text-sm" />
                </div>


                <div class="halpha-flex halpha-items-center halpha-gap-2">
                    <select 
                        x-on:change="$dispatch('table-perpage', {value: $event.target.value})"
                        class="halpha-text-sm halpha-py-1 halpha-px-2 halpha-rounded halpha-border halpha-border-white/5 halpha-bg-transparent halpha-appearance-none no-arrow"
                    >
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



        @php
            $alignmentClasses = function ($col) {
                if ($col['key'] && $col['key'] === 'amount') {
                    return 'halpha-text-right';
                }

                return 'halpha-text-left';
            };
        @endphp
        <!-- Table -->
        <div class="halpha-overflow-x-auto halpha-scroll-hide">
            <table class="halpha-w-full halpha-text-left halpha-min-w-full">
                <thead
                    class="halpha-text-xs halpha-text-muted halpha-uppercase halpha-tracking-wide halpha-bg-card-bg-deeper halpha-border-b halpha-border-white/5">
                    <tr>
                        @foreach($columns as $col)
                            <th class="halpha-py-3 halpha-px-4 halpha-text-white {{ $alignmentClasses($col) }} {{ $col['width'] ?? '' }}">{{ $col['label'] }}</th>
                        @endforeach

                        @if ($rowActionsView)
                            <th class="halpha-py-6 halpha-px-4 halpha-text-center"></th>
                        @endif
                        
                    </tr>


                </thead>


                <tbody class="halpha-text-sm halpha-font-normal halpha-capitalize halpha-font-sans">
                    @if($rows && count($rows) > 0)
                        @foreach($rows as $row)
                            
                            <tr class="halpha-border-b halpha-border-gray-700 hover:halpha-bg-white/20">
                                @foreach($columns as $col)
                                    
                                    <td class="halpha-py-3.5 halpha-px-4 halpha-align-middle halpha-text-[#f0f0f0] {{ $alignmentClasses($col) }}">
                                        @php
                                            $key = $col['key'];
                                        @endphp


                                        {{-- enable dot-notion for nested values e.g. user.name --}}
                                        @php
                                            $value = data_get($row, $key);

                                            $callable = $col['render'] ?? '';
                                        @endphp

                                        @if ($col['key'] === 'type')
                                            <x-dashboard.status-maker :flat="true" label="{{ $value }}" className="{{ $value }}"  />
                                        @elseif ($col['key'] === 'status')
                                            <x-dashboard.status-maker label="{{  $row?->related?->status }}" className="pending"  />
                                        @else
                                            {{ is_callable(value: $callable) ? $callable($row) : $value }}
                                        @endif
                                    </td>
                                @endforeach


                                {{-- extra row actions slot --}}
                                @if($rowActionsView)
                                    <td>
                                        {!! view($rowActionsView, ['row' => $row])->render() !!}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td 
                                class="halpha-py-6 halpha-px-4 halpha-text-center"
                                colspan="{{ count($columns) + (isset($rowActions) ? 1 : 0) }}"
                            >
                                {{ $empty }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination & summary slot -->

        @if($showPagination && $rows && method_exists($rows, 'links'))
            <div
                class="halpha-flex halpha-flex-col md:halpha-flex-row halpha-items-center halpha-justify-between halpha-gap-3 halpha-p-4 halpha-border-t halpha-border-white/5 halpha-border-red-600 halpha-border">
                <div class="halpha-text-xs halpha-text-muted">Showing {{ $rows->firstItem() ?? 0 }} to
                    {{ $rows->lastItem() ?? 0 }} of {{ $rows->total() ?? count($rows) }}</div>
                <div class="halpha-text-sm halpha-pagination halpha-flex halpha-items-center halpha-gap-2 halpha-w-full">{{ $rows->links() }}</div>
            </div>
        @endif
    </div>
</section>