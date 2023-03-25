@extends('layouts.admin')

@section('main-content')
    <h1>Rekap Absen Anda</h1>

    <table class="table table-responsive">
        <thead>
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Jam Absen Masuk</th>
                <th>Status Absen Masuk</th>
                <th>Jam Absen Pulang</th>
                <th>Total Waktu Kerja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->created_at !== null ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('l') : '-' }}
                    </td>
                    <td>{{ $item->created_at !== null ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d-m-Y') : '-' }}
                    </td>
                    <td>{{ $data && $item->jam_absensi_masuk !== null ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->jam_absensi_masuk)->format('H:i:s') : '-' }}
                    </td>
                    <td>
                        <a
                            class="text-decoration-none font-weight-bold {{ $data ? ($item->status_absensi_masuk == 'Telat' ? 'text-danger' : ($item->status_absensi_masuk == 'Telat Toleransi' ? 'text-warning' : '')) : 'text-secondary' }}">
                            {{ $item ? $item->status_absensi_masuk : '-' }}
                        </a>
                    </td>
                    <td>{{ $data && $item->jam_absensi_pulang !== null ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->jam_absensi_pulang)->format('H:i:s') : '-' }}
                    </td>
                    @if ($data && $item->jam_absensi_pulang !== null)
                        <td>
                            @php
                                $totalSeconds = strtotime($item->jam_absensi_pulang) - strtotime($item->jam_absensi_masuk);
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
@endsection
