@extends('layouts.app')
@section('title', 'SurpriseMe — Surprise Your Best Friend')

@section('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .hero-anim   { animation: fadeInUp 0.7s ease forwards; }
    .delay-1     { animation-delay: 0.15s; opacity: 0; }
    .delay-2     { animation-delay: 0.30s; opacity: 0; }
    .delay-3     { animation-delay: 0.45s; opacity: 0; }
    .delay-4     { animation-delay: 0.60s; opacity: 0; }

    @keyframes float {
        0%,100% { transform: translateY(0px); }
        50%      { transform: translateY(-14px); }
    }
    .emoji-float { animation: float 3.5s ease-in-out infinite; display: inline-block; }

    .feature-card {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.11);
        border-radius: 1.25rem;
        padding: 1.25rem 1rem;
        text-align: center;
        transition: border-color 0.3s ease, transform 0.3s ease;
    }
    .feature-card:hover {
        border-color: rgba(233,30,140,0.4);
        transform: translateY(-4px);
    }

    .cta-btn {
        background: linear-gradient(135deg, #e91e8c, #9333ea);
        box-shadow: 0 6px 36px rgba(233,30,140,0.50);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        border-radius: 9999px;
        display: inline-flex; align-items: center; gap: 0.6rem;
        color: white; font-weight: 700; font-size: 1.05rem;
        padding: 1rem 2.5rem; text-decoration: none;
    }
    .cta-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 48px rgba(233,30,140,0.70);
    }
    .cta-btn:active { transform: translateY(0); }

    .step-badge {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg, #e91e8c, #9333ea);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.75rem; font-weight: 700; color: white;
        flex-shrink: 0;
        box-shadow: 0 4px 16px rgba(233,30,140,0.4);
    }

    .divider-line {
        flex: 1; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.12), transparent);
    }
</style>
@endsection

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center px-4 py-20">
    <div class="w-full max-w-xl">

        {{-- Hero --}}
        <div class="text-center mb-12">
            <div class="text-7xl mb-6 hero-anim">
                <span class="emoji-float">🎁</span>
            </div>

            <h1 class="text-4xl md:text-5xl font-900 text-white mb-4 leading-tight hero-anim delay-1">
                Surprise Your<br>
                <span class="glow-text">Best Friend</span>
            </h1>

            <p class="text-white/55 text-base md:text-lg leading-relaxed hero-anim delay-2 mb-8">
                Send your best friend a gift link &amp; a personal voice message —
                all from your browser, in under a minute.
            </p>

            <div class="hero-anim delay-3">
                <a href="{{ route('form') }}" class="cta-btn">
                    Start the Surprise
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- How it works --}}
        <div class="hero-anim delay-4">
            <div class="flex items-center gap-4 mb-6">
                <div class="divider-line"></div>
                <p class="text-white/35 text-xs font-600 uppercase tracking-widest whitespace-nowrap">How it works</p>
                <div class="divider-line"></div>
            </div>

            <div class="space-y-3">

                <div class="feature-card flex items-center gap-4 text-left">
                    <div class="step-badge">1</div>
                    <div>
                        <p class="text-white font-700 text-sm">Enter names &amp; numbers</p>
                        <p class="text-white/45 text-xs mt-0.5">Yours and your best friend's — that's all we need.</p>
                    </div>
                </div>

                <div class="feature-card flex items-center gap-4 text-left">
                    <div class="step-badge">2</div>
                    <div>
                        <p class="text-white font-700 text-sm">We send surprise gift links via SMS</p>
                        <p class="text-white/45 text-xs mt-0.5">Each of you gets a unique, private shopping link — the surprise stays secret!</p>
                    </div>
                </div>

                <div class="feature-card flex items-center gap-4 text-left">
                    <div class="step-badge">3</div>
                    <div>
                        <p class="text-white font-700 text-sm">Record a personal voice note</p>
                        <p class="text-white/45 text-xs mt-0.5">Straight from your browser — no app needed.</p>
                    </div>
                </div>

                <div class="feature-card flex items-center gap-4 text-left">
                    <div class="step-badge">4</div>
                    <div>
                        <p class="text-white font-700 text-sm">Share the voice note via WhatsApp or SMS</p>
                        <p class="text-white/45 text-xs mt-0.5">Your friend gets a link — they tap it and hear your voice. ❤️</p>
                    </div>
                </div>

            </div>
        </div>

        <p class="text-center text-white/20 text-xs mt-10">SurpriseMe · Spread the love ✨</p>

    </div>
</div>
@endsection