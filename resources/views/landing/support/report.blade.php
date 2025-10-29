@extends('layouts.guest')
@section('title', 'Report an Issue')

@section('content')
    <div class="halpha-max-w-3xl halpha-mx-auto halpha-px-6 halpha-py-12">
        <div class="halpha-bg-[#0b0b0d] halpha-rounded-2xl halpha-p-6 halpha-border halpha-border-gray-800">
            <h2 class="halpha-text-2xl halpha-font-semibold">Report an Issue</h2>
            <p class="halpha-text-sm halpha-text-gray-400 halpha-mt-2">
                Found a bug? Provide steps and screenshots to help us
                reproduce it.
            </p>

            <form action="{{ route('support.report.submit') }}" method="post" class="halpha-mt-6"
                enctype="multipart/form-data">
                @csrf
                <div class="halpha-grid halpha-gap-4">
                    <input name="title" placeholder="Short title" value="{{ old('title') }}"
                        class="halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded halpha-bg-[#070708] halpha-border !halpha-border-gray-700 halpha-text-gray-300 focus:halpha-outline-none focus:halpha-ring-0" />
                    <input name="url" placeholder="Page URL (optional)" value="{{ old('url') }}"
                        class="halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded halpha-bg-[#070708] halpha-border !halpha-border-gray-700 halpha-text-gray-300 focus:halpha-outline-none focus:halpha-ring-0" />
                    <select name="severity"
                        class="halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded halpha-bg-[#070708] halpha-border !halpha-border-gray-700 halpha-text-gray-300 focus:halpha-outline-none focus:halpha-ring-0">
                        <option value="low">Low</option>
                        <option value="normal" selected>Normal</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
                    <textarea name="description" placeholder="Steps to reproduce, expected behaviour, actual behaviour..."
                        rows="6"
                        class="halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded halpha-bg-[#070708] halpha-border !halpha-border-gray-700 halpha-text-gray-300 focus:halpha-outline-none focus:halpha-ring-0">{{ old('description') }}</textarea>

                    <div>
                        <label class="halpha-text-xs halpha-text-gray-400">Attach screenshot / logs (optional)</label>
                        <input type="file" name="attachment" class="halpha-mt-2" />
                    </div>

                    <div>
                        <button class="halpha-bg-yellow-500 halpha-text-black halpha-px-4 halpha-py-2 halpha-rounded">Submit
                            Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection