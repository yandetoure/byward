<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_the_visitors_preferred_locale(): void
    {
        $this->get('/', ['Accept-Language' => 'fr-CA,fr;q=0.9'])->assertRedirectContains('/fr');
        $this->get('/', ['Accept-Language' => 'en-US,en;q=0.9'])->assertRedirectContains('/en');
    }

    public function test_root_falls_back_to_french_for_unsupported_languages(): void
    {
        $this->get('/', ['Accept-Language' => 'de-DE,de;q=0.9'])->assertRedirectContains('/fr');
    }

    #[DataProvider('publicPages')]
    public function test_public_pages_render(string $locale, string $path): void
    {
        $this->get("/{$locale}/{$path}")->assertOk();
    }

    public static function publicPages(): array
    {
        $pages = ['', 'services', 'industries', 'about', 'faq', 'contact', 'quote', 'estimate', 'privacy', 'terms'];
        $cases = [];

        foreach (['fr', 'en'] as $locale) {
            foreach ($pages as $path) {
                $cases["{$locale}/{$path}"] = [$locale, $path];
            }
        }

        return $cases;
    }

    public function test_unsupported_locale_is_not_found(): void
    {
        $this->get('/de')->assertNotFound();
    }

    public function test_contact_lead_is_stored_and_confirmed(): void
    {
        $this->post('/fr/contact', [
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'phone' => '+1 555 000 0000',
            'company' => 'Acme',
            'message' => 'Bonjour, je souhaite un devis.',
        ])->assertRedirect()->assertSessionHas('status');

        $this->assertSame(1, Lead::where('type', 'contact')->count());
        $this->assertSame('fr', Lead::first()->locale);
    }

    public function test_contact_form_is_validated(): void
    {
        $this->post('/fr/contact', ['name' => '', 'email' => 'not-an-email'])
            ->assertSessionHasErrors(['name', 'email', 'message']);

        $this->assertSame(0, Lead::count());
    }

    public function test_honeypot_submissions_are_dropped(): void
    {
        $this->post('/en/contact', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'message' => 'spam',
            'website' => 'http://spam.test',
        ])->assertRedirect();

        $this->assertSame(0, Lead::count());
    }

    public function test_quote_request_is_stored_with_shipment_details(): void
    {
        $this->post('/en/quote', [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '+1 555 111 2222',
            'origin_street' => '123 Main St',
            'origin_province' => 'ON',
            'origin_postal_code' => 'K2P 1L4',
            'destination_street' => '456 Queen St',
            'destination_province' => 'QC',
            'destination_postal_code' => 'H3B 4W5',
            'shipment_type' => 'road_ltl',
            'weight' => 250,
            'length' => 120,
            'width' => 80,
            'height' => 60,
        ])->assertRedirect()->assertSessionHas('status');

        $lead = Lead::where('type', 'quote')->firstOrFail();

        $this->assertSame('123 Main St', $lead->origin_street);
        $this->assertSame('ON', $lead->origin_province);
        $this->assertSame('K2P 1L4', $lead->origin_postal_code);
        $this->assertSame('456 Queen St', $lead->destination_street);
        $this->assertSame('QC', $lead->destination_province);
        $this->assertSame('H3B 4W5', $lead->destination_postal_code);
        $this->assertSame('456 Queen St, QC, H3B 4W5', $lead->destination);
        $this->assertSame(250.0, (float) $lead->weight);
    }

    public function test_quote_rejects_an_unknown_shipment_type(): void
    {
        $this->post('/fr/quote', [
            'name' => 'X', 'email' => 'x@example.com', 'phone' => '1',
            'origin_street' => 'A',
            'origin_province' => 'B',
            'origin_postal_code' => 'C',
            'destination_street' => 'D',
            'destination_province' => 'E',
            'destination_postal_code' => 'F',
            'shipment_type' => 'teleportation', 'weight' => 10,
        ])->assertSessionHasErrors('shipment_type');
    }

    public function test_estimate_is_calculated_above_the_method_minimum(): void
    {
        $this->post('/en/estimate', [
            'origin_street' => '123 Main St',
            'origin_province' => 'ON',
            'origin_postal_code' => 'K2P 1L4',
            'destination_street' => '456 Queen St',
            'destination_province' => 'QC',
            'destination_postal_code' => 'H3B 4W5',
            'method' => 'road_ltl',
            'weight' => 500,
        ])->assertRedirect()->assertSessionHas('estimate');

        $estimate = session('estimate');

        $priceFloat = (float) str_replace(['$', ',', ' '], '', $estimate['price']);
        $this->assertGreaterThanOrEqual(720, $priceFloat);
        $this->assertSame(3, $estimate['days_min']);
    }

    public function test_tiny_estimate_is_floored_at_the_method_minimum(): void
    {
        $this->post('/en/estimate', [
            'origin_street' => 'NonExistentOriginStreetAddressXYZ123',
            'origin_province' => 'XX',
            'origin_postal_code' => '000000',
            'destination_street' => 'NonExistentDestinationStreetAddressXYZ123',
            'destination_province' => 'YY',
            'destination_postal_code' => '000000',
            'method' => 'road_ftl', 'weight' => 1,
        ]);

        $this->assertStringContainsString('480', session('estimate')['price']);
    }

    public function test_estimate_rejects_an_invalid_method(): void
    {
        $this->post('/fr/estimate', [
            'origin_street' => 'A',
            'origin_province' => 'B',
            'origin_postal_code' => 'C',
            'destination_street' => 'D',
            'destination_province' => 'E',
            'destination_postal_code' => 'F',
            'method' => 'rocket', 'weight' => 10,
        ])->assertSessionHasErrors('method');
    }

    public function test_pages_expose_hreflang_alternates_and_translated_copy(): void
    {
        $this->get('/fr/services')
            ->assertOk()
            ->assertSee('hreflang="en"', false)
            ->assertSee('/en/services', false);

        $this->get('/en/services')->assertSee('End-to-End Logistics Services', false);
        $this->get('/fr/services')->assertSee('Des services logistiques de bout en bout', false);
    }
}
