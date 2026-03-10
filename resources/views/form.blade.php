@extends('layouts.app')
@section('title', 'Enter Details — SurpriseMe')

@section('styles')
<style>
    .modal-overlay {
        position: fixed; inset: 0; z-index: 50;
        background: rgba(0,0,0,0.75);
        backdrop-filter: blur(6px);
        display: flex; align-items: center; justify-content: center;
        padding: 1.5rem;
        opacity: 0; pointer-events: none;
        transition: opacity 0.25s ease;
    }
    .modal-overlay.open { opacity: 1; pointer-events: all; }
    .modal-box {
        background: rgba(30,10,55,0.95);
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 1.5rem;
        padding: 2rem;
        max-width: 480px; width: 100%;
        transform: translateY(20px);
        transition: transform 0.25s ease;
    }
    .modal-overlay.open .modal-box { transform: translateY(0); }
    .link-box {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        word-break: break-all;
        font-size: 0.7rem;
        color: rgba(255,255,255,0.55);
        margin-top: 0.5rem;
    }
    .link-label { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.25rem; }
</style>
@endsection

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center px-4 py-16">
    <div class="w-full max-w-lg">

        {{-- Step dots --}}
        <div class="flex justify-center gap-3 mb-10">
            @foreach([1,2,3,4] as $step)
            <div class="flex items-center gap-3">
                <div class="step-dot w-10 h-10 rounded-full flex items-center justify-center text-sm font-700
                    {{ $step === 2 ? 'active text-white' : 'glass text-white/40' }}">{{ $step }}</div>
                @if($step < 4)<div class="w-8 h-px {{ $step < 2 ? 'bg-pink-500/60' : 'bg-white/15' }}"></div>@endif
            </div>
            @endforeach
        </div>

        <div class="text-center mb-8 fade-in-up">
            <h2 class="text-3xl md:text-4xl font-800 text-white mb-2">Who's the Duo? 👯</h2>
            <p class="text-white/50">Enter your details and your best friend's — we'll handle the rest.</p>
        </div>

        {{-- Validation errors (fallback for no-JS) --}}
        @if($errors->any())
        <div class="glass rounded-xl p-4 mb-6 border border-red-500/30">
            @foreach($errors->all() as $error)
            <p class="text-red-400 text-sm">• {{ $error }}</p>
            @endforeach
        </div>
        @endif

        {{-- General error from JS --}}
        <div id="ajaxError" class="glass rounded-xl p-4 mb-6 border border-red-500/30 hidden">
            <p class="text-red-400 text-sm" id="ajaxErrorMsg"></p>
        </div>

        <form id="mainForm" class="space-y-6 fade-in-up delay-1" novalidate>
            @csrf

            <div class="glass-strong rounded-2xl p-6">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-xl">👤</span>
                    <h3 class="text-white font-700 text-lg">Your Info</h3>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="text-white/60 text-sm font-500 block mb-2">Your Name</label>
                        <input type="text" name="user_name" placeholder="e.g. Alex Johnson"
                            class="input-field w-full rounded-xl px-4 py-3 text-sm" required>
                    </div>
                    <div>
                        <label class="text-white/60 text-sm font-500 block mb-2">Your Phone Number</label>
                        <input type="tel" name="user_phone" placeholder="e.g. +1 555 000 1234"
                            class="input-field w-full rounded-xl px-4 py-3 text-sm" required>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex-1 h-px bg-white/10"></div>
                <div class="glass rounded-full px-3 py-1 text-pink-400 text-xs font-600">+ FRIEND</div>
                <div class="flex-1 h-px bg-white/10"></div>
            </div>

            <div class="glass-strong rounded-2xl p-6">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-xl">🫂</span>
                    <h3 class="text-white font-700 text-lg">Friend's Info</h3>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="text-white/60 text-sm font-500 block mb-2">Friend's Name</label>
                        <input type="text" name="friend_name" placeholder="e.g. Jordan Smith"
                            class="input-field w-full rounded-xl px-4 py-3 text-sm" required>
                    </div>
                    <div>
                        <label class="text-white/60 text-sm font-500 block mb-2">Friend's Phone Number</label>
                        <input type="tel" name="friend_phone" placeholder="e.g. +1 555 000 5678"
                            class="input-field w-full rounded-xl px-4 py-3 text-sm" required>
                    </div>
                </div>
            </div>

            <div class="glass rounded-xl p-4 flex items-start gap-3">
                <span class="text-pink-400 mt-0.5">📨</span>
                <p class="text-white/50 text-xs leading-relaxed">
                    You'll preview both gift links before anything is sent. Links are active for 60 days.
                </p>
            </div>

            <button type="submit" class="btn-primary w-full text-white font-700 text-base py-4 rounded-xl flex items-center justify-center gap-2" id="submitBtn">
                <span id="btnText">Preview Surprise Links 🎁</span>
                <span id="btnLoader" class="hidden flex items-center gap-2">
                    <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                    Loading preview...
                </span>
            </button>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     CONFIRMATION MODAL
