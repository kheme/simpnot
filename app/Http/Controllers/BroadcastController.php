<?php

namespace App\Http\Controllers;

use App\Services\BroadcastService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BroadcastController extends BaseController
{
    protected $broadcast_service;

    public function __construct(BroadcastService $broadcast_service)
    {
        $this->broadcast_service = $broadcast_service;
    }

    public function store(Request $request, string $topic = null)
    {   
        if (Validator::make($request->all(), [ 'url' => [ 'required', 'json' ], ]) == false) {
            return $this->successResponse('Please enter a valid JSON payload');
        }

        $published = $this->broadcast_service->publish($topic, (object) $request->all());

        if ($published == false) {
            return $this->errorResponse('The topic \'' . $topic . '\' does not exist!', 404);
        }

        if (empty($published) == false) {
            return $this->errorResponse('Could not publish message to the following subscriber(s): ' . implode(', ', $published));
        }

        return $this->successResponse('Message published to all subscribers successfully');
    }
}
