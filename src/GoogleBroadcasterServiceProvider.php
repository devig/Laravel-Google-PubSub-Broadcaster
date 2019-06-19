<?php

namespace WhatDaFox\GoogleBroadcaster;

use Google\Cloud\PubSub\PubSubClient;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Contracts\Broadcasting\Broadcaster;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use WhatDaFox\GoogleBroadcaster\Broadcasters\GoogleBroadcaster;

class GoogleBroadcasterServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     */
    public function boot()
    {
        $this->app->make(BroadcastManager::class)->extend('google-pubsub', function () {
            $client = new PubSubClient([
                'projectId' => env('GOOGLE_CLOUD_PROJECT'),
                'keyFilePath' => base_path(env('GOOGLE_APPLICATION_CREDENTIALS')),
            ]);

            return new GoogleBroadcaster($client);
        });
    }
}