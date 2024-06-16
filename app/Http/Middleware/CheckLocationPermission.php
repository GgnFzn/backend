<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLocationPermission
{
    public function handle(Request $request, Closure $next)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        // Lokasi yang diizinkan (contoh koordinat Jakarta)
        $allowedLatitude = -6.2088;
        $allowedLongitude = 106.8456;

        // Jarak toleransi dalam meter
        $distanceTolerance = 100; // Misalnya 100 meter

        // Hitung jarak antara titik yang diberikan dengan lokasi yang diizinkan
        $distance = $this->calculateDistance($latitude, $longitude, $allowedLatitude, $allowedLongitude);

        // Jika jarak kurang dari toleransi, izinkan akses
        if ($distance <= $distanceTolerance) {
            return $next($request);
        }

        // Jika tidak, kembalikan response error
        return response()->json(['error' => 'Unauthorized location'], 403);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius bumi dalam meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }
}
