<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/get-next-screen',
        '/delete-id',
        '/like-id',
        '/zero-views-clicks',
        '/add-girl',
        'increase-view-id'
    ];
}
