<?php
/**
 * User: pgorski42
 * Date: 30.10.17
 * Time: 11:41
 */

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Lang;

class ThrottleStandardRequests extends ThrottleRequests
{
    protected function handleRedirection(Request $request, $headers, $retryAfter)
    {
        $message = ['throttle' => [Lang::get('auth.throttle', ['seconds' => $retryAfter])]];

        $response = response()->json($message);
        $response->headers->add($headers);
        $response->setStatusCode(Response::HTTP_TOO_MANY_REQUESTS, Response::$statusTexts[Response::HTTP_TOO_MANY_REQUESTS]);
        return $response;
    }

    public function handle($request, Closure $next, $maxAttempts = 3, $decayMinutes = 1)
    {
        $key = $this->resolveRequestSignature($request);

        $maxAttempts = $this->resolveMaxAttempts($request, $maxAttempts);

        if ($this->limiter->tooManyAttempts($key, $maxAttempts, $decayMinutes)) {
            $retryAfter = $this->getTimeUntilNextRetry($key);

            $headers = $this->getHeaders(
                $maxAttempts,
                $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
                $retryAfter
            );

            return $this->handleRedirection($request, $headers, $retryAfter);
        }

        $this->limiter->hit($key, $decayMinutes);

        $response = $next($request);

        return $this->addHeaders(
            $response, $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts)
        );
    }

    // static method of resolveRequestSignature($request)
    protected static function createRequestSignature($request)
    {
        if ($user = $request->user()) {
            return sha1($user->getAuthIdentifier());
        }

        if ($route = $request->route()) {
            return sha1($route->getDomain().'|'.$request->ip());
        }

        throw new RuntimeException(
            'Unable to generate the request signature. Route unavailable.'
        );
    }
}