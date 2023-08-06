<?php

namespace App\Http\Controllers\Api;

use App\Helper\Bonus;
use App\Http\Controllers\Controller;
use App\Models\BoostOrder;
use App\Models\BoostOrderMultiple;
use App\Models\Order;
use App\Models\Product;
use App\Models\StaticBonus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

//project model//
class OrderController extends Controller
{
    /**
     * @OA\get(
     *     path="/api/order/orderInfo",
     *     tags={"Order"},
     *     summary="",
     *     description="orderInfo",
     *     operationId="orderInfo",
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
    public function orderInfo(Request $request)
    {
        $user = auth()->user();

        $result['today_bonus'] = StaticBonus::where('user_id', $user->id)->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->sum('founds');
        $result['yesterday_bonus'] = StaticBonus::where('user_id', $user->id)->whereDate('created_at', '=', Carbon::now()->subDays(1)->format('Y-m-d'))->sum('founds');
        $result['today_completed_order'] = BoostOrder::where('user_id', $user->id)->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->count() + $user->boost_limit;
        $result['user'] = $user;

        $limit = $user->package->boost_times;

        if ($user->day_limit > 0) {
            $limit = $user->day_limit;
        } else {
            $limit = $user->package->boost_times;
        }

        $result['today_limit'] = $limit;
        $result['today_left_times'] = $limit - $result['today_completed_order'];

        return $this->success($result, '');
    }
    /**
     * @OA\post(
     *     path="/api/order/checkOrder",
     *     tags={"Order"},
     *     summary="",
     *     description="checkOrder",
     *     operationId="checkOrder",
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
    public function checkOrder(Request $request)
    {
        $hour = Carbon::now()->format('H');
        if ($hour < 10 || $hour > 23) {
            return $this->fail('E00024', 'Operate Time in  10AM to 11:55PM');
        }
        $user = auth()->user();
        $today_completed_order = BoostOrder::where('user_id', $user->id)->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->count();
        $today_completed_order = $today_completed_order + $user->boost_limit;

        if ($user->day_limit > 0) {
            $limit = $user->day_limit;
        } else {
            $limit = $user->package->boost_times;
        }
        if ($today_completed_order >= $limit) {
            return $this->jsonResponse([
                'code' => 'E00025',
                'data' => false,
                'today' => Carbon::now()->format('Y-m-d'),
                'message' => 'REACH_TODAY_LIMIT',
            ]);
        }

        /* $five_minute = BoostOrder::where('user_id', $user->id)->where('created_at', '>', Carbon::now()->subMinutes(5)->toDateTimeString())->first();
        if ($five_minute) {
        return $this->jsonResponse([
        'code' => 2,
        'data' => false,
        'message' => 'FIVE_MINUTE_LIMIT',
        ]);
        }*/
        $result['is_link_order'] = false;
        $rate = 0;
        if ($user->setting) {
            $setting = json_decode($user->setting);

            $check = BoostOrderMultiple::where([['user_id', $user->id], ['status', 0]])->first();
            if ($check) {

                $result['is_link_order'] = true;

                //$price = $setting[$check->link_order + $check->complete_order]->price;
                $rate = $setting[$check->link_order + $check->complete_order]->profit_rate;
                $today_order = $check->link_order + $check->complete_order;

                if (isset($setting[$today_order]->product_id) && $setting[$today_order]->product_id != '') {
                    $result['product'] = Product::where('status', 1)->where('id', $setting[$today_order]->product_id)->first();
                } elseif ($setting[$today_order]->price != 0) {
                    $high = $setting[$today_order]->price + ($setting[$today_order]->price * 0.1);
                    $low = $setting[$today_order]->price * 0.9;
                    $result['product'] = Product::where('status', 1)->whereBetween('price', [$low, $high])->inRandomOrder()->first();
                } else {
                    $low = $user->point1 * 0.6;
                    $high = $user->point1;
                    $result['product'] = Product::where('status', 1)->whereBetween('price', [$low, $high])->inRandomOrder()->first();
                }
            } else {
                if ($setting[$today_completed_order]->order > 1) {
                    $result['is_link_order'] = true;
                }

                $rate = $setting[$today_completed_order]->profit_rate;

                if (isset($setting[$today_completed_order]->product_id) && $setting[$today_completed_order]->product_id != '') {
                    $result['product'] = Product::where('status', 1)->where('id', $setting[$today_completed_order]->product_id)->first();
                } elseif ($setting[$today_completed_order]->price != 0) {
                    $high = $setting[$today_completed_order]->price + ($setting[$today_completed_order]->price * 0.1);
                    $low = $setting[$today_completed_order]->price * 0.9;
                    $result['product'] = Product::where('status', 1)->whereBetween('price', [$low, $high])->inRandomOrder()->first();
                } else {
                    $low = $user->point1 * 0.6;
                    $high = $user->point1;
                    $result['product'] = Product::where('status', 1)->whereBetween('price', [$low, $high])->inRandomOrder()->first();
                }
            }
        } else {

            $low = $user->point1 * 0.6;
            $high = $user->point1;
            $result['product'] = Product::where('status', 1)->whereBetween('price', [$low, $high])->inRandomOrder()->first();
        }

