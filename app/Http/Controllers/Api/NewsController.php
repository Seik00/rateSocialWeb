<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class NewsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/news/news-list",
     *     tags={"News"},
     *     summary="",
     *     description="News",
     *     operationId="newsList",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *      @OA\Parameter(
     *         name="language",
     *         in="query",
     *         description="en/cn/in/vn/th",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *   *      @OA\Parameter(
     *         name="news_type",
     *         in="query",
     *         description="",
     *         required=false,
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
    public function newsList(Request $request)
    {
        $db = News::select('*');
        $db->where('language', $request->get('language'));
        $db->where('news_type', $request->get('news_type'));

        $db->where('is_display', 1);
        $record = $db->orderBy('id', 'desc')->paginate(10);
        $db = News::select('*');
        $db->where('language', $request->get('language'));
        $db->where('news_type', $request->get('news_type'));

        $db->where('is_display', 1);
        $db->where('is_pop', 1);
        $latest = $db->orderBy('id', 'desc')->first();
        $datap['record'] = $record;

        return $this->success([
            'record' => $record,
            'latest' => $latest,
        ], '');
    }

    /**
     * @OA\Get(
     *     path="/api/news/banner-list",
     *     tags={"News"},
     *     summary="",
     *     description="News",
     *     operationId="bannerList",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *      @OA\Parameter(
     *         name="language",
     *         in="query",
     *         description="en/cn",
     *         required=false,
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
    public function bannerList(Request $request)
    {
        $db = News::select('*');
        $db->where('language', $request->get('language'));
        $db->where('news_type', 2);

        $db->where('is_display', 1);
        $record = $db->orderBy('id', 'desc')->limit(5)->get();

        return $this->success($record, '');
    }
}
