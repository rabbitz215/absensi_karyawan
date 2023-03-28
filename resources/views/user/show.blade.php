@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->
    <p class="font-weight-bold">Nama : {{ $user->full_name }}</p>
    <p class="font-weight-bold">Email : {{ $user->email }}</p>
    <p class="font-weight-bold">No Telp : {{ $user->no_telp }}</p>
    <p class="font-weight-bold">Jabatan : {{ $user->jabatan }}</p>
    <p class="font-weight-bold">Department : {{ $user->department->name }}</p>
    <a href="{{ route('absensi.exportByUser', $user->id) }}" class="btn btn-primary mb-2"><i class="fas fa-file-export"></i>
        Export to Excel</a>
    <div>
        <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
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
                    @foreach ($recaps as $index => $item)
                        @php
                            $iteration = ($recaps->currentPage() - 1) * $recaps->perPage() + $index + 1;
                        @endphp
                        <tr>
                            <td scope="row">{{ $iteration }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('l') }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d-m-Y') }}
                            </td>
                            <td>{{ $item->jam_absensi_masuk !== null ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->jam_absensi_masuk)->format('H:i:s') : '-' }}
                            </td>
                            <td>
                                <a
                                    class="text-decoration-none font-weight-bold {{ $item->status_absensi_masuk == 'Telat' ? 'text-danger' : 'text-success' }}">
                                    {{ $item->status_absensi_masuk }}
                                </a>
                            </td>
                            <td>{{ $item->jam_absensi_pulang !== null ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->jam_absensi_pulang)->format('H:i:s') : '-' }}
                            </td>
                            @if ($recaps && $item->jam_absensi_pulang !== null)
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
        </div>
    </div>

    {{ $recaps->links() }}

    <!-- End of Main Content -->
@endsection
