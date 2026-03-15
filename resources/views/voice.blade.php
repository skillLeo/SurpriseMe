{{-- resources/views/voice.blade.php --}}
@extends('layouts.app')
@section('title', 'Record Voice Note — SurpriseMe')

@section('styles')
<style>
    /* ── Logo bar ───────────────────────────────────── */
    .voice-logo-bar { padding: 1.25rem 1.5rem 0; display: flex; align-items: center; }

    /* ── Mic button ─────────────────────────────────── */
    .mic-btn {
        width: 100px; height: 100px; border-radius: 50%;
        background: linear-gradient(135deg, #E91E8C, #9333EA);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; border: none; outline: none;
        transition: transform 0.3s ease;
        box-shadow: 0 8px 36px rgba(233, 30, 140, 0.38);
        position: relative; z-index: 2;
    }
    .mic-btn:hover { transform: scale(1.05); }

    @keyframes pulse-glow-mic {
        0%, 100% { box-shadow: 0 8px 36px rgba(233,30,140,0.45); transform: scale(1); }
        50%       { box-shadow: 0 8px 60px rgba(233,30,140,0.85); transform: scale(1.05); }
    }
    .mic-btn.recording { animation: pulse-glow-mic 1s ease-in-out infinite; }

    /* ── Waveform container ─────────────────────────── */
    #waveform {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
        height: 80px;
        position: relative;
        z-index: 2;
        transition: height 0.4s ease;
    }

    .waveform-bar {
        width: 5px; border-radius: 6px;
        background: linear-gradient(to top, #E91E8C, #9333EA);
        transition: height 0.1s ease, width 0.3s ease, opacity 0.3s ease;
    }

    /* ── Waveform recording mode (via :has) ─────────── */
    /* When mic button is in recording state — change card background and bars */
    .record-card:has(#micBtn.recording) {
        background: linear-gradient(160deg, #FFF0F8 0%, #F3E8FF 50%, #FFF0F8 100%);
        border-color: rgba(233,30,140,0.18);
    }

    /* Bigger waveform bars during recording */
    .record-card:has(#micBtn.recording) #waveform {
        height: 110px;
        gap: 6px;
    }
    .record-card:has(#micBtn.recording) .waveform-bar {
        width: 7px;
    }

    /* Gradient orb behind the waveform when recording */
    .wave-glow {
        position: absolute;
        width: 260px; height: 160px;
        border-radius: 50%;
        background: radial-gradient(ellipse at center, rgba(233,30,140,0.10) 0%, rgba(147,51,234,0.08) 50%, transparent 70%);
        top: 50%; left: 50%; transform: translate(-50%, -50%);
        pointer-events: none; z-index: 1;
        opacity: 0; transition: opacity 0.4s ease;
    }
    .record-card:has(#micBtn.recording) .wave-glow { opacity: 1; }

    /* ── Timer ───────────────────────────────────────── */
    .timer { font-variant-numeric: tabular-nums; letter-spacing: 0.05em; }

    /* ── Progress bar ────────────────────────────────── */
    .progress-outer {
        height: 6px; background: #EDE4F6;
        border-radius: 6px; cursor: pointer; position: relative;
    }
    .progress-inner {
        height: 100%;
        background: linear-gradient(90deg, #E91E8C, #9333EA);
        border-radius: 6px; width: 0%; pointer-events: none;
    }

    /* ── Preview play button ─────────────────────────── */
    .audio-play-btn {
        width: 44px; height: 44px; border-radius: 50%;
        background: linear-gradient(135deg, #E91E8C, #9333EA);
        border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 16px rgba(233,30,140,0.35);
        flex-shrink: 0; transition: transform 0.2s;
    }
    .audio-play-btn:hover { transform: scale(1.07); }

    /* ── Recording card ──────────────────────────────── */
    .record-card {
        background: #FFFFFF;
        border: 1.5px solid #E6D8F4;
        border-radius: 24px;
        box-shadow: 0 4px 28px rgba(160,80,200,0.10);
        transition: background 0.4s ease, border-color 0.4s ease;
        overflow: hidden;
    }

    @keyframes fadeInUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
    .fade-in-up { animation: fadeInUp 0.6s ease forwards; }
    .delay-1 { animation-delay: 0.10s; opacity: 0; }
</style>
@endsection

@section('content')
<div class="min-h-screen flex flex-col items-center justify-start px-4 pb-12">

    {{-- ── Logo bar ───────────────────────────────────── --}}
    <div class="voice-logo-bar w-full max-w-lg">
        <a href="{{ route('welcome') }}" class="site-logo">SurpriseMe<span>.com</span></a>
    </div>

    <div class="w-full max-w-lg mt-6">

        {{-- Step dots --}}
        <div class="flex justify-center gap-3 mb-8">
            @foreach([1,2,3,4] as $step)
            <div class="flex items-center gap-3">
                <div class="step-dot-light w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold
                    {{ $step === 3 ? 'active' : ($step < 3 ? 'done' : '') }}">
                    @if($step < 3)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        {{ $step }}
                    @endif
                </div>
                @if($step < 4)
                    <div class="w-8 h-px {{ $step < 3 ? 'bg-pink-400/40' : 'bg-gray-200' }}"></div>
                @endif
            </div>
            @endforeach
        </div>

        {{-- Heading --}}
        <div class="text-center mb-6 fade-in-up">
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#1C1830] mb-2">
                Record for <span class="glow-text">{{ session('friend_name', 'Your Friend') }}</span> 🎤
            </h2>
            <p class="text-gray-500 text-sm">Record a personal voice note — straight from your browser.</p>
        </div>

        {{-- Main recording card --}}
        <div class="record-card p-7 text-center fade-in-up delay-1">

            {{-- Status text (JS sets style.color) --}}
            <div id="statusText" class="text-gray-400 text-sm mb-5 h-5">Tap the mic to start recording</div>

            {{-- Waveform — JS queries '.waveform-bar' --}}
            <div id="waveform" class="mb-4 mx-auto" style="max-width:280px; position:relative;">
                <div class="wave-glow"></div>
                @for($i = 0; $i < 20; $i++)
                <div class="waveform-bar" style="height:10px; opacity:0.22;"></div>
                @endfor
            </div>

            {{-- Mic button --}}
            <div class="flex justify-center mb-5">
                <button class="mic-btn" id="micBtn">
                    <svg id="micIcon" class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 1a3 3 0 00-3 3v8a3 3 0 006 0V4a3 3 0 00-3-3z"/>
                        <path d="M19 10v2a7 7 0 01-14 0v-2H3v2a9 9 0 008 8.94V23h2v-2.06A9 9 0 0021 12v-2h-2z"/>
                    </svg>
                    <svg id="stopIcon" class="w-8 h-8 text-white hidden" fill="currentColor" viewBox="0 0 24 24">
                        <rect x="6" y="6" width="12" height="12" rx="2"/>
                    </svg>
                </button>
            </div>

            {{-- Timer --}}
            <div class="timer text-4xl font-black text-[#1C1830] mb-5" id="timerDisplay">0:00</div>

            {{-- Preview section — JS toggles class "hidden" --}}
            <div id="previewSection" class="hidden mb-5">
                <audio id="audioEl" preload="auto" class="hidden"></audio>

                <div class="rounded-2xl p-4 mb-4 bg-[#F8F3FD] border border-[#E6D8F4]">
                    <p class="text-gray-400 text-xs mb-3">Preview your recording</p>
                    <div class="flex items-center gap-3">
                        <button class="audio-play-btn" id="previewPlayBtn" onclick="togglePreview()">
                            <svg id="previewPlayIcon" class="w-5 h-5 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                            <svg id="previewPauseIcon" class="w-5 h-5 text-white hidden" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                            </svg>
                        </button>
                        <div class="flex-1 progress-outer" id="progressBar">
                            <div class="progress-inner" id="progressFill"></div>
                        </div>
                        <div class="text-gray-400 text-xs tabular-nums" style="min-width:84px; text-align:right;">
                            <span id="timeCurrent">0:00</span> / <span id="timeDuration">0:00</span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button id="reRecordBtn"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 border border-gray-200 text-gray-600 font-semibold text-sm py-3 rounded-xl transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Re-record
                    </button>
                    <button id="uploadBtn"
                        class="flex-1 btn-primary text-white font-bold text-sm py-3 rounded-xl flex items-center justify-center gap-2">
                        Send Voice Note
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Uploading spinner — JS toggles class "hidden" --}}
            <div id="uploadingSection" class="hidden text-center py-4">
                <svg class="w-8 h-8 animate-spin text-pink-500 mx-auto mb-3" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
                <p class="text-gray-400 text-sm">Uploading voice note...</p>
            </div>

            {{-- Share section — JS toggles class "hidden" --}}
            <div id="shareSection" class="hidden">
                <div class="rounded-xl p-4 mb-4 bg-pink-50 border border-pink-100">
                    <p class="text-pink-600 text-xs font-semibold mb-1">🔗 Your voice note is ready!</p>
                    <p id="shareLinkDisplay" class="text-gray-400 text-xs break-all"></p>
                </div>
                <p class="text-gray-500 text-sm mb-4">
                    Share directly with <strong class="text-[#1C1830]">{{ session('friend_name', 'your friend') }}</strong>
                </p>
                <div class="flex gap-3">
                    <button id="whatsappBtn"
                        class="flex-1 btn-whatsapp text-white font-bold text-sm py-3 rounded-xl flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        WhatsApp
                    </button>
                    <button id="smsBtn"
                        class="flex-1 btn-sms text-white font-bold text-sm py-3 rounded-xl flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Send SMS
                    </button>
                </div>
                <button id="nextPageBtn"
                    class="w-full mt-3 bg-gray-100 hover:bg-gray-200 border border-gray-200 text-gray-600 font-semibold text-sm py-3 rounded-xl transition-all flex items-center justify-center gap-2">
                    Continue to Share Page
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// ─── Elements ──────────────────────────────────────────────────────────────
const micBtn       = document.getElementById('micBtn');
const micIcon      = document.getElementById('micIcon');
const stopIcon     = document.getElementById('stopIcon');
const timerDisplay = document.getElementById('timerDisplay');
const statusText   = document.getElementById('statusText');
const waveformBars = document.querySelectorAll('.waveform-bar');
const audioEl      = document.getElementById('audioEl');
const previewSec   = document.getElementById('previewSection');
const uploadingSec = document.getElementById('uploadingSection');
const shareSec     = document.getElementById('shareSection');
const progressBar  = document.getElementById('progressBar');
const progressFill = document.getElementById('progressFill');
const timeCurrent  = document.getElementById('timeCurrent');
const timeDuration = document.getElementById('timeDuration');

// ─── State ─────────────────────────────────────────────────────────────────
let mediaRecorder   = null;
let audioStream     = null;
let audioChunks     = [];
let timerInterval   = null;
let waveInterval    = null;
let recordedSeconds = 0;
let knownDuration   = 0;
let recordedBlob    = null;
let shareUrl        = null;
let isRecording     = false;

// ─── Helpers ───────────────────────────────────────────────────────────────
function fmt(s) {
    s = Math.floor(s < 0 ? 0 : s);
    return Math.floor(s / 60) + ':' + String(s % 60).padStart(2, '0');
}

function getDuration() {
    const d = audioEl.duration;
    return (isFinite(d) && d > 0) ? d : knownDuration;
}

function setStatus(msg, color) {
    statusText.textContent = msg;
    statusText.style.color = color || '';
}

// ─── Waveform ──────────────────────────────────────────────────────────────
function startWave() {
    waveInterval = setInterval(() => {
        waveformBars.forEach(b => {
            b.style.height  = (Math.random() * 36 + 6) + 'px';
            b.style.opacity = 0.6 + Math.random() * 0.4;
        });
    }, 90);
}
function stopWave() {
    clearInterval(waveInterval);
    waveformBars.forEach(b => { b.style.height = '10px'; b.style.opacity = '0.22'; });
}

// ─── Recording ─────────────────────────────────────────────────────────────
micBtn.addEventListener('click', async () => {
    if (isRecording) { stopRecording(); return; }
    resetAll();

    try {
        audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });
    } catch {
        setStatus('Microphone access denied.', '#f87171');
        return;
    }

    const mime = ['audio/webm;codecs=opus','audio/webm','audio/ogg;codecs=opus','audio/mp4']
        .find(t => MediaRecorder.isTypeSupported(t)) || '';

    mediaRecorder = new MediaRecorder(audioStream, mime ? { mimeType: mime } : {});
    audioChunks   = [];

    mediaRecorder.ondataavailable = e => { if (e.data && e.data.size > 0) audioChunks.push(e.data); };

    mediaRecorder.onstop = () => {
        audioStream.getTracks().forEach(t => t.stop());
        knownDuration = recordedSeconds;
        recordedBlob  = new Blob(audioChunks, { type: mediaRecorder.mimeType || 'audio/webm' });
        audioEl.src   = URL.createObjectURL(recordedBlob);
        audioEl.load();
        timeDuration.textContent = fmt(knownDuration);
        timeCurrent.textContent  = '0:00';
        progressFill.style.width = '0%';
        previewSec.classList.remove('hidden');
        setStatus('Recording complete! Preview below.', '#16a34a');
    };

    mediaRecorder.start(100);
    isRecording     = true;
    recordedSeconds = 0;
    timerDisplay.textContent = '0:00';
    micBtn.classList.add('recording');
    micIcon.classList.add('hidden');
    stopIcon.classList.remove('hidden');
    setStatus('● Recording...', '#E91E8C');
    startWave();

    timerInterval = setInterval(() => {
        recordedSeconds++;
        timerDisplay.textContent = fmt(recordedSeconds);
        if (recordedSeconds >= 180) stopRecording();
    }, 1000);
});

function stopRecording() {
    if (!mediaRecorder || mediaRecorder.state === 'inactive') return;
    isRecording = false;
    clearInterval(timerInterval);
    stopWave();
    micBtn.classList.remove('recording');
    micIcon.classList.remove('hidden');
    stopIcon.classList.add('hidden');
    setStatus('Saving recording...', '#f59e0b');
    mediaRecorder.requestData();
    mediaRecorder.stop();
}

// ─── Audio player ──────────────────────────────────────────────────────────
audioEl.addEventListener('durationchange', () => {
    const d = audioEl.duration;
    if (isFinite(d) && d > 0) timeDuration.textContent = fmt(d);
});

audioEl.addEventListener('timeupdate', () => {
    const dur = getDuration();
    if (dur <= 0) return;
    progressFill.style.width = Math.min((audioEl.currentTime / dur) * 100, 100) + '%';
    timeCurrent.textContent  = fmt(audioEl.currentTime);
    timeDuration.textContent = fmt(dur);
});

audioEl.addEventListener('ended', () => {
    document.getElementById('previewPlayIcon').classList.remove('hidden');
    document.getElementById('previewPauseIcon').classList.add('hidden');
    progressFill.style.width = '0%';
    timeCurrent.textContent  = '0:00';
    timeDuration.textContent = fmt(getDuration());
});

progressBar.addEventListener('click', function(e) {
    const dur = getDuration();
    if (dur <= 0) return;
    const pct = (e.clientX - this.getBoundingClientRect().left) / this.offsetWidth;
    audioEl.currentTime = Math.max(0, Math.min(pct * dur, dur));
});

function togglePreview() {
    if (audioEl.paused) {
        audioEl.play();
        document.getElementById('previewPlayIcon').classList.add('hidden');
        document.getElementById('previewPauseIcon').classList.remove('hidden');
    } else {
        audioEl.pause();
        document.getElementById('previewPlayIcon').classList.remove('hidden');
        document.getElementById('previewPauseIcon').classList.add('hidden');
    }
}

// ─── Re-record ─────────────────────────────────────────────────────────────
document.getElementById('reRecordBtn').addEventListener('click', () => {
    resetAll();
    previewSec.classList.add('hidden');
    shareSec.classList.add('hidden');
    timerDisplay.textContent = '0:00';
    setStatus('Tap the mic to start recording');
});

function resetAll() {
    audioEl.pause();
    if (audioEl.src) { try { URL.revokeObjectURL(audioEl.src); } catch(e){} audioEl.src = ''; }
    recordedBlob    = null;
    shareUrl        = null;
    audioChunks     = [];
    recordedSeconds = 0;
    knownDuration   = 0;
    progressFill.style.width = '0%';
    timeCurrent.textContent  = '0:00';
    timeDuration.textContent = '0:00';
    document.getElementById('previewPlayIcon').classList.remove('hidden');
    document.getElementById('previewPauseIcon').classList.add('hidden');
}

// ─── Upload ────────────────────────────────────────────────────────────────
document.getElementById('uploadBtn').addEventListener('click', async () => {
    if (!recordedBlob || recordedBlob.size === 0) {
        setStatus('Please record a voice note first.', '#f87171');
        return;
    }

    previewSec.classList.add('hidden');
    uploadingSec.classList.remove('hidden');

    const mtype = recordedBlob.type || 'audio/webm';
    const ext   = mtype.includes('ogg') ? 'ogg' : mtype.includes('mp4') ? 'mp4' : 'webm';
    const file  = new File([recordedBlob], 'voice.' + ext, { type: mtype });
    const fd    = new FormData();
    fd.append('audio', file);
    fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);

    try {
        const res = await fetch('{{ route("voice.upload") }}', { method: 'POST', body: fd });
        let data;
        try { data = await res.json(); } catch { throw new Error('Non-JSON response from server'); }

        if (!res.ok || !data.share_url) {
            throw new Error(data.error || 'Upload failed');
        }

        shareUrl = data.share_url;
        document.getElementById('shareLinkDisplay').textContent = shareUrl;
        uploadingSec.classList.add('hidden');
        shareSec.classList.remove('hidden');

    } catch (err) {
        uploadingSec.classList.add('hidden');
        previewSec.classList.remove('hidden');
        setStatus('Upload failed: ' + err.message, '#f87171');
        console.error('Upload error:', err);
    }
});

// ─── Share ─────────────────────────────────────────────────────────────────
document.getElementById('whatsappBtn').addEventListener('click', () => {
    if (!shareUrl) return;
    const msg = encodeURIComponent('Hey {{ session('friend_name', 'you') }}! 🎤 I recorded a personal voice message just for you 💜\nListen here: ' + shareUrl);
    window.open('https://api.whatsapp.com/send?text=' + msg, '_blank');
});

document.getElementById('smsBtn').addEventListener('click', () => {
    if (!shareUrl) return;
    const msg = encodeURIComponent('Hey {{ session('friend_name', 'you') }}! 🎤 I recorded a voice message just for you. Listen here: ' + shareUrl);
    window.open('sms:?&body=' + msg, '_self');
});

document.getElementById('nextPageBtn').addEventListener('click', () => {
    window.location.href = '{{ route("share") }}';
});
</script>
@endsection