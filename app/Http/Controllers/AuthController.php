<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterFormRequest;
use App\User;

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
        $user         = auth('api')->user();
        $createdToken = $user->createToken('Access Token');
        $token        = $createdToken->token;
        $token->save();

        return response()->json([
            'message' => '',
            'data'    => [
                'accessToken' => $createdToken->accessToken,
                'tokenType'   => 'Bearer',
                'user'        => $user
            ]], 200);
    }

    public function logout()
    {
        request()->user()->token()->revoke();

        return response([
            'message' => 'Logged out',
            'data'    => [],
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
            $createdToken = request()->user()->createToken('Access Token');
            $token        = $createdToken->token;
            $token->save();

            $user = request()->user();
            $user->expires_at = (request()->get('remember')) ? 7 : 1;
            $user->save();

            return $this->respondWithToken($createdToken);
        } else {
            return response()->json([
                'message' => 'Wrong credentials. Could not log in.',
                'data'    => null
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
            'message' => '',
            'data'    => [
                'accessToken' => $token->accessToken,
                'tokenType'   => 'Bearer',
                'user'        => auth()->user(),
            ]
        ], 200);
    }
}
