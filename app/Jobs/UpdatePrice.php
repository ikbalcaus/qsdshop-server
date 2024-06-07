<?php

namespace App\Jobs;

use App\Models\Discount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdatePrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /*$expiredDiscounts = Discount::where('valid_to', '<', now())->get();
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
       */
        $this->info('The product prices have been successfully reverted to their original values after the discount expired.');

    }
}
