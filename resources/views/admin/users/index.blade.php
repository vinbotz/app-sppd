@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Manajemen Pengguna</h5>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Pengguna
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <!-- Pop-up Notifikasi Sukses -->
                        <style>
                            .success-notification {
                                position: fixed;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                background: rgba(0, 0, 0, 0.5);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                z-index: 9999;
                            }
                            .success-modal {
                                background: #22c55e;
                                color: white;
                                padding: 24px;
                                border-radius: 8px;
                                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
                                max-width: 400px;
                                margin: 0 16px;
                                text-align: center;
                            }
                            .success-icon {
                                width: 64px;
                                height: 64px;
                                margin: 0 auto 16px;
                                color: #dcfce7;
                            }
                            .success-title {
                                font-size: 24px;
                                font-weight: bold;
                                margin-bottom: 8px;
                            }
                            .success-message {
                                margin-bottom: 24px;
                                line-height: 1.5;
                            }
                            .close-button {
                                background: #16a34a;
                                color: white;
                                border: none;
                                padding: 8px 24px;
                                border-radius: 9999px;
                                font-weight: 500;
                                cursor: pointer;
                                transition: all 0.3s ease;
                            }
                            .close-button:hover {
                                background: #15803d;
                                transform: scale(1.05);
                                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                            }
                        </style>
                        <div class="success-notification">
                            <div class="success-modal">
                                <div class="success-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="success-title">Berhasil!</h3>
                                <p class="success-message">{{ session('success') }}</p>
                                <button id="closeBtn" class="close-button">Tutup</button>
                            </div>
                        </div>
                        <script>
                            document.getElementById('closeBtn').onclick = function() {
                                var notif = document.querySelector('.success-notification');
                                if(notif) notif.remove();
                            };
                            setTimeout(function() {
                                var notif = document.querySelector('.success-notification');
                                if(notif) notif.remove();
                            }, 2000);
                        </script>
                    @endif

                    @if (session('error'))
                        <!-- Pop-up Notifikasi Error -->
                        <style>
                            .error-notification {
                                position: fixed;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                background: rgba(0, 0, 0, 0.5);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                z-index: 9999;
                            }
                            .error-modal {
                                background: #ef4444;
                                color: white;
                                padding: 24px;
                                border-radius: 8px;
                                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
                                max-width: 400px;
                                margin: 0 16px;
                                text-align: center;
                            }
                            .error-icon {
                                width: 64px;
                                height: 64px;
                                margin: 0 auto 16px;
                                color: #fecaca;
                            }
                            .error-title {
                                font-size: 24px;
                                font-weight: bold;
                                margin-bottom: 8px;
                            }
                            .error-message {
                                margin-bottom: 24px;
                                line-height: 1.5;
                            }
                            .close-button-error {
                                background: #dc2626;
                                color: white;
                                border: none;
                                padding: 8px 24px;
                                border-radius: 9999px;
                                font-weight: 500;
                                cursor: pointer;
                                transition: all 0.3s ease;
                            }
                            .close-button-error:hover {
                                background: #b91c1c;
                                transform: scale(1.05);
                                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                            }
                        </style>
                        <div class="error-notification">
                            <div class="error-modal">
                                <div class="error-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <h3 class="error-title">Error!</h3>
                                <p class="error-message">{{ session('error') }}</p>
                                <button id="closeBtnError" class="close-button-error">Tutup</button>
                            </div>
                        </div>
                        <script>
                            document.getElementById('closeBtnError').onclick = function() {
                                var notif = document.querySelector('.error-notification');
                                if(notif) notif.remove();
                            };
                            setTimeout(function() {
                                var notif = document.querySelector('.error-notification');
                                if(notif) notif.remove();
                            }, 2000);
                        </script>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No HP</th>
                                    <th>Jabatan</th>
                                    <th>Role</th>
                                    <th>Terakhir Login</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                                    <td>{{ $user->nip }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->no_hp }}</td>
                                    <td>{{ $user->jabatan }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->role === 'supervisor' ? 'danger' : 'secondary' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah login' }}</td>
                                    <td>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 