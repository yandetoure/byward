<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class EstimateController extends Controller
{
    public function show()
    {
        return view('pages.estimate');
    }

    public function calculate(Request $request)
    {
        $methods = config('byward.estimate.methods');

        $data = $request->validate([
            'origin_street' => ['required', 'string', 'max:150'],
            'origin_province' => ['required', 'string', 'max:100'],
            'origin_postal_code' => ['required', 'string', 'max:20'],
            'destination_street' => ['required', 'string', 'max:150'],
            'destination_province' => ['required', 'string', 'max:100'],
            'destination_postal_code' => ['required', 'string', 'max:20'],
            'method' => ['required', 'string', 'in:'.implode(',', array_keys($methods))],
            'weight' => ['required', 'numeric', 'min:0.1', 'max:200000'],
        ]);

        $config = $methods[$data['method']];
        
        $origin = "{$data['origin_street']}, {$data['origin_province']}, {$data['origin_postal_code']}";
        $destination = "{$data['destination_street']}, {$data['destination_province']}, {$data['destination_postal_code']}";

        // Calculate driving distance
        $distance = $this->calculateDistance($origin, $destination);
        
        $price = config('byward.estimate.base_fee') 
            + ((float) $data['weight'] * $config['rate']) 
            + ($distance * $config['distance_rate']);
            
        $price = max($price, $config['min']);

        return redirect()
            ->route('estimate')
            ->withInput($data)
            ->with('estimate', [
                'price' => $this->formatPrice(round($price, 2)),
                'days_min' => $config['days'][0],
                'days_max' => $config['days'][1],
                'origin' => $origin,
                'destination' => $destination,
                'weight' => (float) $data['weight'],
                'method' => $data['method'],
                'distance' => round($distance, 1),
            ])
            ->withFragment('result');
    }

    private function calculateDistance(string $origin, string $destination): float
    {
        try {
            $originCoords = $this->geocodeAddress($origin);
            $destCoords = $this->geocodeAddress($destination);

            if ($originCoords && $destCoords) {
                $distanceMeters = $this->getOSRMDistance($originCoords, $destCoords);
                if ($distanceMeters > 0) {
                    return $distanceMeters / 1000.0;
                }
            }
        } catch (\Exception $e) {
            // Fallback to crc32 mock below
        }

        // Fallback: deterministic mock distance based on origin and destination
        $val = abs(crc32(strtolower($origin) . ' - ' . strtolower($destination)));
        return 150.0 + ($val % 650);
    }

    private function geocodeAddress(string $address): ?array
    {
        $url = 'https://nominatim.openstreetmap.org/search?q=' . urlencode($address) . '&format=json&limit=1';
        
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: BywardLogistics/1.0 (info@bywardlogistics.com)'
                ],
                'timeout' => 3
            ]
        ];
        $context = stream_context_create($opts);
        
        $response = @file_get_contents($url, false, $context);
        if ($response) {
            $data = json_decode($response, true);
            if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
                return [
                    'lat' => (float)$data[0]['lat'],
                    'lon' => (float)$data[0]['lon']
                ];
            }
        }
        
        return null;
    }

    private function getOSRMDistance(array $origin, array $dest): float
    {
        $url = "https://router.project-osrm.org/route/v1/driving/{$origin['lon']},{$origin['lat']};{$dest['lon']},{$dest['lat']}?overview=false";
        
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: BywardLogistics/1.0 (info@bywardlogistics.com)'
                ],
                'timeout' => 3
            ]
        ];
        $context = stream_context_create($opts);
        
        $response = @file_get_contents($url, false, $context);
        if ($response) {
            $data = json_decode($response, true);
            if (!empty($data) && isset($data['routes'][0]['distance'])) {
                return (float)$data['routes'][0]['distance'];
            }
        }
        
        return 0.0;
    }

    /**
     * Format an amount in the site currency, falling back to a plain
     * format when the intl extension is unavailable.
     */
    private function formatPrice(float $amount): string
    {
        $currency = config('byward.estimate.currency');

        if (class_exists(\NumberFormatter::class)) {
            $formatter = new \NumberFormatter(
                App::getLocale() === 'fr' ? 'fr_CA' : 'en_US',
                \NumberFormatter::CURRENCY
            );

            return $formatter->formatCurrency($amount, $currency);
        }

        return App::getLocale() === 'fr'
            ? number_format($amount, 2, ',', ' ').' '.$currency
            : $currency.' '.number_format($amount, 2, '.', ',');
    }
}
