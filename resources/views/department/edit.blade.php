@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->

    <div class="card">
        <div class="card-body">
            <form action="{{ route('department.update', $department->id) }}" method="post">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="name">Department Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        id="name" placeholder="Department Name" autocomplete="off"
                        value="{{ old('name') ?? $department->name }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Manager Name</label>
                    <input type="text" class="form-control @error('manager_name') is-invalid @enderror"
                        name="manager_name" id="manager_name" placeholder="Manager Name" autocomplete="off"
                        value="{{ old('manager_name') ?? $department->manager_name }}">
                    @error('manager_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">No Telp Manager Department</label>
                    <input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp"
                        id="no_telp" placeholder="No Telp Manager" autocomplete="off"
                        value="{{ old('no_telp') ?? $department->no_telp }}">
                    @error('no_telp')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Email Manager Department</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        id="email" placeholder="Email Manager" autocomplete="off"
                        value="{{ old('email') ?? $department->email }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Description Department</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                        placeholder="Email Manager">{{ old('description') ?? $department->description }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('department.index') }}" class="btn btn-default">Back to list</a>

            </form>
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
