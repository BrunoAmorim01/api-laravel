<?php

namespace App\Jobs;

use App\Repositories\ProductMovimentationRepository;
use App\Repositories\ProductRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessProductMovimentation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    /**
     * Create a new job instance.
     */
    public function __construct(
        $data,
    ) {
        $this->data = $data;
    }



    /**
     * Execute the job.
     */
    public function handle(
        ProductMovimentationRepository $productMovimentationRepository,
        ProductRepository $productRepository,
    ): void {
        Log::info('Processing product movimentation');
        Log::info('data: ' . $this->data);
        $productMovementData = json_decode($this->data);

        $productMovement = $productMovimentationRepository->find($productMovementData->id);

        if (!$productMovement) {
            Log::error('Product movement not found');
            return;
        }

        if ($productMovement->type === 'out') {
            $productRepository->decrements($productMovement->productId, $productMovement->quantity);
            Log::info('Decremented product stock');

        } else {
            $productRepository->increments($productMovement->productId, $productMovement->quantity);
            Log::info('Incremented product stock');
        }
    }
}
