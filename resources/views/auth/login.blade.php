<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | SIM-RS</title>

    <link rel="icon" type="image/png" href="{{ asset('templates/templates/dist/img/logo_rsud.png') }}">
    <link href="{{ asset('templates/templates/dist/css/tabler.css') }}" rel="stylesheet">
    <link href="{{ asset('templates/templates/dist/css/tabler-themes.css') }}" rel="stylesheet">
    <script src="{{ asset('templates/templates/dist/js/tabler-theme.js') }}"></script>

    <style>
        body {
            position: relative;
            overflow-x: hidden;
            background:
                radial-gradient(circle at 15% 10%, rgba(13, 148, 136, .16), transparent 28rem),
                radial-gradient(circle at 90% 90%, rgba(34, 197, 94, .14), transparent 30rem),
                var(--tblr-bg-surface-secondary);
        }

        .login-shell {
            position: relative;
            z-index: 1;
        }

        .login-brand {
            display: inline-flex;
            align-items: center;
            gap: .75rem;
            color: var(--tblr-body-color);
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: .02em;
            text-decoration: none;
        }

        .login-brand img {
            width: 46px;
            height: 46px;
            object-fit: contain;
        }

        .login-card {
            overflow: hidden;
            border: 0;
            box-shadow: 0 24px 70px rgba(15, 23, 42, .12);
        }

        .login-card-accent {
            height: 5px;
            background: linear-gradient(90deg, #0f766e, #14b8a6, #22c55e);
        }

        .login-logo {
            width: 96px;
            height: 96px;
            object-fit: contain;
            filter: drop-shadow(0 10px 18px rgba(15, 23, 42, .12));
        }

        .password-toggle {
            border: 0;
            background: transparent;
            color: var(--tblr-secondary-color);
        }

        .password-toggle:hover,
        .password-toggle:focus {
            color: var(--tblr-primary);
        }

        .login-submit {
            background: linear-gradient(135deg, #0f766e, #0d9488);
            border-color: #0f766e;
        }

        .login-submit:hover,
        .login-submit:focus {
            background: linear-gradient(135deg, #115e59, #0f766e);
            border-color: #115e59;
        }
    </style>
</head>
<body>
    <a href="#content" class="visually-hidden skip-link">Lewati ke formulir login</a>

    <div class="page page-center login-shell">
        <main id="content" class="container container-tight py-5">
            <div class="text-center mb-4">
                <a href="{{ url('/') }}" class="login-brand" aria-label="Beranda SIM-RS">
                    <img src="{{ asset('templates/templates/dist/img/logo_rsud.png') }}" alt="Logo SIM-RS">
                    <span>SIM-RS</span>
                </a>
            </div>

            <section class="card card-md login-card" aria-labelledby="login-title">
                <div class="login-card-accent"></div>
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <img class="login-logo mb-3" src="{{ asset('templates/templates/dist/img/logo_rsud.png') }}" alt="Logo rumah sakit">
                        <h1 id="login-title" class="h2 mb-2">Selamat datang kembali</h1>
                        <p class="text-secondary mb-0">Masuk ke Sistem Informasi Manajemen Rumah Sakit</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="status">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <div class="d-flex">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon" aria-hidden="true">
                                        <path d="M12 9v4" /><path d="M12 17v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -13a2 2 0 0 0 -3.5 0l-7.1 13a2 2 0 0 0 1.86 2.75" />
                                    </svg>
                                </div>
                                <div>{{ $errors->first() }}</div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="email">Alamat email</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="nama@email.com"
                                autocomplete="username"
                                autofocus
                                required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="password">
                                Password
                                @if (Route::has('password.request'))
                                    <span class="form-label-description">
                                        <a href="{{ route('password.request') }}">Lupa password?</a>
                                    </span>
                                @endif
                            </label>
                            <div class="input-group input-group-flat">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan password"
                                    autocomplete="current-password"
                                    required>
                                <span class="input-group-text">
                                    <button
                                        id="toggle-password"
                                        type="button"
                                        class="password-toggle p-0"
                                        aria-label="Tampilkan password"
                                        aria-pressed="false">
                                        <svg id="password-visible-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon" aria-hidden="true">
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6s-6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6s6.6 2 9 6" />
                                        </svg>
                                        <svg id="password-hidden-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon d-none" aria-hidden="true">
                                            <path d="M3 3l18 18" /><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8" /><path d="M9.9 4.24a9.77 9.77 0 0 1 2.1 -.24c3.6 0 6.6 2 9 6a15.55 15.55 0 0 1 -2.17 2.91" /><path d="M6.61 6.61a15.1 15.1 0 0 0 -3.61 5.39c2.4 4 5.4 6 9 6a9.77 9.77 0 0 0 5.39 -1.61" />
                                        </svg>
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-check">
                                <input type="checkbox" class="form-check-input" name="remember" @checked(old('remember'))>
                                <span class="form-check-label">Ingat saya di perangkat ini</span>
                            </label>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary login-submit w-100">
                                Masuk
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            @if (Route::has('register'))
                <div class="text-center text-secondary mt-4">
                    Belum memiliki akun? <a href="{{ route('register') }}">Daftar akun</a>
                </div>
            @endif

            <div class="text-center text-secondary small mt-3">
                &copy; {{ date('Y') }} SIM-RS. Seluruh hak cipta dilindungi.
            </div>
        </main>
    </div>

    <script src="{{ asset('templates/templates/dist/js/tabler.js') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('toggle-password');
            const password = document.getElementById('password');
            const visibleIcon = document.getElementById('password-visible-icon');
            const hiddenIcon = document.getElementById('password-hidden-icon');

            toggle.addEventListener('click', function () {
                const isVisible = password.type === 'text';

                password.type = isVisible ? 'password' : 'text';
                toggle.setAttribute('aria-pressed', String(! isVisible));
                toggle.setAttribute('aria-label', isVisible ? 'Tampilkan password' : 'Sembunyikan password');
                visibleIcon.classList.toggle('d-none', ! isVisible);
                hiddenIcon.classList.toggle('d-none', isVisible);
            });
        });
    </script>
</body>
</html>
