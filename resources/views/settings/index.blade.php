@extends('layouts.admin')

@section('main-content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Settings</h5>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('settings.store') }}">
                @csrf
                <div class="form-group">
                    <label for="jam_masuk">Jam Masuk</label>
                    <input type="time" class="form-control" id="jam_masuk" name="jam_masuk"
                        value="{{ $settings ? $settings->jam_masuk : '' }}">
                </div>
                <div class="form-group">
                    <label for="jam_pulang">Jam Pulang</label>
                    <input type="time" class="form-control" id="jam_pulang" name="jam_pulang"
                        value="{{ $settings ? $settings->jam_pulang : '' }}">
                </div>
                <div class="form-group">
                    <label for="jam_masuk">Toleransi Jam Masuk (Menit)</label>
                    <input type="number" class="form-control" id="toleransi_jam_masuk" name="toleransi_jam_masuk"
                        value="{{ $settings ? $settings->toleransi_jam_masuk : '' }}">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
