<?php

namespace App\Http\Controllers\Api;

use Auth;
use JWTAuth;
use App\Distributor;
use App\Http\Requests\Api\AuthLogin;
use App\Customs\Transformers\AuthTransformer;


class AuthController extends ApiController
{
    /**
     * AuthController constructor.
     *
     * @param AuthTransformer $transformer
     */
    public function __construct(AuthTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Login user and return the user if successful.
     *
     * @param Login $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthLogin $request)
    {
        $credentials = $request->only('auth.login', 'auth.password');
        $credentials = $credentials['auth'];

        if (!Auth::once($credentials)) {
            return $this->respondFailedLogin();
        }

        return $this->respondWithTransformer(auth()->user());
    }

    /**
     * Destroy session token.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return $this->respond(['message' => 'Successfully logged out'], 202);
    }
}