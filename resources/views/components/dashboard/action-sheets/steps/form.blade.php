<form wire:submit.prevent="createInvoice" class="halpha-space-y-3">
    <div 
        x-data="currencySelector({
            initial: { currency: @js($selectedCurrency ?? 'btc'), label: @js($selectedLabel ?? 'Bitcoin'), icon: @js($selectedIcon ?? 'icon-btc'), bg: @js($selectedBg ?? 'halpha-bg-btc') },
            items: @js($wallets)
        })"
        class="halpha-w-full"
    >
        <label class="halpha-text-xs halpha-text-gray-300 halpha-block halpha-mb-1">Currency</label>

        <div
            role="combobox"
            aria-haspopup="listbox"
            :aria-expanded="open ? 'true' : 'false'"
            @keydown.prevent.stop="handleKey($event)"
            class="halpha-relative"
        >
            <button
                type="button"
                @click="toggle()"
                @keydown.enter.stop.prevent="toggle()"
                class="halpha-w-full halpha-flex halpha-items-center halpha-justify-between halpha-gap-3 halpha-px-3 halpha-py-2 halpha-rounded-lg halpha-bg-gray-700 halpha-text-white halpha-border halpha-border-transparent halpha-shadow-sm focus:halpha-outline-none focus:halpha-ring-1 focus:halpha-ring-accent-2"
            >
                <div class="halpha-flex halpha-items-center halpha-gap-3 halpha-flex-1 halpha-text-left">
                    <!-- left icon circle -->
                    <span class="halpha-w-5 halpha-h-5 halpha-rounded-full halpha-flex halpha-items-center halpha-justify-center" :class="selected?.bg">
                        <span class="icon halpha-text-xs" :class="selected?.icon" aria-hidden="true"></span>
                    </span>

                    <!-- currency symbol + label -->
                    <div class="halpha-flex halpha-flex-col halpha-items-start">
                        <span class="halpha-font-semibold halpha-text-white halpha-text-base halpha-uppercase" x-text="selected?.currency"></span>
                    </div>
                </div>

                <!-- right padded arrow box -->
                <span
                    class="halpha-ml-3 halpha-flex halpha-items-center halpha-justify-center halpha-px-2 halpha-py-2 halpha-rounded halpha-bg-gray-600 halpha-text-gray-200 halpha-cursor-pointer"
                    @click.stop="toggle()"
                    aria-hidden="true"
                >
                    <x-heroicon-o-chevron-down class="halpha-w-5 halpha-h-5" />
                </span>
            </button>

            @error('currency')
                <div class="halpha-text-red-500 halpha-text-xs halpha-mt-1">{{ $message }}</div>
            @enderror

            <!-- Hidden inputs bound to form -->
            <input type="hidden" name="currency" x-model="selected.currency">
            <input type="hidden" name="label" x-model="selected.label">
            <!-- Dropdown -->
            <ul
                x-show="open"
                x-transition.opacity
                x-transition.origin.top
                @click.outside="close()"
                @keydown.arrow-down.prevent="focusNext()"
                @keydown.arrow-up.prevent="focusPrev()"
                class="halpha-absolute halpha-left-0 halpha-right-0 halpha-mt-2 halpha-bg-gray-800 halpha-rounded halpha-shadow-lg halpha-max-h-60 halpha-overflow-auto halpha-z-50 halpha-border halpha-border-accent-3"
                role="listbox"
                tabindex="-1"
                style="display: none;"
            >
                <template x-for="(item, idx) in items" :key="item.currency">
                    <li
                        :id="`option-${item.currency}`"
                        @click="$dispatch('wallet-selected', item); close()"
                        @mouseenter="activeIndex = idx"
                        @mouseleave="activeIndex = -1"
                        :class="[
                            'halpha-flex halpha-items-center halpha-gap-3 halpha-p-2 halpha-cursor-pointer halpha-transition',
                            activeIndex === idx ? 'halpha-bg-gray-700' : 'halpha-bg-transparent'
                        ]"
                        role="option"
                        :aria-selected="selected?.currency === item.currency ? 'true' : 'false'"
                    >
                        <span class="halpha-w-8 halpha-h-8 halpha-rounded-full halpha-flex halpha-items-center halpha-justify-center" :class="item.bg">
                            <span class="icon" :class="item.icon" aria-hidden="true"></span>
                        </span>

                        <div class="halpha-flex-1">
                            <div class="halpha-flex halpha-items-baseline halpha-justify-between">
                                <span class="halpha-font-semibold halpha-text-white halpha-text-sm" x-text="item.currency.toUpperCase()"></span>
                            </div>
                            <div class="halpha-text-xs halpha-text-gray-400 halpha-mt-0.5" x-text="item.label"></div>
                        </div>
                    </li>
                </template>

                <li x-show="items.length === 0" class="halpha-p-3 halpha-text-sm halpha-text-gray-400">No currencies</li>
            </ul>

        </div>
    </div>

    <div>
        <label for="network" class="halpha-text-xs halpha-text-gray-300">Choose Network</label>
        <select id="network" wire:model="network"
            class="halpha-w-full halpha-mt-1 halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-gray-700 halpha-text-white">
            <template x-for="n in networks" :key="n">
                <option 
                    x-text="n" 
                    :value="n" 
                    selected>
                </option>
            </template>
        </select>
    </div>

    <div>
        <label for="amount" class="halpha-text-xs halpha-text-gray-300">Amount</label>
    
        <div class="halpha-relative halpha-flex halpha-items-center">
            <!-- Prefix Icon -->
            <span class="halpha-absolute halpha-left-3 halpha-text-gray-400 halpha-pointer-events-none">
                $
            </span>

            <input 
                id="amount"
                type="text"
                x-on:input="
                    $el.value = $el.value.replace(/[^0-9.]/g, '')
                "
                wire:model.defer="amount"
                class="halpha-w-full halpha-pl-8 halpha-pr-3 halpha-py-2 halpha-border halpha-border-gray-600 halpha-bg-gray-700 halpha-rounded-lg halpha-text-white focus:halpha-outline-none focus:halpha-border-none focus:halpha-ring-0"
                placeholder="Enter amount"
                autocomplete="off"
                inputmode="numeric"
                pattern="[0-9]*"
            >
        </div>

        @error('amount')
            <div class="halpha-text-red-500 halpha-text-xs halpha-mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="note" class="halpha-text-xs halpha-text-gray-300">Note (Optional)</label>

        <div class="halpha-relative halpha-flex halpha-items-center">
            <!-- Prefix Icon -->
            <span class="halpha-absolute halpha-left-3 halpha-text-gray-400 halpha-pointer-events-none">
                <x-heroicon-o-pencil class="halpha-w-4 halpha-h-4" />
            </span>

            <input 
                id="note"
                type="text"
                class="halpha-w-full halpha-pl-8 halpha-pr-3 halpha-py-2 halpha-border halpha-border-gray-600 halpha-bg-gray-700 halpha-rounded-lg halpha-text-white focus:halpha-outline-none focus:halpha-border-none focus:halpha-ring-0"
                placeholder="Enter short note"
                autocomplete="off"
                wire:model="note"
            >
        </div>

        @error('general')
            <div class="halpha-text-red-500 halpha-text-xs halpha-mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="halpha-flex halpha-flex-col halpha-items-center halpha-justify-between halpha-gap-3 halpha-mt-10">
        <button 
            type="submit" 
            class="halpha-flex-1 halpha-py-2.5 halpha-rounded-xl halpha-bg-accent-3 halpha-text-white halpha-font-medium halpha-w-full">
                <span wire:loading.remove wire:target="createInvoice">Continue</span>
                <x-ri-loader-4-fill wire:loading wire:target="createInvoice" class="halpha-w-5 halpha-h-5 halpha-animate-spin" />
        </button>

        <button type="button" @click="closePanel()" class="halpha-px-4 halpha-py-2 halpha-rounded-xl halpha-border halpha-border-gray-600 halpha-text-gray-300 halpha-w-full">Cancel</button>
    </div>

    <div x-show="error" class="halpha-text-sm halpha-text-red-400" x-text="error"></div>
</form>