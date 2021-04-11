<?php

namespace App\Services;

use App\Models\Topic;
use App\Models\Subscriber;
use App\Models\TopicSubscriber;

class SubscriptionService
{
    /**
     * Create new subscription by adding URLs (subscribers) to a topic
     *
     * @param string $topic      Topic of interest to subscriber
     * @param string $subscriber URL to subscribe to the topic of interest
     *
     * @author Okiemute Omuta <iamkheme@gmail.com>
     *
     * @return Topic
     */
    public function subscribe(string $topic, string $subscriber)
    {
        return Topic::updateOrCreate([ 'name' => $topic ])->addSubscriber(
            Subscriber::updateOrCreate([ 'name' => $subscriber ])
        );
    }

    /**
     * Deletes an existing subscription by removing URLs (subscribers) from a topic
     *
     * @param string $topic      Topic of interest to subscriber
     * @param string $subscriber URL to unsubscribe to the topic of interest
     *
     * @author Okiemute Omuta <iamkheme@gmail.com>
     *
     * @return TopicSubscriber
     */
    public function unsubscribe(string $topic, string $subscriber)
    {
        return TopicSubscriber::join('topics', 'topics.id', 'topic_subscribers.topic_id')
            ->join('subscribers', 'subscribers.id', 'topic_subscribers.subscriber_id')
            ->where('topics.name', $topic)
            ->where('subscribers.name', $subscriber)
            ->delete();
    }
}
