<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompressResponse
{
    /**
     * Gzip/Brotli for local `php artisan serve` and other PHP stacks.
     * Production behind Cloudflare typically compresses at the edge; this middleware is a no-op
     * when Content-Encoding is already set.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! in_array($request->getMethod(), ['GET', 'HEAD'], true) || ! $response->isSuccessful()) {
            return $response;
        }

        if ($response->headers->has('Content-Encoding')) {
            return $response;
        }

        $content = $response->getContent();

        if ($content === false || $content === '') {
            return $response;
        }

        $accept = (string) $request->headers->get('Accept-Encoding', '');

        if (str_contains($accept, 'br') && function_exists('brotli_compress')) {
            $compressed = brotli_compress($content, 4);

            if ($compressed !== false) {
                $response->setContent($compressed);
                $response->headers->set('Content-Encoding', 'br');
                $response->headers->set('Vary', 'Accept-Encoding', false);

                return $response;
            }
        }

        if (str_contains($accept, 'gzip') && function_exists('gzencode')) {
            $compressed = gzencode($content, 6);

            if ($compressed !== false) {
                $response->setContent($compressed);
                $response->headers->set('Content-Encoding', 'gzip');
                $response->headers->set('Vary', 'Accept-Encoding', false);
            }
        }

        return $response;
    }
}
