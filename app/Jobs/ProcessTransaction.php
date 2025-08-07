<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Services\DigiflazzService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TransactionStatusNotification;
use App\Models\PriceList;

class ProcessTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300; // 5 minutes
    public $tries = 3;
    public $backoff = [60, 180, 360]; // Retry delays in seconds

    protected $transaction;

    /**
     * Create a new job instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     */
    public function handle(DigiflazzService $digiflazzService): void
    {
        try {
            Log::info('Processing transaction', [
                'order_id' => $this->transaction->order_id,
                'user_id' => $this->transaction->user_id,
                'amount' => $this->transaction->amount
            ]);

            // Update transaction status to processing
            $this->transaction->update([
                'transaction_status' => Transaction::STATUS_PROCESSING
            ]);

            // Get denom data using the relationship
            $denom = $this->transaction->priceList;
            if (!$denom || !$denom->kode_digiflazz) {
                throw new \Exception('SKU Digiflazz not found for transaction: ' . $this->transaction->order_id);
            }



            // Use the service method instead of direct request
            $result = $digiflazzService->orderProduct($this->transaction);

            if ($result['status'] === 'success') {
                // Update transaction with Digiflazz reference
                $this->transaction->update([
                    'digiflazz_ref_id' => $result['data']['ref_id'] ?? null,
                    'transaction_status' => Transaction::STATUS_SUCCESS,
                    'metadata' => array_merge($this->transaction->metadata ?? [], [
                        'digiflazz_response' => $result['data']
                    ])
                ]);

                // Send success notification
                $this->sendNotification('success');

                Log::info('Transaction processed successfully', [
                    'order_id' => $this->transaction->order_id,
                    'digiflazz_ref_id' => $result['data']['ref_id'] ?? null
                ]);

            } else {
                // Handle failure
                $this->handleFailure($result['data']['message'] ?? 'Unknown error');
            }

        } catch (\Exception $e) {
            Log::error('Transaction processing failed', [
                'order_id' => $this->transaction->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->handleFailure($e->getMessage());
            
            // Re-throw to trigger retry
            throw $e;
        }
    }

    /**
     * Handle transaction failure.
     */
    protected function handleFailure(string $errorMessage): void
    {
        $this->transaction->update([
            'transaction_status' => Transaction::STATUS_FAILED,
            'notes' => $errorMessage,
            'metadata' => array_merge($this->transaction->metadata ?? [], [
                'error' => $errorMessage,
                'failed_at' => now()->toISOString()
            ])
        ]);

        // Send failure notification
        $this->sendNotification('failed');

        Log::error('Transaction failed', [
            'order_id' => $this->transaction->order_id,
            'error' => $errorMessage
        ]);
    }

    /**
     * Send notification to user.
     */
    protected function sendNotification(string $status): void
    {
        try {
            // Check if user exists before sending notification
            if ($this->transaction->user) {
                $notification = new TransactionStatusNotification($this->transaction, $status);
                $this->transaction->user->notify($notification);
            } else {
                Log::warning('User not found for notification', [
                    'order_id' => $this->transaction->order_id,
                    'user_id' => $this->transaction->user_id
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send notification', [
                'order_id' => $this->transaction->order_id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Transaction job failed permanently', [
            'order_id' => $this->transaction->order_id,
            'error' => $exception->getMessage()
        ]);

        // Update transaction status to failed
        $this->transaction->update([
            'transaction_status' => Transaction::STATUS_FAILED,
            'notes' => 'Job processing failed: ' . $exception->getMessage()
        ]);

        // Send failure notification
        $this->sendNotification('failed');
    }
} 