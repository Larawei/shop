<?php

use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = factory(Product::class, 30)->create();
        foreach ($products as $product) {
           $skus = factory(ProductSku::class, 3)->create(['product_id' => $product->id]);
           $product->update(['price' => $skus->min('price')]);
        }
    }
}
