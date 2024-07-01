<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $presensi = new Presensi();
        $presensi->user_id = $user->id;
        $presensi->latitude = $request->latitude;
        $presensi->longitude = $request->longitude;
        $presensi->save();

        return response()->json(['message' => 'Presensi berhasil'], 201);
    }

    public function index()
    {
        $user = Auth::user();
        $presensi = Presensi::where('user_id', $user->id)->get();

        return response()->json($presensi);
    }
}
