<?php

namespace App\Http\Middleware;

use Closure;

class AvailableHours
{

    /**
     * Hour Start
     * 
     * @var string
     */
    private $_start = '08:00:00';

    /**
     * Hour End
     * 
     * @var string
     */
    private $_end = '17:00:00';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if (strtotime(date('H:i:s')) >= strtotime($this->_start)
        //     && strtotime(date('H:i:s')) >= strtotime($this->_end)) {

        //     return $this->respondError('Forbidden: the service isn\'t available at this time');
        // }

        return $next($request);
    }

    /**
     * Respond with json error message.
     *
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondError($message)
    {
        return response()->json([
            'errors' => [
                'message' => $message,
                'status_code' => 403
            ]
        ], 401);
    }
}