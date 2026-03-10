<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Surprise Gift 🎁 — SurpriseMe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body {
            background: linear-gradient(135deg, #0f0524 0%, #1a0537 40%, #12022e 70%, #200040 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 1.5rem;
        }
        .glass {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.14);
        }
        .glass-strong {
            background: rgba(255,255,255,0.11);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255,255,255,0.18);
        }
        .btn-primary {
            background: linear-gradient(135deg, #e91e8c, #9333ea);
            box-shadow: 0 4px 30px rgba(233,30,140,0.45);
            transition: all 0.3s ease;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 40px rgba(233,30,140,0.65); }
        .glow-text {
            background: linear-gradient(135deg, #f472b6, #a855f7, #e91e8c);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        @keyframes fadeInUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
        .float { animation: float 3s ease-in-out infinite; }
        .fade-in { animation: fadeInUp 0.6s ease forwards; }
        .d1 { animation-delay:0.1s; opacity:0; }
        .d2 { animation-delay:0.25s; opacity:0; }
        .d3 { animation-delay:0.4s; opacity:0; }
        .d4 { animation-delay:0.55s; opacity:0; }
        .orb { position:fixed; border-radius:50%; filter:blur(80px); opacity:0.13; pointer-events:none; z-index:0; }
        .gift-box {
            width:120px; height:120px;
            background: linear-gradient(135deg,#e91e8c22,#9333ea22);
            border: 2px solid rgba(233,30,140,0.3);
            border-radius:20px;
            display:flex; align-items:center; justify-content:center;
            margin:0 auto 1.5rem; font-size:3.5rem;
        }
        .tag-ribbon {
            position:absolute; top:-14px; left:50%; transform:translateX(-50%);
            background: linear-gradient(135deg,#e91e8c,#9333ea);
            color:white; font-size:11px; font-weight:700;
            padding:4px 16px; border-radius:20px; white-space:nowrap;
            box-shadow: 0 4px 15px rgba(233,30,140,0.4);
        }
        .shop-card {
            background: linear-gradient(135deg, rgba(233,30,140,0.12), rgba(147,51,234,0.12));
            border: 1px solid rgba(233,30,140,0.25);
            border-radius:16px; padding:1.25rem;
            transition:all 0.3s ease; cursor:pointer;
            text-decoration:none; display:block;
        }
        .shop-card:hover {
            transform:translateY(-3px);
            border-color:rgba(233,30,140,0.5);
            box-shadow:0 8px 30px rgba(233,30,140,0.2);
        }
        .coming-soon-badge {
            background: linear-gradient(135deg, rgba(255,165,0,0.15), rgba(255,100,0,0.15));
            border: 1px solid rgba(255,165,0,0.3);
            border-radius:16px; padding:1.25rem;
        }
    </style>
</head>
<body>
    <div class="orb w-96 h-96 bg-pink-500 top-0 left-0 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="orb w-80 h-80 bg-purple-600 bottom-0 right-0 translate-x-1/2 translate-y-1/2"></div>

    <div class="relative z-10 w-full max-w-md">

        <div class="text-center mb-6 fade-in">
            <div class="gift-box float">🎁</div>
            <h1 class="text-3xl md:text-4xl font-900 text-white mb-2">
                Hey <span class="glow-text">{{ $recipientName }}</span>! 🎉
            </h1>
            <p class="text-white/60 text-sm leading-relaxed">
                <strong class="text-pink-400">{{ $senderName }}</strong> is planning a surprise just for you.<br>
                Your exclusive gift shopping link is below — shop something special!
            </p>
        </div>

        <div class="glass-strong rounded-2xl p-6 mb-4 fade-in d1 relative">
            <div class="tag-ribbon">🎀 Just For You</div>
            <div class="mt-3">
                <p class="text-white/50 text-xs font-600 uppercase tracking-widest mb-3">Your Surprise Gift Link</p>

                @if($shopUrl)
                    <a href="{{ $shopUrl }}" class="shop-card" target="_blank">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center text-2xl flex-shrink-0">
                                🛍️
                            </div>
                            <div>
                                <p class="text-white font-700 text-sm">Browse Surprise Gifts</p>
                                <p class="text-white/40 text-xs mt-0.5">Exclusive link — valid 60 days</p>
                            </div>
                            <svg class="w-5 h-5 text-pink-400 ml-auto flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </div>
                    </a>
                @else
                    <div class="coming-soon-badge flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-2xl flex-shrink-0">
                            ⏳
                        </div>
                        <div>
                            <p class="text-white font-700 text-sm">Gift Shop — Coming Soon!</p>
                            <p class="text-orange-300/70 text-xs mt-0.5">Your gift link will be activated shortly</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="glass rounded-xl p-4 mb-6 fade-in d2">
            <div class="flex items-start gap-3">
                <span class="text-lg mt-0.5">🤫</span>
                <p class="text-white/50 text-xs leading-relaxed">
                    This is a surprise — <strong class="text-pink-400">{{ $senderName }}</strong> has their own separate link so neither of you can see what the other is shopping for. The element of surprise is part of the fun!
                </p>
            </div>
        </div>

        <div class="text-center fade-in d3">
            <p class="text-white/30 text-xs mb-3">Want to surprise YOUR best friend too?</p>
            <a href="{{ route('welcome') }}" class="btn-primary inline-flex items-center gap-2 text-white font-700 text-sm px-6 py-3 rounded-full no-underline">
                Start Your Own Surprise 🎁
            </a>
        </div>

        <p class="text-center text-white/20 text-xs mt-6 fade-in d4">SurpriseMe · Spread the love ✨</p>
    </div>
</body>
</html>