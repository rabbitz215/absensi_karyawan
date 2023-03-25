<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\AbsensiKaryawan;
use App\Department;
use App\Exports\ExportByUser;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titleTab = 'Users Page';

        return view('user.list', [
            'title' => 'Users',
            'users' => User::with(['department'])->paginate(10),
            'titleTab' => $titleTab,
            'departments' => Department::get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $titleTab = 'Users Page';
        return view('user.create', [
            'title' => 'New User',
            'users' => User::paginate(10),
            'departments' => Department::get(),
            'titleTab' => $titleTab,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department_id' => $request->department_id,
            'jabatan' => $request->jabatan,
            'no_telp' => $request->no_telp,
        ]);

        $user->assignRole('karyawan');

        return redirect()->route('user.index')->with('message', 'User added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $titleTab = 'Users Page';
        $user = User::find($id);
        $title = 'Absensi ' . $user->full_name;
        $recaps = AbsensiKaryawan::where('user_id', $id)->paginate(15);
        // dd($recaps);
        return view('user.show', compact('user', 'recaps', 'titleTab', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $titleTab = 'Users Page';

        return view('user.edit', [
            'title' => 'Edit User',
            'user' => User::with(['department'])->where('id', $user->id)->first(),
            'departments' => Department::get(),
            'titleTab' => $titleTab,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, User $user)
    {
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->department_id = $request->department_id;
        $user->jabatan = $request->jabatan;
        $user->no_telp = $request->no_telp;
        $user->save();

        return redirect()->route('user.index')->with('message', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Auth::id() == $user->getKey()) {
            return redirect()->route('user.index')->with('warning', 'Can not delete yourself!');
        }

        $user->delete();

        return redirect()->route('user.index')->with('message', 'User deleted successfully!');
    }

    public function exportByUser(User $user)
    {
        $data = $user->absensiKaryawans->map(function ($item) {
            return [
                'hari' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('l'),
                'tanggal' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d-m-Y'),
                'jam_absensi_masuk' => $item->jam_absensi_masuk !== null ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->jam_absensi_masuk)->format('H:i:s') : '-',
                'status_absensi_masuk' => $item->status_absensi_masuk,
                'jam_absensi_pulang' => $item->jam_absensi_pulang !== null ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->jam_absensi_pulang)->format('H:i:s') : '-',
            ];
        });
        $filename = 'absensi-' . str_replace(' ', '', $user->full_name) . '.xlsx';
        return Excel::download(new ExportByUser($data), $filename);
    }

    public function rekapAbsenUser()
    {
        $titleTab = 'Rekap Absensi Anda';
        $data = AbsensiKaryawan::where('user_id', Auth::user()->id)->get();

        return view('absen.absensiuser', compact('data', 'titleTab'));
    }
}
