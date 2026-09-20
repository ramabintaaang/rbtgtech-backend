<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PortfolioUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_upload_cover_image_when_creating_portfolio(): void
    {
        Storage::fake('public');

        $user = User::first() ?? User::factory()->create();

        $file = UploadedFile::fake()->image('test_cover.jpg', 800, 600);

        $response = $this->actingAs($user)->post('/admin/portfolio', [
            'title' => 'Unit Test Portfolio Pro',
            'slug' => 'unit-test-portfolio-pro',
            'category' => 'Enterprise System',
            'status' => 'published',
            'image_file' => $file,
        ], ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $response->assertJsonPath('status', 'success');

        $portfolio = Portfolio::where('slug', 'unit-test-portfolio-pro')->first();
        $this->assertNotNull($portfolio);
        $this->assertStringStartsWith('/storage/portfolios/', $portfolio->image_url);

        $storedFilename = str_replace('/storage/portfolios/', '', $portfolio->image_url);
        Storage::disk('public')->assertExists('portfolios/' . $storedFilename);

        // Test updating cover image
        $newFile = UploadedFile::fake()->image('updated_cover.png', 1000, 800);
        $updateResponse = $this->actingAs($user)->post("/admin/portfolio/{$portfolio->id}", [
            '_method' => 'PUT',
            'title' => 'Unit Test Portfolio Updated',
            'slug' => 'unit-test-portfolio-pro',
            'category' => 'Enterprise System',
            'status' => 'published',
            'image_file' => $newFile,
        ], ['Accept' => 'application/json']);

        $updateResponse->assertStatus(200);
        $portfolio->refresh();

        $newStoredFilename = str_replace('/storage/portfolios/', '', $portfolio->image_url);
        Storage::disk('public')->assertExists('portfolios/' . $newStoredFilename);
        Storage::disk('public')->assertMissing('portfolios/' . $storedFilename);

        // Test delete
        $deleteResponse = $this->actingAs($user)->delete("/admin/portfolio/{$portfolio->id}", [], ['Accept' => 'application/json']);
        $deleteResponse->assertStatus(200);
        Storage::disk('public')->assertMissing('portfolios/' . $newStoredFilename);
    }
}
