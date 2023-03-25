<?php

namespace App\Http\Controllers;

use App\AbsensiKaryawan;
use App\Exports\ExportAbsensi;
use App\Settings;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AbsensiKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $titleTab = 'Absensi Page';
        $settings = Settings::first();
        $absen = AbsensiKaryawan::where('user_id', $user->id)->whereDate('created_at', Carbon::today())->first();

        return view('absen.index', compact('user', 'absen', 'settings', 'titleTab'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $absen = AbsensiKaryawan::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->first();
        $jam_masuk = Carbon::parse(Settings::firstOrFail()->jam_masuk);
        $toleransi_jam_masuk = Settings::firstOrFail()->toleransi_jam_masuk;

        if ($absen == null) {
            $absen = new AbsensiKaryawan;
            $absen->user_id = $user->id;
            $absen->jam_absensi_masuk = Carbon::now();

            if ($absen->jam_absensi_masuk->between($jam_masuk, $jam_masuk->copy()->addMinutes($toleransi_jam_masuk)->addMinute())) {
                $absen->status_absensi_masuk = 'Telat Toleransi';
            } elseif ($absen->jam_absensi_masuk->isAfter($jam_masuk->copy()->addMinutes($toleransi_jam_masuk)->addMinute())) {
                $absen->status_absensi_masuk = 'Telat';
            } else {
                $absen->status_absensi_masuk = 'Tepat Waktu';
            }

            $absen->save();

            return redirect()->back()->with('success', 'Absen masuk berhasil disimpan.');
        } else if ($absen->jam_absensi_masuk !== null) {
            $absen->jam_absensi_pulang = Carbon::now();
            $absen->save();

            return redirect()->back()->with('success', 'Absen pulang berhasil disimpan. Selamat beristirahat');
        } else {
            return redirect()->back()->with('success', 'Anda sudah melakukan absen masuk hari ini.');
        }
    }

    public function showAllAbsensi(Request $request)
    {
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));

        $titleTab = 'Rekap Absensi';
        $users = User::all();
        $absensi = AbsensiKaryawan::whereIn('user_id', $users->pluck('id'))
            ->whereDate('created_at', $date)
            ->get();

        return view('absen.showall', compact('users', 'absensi', 'date', 'titleTab'));
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        return Excel::download(new ExportAbsensi($startDate, $endDate), 'absensi' . $startDate . '-' . $endDate . '.xlsx');
    }
}
