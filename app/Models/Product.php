<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_id',
        'category_id',
        'name',
        'sku',
        'description',
        'purchase_price',
        'sell_price',
        'stock',
        'image',
        'active',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sell_price' => 'decimal:2',
        'stock' => 'integer',
        'active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Product $product): void {
            if ($product->stock <= 0) {
                $product->active = false;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Bootstrap Icon class matching product name / category.
     */
    public function iconClass(): string
    {
        $name = strtolower($this->name ?? '');
        $category = strtolower($this->category?->name ?? '');

        $nameRules = [
            'bi-cup-hot' => ['kopi', 'coffee', 'espresso', 'latte', 'cappuccino'],
            'bi-cup-straw' => ['teh', 'jus', 'soda', 'cola', 'fanta', 'sprite', 'aqua', 'air mineral', 'susu', 'yogurt', 'es teh', 'es jeruk'],
            'bi-egg' => ['telur'],
            'bi-droplet-half' => ['minyak'],
            'bi-egg-fried' => ['mie', 'indomie', 'nasi', 'ayam', 'bakso', 'soto'],
            'bi-basket2' => ['snack', 'keripik', 'chitato', 'camilan', 'biskuit', 'roma', 'wafer'],
            'bi-flower1' => ['buah', 'sayur'],
            'bi-brush' => ['pepsodent', 'gigi', 'odol', 'sikat'],
            'bi-droplet-fill' => ['sabun', 'sampo', 'shampoo', 'detergen', 'rinso', 'lifebuoy', 'pembersih'],
            'bi-box-seam' => ['beras', 'gula', 'tepung', 'garam'],
            'bi-tshirt' => ['baju', 'pakaian', 'kaos', 'celana'],
            'bi-phone' => ['hp', 'handphone', 'gadget', 'charger'],
            'bi-capsule' => ['obat', 'vitamin'],
        ];

        $categoryRules = [
            'bi-cup-straw' => ['minuman', 'drink', 'beverage'],
            'bi-basket2' => ['makanan ringan', 'snack', 'camilan'],
            'bi-egg-fried' => ['makanan', 'food', 'kuliner'],
            'bi-droplet-fill' => ['rumah tangga', 'kebersihan'],
            'bi-box-seam' => ['sembako', 'pokok'],
            'bi-tshirt' => ['fashion', 'pakaian'],
            'bi-phone' => ['elektronik', 'gadget'],
            'bi-capsule' => ['kesehatan', 'apotek'],
            'bi-flower1' => ['buah', 'sayur'],
        ];

        foreach ($nameRules as $icon => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($name, $keyword)) {
                    return $icon;
                }
            }
        }

        foreach ($categoryRules as $icon => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($category, $keyword)) {
                    return $icon;
                }
            }
        }

        return 'bi-box-seam';
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
