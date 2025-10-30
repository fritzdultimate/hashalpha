@extends('layouts.auth')
@section('title','Forgot Password')

@section('content')
<div class="halpha-flex halpha-flex-col halpha-items-center halpha-gap-4">
  <h1 class="halpha-text-2xl halpha-font-semibold">Forgot password</h1>
  <p class="halpha-text-sm halpha-text-gray-400">Enter your account email to get a reset link.</p>

  <form method="POST" action="{{ route('password.email') }}" class="halpha-w-full halpha-mt-4">
    @csrf
    <div class="halpha-space-y-4">
      <input name="email" type="email" required placeholder="you@example.com" class="halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded-xl halpha-border halpha-border-gray-700 halpha-bg-transparent focus:halpha-ring-0" />
      <button class="halpha-w-full halpha-py-3 halpha-rounded-xl halpha-bg-blue-600">Send reset link</button>
    </div>
  </form>
</div>
@endsection
