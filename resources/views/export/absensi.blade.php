<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Email</th>
            <th>No Telp</th>
            <th>Jabatan</th>
            <th>Department</th>
            <th>Tanggal Absen</th>
            <th>Jam Absen Masuk</th>
            <th>Status Absen Masuk</th>
            <th>Jam Absen Pulang</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->user['full_name'] }}</td>
                <td>{{ $item->user['email'] }}</td>
                <td>{{ $item->user['no_telp'] }}</td>
                <td>{{ $item->user['jabatan'] }}</td>
                <td>{{ $item->user->department['name'] }}</td>
                <td>{{ $item['created_at'] ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'])->format('d-m-Y') : '-' }}
                </td>
                <td>{{ $item['jam_absensi_masuk'] ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['jam_absensi_masuk'])->format('H:i:s') : '-' }}
                </td>
                <td>{{ $item['status_absensi_masuk'] }}</td>
                <td>{{ $item['jam_absensi_pulang'] ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['jam_absensi_pulang'])->format('H:i:s') : '-' }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
