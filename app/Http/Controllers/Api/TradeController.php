<?php
namespace App\Http\Controllers\Api;

use App\Helper\TradingPlatform\Trade;
use App\Http\Controllers\Controller;
use App\Models\TradeOrder;
use Illuminate\Http\Request;

//Trading Platform//
class TradeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/trade/placeOrder",
     *     tags={"Team"},
     *     summary="",
     *     description="Robot Team",
     *     operationId="robotTeam",
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
    public function placeOrder(Request $request)
    {
        /*
        'trade_market_id',
        'market_name',
        'order_type'= BUY/SELL
        'order_amount',
        'order_price',
         */
        $user = auth()->user();
        $date = date('Y/m/d h:i:s a', time());
        $market = TraderMarket::where(['id' => $request->get('trade_market_id'),
            'status' => 1])->first();
        if (!$market) {
            return $this->fail('E00044', 'Incorrect Market');
        }

        $order = $request->only('order_type', 'order_side', 'order_maker_fee', 'order_price', );

        $order['trade_market_id'] = $market->id;
        $order['market_name'] = $market->market_name;
        $order['user_id'] = $user->id;
        $order['order_left'] = $order['order_amount']; //amount left
        $order['order_deal_stock'] = 0; //matched amount
        $order['order_deal_stock'] = 0; //matched amount
        $order['order_no'] = (int) filter_var($date, FILTER_SANITIZE_NUMBER_INT) . rand(100, 999);

        $tradeOrder = TradeOrder::create($order);
        $result = $tradeOrder;
        if ($tradeOrder->order_type == 'BUY') {
            Trade::matchBuy($tradeOrder);
        } else {
            Trade::matchSell($tradeOrder);
        }

        return $this->success($result, '');
    }

}
