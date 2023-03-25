@extends('layouts.admin')

@section('main-content')
    <h1>Absensi Karyawan</h1>

    <form method="get" action="{{ route('absensi.showAllAbsensi') }}">
        <label for="date">Pilih Tanggal:</label>
        <input type="date" name="date" value="{{ $date }}" required>
        <button type="submit" class="btn btn-primary mb-2">Tampilkan</button>
    </form>
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exportModal">
        Export
    </button>

    <table class="table table-responsive">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Jam Absen Masuk</th>
                <th>Status Absen Masuk</th>
                <th>Jam Absen Pulang</th>
                <th>Total Waktu Kerja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                @php
                    $absen = $absensi->where('user_id', $user->id)->first();
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $absen && $absen->jam_absensi_masuk !== null ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $absen->jam_absensi_masuk)->format('H:i:s') : '-' }}
                    </td>
                    <td>
                        <a
                            class="text-decoration-none font-weight-bold {{ $absen ? ($absen->status_absensi_masuk == 'Telat' ? 'text-danger' : ($absen->status_absensi_masuk == 'Telat Toleransi' ? 'text-warning' : '')) : 'text-secondary' }}">
                            {{ $absen ? $absen->status_absensi_masuk : '-' }}
                        </a>
                    </td>
                    <td>{{ $absen && $absen->jam_absensi_pulang !== null ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $absen->jam_absensi_pulang)->format('H:i:s') : '-' }}
                    </td>
                    @if ($absen && $absen->jam_absensi_pulang !== null)
                        <td>
                            @php
                                $totalSeconds = strtotime($absen->jam_absensi_pulang) - strtotime($absen->jam_absensi_masuk);
                                $totalHours = floor($totalSeconds / 3600);
                                $totalMinutes = floor(($totalSeconds / 60) % 60);
                                $totalSeconds = $totalSeconds % 60;
                            @endphp
                            {{ $totalHours }} Jam {{ $totalMinutes }} Menit {{ $totalSeconds }} Detik
                        </td>
                    @else
                        <td>-</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="get" action="{{ route('absensi.export') }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportModalLabel">Export Absensi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
