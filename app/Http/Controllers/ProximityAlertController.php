<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProximityLog;
use App\Notifications\ProximityWithinRange;
use Illuminate\Support\Facades\Notification;
use App\Events\ProximityChecked;

class ProximityAlertController extends Controller
{
    public function showForm()
    {
        return view('dashboard.form');
    }

    public function checkProximity(Request $request)
    {
        // Example: use fixed warehouse coordinates; customize as needed
        $warehouseLat = 14.5995;
        $warehouseLng = 120.9842;

        $deliveryLat = floatval($request->input('lat'));
        $deliveryLng = floatval($request->input('lng'));
        $radius = intval($request->input('radius', 250));

        // Calculate distance (Haversine formula, returns meters)
        $distance = $this->haversine($warehouseLat, $warehouseLng, $deliveryLat, $deliveryLng);

        $withinRange = $distance <= $radius;

        // Log to DB
        $log = ProximityLog::create([
            'warehouse_lat' => $warehouseLat,
            'warehouse_lng' => $warehouseLng,
            'delivery_lat' => $deliveryLat,
            'delivery_lng' => $deliveryLng,
            'radius' => $radius,
            'distance' => $distance,
            'within_range' => $withinRange,
        ]);

        // Fire real-time broadcast event
        event(new ProximityChecked($log));

        // Send notification (email) if within range
        if ($withinRange) {
            Notification::route('mail', 'youremail@example.com')
                ->notify(new ProximityWithinRange($log));
        }

        // Show modal with result
        return redirect()
            ->back()
            ->with('alertData', [
                'within_range' => $withinRange,
                'distance' => round($distance, 2)
            ]);
    }

    // Helper: Haversine formula to get meters between coordinates
    protected function haversine($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371000; // meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng/2) * sin($dLng/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $earthRadius * $c;
    }
}