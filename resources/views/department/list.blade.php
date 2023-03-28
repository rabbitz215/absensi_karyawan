@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->

    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#newDepartment">
        New Department
    </button>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Department Name</th>
                    <th>Total Karyawan</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $index => $department)
                    @php
                        $iteration = ($departments->currentPage() - 1) * $departments->perPage() + $index + 1;
                    @endphp
                    <tr>
                        <td scope="row">{{ $iteration }}</td>
                        <td>{{ $department->name }}</td>
                        <td>{{ $department->users_count }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('department.show', $department->id) }}"
                                    class="btn btn-sm btn-secondary mr-2"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('department.edit', $department->id) }}"
                                    class="btn btn-sm btn-primary mr-2"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('department.destroy', $department->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure to delete this?')"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="newDepartment" tabindex="-1" role="dialog" aria-labelledby="newDepartmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">New Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('department.store') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="name">Department Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                id="name" placeholder="Department Name" autocomplete="off" value="{{ old('name') }}"
                                required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Manager Name</label>
                            <input type="text" class="form-control @error('manager_name') is-invalid @enderror"
                                name="manager_name" id="manager_name" placeholder="Manager Name" autocomplete="off"
                                value="{{ old('manager_name') }}" required>
                            @error('manager_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="no_telp">No Telp Manager Department</label>
                            <input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp"
                                id="no_telp" placeholder="No Telp" autocomplete="off" value="{{ old('no_telp') }}"
                                required>
                            @error('no_telp')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="no_telp">Email Manager Department</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                id="email" placeholder="Email" autocomplete="off" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description Department</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                placeholder="Description" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{ $departments->links() }}

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

    @if (session('warning'))
        <div class="alert alert-warning border-left-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
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
