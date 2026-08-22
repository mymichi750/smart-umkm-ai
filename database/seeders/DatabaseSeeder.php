<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get or Create User
        $user = User::where('name', 'agung')->first();
        if (!$user) {
            $user = User::where('email', 'agung@example.com')->first();
        }
        if (!$user) {
            $user = User::first();
        }
        if (!$user) {
            $user = User::create([
                'name' => 'agung',
                'email' => 'agung@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'premium_level' => 1,
            ]);
        }

        // 2. Seed Categories
        $categories = [
            ['name' => 'Sembako', 'description' => 'Bahan pokok kebutuhan sehari-hari'],
            ['name' => 'Minuman', 'description' => 'Aneka minuman segar dan kemasan'],
            ['name' => 'Makanan Ringan', 'description' => 'Camilan, snack, dan biskuit'],
            ['name' => 'Kebutuhan Rumah Tangga', 'description' => 'Sabun, sampo, detergen, dan pembersih'],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[] = Category::firstOrCreate(
                ['name' => $cat['name']],
                ['slug' => Str::slug($cat['name']), 'description' => $cat['description']]
            );
        }

        // 3. Seed Products
        $products = [
            // Sembako
            ['category_idx' => 0, 'name' => 'Beras Pandan Wangi 5kg', 'sku' => 'SEM-001', 'purchase_price' => 65000, 'sell_price' => 75000, 'stock' => 15],
            ['category_idx' => 0, 'name' => 'Minyak Goreng Bimoli 2L', 'sku' => 'SEM-002', 'purchase_price' => 32000, 'sell_price' => 36000, 'stock' => 3], // Low stock
            ['category_idx' => 0, 'name' => 'Gula Pasir Gulaku 1kg', 'sku' => 'SEM-003', 'purchase_price' => 14000, 'sell_price' => 16500, 'stock' => 20],
            ['category_idx' => 0, 'name' => 'Telur Ayam Ras 1kg', 'sku' => 'SEM-004', 'purchase_price' => 24000, 'sell_price' => 27000, 'stock' => 5], // Low stock
            
            // Minuman
            ['category_idx' => 1, 'name' => 'Aqua Air Mineral 600ml', 'sku' => 'MIN-001', 'purchase_price' => 2500, 'sell_price' => 3500, 'stock' => 48],
            ['category_idx' => 1, 'name' => 'Teh Botol Sosro 450ml', 'sku' => 'MIN-002', 'purchase_price' => 4000, 'sell_price' => 5500, 'stock' => 24],
            ['category_idx' => 1, 'name' => 'Coca Cola 250ml', 'sku' => 'MIN-003', 'purchase_price' => 3500, 'sell_price' => 5000, 'stock' => 8], // Low stock

            // Makanan Ringan
            ['category_idx' => 2, 'name' => 'Indomie Goreng Spesial', 'sku' => 'MAK-001', 'purchase_price' => 2600, 'sell_price' => 3100, 'stock' => 120],
            ['category_idx' => 2, 'name' => 'Chitato Sapi Panggang 68g', 'sku' => 'MAK-002', 'purchase_price' => 9500, 'sell_price' => 11500, 'stock' => 12],
            ['category_idx' => 2, 'name' => 'Roma Biskuit Kelapa 300g', 'sku' => 'MAK-003', 'purchase_price' => 8000, 'sell_price' => 9500, 'stock' => 4], // Low stock

            // Kebutuhan Rumah Tangga
            ['category_idx' => 3, 'name' => 'Rinso Anti Noda 770g', 'sku' => 'KRT-001', 'purchase_price' => 18000, 'sell_price' => 21000, 'stock' => 10],
            ['category_idx' => 3, 'name' => 'Pepsodent Herbal 190g', 'sku' => 'KRT-002', 'purchase_price' => 11000, 'sell_price' => 13500, 'stock' => 15],
            ['category_idx' => 3, 'name' => 'Lifebuoy Sabun Cair Refill 400ml', 'sku' => 'KRT-003', 'purchase_price' => 19500, 'sell_price' => 23000, 'stock' => 2], // Low stock
        ];

        $productModels = [];
        foreach ($products as $prod) {
            $catId = $categoryModels[$prod['category_idx']]->id;
            $productModels[] = Product::firstOrCreate(
                ['sku' => $prod['sku']],
                [
                    'category_id' => $catId,
                    'name' => $prod['name'],
                    'purchase_price' => $prod['purchase_price'],
                    'sell_price' => $prod['sell_price'],
                    'stock' => $prod['stock'],
                    'description' => 'Produk ' . $prod['name'],
                    'active' => true,
                ]
            );
        }

        // 4. Seed Customers
        $customers = [
            ['name' => 'Budi Santoso', 'email' => 'budi@gmail.com', 'phone' => '081234567890', 'address' => 'Jl. Merdeka No. 10'],
            ['name' => 'Siti Aminah', 'email' => 'siti@gmail.com', 'phone' => '081398765432', 'address' => 'Jl. Mawar No. 5'],
            ['name' => 'Agus Wijaya', 'email' => 'agus@gmail.com', 'phone' => '085711223344', 'address' => 'Jl. Melati No. 12'],
        ];

        $customerModels = [];
        foreach ($customers as $cust) {
            $customerModels[] = Customer::firstOrCreate(
                ['phone' => $cust['phone']],
                [
                    'name' => $cust['name'],
                    'email' => $cust['email'],
                    'address' => $cust['address'],
                ]
            );
        }

        // 5. Seed Transactions (for the last 7 days + today)
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            
            // Number of transactions on this day
            $numTransactions = ($i == 0) ? rand(3, 5) : rand(1, 3);
            
            for ($t = 0; $t < $numTransactions; $t++) {
                $customer = $customerModels[array_rand($customerModels)];
                
                // Pick random products
                $selectedKeys = (array) array_rand($productModels, rand(1, 3));
                
                $total = 0;
                $detailsData = [];
                $itemsCount = 0;
                
                foreach ($selectedKeys as $pIdx) {
                    $prod = $productModels[$pIdx];
                    $qty = rand(1, 3);
                    $subtotal = $prod->sell_price * $qty;
                    
                    $total += $subtotal;
                    $itemsCount += $qty;
                    
                    $detailsData[] = [
                        'product_id' => $prod->id,
                        'quantity' => $qty,
                        'price' => $prod->sell_price,
                        'subtotal' => $subtotal,
                    ];
                }
                
                $paid = ceil($total / 10000) * 10000;
                if ($paid < $total) {
                    $paid = $total;
                }
                
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'customer_id' => $customer->id,
                    'payment_method' => rand(0, 1) ? 'cash' : 'qris',
                    'invoice' => 'INV-' . $date->format('Ymd') . '-' . sprintf('%04d', rand(1, 9999)),
                    'total' => $total,
                    'paid' => $paid,
                    'change' => $paid - $total,
                    'items_count' => $itemsCount,
                    'notes' => 'Transaksi otomatis seeder',
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
                
                foreach ($detailsData as $detail) {
                    $detail['transaction_id'] = $transaction->id;
                    TransactionDetail::create($detail);
                }
            }
        }
    }
}
