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
            'origin' => ['required', 'string', 'max:180'],
            'destination' => ['required', 'string', 'max:180'],
            'method' => ['required', 'string', 'in:'.implode(',', array_keys($methods))],
            'weight' => ['required', 'numeric', 'min:0.1', 'max:200000'],
        ]);

        $config = $methods[$data['method']];
        $price = config('byward.estimate.base_fee') + ((float) $data['weight'] * $config['rate']);
        $price = max($price, $config['min']);

        return redirect()
            ->route('estimate')
            ->withInput($data)
            ->with('estimate', [
                'price' => $this->formatPrice(round($price, 2)),
                'days_min' => $config['days'][0],
                'days_max' => $config['days'][1],
                'origin' => $data['origin'],
                'destination' => $data['destination'],
                'weight' => (float) $data['weight'],
                'method' => $data['method'],
            ])
            ->withFragment('result');
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