══════════════════════════════════════════════════════════ --}}
<div class="modal-overlay" id="confirmModal">
    <div class="modal-box">

        <div class="text-center mb-6">
            <div class="text-4xl mb-3">🎁</div>
            <h3 class="text-white font-800 text-xl mb-1">Confirm & Send?</h3>
            <p class="text-white/50 text-xs">Review the links below. Tap <strong class="text-pink-400">Send Now</strong> to deliver them via SMS.</p>
        </div>

        {{-- Recipients summary --}}
        <div class="glass rounded-xl p-4 mb-4 flex items-center gap-3">
            <span class="text-2xl">👤</span>
            <div>
                <p class="text-white font-600 text-sm" id="modalUserName">—</p>
                <p class="text-white/40 text-xs" id="modalUserPhone">—</p>
            </div>
        </div>
        <div class="glass rounded-xl p-4 mb-5 flex items-center gap-3">
            <span class="text-2xl">🫂</span>
            <div>
                <p class="text-white font-600 text-sm" id="modalFriendName">—</p>
                <p class="text-white/40 text-xs" id="modalFriendPhone">—</p>
            </div>
        </div>

        {{-- Links --}}
        <div class="mb-5">
            <p class="link-label text-pink-400">Your gift link</p>
            <div class="link-box" id="modalUserLink">—</div>
        </div>
        <div class="mb-6">
            <p class="link-label text-purple-400">Friend's gift link</p>
            <div class="link-box" id="modalFriendLink">—</div>
        </div>

        <div class="flex gap-3">
            <button id="cancelBtn"
                class="flex-1 glass text-white/70 font-600 text-sm py-3 rounded-xl hover:bg-white/10 transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Back
            </button>
            <button id="confirmBtn"
                class="flex-1 btn-primary text-white font-700 text-sm py-3 rounded-xl flex items-center justify-center gap-2">
                <span id="confirmBtnText">Send Now 🚀</span>
                <span id="confirmBtnLoader" class="hidden">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                    Sending...
                </span>
            </button>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
const form        = document.getElementById('mainForm');
const submitBtn   = document.getElementById('submitBtn');
const btnText     = document.getElementById('btnText');
const btnLoader   = document.getElementById('btnLoader');
const modal       = document.getElementById('confirmModal');
const ajaxError   = document.getElementById('ajaxError');
const ajaxErrMsg  = document.getElementById('ajaxErrorMsg');

function showError(msg) {
    ajaxErrMsg.textContent = msg;
    ajaxError.classList.remove('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function hideError() { ajaxError.classList.add('hidden'); }

function setSubmitLoading(v) {
    submitBtn.disabled = v;
    btnText.classList.toggle('hidden', v);
    btnLoader.classList.toggle('hidden', !v);
}

// ── STEP 1: Submit form → preview ──────────────────────────────────────────
form.addEventListener('submit', async e => {
    e.preventDefault();
    hideError();

    // Basic HTML5 validation
    if (!form.checkValidity()) { form.reportValidity(); return; }

    setSubmitLoading(true);

    const fd = new FormData(form);

    try {
        const res  = await fetch('{{ route("form.preview") }}', { method: 'POST', body: fd });
        const data = await res.json();

        if (!res.ok) {
            // Laravel validation errors come as 422
            if (res.status === 422 && data.errors) {
                const msgs = Object.values(data.errors).flat().join('\n');
                showError(msgs);
            } else {
                showError(data.message || 'Something went wrong. Please try again.');
            }
            setSubmitLoading(false);
            return;
        }

        // Populate modal
        document.getElementById('modalUserName').textContent   = data.user_name;
        document.getElementById('modalUserPhone').textContent  = data.user_phone;
        document.getElementById('modalFriendName').textContent = data.friend_name;
        document.getElementById('modalFriendPhone').textContent= data.friend_phone;
        document.getElementById('modalUserLink').textContent   = data.user_link;
        document.getElementById('modalFriendLink').textContent = data.friend_link;

        setSubmitLoading(false);
        modal.classList.add('open');

    } catch (err) {
        showError('Network error. Please check your connection and try again.');
        setSubmitLoading(false);
    }
});

// ── Cancel: close modal + clear pending session ────────────────────────────
document.getElementById('cancelBtn').addEventListener('click', async () => {
    modal.classList.remove('open');
    // Fire-and-forget — just tells server to clear the pending session
    fetch('{{ route("form.cancel") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({})
    }).catch(() => {});
});

// Close modal if clicking outside the box
modal.addEventListener('click', e => {
    if (e.target === modal) {
        document.getElementById('cancelBtn').click();
    }
});

// ── Confirm: send SMS ──────────────────────────────────────────────────────
document.getElementById('confirmBtn').addEventListener('click', async () => {
    const confirmBtn    = document.getElementById('confirmBtn');
    const confirmText   = document.getElementById('confirmBtnText');
    const confirmLoader = document.getElementById('confirmBtnLoader');

    confirmBtn.disabled = true;
    confirmText.classList.add('hidden');
    confirmLoader.classList.remove('hidden');

    try {
        const res  = await fetch('{{ route("form.confirm") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({})
        });
        const data = await res.json();

        if (!res.ok) {
            modal.classList.remove('open');
            showError(data.error || 'Sending failed. Please try again.');
            confirmBtn.disabled = false;
            confirmText.classList.remove('hidden');
            confirmLoader.classList.add('hidden');
            return;
        }

        // Success → redirect to voice page
        window.location.href = data.redirect;

    } catch (err) {
        modal.classList.remove('open');
        showError('Network error while sending. Please try again.');
        confirmBtn.disabled = false;
        confirmText.classList.remove('hidden');
        confirmLoader.classList.add('hidden');
    }
});
</script>
@endsection