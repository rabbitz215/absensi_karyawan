@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Absensi Page') }}</h1>

    <!-- Main Content goes here -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Halo, {{ $user->name }}</h5>
            <p class="card-title mb-0">{{ \Carbon\Carbon::today()->format('l d/m/Y') }}</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <p><b>Nama Karyawan: </b>{{ $user->name }}</p>
                    <p><b>Jabatan: </b>{{ $user->jabatan }}</p>
                    <p><b>Department: </b>{{ $user->department->name }}</p>
                    <p><b>Jam Masuk: </b>{{ $settings->jam_masuk ?? 'Belum ada Settings Jam Masuk' }}</p>
                    <p><b>Toleransi Absensi Masuk:
                        </b>{{ $settings ? ($settings->toleransi_jam_masuk ? $settings->toleransi_jam_masuk . ' Menit' : 'Belum ada Settings Toleransi Jam Masuk') : 'Belum ada Settings Toleransi Jam Masuk' }}
                    </p>
                    <p><b>Jam Pulang: </b>{{ $settings->jam_pulang ?? 'Belum ada Settings Jam Pulang' }}</p>
                </div>
                @if ($absen !== null)
                    <div class="col-sm-6">
                        <p><b>Jam Absen Masuk Anda:
                            </b>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $absen->jam_absensi_masuk)->format('H:i:s') }}
                        </p>
                        @if ($absen->jam_absensi_pulang !== null)
                            <p><b>Jam Absen Pulang Anda:
                                </b>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $absen->jam_absensi_pulang)->format('H:i:s') }}
                            </p>
                        @endif
                        <p><b>Status Absen Masuk: </b><a
                                class="text-decoration-none font-weight-bold {{ $absen->status_absensi_masuk === 'Telat' ? 'text-danger' : ($absen->status_absensi_masuk === 'Telat Toleransi' ? 'text-warning' : '') }}">{{ $absen->status_absensi_masuk }}</a>
                        </p>
                    </div>
                @endif
            </div>
            @if ($settings && $settings->jam_masuk)
                <div class="row mt-4">
                    <div class="col-sm-12 text-center">
                        @if ($absen !== null && $absen->jam_absensi_masuk !== null && $absen->jam_absensi_pulang !== null)
                            <p>Anda sudah melakukan absensi Masuk dan Pulang hari ini</p>
                        @endif
                        @if ($absen == null)
                            @if ($absen == null && \Carbon\Carbon::now()->format('H:i') <= $settings->jam_pulang)
                                <form method="POST" action="{{ route('absen.store') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success mr-2">Absen Masuk</button>
                                </form>
                            @else
                                <p>Anda tidak bisa melakukan absen dikarenakan sudah melewati Jam Waktu Pulang !!</p>
                            @endif
                        @elseif($absen->jam_absensi_pulang == null)
                            <form method="POST" action="{{ route('absen.store') }}">
                                @csrf
                                <button type="submit" class="btn btn-warning mr-2">Absen Pulang</button>
                            </form>
                        @endif
                    </div>
                </div>
            @else
                <center>
                    <h5>Belum settings Waktu Absen</h5>
                </center>
            @endif
        </div>
    </div>

    <!-- End of Main Content -->
@endsection

@push('notif')
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
@endpush
