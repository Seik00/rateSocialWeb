<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Common\AdminBaseController;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends AdminBaseController
{
    public function newsList(Request $request)
    {
        $db = News::select('*');
        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');
    }
    public function newsInfo(Request $request)
    {

        return $this->success([
            'record' => News::where('id', $request->get('id'))->first(),
        ], '');
    }
    public function newsControl(Request $request)
    {
        $data = $request->only('title', 'description', 'news_type', 'language', 'is_display', 'is_pop');

        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $filename = time() . $file->getClientOriginalName();
            $file->storeAs('public/uploaded_news/' . date("Y-m-d"), $filename);
            $path = '/uploaded_news/' . date("Y-m-d") . '/' . $filename;
            $data['banner'] = $path;
        }

        if ($request->get('id')) {
            News::where('id', $request->get('id'))->update($data);
        } else {
            News::create($data);
        }
        return $this->success('', 'REQUEST_COMPLETE');
    }
}
