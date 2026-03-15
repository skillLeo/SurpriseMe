{{-- resources/views/form.blade.php --}}
@extends('layouts.app')
@section('title', 'Enter Details — SurpriseMe')

@section('styles')
<style>
    /* ── Override page bg for form page ─────────────── */
    body.gradient-bg {
        background: linear-gradient(160deg, #E91E8C 0%, #9333EA 100%) !important;
    }

    /* ── Full page wrapper ──────────────────────────── */
    .form-page {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    /* ── Logo bar ───────────────────────────────────── */
    .form-logo-bar {
        padding: 1.25rem 1.5rem 0;
        display: flex; align-items: center; justify-content: space-between;
        flex-shrink: 0;
    }

    /* ── Gradient (top) section ─────────────────────── */
    .gradient-section {
        flex: 1;
        padding: 1.25rem 1.5rem 2rem;
        min-height: 0;
    }

    .gradient-section h2 {
        color: white;
        font-size: 1.6rem;
        font-weight: 900;
        margin-bottom: 0.25rem;
    }
    .gradient-section p { color: rgba(255,255,255,0.70); font-size: 0.85rem; }
    .gradient-label { color: rgba(255,255,255,0.75); font-size: 0.8rem; font-weight: 500; display: block; margin-bottom: 0.4rem; }

    /* ── Step dots on gradient ──────────────────────── */
    .step-line-grad { width: 28px; height: 2px; background: rgba(255,255,255,0.30); }
    .step-line-grad.done { background: rgba(255,255,255,0.65); }

    /* ── "Add Friend" trigger button ────────────────── */
    .add-friend-btn {
        width: 100%; margin-top: 1.5rem;
        background: rgba(255,255,255,0.18);
        border: 1.5px solid rgba(255,255,255,0.40);
        color: white; font-weight: 700; font-size: 0.9rem;
        padding: 0.85rem 1.5rem; border-radius: 14px;
        cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: background 0.3s ease, transform 0.2s ease;
    }
    .add-friend-btn:hover { background: rgba(255,255,255,0.26); transform: translateY(-1px); }
    .add-friend-btn svg { transition: transform 0.4s ease; }

    /* ── White bottom sheet ─────────────────────────── */
    .bottom-sheet {
        background: #FFFFFF;
        border-radius: 28px 28px 0 0;
        box-shadow: 0 -8px 40px rgba(147, 51, 234, 0.18);
        overflow: hidden;
        max-height: 82px; /* shows just the handle peeking */
        transition: max-height 0.55s cubic-bezier(0.4, 0, 0.2, 1);
        flex-shrink: 0;
    }
    .bottom-sheet.open { max-height: 680px; }

    /* Pull handle */
    .sheet-handle {
        display: flex; align-items: center; justify-content: center;
        padding: 1rem 0 0.5rem; cursor: pointer;
        flex-direction: column; gap: 4px;
    }
    .sheet-handle-bar {
        width: 44px; height: 5px; border-radius: 3px;
        background: #E0D0EE;
    }
    .sheet-handle-label {
        font-size: 0.78rem; font-weight: 600; color: #C2B4D6;
        transition: opacity 0.3s ease;
    }

    /* Sheet content */
    .sheet-inner { padding: 0 1.5rem 2rem; }
    .sheet-inner h3 { color: #1C1830; font-size: 1.3rem; font-weight: 800; margin-bottom: 1.25rem; }

    /* ── Error + warning panels ──────────────────────── */
    .error-panel { background: #fef2f2; border: 1.5px solid #fca5a5; border-radius: 14px; padding: 1rem; margin-bottom: 1rem; }
    .warn-panel  { background: #fef2f2; border: 1.5px solid #fca5a5; border-radius: 14px; padding: 1rem; margin-bottom: 1rem; display: none; }
    .warn-panel.visible { display: flex; gap: 0.6rem; align-items: flex-start; }

    /* ── Submit button ───────────────────────────────── */
    .submit-btn {
        width: 100%; margin-top: 1.25rem;
        background: linear-gradient(135deg, #E91E8C, #9333EA);
        color: white; font-weight: 700; font-size: 1rem;
        padding: 1rem; border-radius: 14px; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        box-shadow: 0 4px 24px rgba(233,30,140,0.30);
        transition: all 0.3s ease;
    }
    .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 36px rgba(233,30,140,0.44); }
    .submit-btn:disabled {
        background: #d1d5db; color: #9ca3af;
        box-shadow: none; cursor: not-allowed; transform: none;
    }

    @keyframes fadeInUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
    .fade-in { animation: fadeInUp 0.5s ease forwards; }
</style>
@endsection

@section('content')
<form method="POST" action="{{ route('form.store') }}" id="mainForm">
@csrf

<div class="form-page">

    {{-- ── Logo + step dots ──────────────────────────── --}}
    <div class="form-logo-bar">
        <a href="{{ route('welcome') }}" class="site-logo" style="color:white;">SurpriseMe<span style="color:rgba(255,255,255,0.75)">.com</span></a>

        {{-- Step dots --}}
        <div class="flex items-center gap-2">
            @foreach([1,2,3,4] as $step)
            <div class="flex items-center gap-2">
                <div class="step-dot w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                    {{ $step === 2 ? 'active' : ($step < 2 ? 'done' : '') }}">
                    @if($step < 2)
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        {{ $step }}
                    @endif
                </div>
                @if($step < 4)
                    <div class="step-line-grad {{ $step < 2 ? 'done' : '' }}"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Gradient section: Your info ───────────────── --}}
    <div class="gradient-section fade-in">
        <h2 class="mt-4">Who's the Duo? 👯</h2>
        <p class="mb-6">Enter your details and your best friend's — we'll handle the rest.</p>

        {{-- Your info --}}
        <div class="space-y-4">
            <div>
                <label class="gradient-label">👤 Your Name</label>
                <input
                    type="text"
                    name="user_name"
                    value="{{ old('user_name') }}"
                    placeholder="e.g. Alex Johnson"
                    class="input-glass w-full rounded-xl px-4 py-3 text-sm"
                    required
                >
            </div>
            <div>
                <label class="gradient-label">📱 Your Phone Number</label>
                <input
                    type="tel"
                    name="user_phone"
                    value="{{ old('user_phone') }}"
                    placeholder="e.g. +92 300 000 0000"
                    class="input-glass w-full rounded-xl px-4 py-3 text-sm"
                    required
                >
            </div>
        </div>

        {{-- Add Friend trigger --}}
        <button type="button" class="add-friend-btn" id="addFriendBtn">
            Add Friend Info
            <svg id="addFriendArrow" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
    </div>

    {{-- ── White bottom sheet: Friend info ───────────── --}}
    <div class="bottom-sheet {{ old('friend_name') || $errors->any() ? 'open' : '' }}" id="bottomSheet">

        {{-- Pull handle --}}
        <div class="sheet-handle" id="sheetHandle">
            <div class="sheet-handle-bar"></div>
            <span class="sheet-handle-label" id="sheetHandleLabel">Friend Info</span>
        </div>

        <div class="sheet-inner" id="sheetInner">

            {{-- Logo on sheet --}}
            <h3>🫂 Friend's Info</h3>

            {{-- Server error panel --}}
            @if($errors->any())
            <div class="error-panel">
                @foreach($errors->all() as $error)
                <p class="text-red-500 text-sm">• {{ $error }}</p>
                @endforeach
            </div>
            @endif

            {{-- Same number warning (JS shows/hides) --}}
            <div id="sameNumberWarning" class="warn-panel">
                <span class="text-red-500 mt-0.5">⚠️</span>
                <p class="text-red-500 text-xs leading-relaxed font-medium">
                    Your number and your friend's number cannot be the same.
                    Please enter a different number.
                </p>
            </div>

            {{-- Friend fields --}}
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

            {{-- Info note --}}
            <div class="mt-4 rounded-xl p-3 flex items-start gap-3 bg-pink-50 border border-pink-100">
                <span class="text-pink-500 text-base mt-0.5">📨</span>
                <p class="text-gray-500 text-xs leading-relaxed">
                    Both of you will receive a unique gift link via SMS from
                    <strong class="text-pink-600">SurpriseMe</strong>. Valid for 60 days.
                </p>
            </div>

            {{-- Submit --}}
            <button type="submit" class="submit-btn" id="submitBtn">
                <span id="btnText">Send Surprise Links 🎁</span>
                <span id="btnLoader" class="hidden flex items-center gap-2">
                    <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                    Sending...
                </span>
            </button>

        </div>
    </div>

</div>
</form>
@endsection

@section('scripts')
<script>
// ─── Bottom sheet animation ────────────────────────────────────────────────
const bottomSheet  = document.getElementById('bottomSheet');
const addFriendBtn = document.getElementById('addFriendBtn');
const addFriendArrow = document.getElementById('addFriendArrow');
const sheetHandle  = document.getElementById('sheetHandle');

function openSheet() {
    bottomSheet.classList.add('open');
    addFriendArrow.style.transform = 'rotate(180deg)';
    addFriendBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>';
}

addFriendBtn.addEventListener('click', openSheet);
sheetHandle.addEventListener('click', openSheet);

// Auto-open if there are server errors or old input
@if($errors->any() || old('friend_name'))
openSheet();
@endif

// ─── Phone duplicate check (last-10-digits) ────────────────────────────────
const userPhone   = document.querySelector('[name="user_phone"]');
const friendPhone = document.querySelector('[name="friend_phone"]');
const warning     = document.getElementById('sameNumberWarning');
const submitBtn   = document.getElementById('submitBtn');

function normalise(v) {
    const digits = v.replace(/\D/g, '');
    return digits.slice(-10);
}

function isSame() {
    const u = normalise(userPhone.value);
    const f = normalise(friendPhone.value);
    return u.length >= 7 && f.length >= 7 && u === f;
}

function setBlocked(blocked) {
    if (blocked) {
        warning.classList.add('visible');
        warning.style.display = 'flex';
    } else {
        warning.classList.remove('visible');
        warning.style.display = 'none';
    }
    submitBtn.disabled = blocked;
    friendPhone.style.borderColor = blocked ? '#fca5a5' : '';
    friendPhone.style.background  = blocked ? '#fff5f5' : '';
}

userPhone.addEventListener('input',   () => setBlocked(isSame()));
friendPhone.addEventListener('input', () => {
    setBlocked(isSame());
    if (!bottomSheet.classList.contains('open')) openSheet();
});

document.getElementById('mainForm').addEventListener('submit', function(e) {
    if (isSame()) {
        e.preventDefault();
        setBlocked(true);
        openSheet();
        friendPhone.focus();
        return;
    }
    document.getElementById('btnText').classList.add('hidden');
    document.getElementById('btnLoader').classList.remove('hidden');
    submitBtn.disabled = true;
});
</script>
@endsection