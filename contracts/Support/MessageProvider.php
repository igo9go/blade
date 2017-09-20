<?php

namespace Blade\Contracts\Support;

interface MessageProvider
{
    /**
     * Get the messages for the instance.
     *
     * @return \Blade\Contracts\Support\MessageBag
     */
    public function getMessageBag();
}
