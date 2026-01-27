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

    @include('layouts.dashboard.settings._nav')

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
                <select wire:model.live="category" class="halpha-input">
                    <option value="general">General</option>
                    <option value="wallet">Wallet</option>
                    <option value="withdrawal">Withdrawal</option>
                    <option value="security">Security</option>
                </select>
                @error('category')
                    <div class="halpha-text-red-600 halpha-text-xs">
                        {{ $message }}
                    </div>
                @enderror
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
                @error('subject')
                    <div class="halpha-text-red-600 halpha-text-xs">
                        {{ $message }}
                    </div>
                @enderror
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
                @error('message')
                    <div class="halpha-text-red-600 halpha-text-xs">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button
                type="submit"
                class="halpha-bg-accent-2 halpha-text-white halpha-px-4 halpha-py-2 halpha-rounded halpha-text-xs"
            >
                <span wire:loading.remove="submit">Submit Ticket</span>
                <span wire:loading wire:target="confirmSubmit">Preparing...</span>
                <span wire:loading wire:target="submit">Submiting ticket...</span>
            </button>

        </form>
    </div>

    {{-- User Tickets --}}
    <div class="halpha-space-y-3 halpha-max-w-2xl">

        <h2 class="halpha-text-sm halpha-font-semibold halpha-text-white">
            Your Tickets
        </h2>

        @forelse ($tickets as $ticket)
            <div
                x-data="{ replying: false }"
                class="halpha-card halpha-p-3 halpha-space-y-3"
            >
                <div class="halpha-card halpha-p-3 halpha-flex halpha-justify-between halpha-items-center">
                    <div>
                        <p class="halpha-text-xs halpha-text-gray-400">
                            {{ $ticket->ticket_number }}
                        </p>
                        <p class="halpha-text-sm halpha-text-white">
                            {{ $ticket->subject }}
                        </p>
                        <p class="halpha-text-xs halpha-text-gray-500">
                            {{ $ticket->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <span class="
                        halpha-text-xs halpha-px-2 halpha-py-1 halpha-rounded
                        @if($ticket->status === 'open') halpha-bg-yellow-500/10 halpha-text-yellow-500 @endif
                        @if($ticket->status === 'in_progress') halpha-bg-blue-500/10 halpha-text-blue-500 @endif
                        @if($ticket->status === 'resolved') halpha-bg-green-500/10 halpha-text-green-500 @endif
                        @if($ticket->status === 'closed') halpha-bg-gray-500/10 halpha-text-gray-400 @endif
                    ">
                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                </div>

                @foreach ($ticket->messages as $msg)
                    <div class="halpha-flex {{ $msg->is_staff ? 'halpha-justify-start' : 'halpha-justify-end' }}">
                        <div class="halpha-max-w-md halpha-px-3 halpha-py-2 halpha-rounded
                            {{ $msg->is_staff
                                ? 'halpha-bg-gray-800 halpha-text-white'
                                : 'halpha-bg-accent-2 halpha-text-white' }}">
                            
                            <p class="halpha-text-xs halpha-opacity-70">
                                {{ $msg->is_staff ? 'Support' : 'You' }}
                            </p>

                            <p class="halpha-text-sm">
                                {{ $msg->message }}
                            </p>

                            <p class="halpha-text-[10px] halpha-opacity-50 mt-1">
                                {{ $msg->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @endforeach

                <button
                    type="button"
                    @click="replying = true"
                    x-show="!replying"
                    class="halpha-text-xs halpha-text-accent-2 hover:underline"
                >
                    Reply
                </button>

                <form
                    x-show="replying"
                    x-transition
                    wire:submit.prevent="reply({{ $ticket->id }})"
                    class="halpha-space-y-2"
                >
                    <textarea
                        wire:model.defer="replyMessage"
                        class="halpha-input"
                        rows="3"
                        placeholder="Type your reply..."
                        required
                    ></textarea>

                    <div class="halpha-flex halpha-gap-3">
                        <button 
                            type="submit" 
                            class="halpha-bg-accent-2 halpha-text-white halpha-py-2 halpha-rounded halpha-text-xs halpha-px-6"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove wire:target="reply">Reply</span>
                            <span wire:loading wire:target="reply">Repling...</span>
                        </button>

                        <button
                            type="button"
                            @click="replying = false"
                            class="halpha-text-sm halpha-text-gray-400"
                        >
                            Cancel
                        </button>
                    </div>
                </form>

            </div>
        @empty
            <p class="halpha-text-xs halpha-text-gray-400">
                You have not created any support tickets yet.
            </p>
        @endforelse
    </div>


    {{-- Confirmation Modal --}}
    <x-confirmation-modal
        event="confirm-support-submit"
        wireConfirm="submit"
        title="Submit Support Ticket"
        message="Are you sure you want to send this message to support?"
    />

</div>
