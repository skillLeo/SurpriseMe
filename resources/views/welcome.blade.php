{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')
@section('title', 'SurpriseMe — Surprise Your Best Friend')

@section('styles')
<style>
    /* ── Logo bar ──────────────────────────────────── */
    .top-logo-bar {
        position: absolute; top: 0; left: 0; right: 0;
        z-index: 20; padding: 1.25rem 1.5rem;
        display: flex; align-items: center;
    }

    /* ── Slideshow ─────────────────────────────────── */
    .slideshow-wrap {
        position: relative; width: 100%; height: 320px;
        border-radius: 0 0 36px 36px;
        overflow: hidden;
        box-shadow: 0 8px 40px rgba(233,30,140,0.18);
    }
    .slide {
        position: absolute; inset: 0;
        opacity: 0; transition: opacity 1s ease;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        text-align: center; padding: 2rem;
    }
    .slide.active { opacity: 1; }

    .slide-1 { background: linear-gradient(145deg, #f953c6, #b91d73); }
    .slide-2 { background: linear-gradient(145deg, #c850c0, #4158d0); }
    .slide-3 { background: linear-gradient(145deg, #ff6b9d, #c850c0); }
    .slide-4 { background: linear-gradient(145deg, #a18cd1, #fbc2eb); }
    .slide-5 { background: linear-gradient(145deg, #f093fb, #f5576c); }

    .slide-emoji  { font-size: 4.5rem; margin-bottom: 0.75rem; filter: drop-shadow(0 4px 16px rgba(0,0,0,0.15)); }
    .slide-label  { font-size: 1.5rem; font-weight: 800; color: white; text-shadow: 0 2px 12px rgba(0,0,0,0.2); }
    .slide-sub    { font-size: 0.85rem; color: rgba(255,255,255,0.80); margin-top: 0.4rem; }

    /* Dot indicators */
    .slide-dots { display: flex; gap: 6px; justify-content: center; margin-top: 1rem; }
    .slide-dot-ind {
        width: 8px; height: 8px; border-radius: 50%;
        background: rgba(233,30,140,0.25); transition: all 0.3s ease; cursor: pointer;
    }
    .slide-dot-ind.active { background: #E91E8C; width: 22px; border-radius: 4px; }

    /* ── Hero text ─────────────────────────────────── */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .hero-anim { animation: fadeInUp 0.7s ease forwards; }
    .h-d1 { animation-delay: 0.15s; opacity: 0; }
    .h-d2 { animation-delay: 0.30s; opacity: 0; }
    .h-d3 { animation-delay: 0.45s; opacity: 0; }
    .h-d4 { animation-delay: 0.60s; opacity: 0; }

    /* ── Feature cards ─────────────────────────────── */
    .feature-card {
        background: #FFFFFF;
        border: 1.5px solid #EDE4F6;
        border-radius: 1.25rem;
        padding: 1rem;
        display: flex; align-items: center; gap: 1rem;
        box-shadow: 0 2px 12px rgba(160, 80, 200, 0.07);
        transition: border-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    }
    .feature-card:hover {
        border-color: rgba(233, 30, 140, 0.28);
        transform: translateY(-3px);
        box-shadow: 0 6px 24px rgba(233, 30, 140, 0.10);
    }
    .step-badge {
        width: 34px; height: 34px; border-radius: 50%;
        background: linear-gradient(135deg, #E91E8C, #9333EA);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.72rem; font-weight: 700; color: white; flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(233, 30, 140, 0.28);
    }
    .cta-btn {
        background: linear-gradient(135deg, #E91E8C, #9333EA);
        box-shadow: 0 6px 32px rgba(233, 30, 140, 0.38);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        border-radius: 9999px;
        display: inline-flex; align-items: center; gap: 0.6rem;
        color: white; font-weight: 700; font-size: 1.05rem;
        padding: 1rem 2.5rem; text-decoration: none;
    }
    .cta-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 44px rgba(233, 30, 140, 0.55); }
    .cta-btn:active { transform: translateY(0); }
    .divider-line { flex: 1; height: 1px; background: linear-gradient(90deg, transparent, #E0D0EE, transparent); }
</style>
@endsection

@section('content')
<div class="min-h-screen">

    {{-- ── Logo bar ───────────────────────────────────────── --}}
    <div class="top-logo-bar">
        <a href="{{ route('welcome') }}" class="site-logo">SurpriseMe<span>.com</span></a>
    </div>

    {{-- ── Slideshow ──────────────────────────────────────── --}}
    <div class="slideshow-wrap">
        <div class="slide slide-1 active">
            <div class="slide-emoji">🎁</div>
            <div class="slide-label">Celebrate Her</div>
            <div class="slide-sub">She deserves to be surprised</div>
        </div>
        <div class="slide slide-2">
            <div class="slide-emoji">💝</div>
            <div class="slide-label">Gift with Heart</div>
            <div class="slide-sub">A surprise she'll never forget</div>
        </div>
        <div class="slide slide-3">
            <div class="slide-emoji">🌸</div>
            <div class="slide-label">Show Her You Care</div>
            <div class="slide-sub">More than just a gift — a feeling</div>
        </div>
        <div class="slide slide-4">
            <div class="slide-emoji">🎤</div>
            <div class="slide-label">Your Voice, Her Joy</div>
            <div class="slide-sub">Send a personal voice message too</div>
        </div>
        <div class="slide slide-5">
            <div class="slide-emoji">✨</div>
            <div class="slide-label">Spread the Love</div>
            <div class="slide-sub">Because every woman deserves magic</div>
        </div>
    </div>

    {{-- Slide dots --}}
    <div class="slide-dots mt-4 hero-anim" id="slideDots">
        <div class="slide-dot-ind active" onclick="goSlide(0)"></div>
        <div class="slide-dot-ind" onclick="goSlide(1)"></div>
        <div class="slide-dot-ind" onclick="goSlide(2)"></div>
        <div class="slide-dot-ind" onclick="goSlide(3)"></div>
        <div class="slide-dot-ind" onclick="goSlide(4)"></div>
    </div>

    {{-- ── Hero text ──────────────────────────────────────── --}}
    <div class="px-6 max-w-xl mx-auto">

        <div class="text-center mt-8 mb-8">
            <h1 class="text-4xl md:text-5xl font-black text-[#1C1830] mb-4 leading-tight hero-anim h-d1">
                Women<br>
                <span class="glow-text">Celebrating Women</span>
            </h1>
            <p class="text-gray-500 text-base md:text-lg leading-relaxed hero-anim h-d2 mb-8">
                Give a gift and surprise a woman that is special to you!
            </p>
            <div class="hero-anim h-d3">
                <a href="{{ route('form') }}" class="cta-btn">
                    Start the Surprise
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- ── How it works ──────────────────────────────── --}}
        <div class="hero-anim h-d4 pb-12">
            <div class="flex items-center gap-4 mb-5">
                <div class="divider-line"></div>
                <p class="text-gray-400 text-xs font-semibold uppercase tracking-widest whitespace-nowrap">How it works</p>
                <div class="divider-line"></div>
            </div>
            <div class="space-y-3">
                <div class="feature-card">
                    <div class="step-badge">1</div>
                    <div>
                        <p class="text-[#1C1830] font-bold text-sm">Enter names &amp; numbers</p>
                        <p class="text-gray-400 text-xs mt-0.5">Yours and your best friend's — that's all we need.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="step-badge">2</div>
                    <div>
                        <p class="text-[#1C1830] font-bold text-sm">We send surprise gift links via SMS</p>
                        <p class="text-gray-400 text-xs mt-0.5">Each of you gets a unique, private shopping link — the surprise stays secret!</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="step-badge">3</div>
                    <div>
                        <p class="text-[#1C1830] font-bold text-sm">Record a personal voice note</p>
                        <p class="text-gray-400 text-xs mt-0.5">Straight from your browser — no app needed.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="step-badge">4</div>
                    <div>
                        <p class="text-[#1C1830] font-bold text-sm">Share the voice note via WhatsApp or SMS</p>
                        <p class="text-gray-400 text-xs mt-0.5">Your friend gets a link — they tap it and hear your voice. ❤️</p>
                    </div>
                </div>
            </div>
            <p class="text-center text-gray-300 text-xs mt-8">SurpriseMe · Spread the love ✨</p>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
// ── Auto Slideshow ──────────────────────────────────────────────────────
let current = 0;
const slides    = document.querySelectorAll('.slide');
const dotInds   = document.querySelectorAll('.slide-dot-ind');
const total     = slides.length;

function goSlide(n) {
    slides[current].classList.remove('active');
    dotInds[current].classList.remove('active');
    current = (n + total) % total;
    slides[current].classList.add('active');
    dotInds[current].classList.add('active');
}

setInterval(() => goSlide(current + 1), 3800);
</script>
@endsection