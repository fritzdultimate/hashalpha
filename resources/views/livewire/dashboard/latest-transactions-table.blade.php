<div x-data class="halpha-w-full">
    <x-dashboard.halpha-table 
        :columns="[
            ['key' => 'id', 'label' => 'ID', 'width' => 'w-14'],
            ['key' => 'type', 'label' => 'Type', 'width' => 'w-24'],
            ['key' => 'amount', 'label' => 'Amount', 'width' => 'w-28', 'render' => function ($row) {
            return number_format($row->amount, 2); }],
            ['key' => 'status', 'label' => 'Status', 'width' => 'w-24'],
            ['key' => 'created_at', 'label' => 'Date', 'width' => 'w-36', 'render' => function ($row) {
            return $row->created_at->diffForHumans(); }],
        ]" 
        :rows="$rows"
        rrow-actions-view="components.dashboard.row-actions"
        class="halpha-shadow-sm"
    >
        @slot('actions')
            <div class="halpha-flex halpha-items-center halpha-gap-2 !halpha-hidden">
                <a href="#" class="halpha-text-sm halpha-bg-accent-3 halpha-py-1 halpha-px-2 halpha-rounded">New</a>
            </div>
        @endslot


    </x-dashboard.halpha-table>
</div>