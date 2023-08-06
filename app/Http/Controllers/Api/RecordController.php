<?php

namespace App\Http\Controllers\Api;

use App\Helper\Bonus;
use App\Http\Controllers\Controller;
use App\Models\DynamicBonus;
use App\Models\FundTransfer;
use App\Models\LevelBonus;
use App\Models\MatchingBonus;
use App\Models\SpecialBonus;
use App\Models\SponsorBonus;
use App\Models\User;
use Illuminate\Http\Request;

//project model//
class RecordController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/record/wallet-record",
     *     tags={"Record"},
     *     summary="",
     *     description="wallet record",
     *     operationId="walletRecord",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="wallet",
     *         in="query",
     *         description="point1,point2",
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
    public function walletRecord(Request $request)
    {
        $this->validate($request, [
            'wallet' => 'required',
        ]);
        if ($request->get('wallet') == 'point1') {
            $wallet = 1;
        } else if ($request->get('wallet') == 'point2') {
            $wallet = 2;
        } else if ($request->get('wallet') == 'point3') {
            $wallet = 3;
        } else if ($request->get('wallet') == 'point4') {
            $wallet = 4;
        } else {
            $wallet = 10;
        }
        $db = FundTransfer::select('*');

        $db->where('user_id', auth()->user()->id);

        if ($wallet) {
            $db->where(function ($q) use ($wallet) {
                $q->where('in_type', $wallet)
                    ->orWhere('out_type', $wallet);
            });
        }

        if ($request->get('start_date')) {
            $db->whereBetween('created_at', [$request->get('start_date') . ' 00:00:00', $request->get('end_date') . ' 23:59:59']);
        }

        if ($request->get('found_type')) {
            $found_type = explode(",", $request->get('found_type'));
            $db->wherein('found_type', $found_type);
        }
        $total = $db->sum('found');
        $record = $db->orderBy('id', 'desc')->paginate(10);

        return $this->success([
            'record' => $record,
            'total_amount' => $total,
            'found_type' => $this->fount_type(),
        ], '');
    }
    /**
     * @OA\Get(
     *     path="/api/record/bonus-record",
     *     tags={"Record"},
     *     summary="",
     *     description="bonus record",
     *     operationId="bonusRecord",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="bonus",
     *         in="query",
     *         description="static_bonus,sponsor_bonus",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * *      @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="start_date",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * *      @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         description="end_date",
     *         required=false,
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
    public function bonusRecord(Request $request)
    {

        $bonus = $request->get('bonus');

        if ($bonus == 'sponsor_bonus') {
            $record = SponsorBonus::select('*');
            $total = SponsorBonus::select('*');
        } elseif ($bonus == 'dynamic_bonus') {
            $record = DynamicBonus::select('*');
            $total = DynamicBonus::select('*');
        } elseif ($bonus == 'matching_bonus') {
            $record = MatchingBonus::select('*');
            $total = MatchingBonus::select('*');
        } elseif ($bonus == 'special_bonus') {
            $record = SpecialBonus::select('*');
            $total = SpecialBonus::select('*');
        } else {
            $record = LevelBonus::select('*');
            $total = LevelBonus::select('*');
        }
        if ($request->get('start_date')) {

            $where[0] = ['created_at', '>=', $request->get('start_date') . ' 00:00:00'];
            $where[1] = ['created_at', '<=', $request->get('end_date') . ' 23:59:59'];
            $record->where($where);
            $total->where($where);
        }
        $record = $record->where('user_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(10);
        $total = $total->where('user_id', auth()->user()->id)->sum('founds');

        return $this->success([
            'record' => $record,
            'total_amount' => $total,
        ], '');
    }
}
