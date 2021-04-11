<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopicSubscriber extends Model
{
    protected $fillable = [ 'topic_id', 'subscriber_id', ];
}
