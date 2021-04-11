<?php

namespace App\Http\Controllers;

use Throwable;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends BaseController
{
    protected $subscription_service;

    public function __construct(SubscriptionService $subscription_service)
    {
        $this->subscription_service = $subscription_service;
    }

    /**
     * Create new subscription
     *
     * @param Request $request HTTP request
     *                          Payload includes "url" (string) as the subscriber
     * @param string $topic    Topif of interest to the subscribers
     *
     * @author Okiemute Omuta <iamkheme@gmail.com>
     *
     * @return json
     */
    public function store(Request $request, string $topic = null)
    {   
        if (Validator::make($request->all(), [ 'url' => [ 'required', 'string' ], ]) == false) {
            return $this->errorResponse('Please provide a URL');
        }

        try {
            $this->subscription_service->subscribe($topic, $request->url);
            
            return $this->jsonResponse([
                'url'   => $request->url,
                'topic' => $topic,
            ]);
        } catch (Throwable $exception) {
            Log::error($exception);

            return $this->errorResponse('Creating subscription failed! Please try again later', 500);
        }
    }
    /**
     * Deletes an existing subscription
     *
     * @param Request $request HTTP request
     *                          Payload includes "url" (string) as the unsubscriber
     * @param string $topic    Topif of interest to unsubscribe from
     *
     * @author Okiemute Omuta <iamkheme@gmail.com>
     *
     * @return json
     */
    public function destroy(Request $request, string $topic = null)
    {
        if (Validator::make($request->all(), [ 'url' => [ 'required', 'string' ], ]) == false) {
            return $this->errorResponse('Please provide a URL');
        }

        try {
            $this->subscription_service->unsubscribe($topic, $request->url);

            return $this->successResponse('Subscription deleted successfully');
        } catch(Throwable $exception) {
            Log::error($exception);

            return $this->errorResponse('Error unsubscribing! Please try again later');
        }
    }
}
