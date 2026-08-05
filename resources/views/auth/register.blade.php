<x-guest-layout>

<div class="register-wrapper">

    <div class="register-card">

        <div class="register-header text-center">
            <div class="register-logo">
                <i class="bi bi-robot"></i>
            </div>

            <h2 class="fw-bold mt-3">
                Buat Akun Smart UMKM AI
            </h2>

            <p>
                Kelola penjualan, stok, dan analisis bisnis dengan bantuan AI.
            </p>
        </div>


        <form method="POST" action="{{ route('register') }}" class="mt-4">
            @csrf


            <div class="form-group mb-3">
                <label for="name">
                    <i class="bi bi-person me-2"></i>
                    Nama Lengkap
                </label>

                <input 
                    id="name"
                    class="form-control"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama Anda"
                    required
                    autofocus
                >

                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>



            <div class="form-group mb-3">
                <label for="email">
                    <i class="bi bi-envelope me-2"></i>
                    Email
                </label>

                <input 
                    id="email"
                    class="form-control"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="contoh@email.com"
                    required
                >

                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>



            <div class="form-group mb-3">
                <label for="password">
                    <i class="bi bi-lock me-2"></i>
                    Password
                </label>

                <input 
                    id="password"
                    class="form-control"
                    type="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    required
                >

                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>



            <div class="form-group mb-4">
                <label for="password_confirmation">
                    <i class="bi bi-shield-check me-2"></i>
                    Konfirmasi Password
                </label>

                <input 
                    id="password_confirmation"
                    class="form-control"
                    type="password"
                    name="password_confirmation"
                    placeholder="Ulangi password"
                    required
                >

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
            </div>



            <button type="submit" class="register-btn">
                <i class="bi bi-person-plus me-2"></i>
                Daftar Sekarang
            </button>


            <div class="text-center mt-4">
                <span class="text-muted">
                    Sudah memiliki akun?
                </span>

                <a href="{{ route('login') }}">
                    Masuk
                </a>
            </div>

        </form>

    </div>

</div>


<style>

.register-wrapper {
    min-height: calc(100vh - 80px);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 30px 15px;
}


.register-card {
    width: 100%;
    max-width: 430px;

    background: #ffffff;

    border-radius: 24px;

    padding: 32px;

    box-shadow:
        0 15px 40px rgba(15, 23, 42, 0.12);

    border: 1px solid rgba(226, 232, 240, 0.8);
}



.register-logo {
    width: 60px;
    height: 60px;

    margin: auto;

    display: flex;
    justify-content: center;
    align-items: center;

    border-radius: 18px;

    background: linear-gradient(135deg,#2563eb,#06b6d4);

    color:white;

    font-size:28px;
}

@media(max-width:576px){

    .register-card {
        padding:25px;
        border-radius:20px;
    }

}

.register-header h2 {

    color:#0f172a;

}


.register-header p {

    color:#64748b;

    font-size:.95rem;

}



.form-group label {

    font-weight:600;

    color:#334155;

    margin-bottom:8px;

    display:block;

}



.form-control {

    height:52px;

    border-radius:14px;

    border:1px solid #cbd5e1;

    padding:0 18px;

    transition:.2s;

}



.form-control:focus {

    border-color:#2563eb;

    box-shadow:
    0 0 0 4px rgba(37,99,235,.15);

}



.register-btn {

    width:100%;

    height:52px;

    border:none;

    border-radius:14px;

    color:white;

    font-weight:600;

    font-size:16px;


    background:
    linear-gradient(135deg,#2563eb,#06b6d4);


    box-shadow:
    0 15px 30px rgba(37,99,235,.25);


    transition:.25s;

}



.register-btn:hover {

    transform:translateY(-2px);

}



.text-center a {

    color:#2563eb;

    font-weight:600;

    text-decoration:none;

}



</style>


</x-guest-layout>