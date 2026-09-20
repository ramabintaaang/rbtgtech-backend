<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_access_invoices_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.invoices.index'));
        $response->assertStatus(200);
        $response->assertSee('Manajemen Nota & Invoice');
    }

    public function test_authenticated_user_can_create_invoice_with_dynamic_items(): void
    {
        $user = User::factory()->create();

        $invoiceData = [
            'invoice_number' => 'INV20260920-999',
            'invoice_date' => '2026-09-20',
            'billed_to' => 'PT Testing Indonesia',
            'status' => 'unpaid',
            'items' => [
                [
                    'item' => 'Jasa Pembuatan Web App',
                    'quantity' => 1,
                    'unit_price' => 2500000,
                ],
                [
                    'item' => 'Hosting & Domain 1 Tahun',
                    'quantity' => 1,
                    'unit_price' => 500000,
                ]
            ],
            'account_name' => 'RAMA BINTANG',
            'bank_name' => 'Bank Mandiri',
            'account_number' => '1350019554706',
        ];

        $response = $this->actingAs($user)->post(route('admin.invoices.store'), $invoiceData);
        $response->assertRedirect();

        $invoice = Invoice::where('invoice_number', 'INV20260920-999')->first();
        $this->assertNotNull($invoice);
        $this->assertEquals(3000000, (float) $invoice->total_amount);
        $this->assertCount(2, $invoice->items);

        // Test print view
        $printResponse = $this->actingAs($user)->get(route('admin.invoices.print', $invoice->id));
        $printResponse->assertStatus(200);
        $printResponse->assertSee('PT Testing Indonesia');
        $printResponse->assertSee('INVOICE');
        $printResponse->assertSee('Rp 3.000.000');

        // Cleanup test invoice
        $invoice->delete();
    }
}
