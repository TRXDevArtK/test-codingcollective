<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Illuminate\Http\Request;

use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @OA\Get(
     *     path="/login",
     *     tags={"auth"},
     *     summary="Oauth Login Gateway",
     *     description="this is route use to login using google oauth2",
     *     operationId="login",
     *     @OA\Parameter(
     *          name="username",
     *          description="password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password",
     *          description="password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="redirect to /login/redir"
     *     )
     * )
     */
    public function redirOauth(){
        try {
            $init = $this->authService->redirOauth();

            return $init;
        } catch (\Throwable $th) {
            return ["something error happen", $th];
        }
    }

    /**
     * @OA\Get(
     *     path="/login/redir",
     *     tags={"auth"},
     *     summary="Oauth Login Redirect",
     *     description="this is route use to as callback from /login oauth2",
     *     operationId="login-redir",
     *     @OA\Response(
     *         response="default",
     *         description="redirect to this app base_url()/"
     *     )
     * )
     */
    public function login(){
        try {
            $init = $this->authService->login();

            return $init;
        } catch (\Throwable $th) {
            return ["something error happen", $th];
        }
    }

    /**
     * @OA\Get(
     *     path="/logout",
     *     tags={"auth"},
     *     summary="logout gateway",
     *     description="this is route use to logout session login",
     *     operationId="logout",
     *     @OA\Response(
     *         response="default",
     *         description="will show you now logout message"
     *     )
     * )
     */
    public function logout(){
        try {
            $init = $this->authService->logout();

            return $init;
        } catch (\Throwable $th) {
            return ["something error happen", $th];
        }
    }


}
