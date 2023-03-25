<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Hari</th>
            <th>Tanggal</th>
            <th>Jam Absen Masuk</th>
            <th>Status Absen Masuk</th>
            <th>Jam Absen Pulang</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item['hari'] }}</td>
                <td>{{ $item['tanggal'] }}</td>
                <td>{{ $item['jam_absensi_masuk'] }}</td>
                <td>{{ $item['status_absensi_masuk'] }}</td>
                <td>{{ $item['jam_absensi_pulang'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
