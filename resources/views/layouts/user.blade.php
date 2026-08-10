<div class="nav-item dropdown">
    <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="Open user menu">
        <span class="avatar avatar-sm" style="background-image: url('{{ asset('templates/templates/dist/img/user_akun.png') }}')">
        </span>

        <div class="d-none d-xl-block ps-2">
            <div>{{ auth()->user()->name }}</div>
            <div class="mt-1 small text-secondary">{{ ucfirst(auth()->user()->role) }}</div>
        </div>

    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-profile">
            <svg xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                class="icon dropdown-item-icon icon-2">

                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />

            </svg>
            Profile
        </a>
        <div class="dropdown-divider"></div>
        <!-- <a class="dropdown-item" href="./settings.html">Settings &amp; Privacy</a> -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="dropdown-item">
                Keluar
            </button>
        </form>
    </div>
</div>
