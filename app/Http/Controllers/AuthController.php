<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterFormRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param RegisterFormRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function register(RegisterFormRequest $request)
    {
        $user           = new User;
        $user->email    = $request->email;
        $user->name     = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();

        return $this->loginUser($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        return $this->loginUser($request);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $user              = auth('api')->user();
        $createdToken      = $user->createToken('Access Token');
        $token             = $createdToken->token;
        $token->expires_at = (request()->get('rememberMe')) ? Carbon::now()->addDays(1) : -1;
        $token->save();

        return response()->json([
            'data'  => [
                'accessToken' => $createdToken->accessToken,
                'tokenType'   => 'Bearer',
                'expiresAt'   => Carbon::parse($createdToken->token->expires_at)->toDateTimeString(),
                'user'        => $user,
            ],
            'error' => null
        ], 200);
    }

    public function logout()
    {
//        auth('api')->logout();
        request()->user()->token()->revoke();

        return response([
            'data'  => ['msg' => 'Logged out'],
            'error' => null
        ], 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(request()->user());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function loginUser(Request $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $authorized  = auth()->attempt($credentials);

        if ($authorized) {
            $createdToken      = request()->user()->createToken('Access Token');
            $token             = $createdToken->token;
            $token->expires_at = ($request->get('rememberMe')) ? Carbon::now()->addWeeks(1) : -1;
            $token->save();

            return $this->respondWithToken($createdToken);
        } else {
            return response()->json([
                'data'  => null,
                'error' => ['msg' => 'Could not login.']
            ], 401);
        }
    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'data'  => [
                'accessToken' => $token->accessToken,
                'tokenType'   => 'Bearer',
                'expiresAt'   => Carbon::parse($token->token->expires_at)->toDateTimeString(),
                'user'        => auth()->user(),
            ],
            'error' => null
        ], 200);
    }
}
