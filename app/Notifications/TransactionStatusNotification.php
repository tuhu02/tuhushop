<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $transaction;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct(Transaction $transaction, string $status)
    {
        $this->transaction = $transaction;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $subject = $this->getSubject();
        $greeting = $this->getGreeting();
        $message = $this->getMessage();

        return (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line($message)
            ->line('Order ID: ' . $this->transaction->order_id)
            ->line('Game: ' . $this->transaction->game->game_name)
            ->line('Amount: ' . $this->transaction->formatted_amount)
            ->line('User ID Game: ' . $this->transaction->user_id_game)
            ->when($this->status === 'success', function ($mail) {
                return $mail->line('Your topup has been processed successfully!');
            })
            ->when($this->status === 'failed', function ($mail) {
                return $mail->line('If you have any questions, please contact our support team.');
            })
            ->action('View Transaction', url('/transactions/' . $this->transaction->id))
            ->line('Thank you for using Tuhu Topup!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'transaction_id' => $this->transaction->id,
            'order_id' => $this->transaction->order_id,
            'status' => $this->status,
            'game_name' => $this->transaction->game->game_name,
            'amount' => $this->transaction->amount,
            'user_id_game' => $this->transaction->user_id_game,
            'message' => $this->getMessage(),
            'created_at' => now()
        ];
    }

    /**
     * Get notification subject.
     */
    protected function getSubject(): string
    {
        return match($this->status) {
            'success' => 'Topup Berhasil - ' . $this->transaction->game->game_name,
            'failed' => 'Topup Gagal - ' . $this->transaction->game->game_name,
            'processing' => 'Topup Sedang Diproses - ' . $this->transaction->game->game_name,
            default => 'Update Status Topup - ' . $this->transaction->game->game_name
        };
    }

    /**
     * Get notification greeting.
     */
    protected function getGreeting(): string
    {
        return 'Halo ' . $this->transaction->user->name . '!';
    }

    /**
     * Get notification message.
     */
    protected function getMessage(): string
    {
        return match($this->status) {
            'success' => 'Selamat! Topup ' . $this->transaction->game->game_name . ' Anda telah berhasil diproses.',
            'failed' => 'Maaf, topup ' . $this->transaction->game->game_name . ' Anda gagal diproses.',
            'processing' => 'Topup ' . $this->transaction->game->game_name . ' Anda sedang diproses.',
            default => 'Status topup ' . $this->transaction->game->game_name . ' Anda telah diperbarui.'
        };
    }
} 