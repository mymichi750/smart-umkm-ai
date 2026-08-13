<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_with_empty_stock_is_automatically_inactive(): void
    {
        $product = $this->createProduct(['stock' => 0, 'active' => true]);

        $this->assertFalse($product->fresh()->active);
    }

    public function test_product_becomes_inactive_after_last_item_is_sold(): void
    {
        $user = User::factory()->create(['role' => 'kasir']);
        $product = $this->createProduct(['stock' => 1, 'active' => true]);

        $response = $this->actingAs($user)
            ->withSession([
                'pos.cart' => [
                    $product->id => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->sell_price,
                        'quantity' => 1,
                        'subtotal' => $product->sell_price,
                    ],
                ],
            ])
            ->post(route('pos.checkout'), ['paid' => $product->sell_price]);

        $response->assertRedirect();
        $this->assertSame(0, $product->fresh()->stock);
        $this->assertFalse($product->fresh()->active);
    }

    private function createProduct(array $attributes): Product
    {
        $category = Category::create(['name' => 'Makanan', 'slug' => 'makanan']);

        return Product::create(array_merge([
            'category_id' => $category->id,
            'name' => 'Produk Uji',
            'sku' => 'SKU-UJI-' . fake()->unique()->numerify('####'),
            'purchase_price' => 5_000,
            'sell_price' => 10_000,
            'stock' => 1,
            'active' => true,
        ], $attributes));
    }
}
