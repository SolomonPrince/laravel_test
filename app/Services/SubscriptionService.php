<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Exception;

class SubscriptionService
{
    /**
     * Инициирует процесс подписки, шифрует email пользователя,
     * генерирует URL для подтверждения и отправляет письмо с ссылкой для подтверждения.
     *
     * @param string $email Email адрес пользователя, который подписывается.
     * @return array Массив с сообщением о процессе подписки.
     */
    public function subscribe(string $email): array
    {
        try {
            $encryptedEmail = Crypt::encryptString($email);
        } catch (Exception $e) {
            return ['message' => 'Ошибка при шифровании email.'];
        }

        $expiration = Carbon::now()->addHour();

        $verificationUrl = URL::temporarySignedRoute(
            'subscription.verify',
            $expiration,
            ['encryptedEmail' => $encryptedEmail]
        );

        try {
            Mail::raw("Подтвердите вашу подписку по ссылке: $verificationUrl", function ($message) use ($email) {
                $message->to($email)
                        ->subject('Подтверждение подписки');
            });
        } catch (Exception $e) {
            return ['message' => 'Ошибка при отправке email.'];
        }

        return ['message' => 'Ссылка для подтверждения отправлена на ваш email.'];
    }


    /**
     * Подтверждает подписку путем расшифровки email и подтверждения процесса.
     *
     * @param string $encryptedEmail Зашифрованный email адрес из ссылки подтверждения.
     * @return array Массив с сообщением и расшифрованным email адресом.
     */
    public function verify($encryptedEmail):array
    {
        try {
            $email = Crypt::decryptString($encryptedEmail);
        } catch (Exception $e) {
            return ['message' => 'Некорректная или истекшая ссылка подтверждения.'];
        }

        // Здесь можно обработать подтверждение подписки, например, отправить приветственное письмо.

        return ['message' => 'Email успешно подтвержден.', 'email' => $email];
    }
}