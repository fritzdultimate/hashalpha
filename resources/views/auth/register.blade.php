@extends('layouts.auth')
@section('title','Register')

@section('content')
<div class="halpha-flex halpha-flex-col halpha-items-center halpha-gap-4 halpha-pt-2">
  <div class="halpha-rounded-full halpha-w-16 halpha-h-16 halpha-flex halpha-items-center halpha-justify-center halpha-bg-white halpha-bg-opacity-5">
    <svg class="halpha-w-7 halpha-h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v4m0 8v4M4 12h16"/></svg>
  </div>

  <h1 class="halpha-text-2xl halpha-font-semibold">Create account</h1>
  <p class="halpha-text-sm halpha-text-gray-400">Create your secure account — quick and free.</p>

  <form method="POST" action="{{ route('register.attempt') }}" class="halpha-w-full halpha-mt-2">
    @csrf
    <div class="halpha-space-y-4">
      <div>
        <label class="halpha-text-xs halpha-text-gray-400">Full name</label>
        <input name="name" required value="{{ old('name') }}" class="halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded-xl halpha-border halpha-border-gray-700 halpha-bg-transparent focus:halpha-ring-0" />
        @error('name') <div class="halpha-text-xs halpha-text-red-400">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="halpha-text-xs halpha-text-gray-400">Email</label>
        <input name="email" type="email" required value="{{ old('email') }}" class="halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded-xl halpha-border halpha-border-gray-700 halpha-bg-transparent focus:halpha-ring-0" />
        @error('email') <div class="halpha-text-xs halpha-text-red-400">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="halpha-text-xs halpha-text-gray-400">Password</label>
        <input name="password" type="password" required class="halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded-xl halpha-border halpha-border-gray-700 halpha-bg-transparent focus:halpha-ring-0" />
        @error('password') <div class="halpha-text-xs halpha-text-red-400">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="halpha-text-xs halpha-text-gray-400">Confirm password</label>
        <input name="password_confirmation" type="password" required class="halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded-xl halpha-border halpha-border-gray-700 halpha-bg-transparent focus:halpha-ring-0" />
      </div>

      <div class="halpha-flex halpha-items-center halpha-gap-2">
        <input id="terms" name="terms" type="checkbox" class="halpha-form-checkbox" />
        <label for="terms" class="halpha-text-sm halpha-text-gray-300">I agree to the <a href="#" class="halpha-underline">terms</a></label>
      </div>

      <div>
        <button class="halpha-w-full halpha-py-3 halpha-rounded-xl halpha-bg-gradient-to-r halpha-from-blue-600 halpha-to-purple-600 halpha-font-semibold">Create account</button>
      </div>

      <div class="halpha-text-center halpha-text-sm halpha-text-gray-400">
        <span>Already have an account?</span>
        <a href="{{ route('login') }}" class="halpha-text-white halpha-underline">Sign in</a>
      </div>
    </div>
  </form>
</div>
@endsection
