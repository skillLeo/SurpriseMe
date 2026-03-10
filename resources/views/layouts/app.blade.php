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
            background: linear-gradient(135deg, #0f0524 0%, #1a0537 40%, #12022e 70%, #200040 100%);
            min-height: 100vh;
        }
        .glass {
            background: rgba(255,255,255,0.07);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.12);
        }
        .glass-strong {
            background: rgba(255,255,255,0.10);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255,255,255,0.18);
        }
        .btn-primary {
            background: linear-gradient(135deg, #e91e8c, #9333ea);
            transition: all 0.3s ease;
            box-shadow: 0 4px 30px rgba(233,30,140,0.4);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 40px rgba(233,30,140,0.6);
        }
        .btn-whatsapp {
            background: linear-gradient(135deg, #25D366, #128C7E);
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(37,211,102,0.3);
        }
        .btn-whatsapp:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(37,211,102,0.5); }
        .btn-sms {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(59,130,246,0.3);
        }
        .btn-sms:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(59,130,246,0.5); }
        .input-field {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            transition: all 0.3s ease;
        }
        .input-field:focus {
            outline: none;
            border-color: #e91e8c;
            background: rgba(255,255,255,0.12);
            box-shadow: 0 0 0 3px rgba(233,30,140,0.2);
        }
        .input-field::placeholder { color: rgba(255,255,255,0.4); }
        .step-dot { transition: all 0.3s ease; }
        .step-dot.active { background: linear-gradient(135deg, #e91e8c, #9333ea); transform: scale(1.2); }
        .glow-text {
            background: linear-gradient(135deg, #f472b6, #a855f7, #e91e8c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(233,30,140,0.4); }
            50% { box-shadow: 0 0 50px rgba(233,30,140,0.8), 0 0 80px rgba(147,51,234,0.4); }
        }
        @keyframes ripple {
            0% { transform: scale(1); opacity: 1; }
            100% { transform: scale(2.5); opacity: 0; }
        }
        .float-anim { animation: float 3s ease-in-out infinite; }
        .pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
        .ripple-ring {
            position: absolute;
            border-radius: 50%;
            border: 2px solid rgba(233,30,140,0.6);
            animation: ripple 1.5s ease-out infinite;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up { animation: fadeInUp 0.6s ease forwards; }
        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
        .delay-4 { animation-delay: 0.4s; opacity: 0; }
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            pointer-events: none;
            z-index: 0;
        }
    </style>
    @yield('styles')
</head>
<body class="gradient-bg">
    <div class="orb w-96 h-96 bg-pink-500 top-0 left-0 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="orb w-80 h-80 bg-purple-600 bottom-0 right-0 translate-x-1/2 translate-y-1/2"></div>
    <div class="orb w-64 h-64 bg-indigo-500 top-1/2 left-1/2"></div>

    <div class="relative z-10">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>