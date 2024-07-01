<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function clockIn(Request $request)
    {
        $this->validate($request, [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Verifikasi lokasi menggunakan middleware
        // Jika sudah lolos middleware, berarti lokasi valid
        $attendance = new Attendance;
        $attendance->latitude = $request->latitude;
        $attendance->longitude = $request->longitude;
        $attendance->user_id = Auth::id(); // Mengambil ID user yang sedang login
        $attendance->clock_in = now(); // Timestamp saat absen masuk
        $attendance->is_within_location = true; // Set lokasi valid
        $attendance->save();

        return response()->json(['message' => 'Clock in recorded', 'data' => $attendance], 201);
    }

    public function clockOut(Request $request)
    {
        $this->validate($request, [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Cari absensi terakhir yang belum memiliki absen keluar
        $attendance = Attendance::where('user_id', Auth::id())
                                ->whereNull('clock_out')
                                ->latest()
                                ->first();

        if (!$attendance) {
            return response()->json(['error' => 'No active attendance record found'], 404);
        }

        // Verifikasi lokasi menggunakan middleware
        // Jika sudah lolos middleware, berarti lokasi valid
        $attendance->latitude_out = $request->latitude;
        $attendance->longitude_out = $request->longitude;
        $attendance->clock_out = now(); // Timestamp saat absen keluar
        $attendance->save();

        return response()->json(['message' => 'Clock out recorded', 'data' => $attendance], 200);
    }
}
