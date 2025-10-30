@extends('layouts.auth')
@section('title','Recovery Codes')

@section('content')
<div class="halpha-flex halpha-flex-col halpha-items-center halpha-gap-4">
  <h1 class="halpha-text-2xl halpha-font-semibold">Recovery codes</h1>
  <p class="halpha-text-sm halpha-text-gray-400">Save these codes somewhere safe. Each code can be used once to access your account if you lose your 2FA device.</p>

  <div class="halpha-mt-4 halpha-w-full halpha-grid halpha-grid-cols-2 halpha-gap-2">
    @foreach($codes as $c)
      <div class="halpha-bg-[#070708] halpha-border halpha-border-gray-800 halpha-rounded-xl halpha-p-3 halpha-text-center halpha-text-xs halpha-font-mono">{{ $c }}</div>
    @endforeach
  </div>

  <div class="halpha-w-full halpha-mt-4">
    <a href="{{ url('/') }}" class="halpha-w-full halpha-block halpha-text-center halpha-py-3 halpha-rounded-xl halpha-bg-blue-600">Done</a>
  </div>
</div>
@endsection
