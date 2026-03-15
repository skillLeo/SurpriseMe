{{-- resources/views/share.blade.php --}}
@extends('layouts.app')
@section('title', 'Spread the Love — SurpriseMe')

@section('styles')
<style>
    /* ── Override body bg for share page ────────────── */
    body.gradient-bg {
        background: linear-gradient(160deg, #E91E8C 0%, #9333EA 100%) !important;
    }

    /* ── Logo bar ───────────────────────────────────── */
    .share-logo-bar {
        padding: 1.25rem 1.5rem 0;
        display: flex; align-items: center; justify-content: space-between;
        position: relative; z-index: 20;
    }

    /* ── Background "hero" area ─────────────────────── */
    .hero-bg {
        flex: 1;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        padding: 2rem 1.5rem;
        text-align: center;
    }
    .hero-bg h1 { color: white; font-size: 1.8rem; font-weight: 900; }
    .hero-bg p  { color: rgba(255,255,255,0.75); font-size: 0.9rem; margin-top: 0.5rem; }

    /* ── Bottom panel (slides up on load) ───────────── */
    .share-panel {
        background: #FFFFFF;
        border-radius: 28px 28px 0 0;
        box-shadow: 0 -8px 40px rgba(147,51,234,0.20);
        transform: translateY(100%);
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        max-height: 85vh;
        overflow-y: auto;
        flex-shrink: 0;
    }
    .share-panel.revealed { transform: translateY(0); }

    /* Panel handle */
    .panel-handle {
        display: flex; flex-direction: column; align-items: center;
        padding: 1rem 0 0.25rem; gap: 4px;
    }
    .panel-handle-bar { width: 44px; height: 5px; border-radius: 3px; background: #E0D0EE; }

    /* Panel inner */
    .panel-inner { padding: 0.5rem 1.5rem 2.5rem; }

    /* ── Video card ─────────────────────────────────── */
    .video-card {
        background: #F8F3FD;
        border: 1.5px solid #E6D8F4;
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 1rem;
    }
    .video-card video { width: 100%; display: block; max-height: 220px; object-fit: cover; }

    /* ── Checkbox row ───────────────────────────────── */
    .check-row {
        display: flex; align-items: center; gap: 10px;
        background: #F8F3FD; border: 1.5px solid #E6D8F4;
        border-radius: 12px; padding: 0.75rem 1rem; margin-bottom: 1.25rem;
        cursor: pointer;
    }
    .check-row input[type="checkbox"] {
        width: 18px; height: 18px; accent-color: #E91E8C; cursor: pointer; flex-shrink: 0;
    }
    .check-row label { color: #6B7280; font-size: 0.82rem; cursor: pointer; line-height: 1.4; }

    /* ── Share buttons ──────────────────────────────── */
    .share-title { color: #1C1830; font-weight: 700; text-align: center; margin-bottom: 1rem; font-size: 0.95rem; }

    /* ── Congrats pill ──────────────────────────────── */
    .congrats-pill {
        background: linear-gradient(135deg, #fff0f8, #f3e8ff);
        border: 1.5px solid #fce7f3;
        border-radius: 16px; padding: 1rem 1.25rem;
        text-align: center; margin-top: 1rem;
    }

    /* ── Step dots on gradient ──────────────────────── */
    .step-line-w { width: 24px; height: 2px; background: rgba(255,255,255,0.35); }
    .step-line-w.done { background: rgba(255,255,255,0.65); }

    @keyframes fadeInUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
    .fade-in { animation: fadeInUp 0.5s ease forwards; }
</style>
@endsection

@section('content')
<div class="min-h-screen flex flex-col" style="position:relative;">

    {{-- ── Logo + step dots ──────────────────────────── --}}
    <div class="share-logo-bar">
        <a href="{{ route('welcome') }}" class="site-logo" style="color:white;">SurpriseMe<span style="color:rgba(255,255,255,0.75)">.com</span></a>

        <div class="flex items-center gap-2">
            @foreach([1,2,3,4] as $step)
            <div class="flex items-center gap-2">
                <div class="step-dot w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                    {{ $step === 4 ? 'active' : 'done' }}">
                    @if($step < 4)
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        {{ $step }}
                    @endif
                </div>
                @if($step < 4)
                    <div class="step-line-w done"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Background hero text ───────────────────────── --}}
    <div class="hero-bg fade-in">
        <div class="text-6xl mb-4" style="animation: float 3s ease-in-out infinite; display:inline-block;">🌊</div>
        <h1>Let's Keep<br>This Going!</h1>
        <p>You surprised <strong style="color:white;">{{ session('friend_name', 'your friend') }}</strong>!<br>Now pass it on — share SurpriseMe!</p>
    </div>

    {{-- ── Bottom slide-up panel ──────────────────────── --}}
    <div class="share-panel" id="sharePanel">

        {{-- Handle --}}
        <div class="panel-handle">
            <div class="panel-handle-bar"></div>
        </div>

        <div class="panel-inner">

            {{-- Promo video --}}
            <div class="video-card">
                <video
                    id="promoVideo"
                    autoplay
                    muted
                    loop
                    playsinline
                    controls
                >
                    <source src="{{ asset('assets/promotion.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>

            {{-- Checkbox: include video when sharing --}}
            <div class="check-row" onclick="document.getElementById('includeVideo').click()">
                <input type="checkbox" id="includeVideo" onclick="event.stopPropagation()">
                <label for="includeVideo">
                    Include the promo video link when sharing with friends
                </label>
            </div>

            {{-- Share buttons --}}
            <p class="share-title">Share SurpriseMe with your friends 👇</p>
            <div class="space-y-3">

                <button onclick="shareWhatsApp()"
                    class="btn-whatsapp w-full text-white font-bold text-sm py-3.5 rounded-xl flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Share on WhatsApp
                </button>

                <button onclick="shareSMS()"
                    class="btn-sms w-full text-white font-bold text-sm py-3.5 rounded-xl flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Share via SMS
                </button>

                <button onclick="copyLink()"
                    class="w-full bg-gray-100 hover:bg-gray-200 border border-gray-200 text-gray-600 font-bold text-sm py-3.5 rounded-xl flex items-center justify-center gap-3 transition-all"
                    id="copyBtn">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <span id="copyBtnText">Copy Link</span>
                </button>
            </div>

            {{-- Congrats --}}
            <div class="congrats-pill">
                <p class="text-pink-600 font-bold mb-1">🎉 You're amazing, {{ session('user_name', 'friend') }}!</p>
                <p class="text-gray-500 text-sm">Your surprise has been set in motion. Both you and <strong class="text-[#1C1830]">{{ session('friend_name', 'your friend') }}</strong> will receive your gift links shortly.</p>
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('welcome') }}" class="text-gray-400 hover:text-gray-600 text-sm transition-colors">← Start a new surprise</a>
            </div>

        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
// ── Slide panel up on load ─────────────────────────────────────────────────
window.addEventListener('load', () => {
    setTimeout(() => {
        document.getElementById('sharePanel').classList.add('revealed');
    }, 350); // slight delay so user sees the gradient bg first
});

// ── Float animation for the wave emoji ────────────────────────────────────
const style = document.createElement('style');
style.textContent = '@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}';
document.head.appendChild(style);

// ── Share functions ────────────────────────────────────────────────────────
const baseUrl    = '{{ url('/') }}';
const videoUrl   = '{{ asset('assets/promotion.mp4') }}';
const baseMsg    = "Hey! 🎁 I just surprised my best friend with a gift link and a voice note using SurpriseMe! You should do the same for yours → " + baseUrl;

function getShareMessage() {
    const includeVid = document.getElementById('includeVideo').checked;
    return encodeURIComponent(includeVid ? baseMsg + "\n\n🎬 Watch this first: " + baseUrl : baseMsg);
}

function shareWhatsApp() {
    window.open('https://api.whatsapp.com/send?text=' + getShareMessage(), '_blank');
}
function shareSMS() {
    window.open('sms:?&body=' + getShareMessage(), '_self');
}
function copyLink() {
    navigator.clipboard.writeText(baseUrl).then(() => {
        document.getElementById('copyBtnText').textContent = '✓ Copied!';
        setTimeout(() => document.getElementById('copyBtnText').textContent = 'Copy Link', 2500);
    });
}
</script>
@endsection