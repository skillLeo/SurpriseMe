<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Expired — SurpriseMe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body {
            background: linear-gradient(135deg, #0f0524, #1a0537, #0d0320);
            min-height: 100vh; display: flex; align-items: center;
            justify-content: center; padding: 1.5rem;
        }
        .glass {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.13);
        }
    </style>
</head>
<body>
    <div class="glass rounded-2xl p-10 max-w-sm w-full text-center">
        <div class="text-5xl mb-4">⏰</div>
        <h1 class="text-white font-800 text-2xl mb-2">Link Expired</h1>
        <p class="text-white/50 text-sm mb-6">This surprise gift link has expired or is no longer valid. Gift links are active for 60 days from when they are created.</p>
        <a href="{{ route('welcome') }}" class="inline-block bg-gradient-to-r from-pink-500 to-purple-600 text-white font-700 text-sm px-6 py-3 rounded-full no-underline">
            Create a New Surprise 🎁
        </a>
    </div>
</body>
</html>