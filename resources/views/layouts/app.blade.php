{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SurpriseMe — Surprise Your Best Friend')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; }
        body { margin: 0; padding: 0; }

        .gradient-bg {
            background: linear-gradient(160deg, #FDFBFF 0%, #F3EAFF 55%, #FFF0F8 100%);
            min-height: 100vh;
        }

        /* ── Logo ───────────────────────────────────────── */
        .site-logo {
            font-size: 1.25rem;
            font-weight: 900;
            color: #1C1830;
            letter-spacing: -0.02em;
            text-decoration: none;
        }
        .site-logo span { color: #E91E8C; }

        /* ── Cards ──────────────────────────────────────── */
        .glass {
            background: #FFFFFF;
            border: 1.5px solid #EDE4F6;
            box-shadow: 0 2px 16px rgba(160, 80, 200, 0.07);
        }
        .glass-strong {
            background: #FFFFFF;
            border: 1.5px solid #E6D8F4;
            box-shadow: 0 4px 28px rgba(160, 80, 200, 0.10);
        }

        /* ── Buttons ────────────────────────────────────── */
        .btn-primary {
            background: linear-gradient(135deg, #E91E8C, #9333EA);
            transition: all 0.3s ease;
            box-shadow: 0 4px 24px rgba(233, 30, 140, 0.28);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 36px rgba(233, 30, 140, 0.44);
        }
        .btn-whatsapp {
            background: linear-gradient(135deg, #25D366, #128C7E);
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(37, 211, 102, 0.22);
        }
        .btn-whatsapp:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37, 211, 102, 0.38); }
        .btn-sms {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.22);
        }
        .btn-sms:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(59, 130, 246, 0.38); }

        /* ── Inputs ─────────────────────────────────────── */
        .input-field {
            background: #F8F3FD;
            border: 1.5px solid #E0D0EE;
            color: #1C1830;
            transition: all 0.3s ease;
        }
        .input-field:focus {
            outline: none;
            border-color: #E91E8C;
            background: #FEF3FA;
            box-shadow: 0 0 0 3px rgba(233, 30, 140, 0.10);
        }
        .input-field::placeholder { color: #C2B4D6; }

        /* Glass inputs (for gradient backgrounds) */
        .input-glass {
            background: rgba(255,255,255,0.18);
            border: 1.5px solid rgba(255,255,255,0.35);
            color: #ffffff;
            transition: all 0.3s ease;
        }
        .input-glass:focus {
            outline: none;
            background: rgba(255,255,255,0.26);
            border-color: rgba(255,255,255,0.70);
            box-shadow: 0 0 0 3px rgba(255,255,255,0.15);
        }
        .input-glass::placeholder { color: rgba(255,255,255,0.55); }

        /* ── Step Dots ──────────────────────────────────── */
        .step-dot {
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.25);
            border: 1.5px solid rgba(255,255,255,0.40);
            color: rgba(255,255,255,0.70);
        }
        .step-dot.active {
            background: #ffffff;
            border-color: transparent;
            color: #E91E8C;
            transform: scale(1.15);
            box-shadow: 0 4px 18px rgba(0,0,0,0.18);
        }
        .step-dot.done {
            background: rgba(255,255,255,0.35);
            border-color: rgba(255,255,255,0.50);
            color: rgba(255,255,255,0.90);
        }

        /* Light step dots (for white backgrounds) */
        .step-dot-light {
            transition: all 0.3s ease;
            background: #F4EDF9;
            border: 1.5px solid #E0D0EE;
            color: #B8A8CC;
        }
        .step-dot-light.active {
            background: linear-gradient(135deg, #E91E8C, #9333EA);
            border-color: transparent;
            color: #FFFFFF;
            transform: scale(1.15);
            box-shadow: 0 4px 18px rgba(233, 30, 140, 0.38);
        }
        .step-dot-light.done {
            background: linear-gradient(135deg, #E91E8C, #9333EA);
            border-color: transparent;
            color: #FFFFFF;
        }

        /* ── Brand Gradient Text ────────────────────────── */
        .glow-text {
            background: linear-gradient(135deg, #E91E8C, #9333EA);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Animations ─────────────────────────────────── */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-10px); }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 4px 24px rgba(233, 30, 140, 0.35); }
            50%       { box-shadow: 0 8px 50px rgba(233, 30, 140, 0.65), 0 0 70px rgba(147, 51, 234, 0.30); }
        }
        @keyframes ripple {
            0%   { transform: scale(1); opacity: 1; }
            100% { transform: scale(2.5); opacity: 0; }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .float-anim  { animation: float 3s ease-in-out infinite; }
        .pulse-glow  { animation: pulse-glow 2s ease-in-out infinite; }
        .ripple-ring {
            position: absolute; border-radius: 50%;
            border: 2px solid rgba(233, 30, 140, 0.35);
            animation: ripple 1.5s ease-out infinite;
        }
        .fade-in-up { animation: fadeInUp 0.6s ease forwards; }
        .delay-1 { animation-delay: 0.10s; opacity: 0; }
        .delay-2 { animation-delay: 0.20s; opacity: 0; }
        .delay-3 { animation-delay: 0.30s; opacity: 0; }
        .delay-4 { animation-delay: 0.40s; opacity: 0; }

        /* ── Background Orbs ────────────────────────────── */
        .orb {
            position: fixed; border-radius: 50%;
            filter: blur(90px); opacity: 0.055;
            pointer-events: none; z-index: 0;
        }
    </style>
    @yield('styles')
</head>
<body class="gradient-bg">
    <div class="orb w-96 h-96 bg-pink-400 top-0 left-0 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="orb w-80 h-80 bg-purple-500 bottom-0 right-0 translate-x-1/2 translate-y-1/2"></div>
    <div class="orb w-72 h-72 bg-fuchsia-300 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>

    <div class="relative z-10">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>