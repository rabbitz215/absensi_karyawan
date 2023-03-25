<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $titleTab = 'Absensi Karyawan';
        $userscount = User::count();
        $department = User::with(['department'])->where('id', Auth::user()->id)->first();

        $widget = [
            'users' => $userscount,
            'department' => $department,
            //...
        ];

        return view('home', compact('widget', 'titleTab'));
    }
}
