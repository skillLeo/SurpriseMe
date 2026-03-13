{{-- resources/views/form.blade.php --}}
@extends('layouts.app')
@section('title', 'Enter Details — SurpriseMe')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center px-4 py-16">
    <div class="w-full max-w-lg">

        {{-- Step dots --}}
        <div class="flex justify-center gap-3 mb-10">
            @foreach([1,2,3,4] as $step)
            <div class="flex items-center gap-3">
                <div class="step-dot w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold
                    {{ $step === 2 ? 'active' : ($step < 2 ? 'done' : '') }}">
                    @if($step < 2)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        {{ $step }}
                    @endif
                </div>
                @if($step < 4)
                    <div class="w-8 h-px {{ $step < 2 ? 'bg-pink-400/40' : 'bg-gray-200' }}"></div>
                @endif
            </div>
            @endforeach
        </div>

        <div class="text-center mb-8 fade-in-up">
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#1C1830] mb-2">Who's the Duo? 👯</h2>
            <p class="text-gray-500 text-sm">Enter your details and your best friend's — we'll handle the rest.</p>
        </div>

        @if($errors->any())
        <div class="rounded-xl p-4 mb-6 border border-red-200 bg-red-50">
            @foreach($errors->all() as $error)
            <p class="text-red-500 text-sm">• {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('form.store') }}" class="space-y-6 fade-in-up delay-1">
            @csrf

            {{-- Your info --}}
            <div class="glass-strong rounded-2xl p-6">
                <div class="flex items-center gap-2 mb-5">
                    <span class="text-xl">👤</span>
                    <h3 class="text-[#1C1830] font-bold text-lg">Your Info</h3>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="text-gray-500 text-sm font-medium block mb-1.5">Your Name</label>
                        <input
                            type="text"
                            name="user_name"
                            value="{{ old('user_name') }}"
                            placeholder="e.g. Alex Johnson"
                            class="input-field w-full rounded-xl px-4 py-3 text-sm"
                            required
                        >
                    </div>
                    <div>
                        <label class="text-gray-500 text-sm font-medium block mb-1.5">Your Phone Number</label>
                        <input
                            type="tel"
                            name="user_phone"
                            value="{{ old('user_phone') }}"
                            placeholder="e.g. +92 300 000 0000"
                            class="input-field w-full rounded-xl px-4 py-3 text-sm"
                            required
                        >
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="flex items-center gap-4">
                <div class="flex-1 h-px bg-gray-200"></div>
                <div class="rounded-full px-3 py-1 text-xs font-semibold text-pink-600 bg-pink-50 border border-pink-200">
                    + FRIEND
                </div>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            {{-- Friend's info --}}
            <div class="glass-strong rounded-2xl p-6">
                <div class="flex items-center gap-2 mb-5">
                    <span class="text-xl">🫂</span>
                    <h3 class="text-[#1C1830] font-bold text-lg">Friend's Info</h3>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="text-gray-500 text-sm font-medium block mb-1.5">Friend's Name</label>
                        <input
                            type="text"
                            name="friend_name"
                            value="{{ old('friend_name') }}"
                            placeholder="e.g. Jordan Smith"
                            class="input-field w-full rounded-xl px-4 py-3 text-sm"
                            required
                        >
                    </div>
                    <div>
                        <label class="text-gray-500 text-sm font-medium block mb-1.5">Friend's Phone Number</label>
                        <input
                            type="tel"
                            name="friend_phone"
                            value="{{ old('friend_phone') }}"
                            placeholder="e.g. +92 300 000 0000"
                            class="input-field w-full rounded-xl px-4 py-3 text-sm"
                            required
                        >
                    </div>
                </div>
            </div>

            {{-- Info note --}}
            <div class="rounded-xl p-4 flex items-start gap-3 bg-pink-50 border border-pink-100">
                <span class="text-pink-500 mt-0.5 text-base">📨</span>
                <p class="text-gray-500 text-xs leading-relaxed">
                    Both you and your friend will instantly receive a unique surprise gift shopping link via SMS from
                    <strong class="text-pink-600">SurpriseMe</strong>. Links are active for 60 days.
                </p>
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="btn-primary w-full text-white font-bold text-base py-4 rounded-xl flex items-center justify-center gap-2"
                id="submitBtn">
                <span id="btnText">Send Surprise Links 🎁</span>
                <span id="btnLoader" class="hidden flex items-center gap-2">
                    <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                    Sending...
                </span>
            </button>

        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.querySelector('form').addEventListener('submit', function () {
    document.getElementById('btnText').classList.add('hidden');
    document.getElementById('btnLoader').classList.remove('hidden');
    document.getElementById('submitBtn').disabled = true;
});
</script>
@endsection