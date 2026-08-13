<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Smart UMKM POS') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css">

    <style>
        body{
            margin:0;
            padding:0;
            background: linear-gradient(135deg,#f8fafc,#eef2ff,#ffffff);
            font-family: 'Segoe UI', sans-serif;
        }

        .welcome-shell{
            min-height:100vh;
            display:flex;
            align-items:center;
        }

        .welcome-badge{
            display:inline-block;
            padding:10px 20px;
            border-radius:999px;
            background:rgba(79,70,229,.1);
            color:#4f46e5;
            font-weight:600;
        }

        .hero-title{
            font-size:3rem;
            font-weight:800;
            line-height:1.2;
            color:#111827;
        }

        .hero-subtitle{
            font-size:1.15rem;
            color:#6b7280;
        }

        .btn-brand{
            background:#4f46e5;
            color:white;
            border:none;
            padding:12px 28px;
            border-radius:12px;
            font-weight:600;
        }

        .btn-brand:hover{
            background:#4338ca;
            color:white;
        }

        .feature-card{
            background:white;
            border:none;
            border-radius:20px;
            padding:25px;
            text-align:center;
            box-shadow:0 10px 30px rgba(0,0,0,.08);
            transition:.3s;
            height:100%;
        }

        .feature-card:hover{
            transform:translateY(-8px);
        }

        .feature-icon{
            width:70px;
            height:70px;
            display:flex;
            align-items:center;
            justify-content:center;
            margin:auto;
            border-radius:20px;
            background:#eef2ff;
            color:#4f46e5;
            font-size:30px;
        }

        .preview-card{
            background:white;
            border-radius:25px;
            padding:30px;
            box-shadow:0 15px 40px rgba(0,0,0,.1);
        }

        .dashboard-preview{
            width:100%;
            aspect-ratio:4/3;
            object-fit:cover;
            border-radius:15px;
        }

        .section-title{
            font-weight:700;
            color:#111827;
        }

        .section-text{
            color:#6b7280;
        }

        .help-chatbot-toggle{
            position:fixed;
            right:24px;
            bottom:24px;
            z-index:1050;
            width:58px;
            height:58px;
            border:0;
            border-radius:50%;
            background:linear-gradient(135deg,#4f46e5,#2563eb);
            color:#fff;
            font-size:1.45rem;
            box-shadow:0 12px 28px rgba(79,70,229,.35);
            transition:transform .2s ease, box-shadow .2s ease;
        }

        .help-chatbot-toggle:hover{
            transform:translateY(-3px);
            box-shadow:0 16px 32px rgba(79,70,229,.42);
        }

        .help-chatbot{
            position:fixed;
            right:24px;
            bottom:94px;
            z-index:1050;
            display:flex;
            flex-direction:column;
            width:min(370px,calc(100vw - 32px));
            overflow:hidden;
            border:1px solid #e0e7ff;
            border-radius:20px;
            background:#fff;
            box-shadow:0 18px 48px rgba(15,23,42,.2);
            opacity:0;
            pointer-events:none;
            transform:translateY(12px) scale(.98);
            transform-origin:bottom right;
            transition:opacity .2s ease, transform .2s ease;
        }

        .help-chatbot.is-open{
            opacity:1;
            pointer-events:auto;
            transform:translateY(0) scale(1);
        }

        .help-chatbot__header{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:1rem;
            padding:1rem 1.15rem;
            background:linear-gradient(135deg,#4f46e5,#2563eb);
            color:#fff;
        }

        .help-chatbot__header p{ margin:0; color:rgba(255,255,255,.82); font-size:.8rem; }
        .help-chatbot__close{ border:0; background:transparent; color:#fff; font-size:1.2rem; }
        .help-chatbot__messages{ display:flex; flex-direction:column; gap:.7rem; min-height:210px; max-height:290px; overflow-y:auto; padding:1rem; background:#f8fafc; }
        .help-chatbot__message{ max-width:90%; padding:.7rem .8rem; border-radius:14px; font-size:.87rem; line-height:1.5; }
        .help-chatbot__message--bot{ align-self:flex-start; border-bottom-left-radius:4px; background:#e0e7ff; color:#1e1b4b; }
        .help-chatbot__message a{ color:#3730a3; font-weight:700; }
        .help-chatbot__quick-actions{ display:flex; flex-wrap:wrap; gap:.45rem; padding:.8rem 1rem; border-top:1px solid #e5e7eb; }
        .help-chatbot__quick-action{ border:1px solid #c7d2fe; border-radius:999px; background:#fff; color:#4338ca; padding:.38rem .65rem; font-size:.76rem; font-weight:600; }
        .help-chatbot__form{ display:flex; gap:.5rem; padding:.75rem 1rem 1rem; }
        .help-chatbot__input{ min-width:0; flex:1; border:1px solid #cbd5e1; border-radius:10px; padding:.55rem .7rem; font-size:.85rem; }
        .help-chatbot__send{ border:0; border-radius:10px; background:#4f46e5; color:#fff; padding:0 .8rem; }

        @media(max-width:768px){
            .welcome-shell{
                align-items:flex-start;
            }

            .welcome-shell .container{
                padding-top:2.5rem !important;
                padding-bottom:2.5rem !important;
            }

            .hero-title{
                font-size:2rem;
            }

            .hero-subtitle{
                font-size:1rem;
            }

            .preview-card{
                padding:1rem;
                border-radius:18px;
            }

            .feature-card{
                padding:1.25rem;
            }

            .help-chatbot-toggle{ right:16px; bottom:16px; }
            .help-chatbot{ right:16px; bottom:86px; }
        }

        @media(max-width:420px){
            .hero-title{
                font-size:1.7rem;
            }

            .welcome-badge{
                padding:8px 14px;
                font-size:.9rem;
            }

            .welcome-shell .btn{
                width:100%;
            }
        }
    </style>
</head>
<body>

<div class="welcome-shell">
    <div class="container py-5">

        <div class="row align-items-center g-5">

            <div class="col-lg-6">

                <div class="welcome-badge mb-4">
                    🏪 POS khusus warung sembako
                </div>

                <h1 class="hero-title">
                    Kelola Warung Sembako Lebih Rapi, Cepat, dan Untung
                </h1>

                <p class="hero-subtitle mt-4">
                    Smart UMKM POS membantu pemilik warung sembako mencatat
                    penjualan, memantau stok barang harian, dan melihat
                    keuntungan usaha dalam satu aplikasi yang mudah digunakan.
                </p>

                <div class="d-flex flex-wrap gap-3 mt-4">

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-brand">
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-brand">
                                Masuk
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                    Daftar Sekarang
                                </a>
                            @endif
                        @endauth
                    @endif

                </div>

            </div>

            <div class="col-lg-6">

                <div class="preview-card">

                   <img
    src="{{ asset('images/warung.jpg') }}"
    class="dashboard-preview"
    alt="Warung sembako yang menggunakan Smart UMKM POS">

                    <div class="text-center mt-4">
                        <h4 class="section-title">
                            Partner Digital untuk Warung Anda
                        </h4>

                        <p class="section-text mb-0">
                            Fokus melayani pelanggan, biarkan pencatatan
                            transaksi dan stok kami bantu rapikan.
                        </p>
                    </div>

                </div>

            </div>

        </div>

        <div class="row mt-5 g-4">

            <div class="col-md-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <h5 class="mt-3">Kasir Digital</h5>
                    <p class="text-muted mb-0">
                        Layani belanja harian dengan cepat dan minim salah hitung.
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h5 class="mt-3">Stok Sembako</h5>
                    <p class="text-muted mb-0">
                        Pantau beras, minyak, gula, dan barang dagangan lainnya.
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h5 class="mt-3">Pelanggan Langganan</h5>
                    <p class="text-muted mb-0">
                        Simpan data pelanggan agar pelayanan lebih personal.
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h5 class="mt-3">Laporan Penjualan</h5>
                    <p class="text-muted mb-0">
                        Ketahui omzet dan perkembangan warung setiap hari.
                    </p>
                </div>
            </div>

        </div>

    </div>
</div>

<button type="button" class="help-chatbot-toggle" id="helpChatToggle" aria-label="Buka Asisten AI" aria-expanded="false" aria-controls="helpChatbot">
    <i class="bi bi-chat-dots-fill"></i>
</button>

<section class="help-chatbot" id="helpChatbot" aria-label="Asisten AI panduan masuk dan daftar" aria-hidden="true">
    <div class="help-chatbot__header">
        <div>
            <strong><i class="bi bi-robot me-1"></i>Asisten AI</strong>
            <p>Panduan masuk dan daftar akun</p>
        </div>
        <button type="button" class="help-chatbot__close" id="helpChatClose" aria-label="Tutup bantuan"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="help-chatbot__messages" id="helpChatMessages" aria-live="polite">
        <div class="help-chatbot__message help-chatbot__message--bot">Halo! Saya dapat membantu Anda mengetahui cara masuk atau membuat akun. Silakan pilih pertanyaan di bawah.</div>
    </div>
    <div class="help-chatbot__quick-actions">
        <button type="button" class="help-chatbot__quick-action" data-help-topic="login">Cara masuk</button>
        <button type="button" class="help-chatbot__quick-action" data-help-topic="register">Cara daftar</button>
        <button type="button" class="help-chatbot__quick-action" data-help-topic="password">Lupa kata sandi</button>
    </div>
    <form class="help-chatbot__form" id="helpChatForm">
        <input class="help-chatbot__input" id="helpChatInput" type="text" placeholder="Tulis pertanyaan Anda..." aria-label="Pertanyaan bantuan">
        <button type="submit" class="help-chatbot__send" aria-label="Kirim pertanyaan"><i class="bi bi-send-fill"></i></button>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatbot = document.getElementById('helpChatbot');
        const toggle = document.getElementById('helpChatToggle');
        const close = document.getElementById('helpChatClose');
        const form = document.getElementById('helpChatForm');
        const input = document.getElementById('helpChatInput');
        const messages = document.getElementById('helpChatMessages');
        const loginUrl = @json(Route::has('login') ? route('login') : '#');
        const registerUrl = @json(Route::has('register') ? route('register') : '#');
        const passwordUrl = @json(Route::has('password.request') ? route('password.request') : '#');

        function setOpen(isOpen) {
            chatbot.classList.toggle('is-open', isOpen);
            chatbot.setAttribute('aria-hidden', String(!isOpen));
            toggle.setAttribute('aria-expanded', String(isOpen));
            if (isOpen) input.focus();
        }

        function addReply(topic) {
            const replies = {
                login: 'Untuk masuk: tekan tombol <a href="' + loginUrl + '">Masuk</a>, lalu isi email dan kata sandi yang dipakai saat mendaftar. Setelah itu tekan tombol masuk.',
                register: 'Untuk membuat akun: tekan <a href="' + registerUrl + '">Daftar Sekarang</a>, isi nama, email, kata sandi, serta konfirmasi kata sandi. Setelah lengkap, tekan tombol Daftar Sekarang.',
                password: 'Jika lupa kata sandi, buka halaman <a href="' + passwordUrl + '">Lupa kata sandi</a>, masukkan email Anda, lalu ikuti tautan pemulihan yang dikirim ke email tersebut.',
                default: 'Saya dapat membantu panduan <strong>cara masuk</strong>, <strong>cara daftar</strong>, atau <strong>lupa kata sandi</strong>. Silakan pilih salah satu tombol di atas.'
            };
            const message = document.createElement('div');
            message.className = 'help-chatbot__message help-chatbot__message--bot';
            message.innerHTML = replies[topic] || replies.default;
            messages.appendChild(message);
            messages.scrollTop = messages.scrollHeight;
        }

        toggle.addEventListener('click', () => setOpen(!chatbot.classList.contains('is-open')));
        close.addEventListener('click', () => setOpen(false));
        document.querySelectorAll('[data-help-topic]').forEach(button => button.addEventListener('click', () => addReply(button.dataset.helpTopic)));
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            const question = input.value.trim().toLowerCase();
            if (!question) return;
            input.value = '';
            addReply(question.includes('daftar') || question.includes('register') || question.includes('buat akun') ? 'register' : question.includes('lupa') || question.includes('sandi') || question.includes('password') ? 'password' : question.includes('masuk') || question.includes('login') ? 'login' : 'default');
        });
    });
</script>

</body>
</html>
