<?php

namespace Blade\Contracts\Support;

interface Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Blade\Http\Request  $request
     * @return \Blade\Http\Response
     */
    public function toResponse($request);
}
