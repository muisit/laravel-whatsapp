<?php

namespace NotificationChannels\WhatsApp;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Broadcasting\Channel;

class Provider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $manager = $this->app->make(ChannelManager::class);
        if ($manager) {
            $manager->extend('whatsapp', function ($app) {
                return new Channel(new WhatsApp());
            });
            $manager->channel("whatsapp");
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
