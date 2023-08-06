<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LiveChat;
use App\Models\User;
use Illuminate\Http\Request;

//project model//
class ChatController extends Controller
{

    /**
     * @OA\GET(
     *     path="/api/chat/getChatNotification",
     *     tags={"Chat"},
     *     summary="",
     *     description="getChatNotification",
     *     operationId="getChatNotification",
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
    public function getChatNotification(Request $request)
    {

        $user = auth()->user();
        $record = LiveChat::where([
            ['user_id', '=', $user->id],
            ['message_type', '=', 'admin'],
            ['is_read', '=', 0],
        ])->count();

        return $this->success('', 'REQUEST_COMPLETE');

    }
    /**
     * @OA\GET(
     *     path="/api/chat/getChat",
     *     tags={"Chat"},
     *     summary="",
     *     description="getChat",
     *     operationId="getChat",
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
    public function getChat(Request $request)
    {

        $user = auth()->user();
        LiveChat::where([
            ['user_id', '=', $user->id],
            ['message_type', '=', 'admin'],
            ['is_read', '=', 0],
        ])->update([['is_read', 1]]);
        $record = LiveChat::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);

        return $this->success('', 'REQUEST_COMPLETE');

    }
/**
 * @OA\post(
 *     path="/api/chat/sentChat",
 *     tags={"Chat"},
 *     summary="",
 *     description="sentChat",
 *     operationId="sentChat",
 *     deprecated=false,
 *     security={{"bearerAuth":{}}},
 *       @OA\Parameter(
 *         name="message",
 *         in="query",
 *         description="Message",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
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
    public function sentChat(Request $request)
    {

        $user = auth()->user();

        $record = $request->only('message');

        $record['user_id'] = $user->id;

        LiveChat::create($record);

        return $this->success('', 'REQUEST_COMPLETE');

    }
}
