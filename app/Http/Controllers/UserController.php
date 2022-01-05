<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $hash = Hash::make('admin');
        $search = $request->search;
        $pagination = $request->pagination;
        $index = 4;
        $page_now =1;
        $url = 'user-config.admin';
        $start = 1;

        if($search==null && $pagination ==null){
            $datauser = DB::table('sys_user')->skip(0)->take($index)->get();;
            $count = DB::table('sys_user')->count();
            $count = ceil($count/$index);
        }elseif($search==null&&$pagination!=null){
            $count = DB::table('sys_user')->count();
            $count = ceil($count/$index);
            $page_now = $pagination;
            $datauser = DB::table('sys_user')->skip(($page_now-1)*$index)->take($index)->get();
            $start = (($page_now-1)*$index)+1;
        }elseif($search!=null && $pagination ==null){
            $count = DB::table('sys_user')
                ->where('username', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            $page_now = 1;
            $datauser = DB::table('sys_user')
                ->where('username', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            $start = 1;
        }else{
            $count = DB::table('sys_user')
                ->where('username', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            
            $page_now = $pagination;
            $datauser = DB::table('sys_user')
                ->where('username', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            $start = (($page_now-1)*$index)+1;
        }

        // return $count;

        return view($url, compact ('datauser', 'page_now', 'search', 'count', 'start'));
        // $decrypted = Crypt::decryptString($hash);
        return session()->all();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        DB::table('sys_user')->insert(
            ['id' => null, 'username' => $request->username, 'password' => Crypt::encryptString($request->password)]
        );
        
        return redirect('uc/admin')->with('status1', 'Data Berhasil Ditambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect('admin/login');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datauser = DB::table('sys_user')->where('id', $id)->get();
        return view('user-config.admin-edit', compact('datauser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::table('sys_user')
              ->where('id', $request->id)
              ->update(['username' => $request->username, 'password' => Crypt::encryptString($request->password)]);

        return redirect('uc/admin')->with('status1', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('sys_user')->where('id', $id)->delete();
        return redirect('uc/admin')->with('status1', 'Data Berhasil Dihapus');
    }
}
