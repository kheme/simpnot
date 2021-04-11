<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [ 'name', ];

    public function subscribers()
    {
        return $this->hasManyThrough(
            Subscriber::class,
            TopicSubscriber::class,
            'topic_id', 'id',
        );
    }

    /**
     * Adds a subscriber (URL) to the current topic
     *
     * @param Subscriber $subscriber URL to subscribe to topic
     *
     * @author Okiemute Omuta <iamkheme@gmail.com>
     *
     * @return void
     */
    public function addSubscriber(Subscriber $subscriber)
    {   
        TopicSubscriber::updateOrCreate([
            'topic_id'      => $this->id,
            'subscriber_id' => $subscriber->id,
        ]);
    }
}
