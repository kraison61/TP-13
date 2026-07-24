<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <title>เข้าสู่ระบบ — ธีรพงษ์การช่าง</title>
  <link rel="icon" href="{{ config('company.favicon') }}" type="image/png" sizes="180x180">
  <link rel="apple-touch-icon" href="{{ config('company.favicon') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: { extend: {
        colors: {
          'navy-950':'#04111d','navy-900':'#071a2c','navy-800':'#0a2540','navy-700':'#0a3d62',
          'accent':'#0a3d62','hivis':'#ffc83a','ink':'#0f1722','ink2':'#36475a',
          'muted':'#6a7787','line':'#e3e7ee','surface':'#f6f8fb'
        },
        fontFamily: {
          sans:['"IBM Plex Sans Thai"','"IBM Plex Sans"','sans-serif'],
          mono:['"IBM Plex Mono"','"IBM Plex Sans"','monospace']
        }
      }}
    }
  </script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@300;400;500;600;700&family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <style>
    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:"IBM Plex Sans Thai","IBM Plex Sans",sans-serif;}
  </style>
</head>
<body class="min-h-screen bg-navy-950 text-ink antialiased">
  <div class="min-h-screen grid lg:grid-cols-2">
    <div class="relative hidden lg:flex flex-col justify-between p-10 overflow-hidden bg-navy-900">
      <div class="absolute inset-0 opacity-40" style="background:
        radial-gradient(ellipse 80% 60% at 20% 20%, rgba(10,61,98,.9), transparent 55%),
        radial-gradient(ellipse 70% 50% at 90% 80%, rgba(255,200,58,.18), transparent 50%);"></div>
      <div class="relative z-10">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-hivis grid place-items-center text-navy-900 font-bold text-lg">ท</div>
          <div>
            <div class="text-white font-semibold tracking-wide">ธีรพงษ์การช่าง</div>
            <div class="text-[10px] text-white/35 tracking-[0.12em] font-mono">ADMIN</div>
          </div>
        </div>
      </div>
      <div class="relative z-10 max-w-md">
        <h1 class="text-3xl font-bold text-white leading-snug mb-3">ระบบจัดการหลังบ้าน</h1>
        <p class="text-white/50 text-sm leading-relaxed">เข้าสู่ระบบด้วยอีเมลหรือเบอร์โทรศัพท์เพื่อจัดการบริการ ราคา และเนื้อหาเว็บไซต์</p>
      </div>
      <div class="relative z-10 text-white/25 text-xs font-mono">© {{ date('Y') }} Theeraphong</div>
    </div>

    <div class="flex items-center justify-center p-6 sm:p-10 bg-surface">
      <div class="w-full max-w-[400px]">
        <div class="lg:hidden flex items-center gap-3 mb-8">
          <div class="w-9 h-9 rounded-xl bg-hivis grid place-items-center text-navy-900 font-bold">ท</div>
          <div>
            <div class="text-navy-900 font-semibold">ธีรพงษ์การช่าง</div>
            <div class="text-[10px] text-muted tracking-[0.12em] font-mono">ADMIN</div>
          </div>
        </div>

        <h2 class="text-2xl font-bold text-navy-900 mb-1">เข้าสู่ระบบ</h2>
        <p class="text-muted text-sm mb-8">ใช้อีเมลหรือเบอร์โทรพร้อมรหัสผ่าน</p>

        @if ($errors->any())
          <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 flex items-start gap-2">
            <i class="bi bi-exclamation-circle mt-0.5"></i>
            <span>{{ $errors->first() }}</span>
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
          @csrf

          <div>
            <label for="login" class="block text-sm font-semibold text-ink2 mb-1.5">อีเมล หรือเบอร์โทร</label>
            <div class="relative">
              <i class="bi bi-person absolute left-3.5 top-1/2 -translate-y-1/2 text-muted text-sm pointer-events-none"></i>
              <input
                id="login"
                type="text"
                name="login"
                value="{{ old('login') }}"
                autocomplete="username"
                required
                autofocus
                placeholder="email@example.com หรือ 0812345678"
                class="w-full rounded-xl border border-line bg-white pl-10 pr-4 py-3 text-sm text-ink outline-none transition focus:border-navy-700"
              />
            </div>
          </div>

          <div>
            <label for="password" class="block text-sm font-semibold text-ink2 mb-1.5">รหัสผ่าน</label>
            <div class="relative">
              <i class="bi bi-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-muted text-sm pointer-events-none"></i>
              <input
                id="password"
                type="password"
                name="password"
                autocomplete="current-password"
                required
                placeholder="••••••••"
                class="w-full rounded-xl border border-line bg-white pl-10 pr-4 py-3 text-sm text-ink outline-none transition focus:border-navy-700"
              />
            </div>
          </div>

          <label class="flex items-center gap-2 text-sm text-ink2 cursor-pointer select-none">
            <input type="checkbox" name="remember" value="1" class="rounded border-line text-navy-700 focus:ring-navy-700"/>
            จดจำฉันไว้ในอุปกรณ์นี้
          </label>

          <button
            type="submit"
            class="w-full mt-2 rounded-xl bg-navy-900 hover:bg-navy-800 text-white font-semibold text-sm py-3.5 transition flex items-center justify-center gap-2"
          >
            <span>เข้าสู่ระบบ</span>
            <i class="bi bi-arrow-right"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
