@extends('layouts.app')
@section('title', 'SurpriseMe — Surprise Your Best Friend')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center px-4 py-16">

    <div class="text-center mb-6 fade-in-up">
        <div class="inline-flex items-center gap-2 glass rounded-full px-4 py-2 mb-6">
            <span class="text-pink-400 text-sm">✨</span>
            <span class="text-white/70 text-sm font-medium">The Surprise Gifting Experience</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-900 text-white leading-tight mb-4">
            Surprise<span class="glow-text">Me</span>
        </h1>
        <p class="text-white/60 text-lg md:text-xl max-w-md mx-auto leading-relaxed">
            Send a surprise gift link & a personal voice note to your best friend — and keep the magic going.
        </p>
    </div>

    <div class="w-full max-w-2xl mb-8 fade-in-up delay-2">
        <div class="glass-strong rounded-2xl overflow-hidden shadow-2xl">
            <div class="aspect-video bg-black/40 flex items-center justify-center relative">
                {{-- Replace src with actual video when client provides it --}}
                <video
                    class="w-full h-full object-cover"
                    controls
                    poster="https://via.placeholder.com/800x450/1a0537/e91e8c?text=SurpriseMe+Promo+Video"
                >
                    {{-- <source src="{{ asset('storage/promo.mp4') }}" type="video/mp4"> --}}
                </video>
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none" id="videoPlaceholder">
                    <div class="text-center">
                        <div class="w-20 h-20 rounded-full btn-primary flex items-center justify-center mx-auto mb-3 float-anim">
                            <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                        <p class="text-white/50 text-sm">Promo video coming soon</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-2xl w-full mb-10 fade-in-up delay-3">
        <div class="glass rounded-xl p-4 text-center">
            <div class="text-3xl mb-2">🎁</div>
            <p class="text-white font-600 text-sm">Surprise Gift Links</p>
            <p class="text-white/50 text-xs mt-1">Unique shopping links for both of you</p>
        </div>
        <div class="glass rounded-xl p-4 text-center">
            <div class="text-3xl mb-2">🎤</div>
            <p class="text-white font-600 text-sm">Personal Voice Note</p>
            <p class="text-white/50 text-xs mt-1">Record a message from your browser</p>
        </div>
        <div class="glass rounded-xl p-4 text-center">
            <div class="text-3xl mb-2">🌊</div>
            <p class="text-white font-600 text-sm">Domino Effect</p>
            <p class="text-white/50 text-xs mt-1">Spread the surprise to others</p>
        </div>
    </div>

    <div class="fade-in-up delay-4">
        <a href="{{ route('form') }}" class="btn-primary inline-flex items-center gap-3 text-white font-700 text-lg px-10 py-4 rounded-full no-underline">
            <span>Get Started</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
            </svg>
        </a>
        <p class="text-white/30 text-xs text-center mt-4">Free to use · No app needed</p>
    </div>

</div>
@endsection