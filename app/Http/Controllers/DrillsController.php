<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Drill;

class DrillsController extends Controller
{
    public function index() {
        $drills = Drill::all();
        return view('drills.index', ['drills' => $drills]);
    }

    public function mypage(){
        $drills = Auth::user()->drills()->get();
        return view('drills.mypage', compact('drills'));
    }

    public function new()
    {
        return view('drills.new');
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_name' => 'required|string|max:255',
            'problem0' => 'required|string|max:255'
        ]);

        // モデルを使って、DBに登録する値をセット
        $drill = new Drill;

        // 一つずつ入れる
        // $drill->title = $request->title;
        // $drill->category_name = $request->category_name;
        // $drill->save();

        // fillを使って一気に入れる
        // $fillableを使っていないと変なデータが入り込んだ場合に勝手にDBが更新されてしまうので注意
        // $drill->fill($request->all())->save();

        Auth::user()->drills()->save($drill->fill($request->all()));

        return redirect('/drills/new')->with('flash_message', __('Reigistered.'));
    }

    public function show($id)
    {
        // GETパラメータが数字かどうかをチェックする。
        if(!ctype_digit($id)){
            return redirect('/drills/new')->with('flash_message', __('Invalid operation was performed.'));
        }
        $drill = Drill::find($id);
        return view('drills.show', ['drill' => $drill]);
    }

    public function edit($id)
    {
        // GETパラメータが数字かどうかをチェックする。URLは文字列で渡されるため。
        // 事前にチェックしておくことでDBへの無駄なアクセスを減らせる（WEBサーバへのアクセスのみで済む）
        if(!ctype_digit($id)){
            return redirect('/drills/new')->with('flash_message', __('Invalid operation was performed.'));
        }
        // $drill = Drill::find($id);
        // ログイン中ユーザの問題を取得する
        $drill = Auth::user()->drills()->find($id);
        return view('drills.edit', ['drill' => $drill]);
    }

    public function update($id, Request $request)
    {
        if(!ctype_digit($id)){
            return redirect('/drills/new')->with('flash_message', __('Invalid operation was performed.'));
        }

        $drill = Drill::find($id);
        $drill->fill($request->all())->save();

        return redirect('/drills')->with('flash_message', __('Registered.'));
    }

    public function destroy($id)
    {
        if(!ctype_digit($id)){
            return redirect('/drills/new')->with('flash_message', __('Invalid operation was performed.'));
        }

        Drill::find($id)->delete();

        return redirect('/drills')->with('flash_message', __('Deleted.'));


    }
}
