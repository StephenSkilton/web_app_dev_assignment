<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'manufacturer_id', 'sku', 'product_image','description'];

    /**
     * Public URL of the uploaded image, or null when there is none.
     * (Requires `php artisan storage:link`.)
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->product_image ? Storage::url($this->product_image) : null
        );
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    /** Many-to-many: the carts this product has been added to (pivot: cart_items). */
    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'cart_items')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /** Many-to-many: the orders this product appears in (pivot: order_items). */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
