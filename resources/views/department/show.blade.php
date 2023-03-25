@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <p class="font-weight-bold">Department Name : {{ $department->name }}</p>
    <p class="font-weight-bold">Department Manager Name : {{ $department->manager_name }}</p>
    <p class="font-weight-bold">Department Manager Email : {{ $department->email }}</p>
    <p class="font-weight-bold">Department Manager No Telp : {{ $department->no_telp }}</p>
    <p class="font-weight-bold">Department Description : {{ $department->description }}</p>

    <div class="card mt-4">
        <div class="card-body">
            <p><b>Total Karyawan : {{ $usersByDepartment->count() }}</b></p>
            <table class="table table-responsive table-stripped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>No Telp</th>
                        <th>Jabatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usersByDepartment as $user)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->no_telp }}</td>
                            <td>{{ $user->jabatan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $usersByDepartment->links() }}
        </div>
    </div>
@endsection
