<div class="halpha-space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
            Support
        </h1>
        <p class="halpha-text-xs halpha-text-gray-400">
            Get help from our support team
        </p>
    </div>

    {{-- Info cards --}}
    <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-3 halpha-gap-3">
        <div class="halpha-card halpha-p-3">
            <p class="halpha-text-xs halpha-text-gray-400">Response Time</p>
            <p class="halpha-text-sm halpha-text-white">Within 24 hours</p>
        </div>
        <div class="halpha-card halpha-p-3">
            <p class="halpha-text-xs halpha-text-gray-400">Ticket Status</p>
            <p class="halpha-text-sm halpha-text-success">Tracked</p>
        </div>
        <div class="halpha-card halpha-p-3">
            <p class="halpha-text-xs halpha-text-gray-400">Security</p>
            <p class="halpha-text-sm halpha-text-white">Encrypted Messages</p>
        </div>
    </div>

    {{-- Support Form --}}
    <div class="halpha-card halpha-p-4 halpha-max-w-xl">
        <form wire:submit.prevent="confirmSubmit" class="halpha-space-y-4">

            <div>
                <label class="halpha-text-xs halpha-text-gray-400">
                    Category
                </label>
                <select wire:model="category" class="halpha-input">
                    <option value="general">General</option>
                    <option value="wallet">Wallet</option>
                    <option value="withdrawal">Withdrawal</option>
                    <option value="security">Security</option>
                </select>
            </div>

            <div>
                <label class="halpha-text-xs halpha-text-gray-400">
                    Subject
                </label>
                <input
                    type="text"
                    wire:model.defer="subject"
                    class="halpha-input"
                    placeholder="Brief summary of your issue"
                />
            </div>

            <div>
                <label class="halpha-text-xs halpha-text-gray-400">
                    Message
                </label>
                <textarea
                    wire:model.defer="message"
                    rows="4"
                    class="halpha-input"
                    placeholder="Describe the issue in detail"
                ></textarea>
            </div>

            <button
                type="submit"
                class="halpha-bg-accent-2 halpha-text-white halpha-px-4 halpha-py-2 halpha-rounded halpha-text-xs"
            >
                Submit Ticket
            </button>

        </form>
    </div>

    {{-- Confirmation Modal --}}
    <x-confirmation-modal
        event="confirm-support-submit"
        wireConfirm="submit"
        title="Submit Support Ticket"
        message="Are you sure you want to send this message to support?"
    />

</div>
