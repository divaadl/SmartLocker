<?php

namespace App\Http\Controllers;

use App\Models\Locker;
use Illuminate\Http\Request;

class LockerController extends Controller
{
    public function index()
    {
        $lockers = Locker::all();
        return view('loker.index', compact('lockers'));
    }

    public function create(Locker $locker)
    {
        if ($locker->status !== 'kosong') {
            return back()->with('error', 'Loker tidak tersedia!');
        }

        return view('loker.create', compact('locker'));
    }

    public function store(Request $request, Locker $locker)
    {
        // proses sewa + midtrans akan ditambahkan
    }
}
