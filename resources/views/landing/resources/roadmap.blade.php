@extends('layouts.guest')

@section('title', 'Roadmap')

@section('content')
    <div class="halpha-px-6 halpha-py-12 halpha-bg-[#070707] halpha-text-white">
        <div class="halpha-max-w-6xl halpha-mx-auto" x-data="{ phase: 'all' }">
            <div class="halpha-flex halpha-items-center halpha-justify-between halpha-mb-6">
                <div>
                    <h1 class="halpha-text-3xl halpha-font-semibold">Product Roadmap</h1>
                    <p class="halpha-text-gray-300 halpha-mt-2">
                        Planned features, delivery windows and progress highlights —
                        transparent and trackable.
                    </p>
                </div>
                <div>
                    <a href="{{ route('resources.index') }}" class="halpha-text-sm halpha-opacity-80">Back to resources</a>
                </div>
            </div>

            <div class="halpha-mb-6">
                <div class="halpha-flex halpha-gap-2">
                    <button @click="phase='all'" :class="phase=='all' ? '!halpha-bg-blue-600 !halpha-text-white' : 'halpha-bg-transparent halpha-text-gray-300'"
                        class="halpha-px-3 halpha-py-2 halpha-rounded">All</button>
                    <button @click="phase='completed'"
                        :class="phase=='completed' ? 'halpha-bg-green-600 halpha-text-white' : 'halpha-bg-transparent halpha-text-gray-300'"
                        class="halpha-px-3 halpha-py-2 halpha-rounded">Completed</button>
                    <button @click="phase='in-progress'"
                        :class="phase=='in-progress' ? 'halpha-bg-yellow-600 halpha-text-black' : 'halpha-bg-transparent halpha-text-gray-300'"
                        class="halpha-px-3 halpha-py-2 halpha-rounded">In Progress</button>
                    <button @click="phase='upcoming'"
                        :class="phase=='upcoming' ? 'halpha-bg-gray-600 halpha-text-white' : 'halpha-bg-transparent halpha-text-gray-300'"
                        class="halpha-px-3 halpha-py-2 halpha-rounded">Upcoming</button>
                </div>
            </div>

            {{-- roadmap --}}
            <div class="halpha-relative halpha-pt-8">
                <div class="halpha-absolute halpha-left-16 halpha-top-0 halpha-h-full halpha-w-px halpha-bg-gray-800"></div>

                <div class="halpha-space-y-8">
                    @foreach($milestones as $m)
                        <span x-text="agbe"></span>
                        <div x-show="phase == 'all' || phase == '{{ $m['status'] }}'" x-cloak class="halpha-flex halpha-gap-6">
                            <div
                                class="halpha-w-32 halpha-text-sm halpha-text-gray-400 halpha-flex halpha-flex-col halpha-items-end halpha-pr-4">
                                <div class="halpha-font-medium">{{ $m['date'] }}</div>
                                <div class="halpha-text-xs halpha-mt-1">{{ $m['phase'] }}</div>
                            </div>

                            <div
                                class="halpha-relative halpha-flex-1 halpha-bg-[#0b0b0d] halpha-rounded-2xl halpha-p-5 halpha-border halpha-border-gray-800 halpha-shadow">
                                {{-- status badge --}}
                                <div class="halpha-absolute halpha-left-[-1rem] halpha-top-6">
                                    <div class="halpha-w-6 halpha-h-6 halpha-rounded-full {{ $m['status'] === 'completed' ? 'halpha-bg-green-500' : ($m['status'] === 'in-progress' ? 'halpha-bg-yellow-400' : 'halpha-bg-gray-600') }} halpha-border halpha-border-gray-800"></div>
                                </div>

                                <div class="halpha-flex halpha-justify-between halpha-items-start">
                                    <div>
                                        <h3 class="halpha-text-lg halpha-font-semibold">{{ $m['title'] }}</h3>
                                        <p class="halpha-text-sm halpha-text-gray-300 halpha-mt-2">{{ $m['summary'] }}</p>

                                        <ul class="halpha-mt-3 halpha-text-sm halpha-text-gray-300 halpha-space-y-1">
                                            @foreach($m['details'] as $d)
                                                <li>• {{ $d }}</li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <div class="halpha-text-right halpha-text-xs halpha-text-gray-400">
                                        <div class="halpha-font-medium">{{ ucfirst($m['status']) }}</div>
                                    </div>
                                </div>

                                
                                <div class="halpha-mt-4">
                                    <button
                                        @click="alert('Open issue tracker or roadmap ticket for: {{ addslashes($m['title']) }}')"
                                        class="halpha-text-xs halpha-px-3 halpha-py-2 halpha-border halpha-rounded">Open
                                        ticket</button>
                                    <!-- <a href="#" class="halpha-ml-2 halpha-text-xs halpha-opacity-80">View details</a> -->
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div
                class="halpha-mt-10 halpha-bg-[#0b0b0d] halpha-rounded-xl halpha-p-5 halpha-flex halpha-items-center halpha-justify-between">
                <div>
                    <h4 class="halpha-font-semibold">Roadmap Progress</h4>
                    <p class="halpha-text-sm halpha-text-gray-400 halpha-mt-1">
                        Overview of completed vs upcoming
                        initiatives.
                    </p>
                </div>

                <div class="halpha-w-1/2">
                    <div class="halpha-h-3 halpha-bg-gray-800 halpha-rounded-full">
                        <div class="halpha-h-full halpha-rounded-full halpha-bg-green-500" style="width:35%"></div>
                    </div>
                    <div class="halpha-text-xs halpha-text-gray-400 halpha-mt-2">35% complete</div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>