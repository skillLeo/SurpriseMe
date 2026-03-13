{{-- resources/views/listen.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Message For You 💜</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; }

        body {
            background: linear-gradient(160deg, #FDFBFF 0%, #F3EAFF 55%, #FFF0F8 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 1.5rem;
        }

        /* ── Player card ── */
        .player-card {
            background: #FFFFFF;
            border: 1.5px solid #E6D8F4;
            border-radius: 24px;
            box-shadow: 0 6px 36px rgba(160, 80, 200, 0.12);
        }

        /* ── Play button ── */
        .play-btn {
            width: 88px; height: 88px; border-radius: 50%;
            background: linear-gradient(135deg, #E91E8C, #9333EA);
            border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 36px rgba(233, 30, 140, 0.40);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .play-btn:hover  { transform: scale(1.08); box-shadow: 0 12px 50px rgba(233, 30, 140, 0.60); }
        .play-btn:active { transform: scale(0.97); }

        /* ── Progress bar ── */
        .progress-track {
            flex: 1; height: 6px;
            background: #EDE4F6;
            border-radius: 6px; cursor: pointer; position: relative;
        }
        .progress-fill {
            height: 100%; border-radius: 6px; width: 0%;
            background: linear-gradient(90deg, #E91E8C, #9333EA);
            pointer-events: none; transition: width 0.08s linear;
        }

        /* ── Progress bg ── */
        .progress-bg {
            background: #F8F3FD;
            border: 1.5px solid #EDE4F6;
            border-radius: 16px;
        }

        /* ── Orbs ── */
        .orb { position: fixed; border-radius: 50%; filter: blur(90px); opacity: 0.055; pointer-events: none; z-index: 0; }

        /* ── Animations ── */
        @keyframes float  { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        @keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        .float   { animation: float 3s ease-in-out infinite; }
        .fade-up { animation: fadeUp 0.5s ease forwards; }
        .d1 { animation-delay: .10s; opacity: 0; }
        .d2 { animation-delay: .25s; opacity: 0; }
        .d3 { animation-delay: .40s; opacity: 0; }
    </style>
</head>
<body>
    <div class="orb w-96 h-96 bg-pink-400 top-0 left-0 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="orb w-80 h-80 bg-purple-400 bottom-0 right-0 translate-x-1/2 translate-y-1/2"></div>

    <div class="relative z-10 player-card p-8 max-w-sm w-full text-center">

        <div class="text-5xl mb-5 float">💜</div>

        <h1 class="text-[#1C1830] font-extrabold text-2xl mb-2 fade-up">A Message For You</h1>
        <p class="text-gray-500 text-sm mb-8 leading-relaxed fade-up d1">
            Someone recorded a personal voice note just for you.<br>Press play to listen.
        </p>

        <audio id="player" src="{{ $audioUrl }}" preload="auto"></audio>

        {{-- Play button --}}
        <div class="flex justify-center mb-6 fade-up d2">
            <button class="play-btn" id="playBtn" onclick="togglePlay()">
                <svg id="iconPlay" class="w-9 h-9 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
                <svg id="iconPause" class="w-8 h-8 text-white hidden" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                </svg>
            </button>
        </div>

        {{-- Progress + time --}}
        <div class="progress-bg px-4 py-4 mb-2 fade-up d3">
            <div class="flex items-center gap-3">
                <span class="text-gray-400 text-xs tabular-nums w-10 text-right shrink-0" id="lblCurrent">--:--</span>
                <div class="progress-track" id="track">
                    <div class="progress-fill" id="fill"></div>
                </div>
                <span class="text-gray-400 text-xs tabular-nums w-10 shrink-0" id="lblDuration">--:--</span>
            </div>
            <p class="text-gray-400 text-xs mt-3" id="statusLabel">Tap play to listen ▶</p>
        </div>

        <p class="text-gray-300 text-xs mt-5">Sent with 💜 via SurpriseMe</p>
    </div>

<script>
const player    = document.getElementById('player');
const iconPlay  = document.getElementById('iconPlay');
const iconPause = document.getElementById('iconPause');
const lblCur    = document.getElementById('lblCurrent');
const lblDur    = document.getElementById('lblDuration');
const fill      = document.getElementById('fill');
const status    = document.getElementById('statusLabel');
const track     = document.getElementById('track');

let durationKnown  = false;
let realDuration   = 0;
let seekingForDur  = false;

function fmt(s) {
    if (!isFinite(s) || s < 0) return '--:--';
    s = Math.floor(s);
    return Math.floor(s / 60) + ':' + String(s % 60).padStart(2, '0');
}

function getDur() {
    const d = player.duration;
    return (isFinite(d) && d > 0) ? d : realDuration;
}

function tryResolveDuration() {
    const d = player.duration;
    if (isFinite(d) && d > 0) {
        durationKnown = true;
        realDuration  = d;
        lblDur.textContent = fmt(d);
        return;
    }
    seekingForDur = true;
    player.currentTime = 1e101;
}

player.addEventListener('durationchange', () => {
    const d = player.duration;
    if (isFinite(d) && d > 0) {
        durationKnown = true;
        realDuration  = d;
        lblDur.textContent = fmt(d);
        if (seekingForDur) {
            seekingForDur = false;
            player.currentTime = 0;
        }
    }
});

player.addEventListener('loadedmetadata', () => { tryResolveDuration(); });
player.addEventListener('canplaythrough', () => { if (!durationKnown) tryResolveDuration(); });

player.addEventListener('timeupdate', () => {
    if (seekingForDur) return;
    const dur = getDur();
    lblCur.textContent = fmt(player.currentTime);
    if (dur > 0) {
        fill.style.width   = Math.min((player.currentTime / dur) * 100, 100) + '%';
        lblDur.textContent = fmt(dur);
    }
});

player.addEventListener('ended', () => {
    iconPlay.classList.remove('hidden');
    iconPause.classList.add('hidden');
    fill.style.width   = '0%';
    lblCur.textContent = '--:--';
    status.textContent = 'Tap play to listen ▶';
    status.style.color = '';
});

player.addEventListener('error', () => {
    status.textContent = 'Could not load audio.';
    status.style.color = '#f87171';
});

function togglePlay() {
    if (player.paused) {
        if (seekingForDur) {
            seekingForDur = false;
            player.currentTime = 0;
        }
        player.play().then(() => {
            iconPlay.classList.add('hidden');
            iconPause.classList.remove('hidden');
            lblCur.textContent = fmt(player.currentTime);
            status.textContent = 'Playing...';
        }).catch(() => {
            status.textContent = 'Playback failed.';
            status.style.color = '#f87171';
        });
    } else {
        player.pause();
        iconPlay.classList.remove('hidden');
        iconPause.classList.add('hidden');
        status.textContent = 'Paused';
    }
}

track.addEventListener('click', function(e) {
    const dur = getDur();
    if (dur <= 0) return;
    player.currentTime = ((e.clientX - this.getBoundingClientRect().left) / this.offsetWidth) * dur;
});
</script>
</body>
</html>