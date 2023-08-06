<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

//project model//
class TicketController extends Controller
{

    /**
     * @OA\GET(
     *     path="/api/ticket/get-ticket",
     *     tags={"Ticket"},
     *     summary="getTicket",
     *     description="get requested ticket",
     *     operationId="getTicket",
     *      security={{"bearerAuth":{}}},

     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function getTicket(Request $request)
    {

        $user = auth()->user();

        $record = Ticket::where('user_id', $user->id)->orderBy('id', 'desc')->get();

        return $this->success([
            'ticket' => $record,
        ], '');
    }
    /**
     * @OA\GET(
     *     path="/api/ticket/read-ticket",
     *     tags={"Ticket"},
     *     summary="getTicket",
     *     description="read requested ticket",
     *     operationId="getTicket",
     *      security={{"bearerAuth":{}}},
     *       @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="ticket id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function readTicket(Request $request)
    {

        $user = auth()->user();

        $ticket = Ticket::where('user_id', $user->id)->where('id', $request->get('id'))->first();
        $ticket->user_read = 1;
        $ticket->save();
        return $this->success([
            'ticket' => $ticket,
        ], '');
    }

    /**
     * @OA\Post(
     *    path="/api/ticket/create-ticket",
     *     tags={"Ticket"},
     *     summary="create ticket",
     *     description="Register member",
     *     operationId="createTicket",
     *      security={{"bearerAuth":{}}},
     *     deprecated=false,
     *  *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="title",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="body",
     *         in="query",
     *         description="body",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function createTicket(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        $user = auth()->user();
        $data = $request->only('title', 'body');
        $data['user_id'] = $user->id;
        $data['user_read'] = 1;
        $ticket = Ticket::create($data);
        return $this->success('', 'Ticket_added');
    }
}
