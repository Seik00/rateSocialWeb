<?php
namespace App\Http\Controllers\Api;

use App\Helper\Binaxtion;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

//project model//
class BOController extends Controller
{
    /**
     * @OA\get(
     *     path="/api/bo/login",
     *     tags={"BO"},
     *     summary="",
     *     description="login to Binary Option",
     *     operationId="loginBO",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function login(Request $request)
    {
        $user = auth()->user();
        Binaxtion::login($user->username);

    }
    /**
     * @OA\get(
     *     path="/api/bo/boInfo",
     *     tags={"BO"},
     *     summary="",
     *     description="boInfo",
     *     operationId="boInfo",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function boInfo(Request $request)
    {
        $user = auth()->user();
        $bo_info = Binaxtion::user_info($user->username);

        return $this->success($bo_info, '');
    }

    /**
     * @OA\post(
     *     path="/api/bo/deposit",
     *     tags={"BO"},
     *     summary="",
     *     description="bo deposit",
     *     operationId="bodeposit",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ), @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         description="amount to deposit",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function deposit(Request $request)
    {
        $amount = $request->get('amount');
        $user = auth()->user();
        //$result = Binaxtion::deposit($user->username, $amount);

        return $this->success($result, '');

    }
}