        if (!$result['product']) {
            return $this->fail('E00026', 'NO_PRODUCT_MATCH');
        }
        if ($result['product']->price <= 0) {
            return $this->fail('E00006', 'INSUFFICIAN_BALANCE');
        }
        /*if ($user->setting) {
        $order_setting = json_decode($user->setting);
        if (isset($order_setting[$today_completed_order])) {
        $result['total_cost'] = $result['product']->price * $order_setting[$today_completed_order];
        $result['total_order'] = $order_setting[$today_completed_order];
        } else {
        $result['total_cost'] = $result['product']->price;
        $result['total_order'] = 1;
        }

        } else {

        }*/
        if (!$rate) {
            $rate = $user->package->static_bonus;
        }
        $result['total_cost'] = $result['product']->price;
        $result['total_order'] = 1;
        $result['user'] = $user;
        $result['profit'] = $result['total_cost'] * $rate / 100;
        $result['total_return'] = $result['total_cost'] + $result['profit'];
        return $this->success($result, '');
    }

    /**
     * @OA\post(
     *     path="/api/order/boostOrder",
     *     tags={"Order"},
     *     summary="",
     *     description="boostOrder",
     *     operationId="boostOrder",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ), @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="product id from checkorder",
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
    public function boostOrder(Request $request)
    {
        $hour = Carbon::now()->format('H');
        if ($hour < 10 || $hour > 23) {
            return $this->fail('E00024', 'Operate Time in  10AM to 11:55PM');
        }

        $user = auth()->user();
        $today_completed_order = BoostOrder::where('user_id', $user->id)->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->count();
        $today_completed_order = $today_completed_order + $user->boost_limit;
        $result['user'] = $user;

        if ($user->day_limit > 0) {
            $limit = $user->day_limit;
        } else {
            $limit = $user->package->boost_times;
        }

        if ($today_completed_order >= $limit) {
            return $this->fail('E00025', 'REACH_TODAY_LIMIT');
        }

        /*$five_minute = BoostOrder::where('user_id', $user->id)->where('created_at', '>', Carbon::now()->subMinutes(5)->toDateTimeString())->first();

        if ($five_minute) {
        return $this->jsonResponse([
        'code' => 2,
        'data' => false,
        'message' => 'FIVE_MINUTE_LIMIT',
        ]);
        }*/
        $low = $user->point1 * 0.6;
        $product = Product::where('id', $request->get('product_id'))->where('status', 1)->first();
        if (!$product) {
            return $this->fail('E00027', 'INCORRECT_PRODUCT');
        }
        if ($product->price <= 0) {
            return $this->fail('E00006', 'INSUFFICIAN_BALANCE');
        }
        if ($user->point1 < 0) {
            return $this->fail('E00006', 'INSUFFICIAN_BALANCE');
        }
        if ($user->point1 < $product->price) {
            return $this->fail('E00006', 'INSUFFICIAN_BALANCE');
        }
        $total_cost = $product->price;

        $link_order = false;
        $check = null; //123321
        $rate = 0;

        if ($user->setting) {
            $setting = json_decode($user->setting);

            if (isset($setting[$today_completed_order]->product_id) && $setting[$today_completed_order]->product_id != '') {
                $special_product = Product::where('status', 1)->where('id', $setting[$today_completed_order]->product_id)->first();
                if ($special_product->id != $product->id) {
                    return $this->fail('E00027', 'INCORRECT_PRODUCT');
                }
            }

            $multiple_order = BoostOrderMultiple::where([['user_id', $user->id], ['status', 0]])->first();
            if ($multiple_order) {
                $link_order = true;
                $rate = $setting[$multiple_order->link_order + $multiple_order->complete_order]->profit_rate;

                $check_order = $multiple_order->complete_order + 1;
                if ($check_order >= $multiple_order->total_order) {
                    if ($user->point1 < $product->price) {
                        return $this->fail('E00006', 'INSUFFICIAN_BALANCE');
                    }
                }
            } else {
                if ($setting[$today_completed_order]->order > 1) {
                    $link_order = true;

                    $addrecord['user_id'] = $user->id;
                    $addrecord['total_order'] = $user->id;
                    $addrecord['complete_order'] = 0;
                    $addrecord['link_order'] = $today_completed_order;
                    $addrecord['total_order'] = $setting[$today_completed_order]->order;
                    $multiple_order = BoostOrderMultiple::create($addrecord);
                } else {
                    if ($user->point1 < $product->price) {
                        return $this->fail('E00006', 'INSUFFICIAN_BALANCE');
                    }
                }
                $rate = $setting[$today_completed_order]->profit_rate;
            }
        } else {
            if ($user->point1 < $product->price) {
                return $this->fail('E00006', 'INSUFFICIAN_BALANCE');
            }
        }

        $now_order = $today_completed_order + 1;
        $this->create_transaction($user->id, '-', 'point1', 110, 1, $total_cost, '刷单:' . $now_order . ',商品价格:SGD' . $product->price, 'Boost Order :' . $now_order . ' ,Product Price:SGD' . $product->price, 'Rút tiền không thành công', 'Penarikan gagal', 'การถอนล้มเหลว', $request->get('remark'));

        if (!$rate) {
            $rate = $user->package->static_bonus;
        }

        $bonus = Bonus::boost_bonus($user->id, $total_cost, $rate);
        if ($bonus) {

            if ($link_order) {
                $multiple_order->complete_order = $multiple_order->complete_order + 1;

                $this->create_transaction($user->id, '+', 'point2', 101, 2, $bonus + $total_cost, '刷单收益', 'Boost Order Reward');

                if ($multiple_order->complete_order >= $setting[$multiple_order->link_order]->order) {
                    //完成连单
                    $multiple_order->status = 1;
                    $multiple_order->total_order = $setting[$multiple_order->link_order]->order;
                    $user = auth()->user()->fresh();
                    $this->create_transaction($user->id, '-', 'point2', 102, 1, $user->point2, '释放刷单收益', 'Release Boost Reward');

                    $this->create_transaction($user->id, '+', 'point1', 101, 1, $user->point2, '释放刷单收益', 'Release Boost Reward');
                }

                $multiple_order->save();
            } else {
                $this->create_transaction($user->id, '+', 'point1', 100, 1, $bonus + $total_cost, '刷单收益', 'Boost Order Reward');
            }

            $order['user_id'] = $user->id;
            $order['product_id'] = $product->id;
            $order['cost'] = $product->price;
            $order['bonus'] = $bonus;
            $order['order_no'] = $today_completed_order + 1;
            $result = BoostOrder::create($order);
        } else {
            $result = false;
        }
        return $this->success($result, '');
    }
}
