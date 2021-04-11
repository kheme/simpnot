<?php

namespace App\Services;

use Throwable;
use App\Models\Topic;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Facades\Log;

class BroadcastService
{
    /**
     * Create new subscription by adding URLs (subscribers) to a topic
     *
     * @param string $topic      Topic of interest to subscriber
     * @param string $subscriber URL to subscribe to the topic of interest
     *
     * @author Okiemute Omuta <iamkheme@gmail.com>
     *
     * @return bool
     */
    public function publish(string $topic, object $message)
    {
        try {
            $subscribers = Topic::where('name', $topic)
                ->with('subscribers')
                ->first()
                ->subscribers()
                ->pluck('name');

            $client   = new Client();
            $promises = [];

            foreach ($subscribers as $subscriber) {
                $promises[] = $client->postAsync($subscriber, [ 'form_params' => $message ]);
            }

            $failed_broadcasts = [];

            foreach (Utils::settle($promises)->wait() as $key => $response) {
                if ($response['value']->getStatusCode() != 200) {
                    $failed_broadcasts[] = $subscribers[$key];
                }
            }

            return array_unique($failed_broadcasts) ?? true;
        } catch (Throwable $exception) {
            Log::error($exception);

            return false;
        }
    }
}
