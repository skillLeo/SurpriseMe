{{-- resources/views/gift.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Surprise Gift 🎁 — SurpriseMe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; }

        body {
            background: linear-gradient(160deg, #FDFBFF 0%, #F3EAFF 55%, #FFF0F8 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 1.5rem;
        }

        /* ── Cards ── */
        .card {
            background: #FFFFFF;
            border: 1.5px solid #E6D8F4;
            border-radius: 20px;
            box-shadow: 0 4px 28px rgba(160, 80, 200, 0.10);
        }
        .card-inner {
            background: #FFFFFF;
            border: 1.5px solid #EDE4F6;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(160, 80, 200, 0.07);
        }

        /* ── Brand text ── */
        .glow-text {
            background: linear-gradient(135deg, #E91E8C, #9333EA);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── CTA button ── */
        .btn-primary {
            background: linear-gradient(135deg, #E91E8C, #9333EA);
            box-shadow: 0 4px 24px rgba(233, 30, 140, 0.28);
            transition: all 0.3s ease;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 36px rgba(233, 30, 140, 0.44); }

        /* ── Gift box icon ── */
        .gift-box {
            width: 110px; height: 110px;
            background: linear-gradient(135deg, #FFF0F8, #F3EAFF);
            border: 2px solid #F0DDF8;
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem; font-size: 3.2rem;
            box-shadow: 0 4px 20px rgba(233, 30, 140, 0.12);
        }

        /* ── Ribbon label ── */
        .tag-ribbon {
            position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
            background: linear-gradient(135deg, #E91E8C, #9333EA);
            color: white; font-size: 11px; font-weight: 700;
            padding: 4px 16px; border-radius: 20px; white-space: nowrap;
            box-shadow: 0 4px 14px rgba(233, 30, 140, 0.32);
        }

        /* ── Shop link card ── */
        .shop-card {
            background: linear-gradient(135deg, #FFF5FB, #F8F0FF);
            border: 1.5px solid #F0DDF8;
            border-radius: 14px; padding: 1.1rem;
            transition: all 0.3s ease; cursor: pointer;
            text-decoration: none; display: block;
        }
        .shop-card:hover {
            transform: translateY(-3px);
            border-color: rgba(233, 30, 140, 0.35);
            box-shadow: 0 8px 28px rgba(233, 30, 140, 0.14);
        }

        /* ── Coming soon badge ── */
        .coming-soon-badge {
            background: linear-gradient(135deg, #fffbeb, #fef3c7);
            border: 1.5px solid #fde68a;
            border-radius: 14px; padding: 1.1rem;
        }

        /* ── Orbs ── */
        .orb { position: fixed; border-radius: 50%; filter: blur(90px); opacity: 0.055; pointer-events: none; z-index: 0; }

        /* ── Animations ── */
        @keyframes float   { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        @keyframes fadeInUp{ from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
        .float   { animation: float 3s ease-in-out infinite; }
        .fade-in { animation: fadeInUp 0.6s ease forwards; }
        .d1 { animation-delay: 0.10s; opacity: 0; }
        .d2 { animation-delay: 0.25s; opacity: 0; }
        .d3 { animation-delay: 0.40s; opacity: 0; }
        .d4 { animation-delay: 0.55s; opacity: 0; }
    </style>
</head>
<body>
    <div class="orb w-96 h-96 bg-pink-400 top-0 left-0 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="orb w-80 h-80 bg-purple-400 bottom-0 right-0 translate-x-1/2 translate-y-1/2"></div>

    <div class="relative z-10 w-full max-w-md">

        {{-- Hero --}}
        <div class="text-center mb-6 fade-in">
            <div class="gift-box float">🎁</div>
            <h1 class="text-3xl md:text-4xl font-black text-[#1C1830] mb-2">
                Hey <span class="glow-text">{{ $recipientName }}</span>! 🎉
            </h1>
            <p class="text-gray-500 text-sm leading-relaxed">
                <strong class="text-pink-600">{{ $senderName }}</strong> is planning a surprise just for you.<br>
                Your exclusive gift shopping link is below — shop something special!
            </p>
        </div>

        {{-- Gift link card --}}
        <div class="card p-6 mb-4 fade-in d1 relative">
            <div class="tag-ribbon">🎀 Just For You</div>
            <div class="mt-3">
                <p class="text-gray-400 text-xs font-semibold uppercase tracking-widest mb-3">Your Surprise Gift Link</p>

                @if($shopUrl)
                    <a href="{{ $shopUrl }}" class="shop-card" target="_blank">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center text-2xl flex-shrink-0">
                                🛍️
                            </div>
                            <div>
                                <p class="text-[#1C1830] font-bold text-sm">Browse Surprise Gifts</p>
                                <p class="text-gray-400 text-xs mt-0.5">Exclusive link — valid 60 days</p>
                            </div>
                            <svg class="w-5 h-5 text-pink-500 ml-auto flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </div>
                    </a>
                @else
                    <div class="coming-soon-badge flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-2xl flex-shrink-0">
                            ⏳
                        </div>
                        <div>
                            <p class="text-[#1C1830] font-bold text-sm">Gift Shop — Coming Soon!</p>
                            <p class="text-amber-600 text-xs mt-0.5">Your gift link will be activated shortly</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Secret note --}}
        <div class="card-inner p-4 mb-6 fade-in d2">
            <div class="flex items-start gap-3">
                <span class="text-lg mt-0.5">🤫</span>
                <p class="text-gray-500 text-xs leading-relaxed">
                    This is a surprise — <strong class="text-pink-600">{{ $senderName }}</strong> has their own
                    separate link so neither of you can see what the other is shopping for.
                    The element of surprise is part of the fun!
                </p>
            </div>
        </div>

        {{-- CTA --}}
        <div class="text-center fade-in d3">
            <p class="text-gray-400 text-xs mb-3">Want to surprise YOUR best friend too?</p>
            <a href="{{ route('welcome') }}"
                class="btn-primary inline-flex items-center gap-2 text-white font-bold text-sm px-6 py-3 rounded-full no-underline">
                Start Your Own Surprise 🎁
            </a>
        </div>

        <p class="text-center text-gray-300 text-xs mt-6 fade-in d4">SurpriseMe · Spread the love ✨</p>
    </div>
</body>
</html>