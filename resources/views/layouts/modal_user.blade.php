<div class="modal modal-blur fade" id="modal-profile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Profile User
                </h5>
                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="modal-body">
                    <div class="text-center">
                        <span class="avatar avatar-xl mb-3"
                            style="background-image:url('{{ asset('templates/templates/dist/img/user_akun.png') }}')">
                        </span>
                        <h3>
                            {{ auth()->user()->name }}
                        </h3>
                        <div class="text-secondary">
                            {{ auth()->user()->role }}
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="form-label">Email</label>
                        <input type="text"
                            class="form-control"
                            name="email"
                            value="{{ auth()->user()->email }}">
                        <label class="form-label mt-3">Nama</label>
                        <input type="text"
                            class="form-control"
                            name="name"
                            value="{{ auth()->user()->name }}">
                        <label class="form-label mt-3">Role</label>
                        <input type="text"
                            class="form-control"
                            value="{{ auth()->user()->role }}"
                            readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                    <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
