<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SubscriptionRequest;
use App\Services\SubscriptionService;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    // Метод для отображения формы подписки
    public function showForm(): View
    {
        return view('subscription.form');
    }


    // Метод для обработки формы подписки
    public function subscribe(SubscriptionRequest $request): JsonResponse
    {
        $response = $this->subscriptionService->subscribe($request->input('email'));

        return response()->json($response);
    }


    // Метод для верификации email
    public function verify(Request $request): JsonResponse
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'Неверная или просроченная ссылка.');
        }

        $response = $this->subscriptionService->verify($request->input('encryptedEmail'));

        return response()->json($response);
    }
}
