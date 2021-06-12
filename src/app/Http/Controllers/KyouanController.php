<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhoto;
use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreKyouan;

class KyouanController extends Controller
{
    public function __construct()
    {
        // 認証
        $this->middleware('auth');
    }

    /**
     * 教案の投稿
     *
     * @param StoreKyouan $request
     * @return void
     */
    public function create(StoreKyouan $request)
    {
        // 投稿画像の拡張子を取得する
        $extension = $request->kyouan->extension();

        $kyouan = new Kyouan;

        // 'public'でファイルを公開状態で保存
        $kyouan->filename = $kyouan->id . '.' . $extension;
        Storage::cloud() //putFileAsは名前をつけたい時に使用 Storage::cloud()はfilesystems.phpのcloud
            ->putFileAs('', $request->kyouan_img, $kyouan->filename, 'public');
        
        // データベースエラー時にファイル削除を行うため
        DB::beginTransaction();

        try {
            Auth::user()->kyouan()->save($kyouan);
            DB::commit();
        } catch(\Exception $exception)  {
            DB::rollback();
            // DBをロールバックしたのでアップロードファイルも削除
            Storage::cloud()->delete($kyouan->filename);
            throw $exception;
        }

        return response($kyouan, 201);
    }
}
