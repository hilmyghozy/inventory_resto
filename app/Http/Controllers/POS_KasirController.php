<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class POS_KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $pagination = $request->pagination;
        $index = 4;
        $page_now =1;
        $url = 'pos-config.kasir.kasir';
        $start = 1;

        if($search==null && $pagination ==null){
            $datakasir = DB::table('pos_kasir')->skip(0)->take($index)->get();;
            $count = DB::table('pos_kasir')->count();
            $count = ceil($count/$index);
        }elseif($search==null&&$pagination!=null){
            $count = DB::table('pos_kasir')->count();
            $count = ceil($count/$index);
            $page_now = $pagination;
            $datakasir = DB::table('pos_kasir')->skip(($page_now-1)*$index)->take($index)->get();
            $start = (($page_now-1)*$index)+1;
        }elseif($search!=null && $pagination ==null){
            $count = DB::table('pos_kasir')
                ->where('nama', 'like', '%'.$search.'%')
                ->orWhere('username', 'like', '%'.$search.'%')
                ->orWhere('role', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            $page_now = 1;
            $datakasir = DB::table('pos_kasir')
                ->where('nama', 'like', '%'.$search.'%')
                ->orWhere('username', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->orWhere('role', 'like', '%'.$search.'%')
                ->get();
            $start = 1;
        }else{
            $count = DB::table('pos_kasir')
                ->where('nama', 'like', '%'.$search.'%')
                ->orWhere('username', 'like', '%'.$search.'%')
                ->orWhere('role', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            
            $page_now = $pagination;
            $datakasir = DB::table('pos_kasir')
                ->where('nama', 'like', '%'.$search.'%')
                ->orWhere('username', 'like', '%'.$search.'%')
                ->orWhere('role', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            $start = (($page_now-1)*$index)+1;
        }

        // return $count;

        return view($url, compact ('datakasir', 'page_now', 'search', 'count', 'start'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        DB::table('pos_kasir')->insert(
            ['id' => null, 'username' => $request->username, 'nama' => $request->nama, 
            'password' => $request->password, 'role' => $request->role]
        );
        
        return redirect('uc/user')->with('status1', 'Data Berhasil Ditambah');
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
        $datakasir = DB::table('pos_kasir')->where('id', $id)->get();
        return view('pos-config.kasir.kasir-edit', compact('datakasir'));
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
        DB::table('pos_kasir')
              ->where('id', $request->id)
              ->update(['username' => $request->username, 'nama' => $request->nama, 
              'password' => $request->password, 'role' => $request->role]);

        return redirect('uc/user')->with('status1', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('pos_kasir')->where('id', $id)->delete();
        return redirect('uc/user')->with('status1', 'Data Berhasil Dihapus');
    }
}
