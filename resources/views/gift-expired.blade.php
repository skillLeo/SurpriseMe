{{-- resources/views/gift-expired.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Expired — SurpriseMe</title>
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

        .expired-card {
            background: #FFFFFF;
            border: 1.5px solid #E6D8F4;
            border-radius: 24px;
            box-shadow: 0 6px 36px rgba(160, 80, 200, 0.10);
        }

        .icon-wrap {
            width: 80px; height: 80px; border-radius: 50%;
            background: linear-gradient(135deg, #FFF7ED, #FEF3C7);
            border: 2px solid #FDE68A;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem; margin: 0 auto 1.25rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #E91E8C, #9333EA);
            box-shadow: 0 4px 24px rgba(233, 30, 140, 0.28);
            transition: all 0.3s ease;
            display: inline-block;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 36px rgba(233, 30, 140, 0.44);
        }

        .orb { position: fixed; border-radius: 50%; filter: blur(90px); opacity: 0.055; pointer-events: none; z-index: 0; }

        @keyframes fadeInUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        .fade-in { animation: fadeInUp 0.6s ease forwards; }
    </style>
</head>
<body>
    <div class="orb w-96 h-96 bg-pink-400 top-0 left-0 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="orb w-80 h-80 bg-purple-400 bottom-0 right-0 translate-x-1/2 translate-y-1/2"></div>

    <div class="relative z-10 expired-card p-10 max-w-sm w-full text-center fade-in">

        <div class="icon-wrap">⏰</div>

        <h1 class="text-[#1C1830] font-extrabold text-2xl mb-2">Link Expired</h1>

        <p class="text-gray-500 text-sm mb-8 leading-relaxed">
            This surprise gift link has expired or is no longer valid.
            Gift links are active for <strong class="text-[#1C1830]">60 days</strong> from when they are created.
        </p>

        <a href="{{ route('welcome') }}"
            class="btn-primary text-white font-bold text-sm px-6 py-3 rounded-full no-underline">
            Create a New Surprise 🎁
        </a>

        <p class="text-gray-300 text-xs mt-8">SurpriseMe · Spread the love ✨</p>
    </div>
</body>
</html>