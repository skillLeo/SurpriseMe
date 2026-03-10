@extends('layouts.app')
@section('title', 'Spread the Love — SurpriseMe')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center px-4 py-16">
    <div class="w-full max-w-lg">

        <div class="flex justify-center gap-3 mb-10">
            @foreach([1,2,3,4] as $step)
            <div class="flex items-center gap-3">
                <div class="step-dot w-10 h-10 rounded-full flex items-center justify-center text-sm font-700 {{ $step === 4 ? 'active text-white' : 'glass text-white/60' }}">
                    @if($step < 4)
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    @else
                    {{ $step }}
                    @endif
                </div>
                @if($step < 4)<div class="w-8 h-px {{ $step < 4 ? 'bg-pink-500/60' : 'bg-white/15' }}"></div>@endif
            </div>
            @endforeach
        </div>

        <div class="text-center mb-8 fade-in-up">
            <div class="text-5xl mb-4 float-anim">🌊</div>
            <h2 class="text-3xl md:text-4xl font-800 text-white mb-2">Keep the Chain Going!</h2>
            <p class="text-white/50 text-sm">You've surprised <strong class="text-pink-400">{{ session('friend_name', 'your friend') }}</strong>. Now share SurpriseMe with others so they can do the same!</p>
        </div>

        <div class="glass-strong rounded-2xl overflow-hidden mb-6 fade-in-up delay-1">
            <div class="aspect-video bg-black/40 flex items-center justify-center relative">
                <video class="w-full h-full object-cover" controls poster="">
                    {{-- <source src="{{ asset('storage/promo.mp4') }}" type="video/mp4"> --}}
                </video>
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full btn-primary flex items-center justify-center mx-auto mb-3 float-anim">
                            <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                        <p class="text-white/40 text-xs">Promo video</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-strong rounded-2xl p-6 mb-6 fade-in-up delay-2">
            <p class="text-white font-600 text-center mb-4">Share SurpriseMe with your friends 👇</p>
            <div class="space-y-3">
                <button onclick="shareWhatsApp()" class="btn-whatsapp w-full text-white font-700 text-sm py-3.5 rounded-xl flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Share on WhatsApp
                </button>
                <button onclick="shareSMS()" class="btn-sms w-full text-white font-700 text-sm py-3.5 rounded-xl flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Share via SMS
                </button>
                <button onclick="copyLink()" class="glass w-full text-white/80 font-700 text-sm py-3.5 rounded-xl flex items-center justify-center gap-3 hover:bg-white/10 transition-all" id="copyBtn">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <span id="copyBtnText">Copy Link</span>
                </button>
            </div>
        </div>

        <div class="glass rounded-xl p-5 text-center fade-in-up delay-3">
            <p class="text-pink-400 font-700 text-lg mb-1">🎉 You're amazing, {{ session('user_name', 'friend') }}!</p>
            <p class="text-white/50 text-sm">Your surprise has been set in motion. Both you and {{ session('friend_name', 'your friend') }} will receive your gift links shortly.</p>
        </div>

        <div class="text-center mt-6 fade-in-up delay-4">
            <a href="{{ route('welcome') }}" class="text-white/40 hover:text-white/70 text-sm transition-colors">← Start a new surprise</a>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
const shareMessage = encodeURIComponent("Hey! 🎁 I just surprised my best friend with a gift link and a voice note using SurpriseMe! You should do the same for yours → {{ url('/') }}");

function shareWhatsApp() {
    window.open(`https://api.whatsapp.com/send?text=${shareMessage}`, '_blank');
}
function shareSMS() {
    window.open(`sms:?&body=${shareMessage}`, '_self');
}
function copyLink() {
    navigator.clipboard.writeText('{{ url('/') }}').then(() => {
        document.getElementById('copyBtnText').textContent = '✓ Copied!';
        setTimeout(() => document.getElementById('copyBtnText').textContent = 'Copy Link', 2500);
    });
}
</script>
@endsection