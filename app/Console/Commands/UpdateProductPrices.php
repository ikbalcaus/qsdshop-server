<?php

namespace App\Console\Commands;

use App\Models\Discount;
use Illuminate\Console\Command;

class UpdateProductPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-product-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredDiscounts = Discount::where('valid_to', '<', now())->get();

        foreach ($expiredDiscounts as $discount) {
            foreach ($discount->products as $product) {
                if ($discount->discount > 0) {
                    $originalPrice = $product->price / (1 - ($discount->discount / 100));
                    $product->price = $originalPrice;
                    $product->discounts()->detach($discount->id);
                    $product->save();
                }
            }
        }
        $this->info('The product prices have been successfully reverted to their original values after the discount expired.');
    }
}
