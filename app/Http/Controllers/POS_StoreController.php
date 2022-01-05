<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class POS_StoreController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->search;
        $pagination = $request->pagination;
        $index = 4;
        $page_now =1;
        $url = 'pos-config.store.store';
        $start = 1;

        if($search==null && $pagination ==null){
            $datastore = DB::table('pos_store')->skip(0)->take($index)->get();;
            $count = DB::table('pos_store')->count();
            $count = ceil($count/$index);
        }elseif($search==null&&$pagination!=null){
            $count = DB::table('pos_store')->count();
            $count = ceil($count/$index);
            $page_now = $pagination;
            $datastore = DB::table('pos_store')->skip(($page_now-1)*$index)->take($index)->get();
            $start = (($page_now-1)*$index)+1;
        }elseif($search!=null && $pagination ==null){
            $count = DB::table('pos_store')
                ->where('nama_store', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            $page_now = 1;
            $datastore = DB::table('pos_store')
                ->where('nama_store', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            $start = 1;
        }else{
            $count = DB::table('pos_store')
                ->where('nama_store', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            
            $page_now = $pagination;
            $datastore = DB::table('pos_store')
                ->where('nama_store', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            $start = (($page_now-1)*$index)+1;
        }

        // return $count;

        return view($url, compact ('datastore', 'page_now', 'search', 'count', 'start'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        DB::table('pos_store')->insert(
            ['id_store' => null, 'kode_store' => $request->kode_store, 
            'nama_store' => $request->nama_store, 'jumlah_meja' => $request->jumlah_meja, 
            'print_kasir' => $request->print_kasir]
        );

        $id_store = DB::table('pos_store')->where('kode_store', $request->kode_store)
                    ->where('nama_store', $request->nama_store)->first()->id_store;

        for ($i=1; $i <= $request->jumlah_meja ; $i++) { 
            DB::table('pos_meja')->insert(
                ['id_store' => $id_store, 
                'nama_meja' => "Meja ".$i, 'status' => 0]
            );
        }
        
        return redirect('pos/store')->with('status1', 'Store Berhasil Ditambah');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $datastore = DB::table('pos_store')->where('id_store', $id)->get();
        return view('pos-config.store.store-edit', compact('datastore'));
    }

    public function update(Request $request)
    {
        DB::table('pos_meja')->where('id_store', $request->id_store)->delete();
        for ($i=1; $i <= $request->jumlah_meja ; $i++) { 
            DB::table('pos_meja')->insert(
                ['id_store' => $request->id_store, 
                'nama_meja' => "Meja ".$i, 'status' => 0]
            );
        }

        DB::table('pos_store')
              ->where('id_store', $request->id_store)
              ->update(['kode_store' => $request->kode_store, 'nama_store' => $request->nama_store, 
              'jumlah_meja' => $request->jumlah_meja, 'print_kasir' => $request->print_kasir]);

        return redirect('pos/store')->with('status1', 'Store Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('pos_store')->where('id_store', $id)->delete();
        DB::table('pos_meja')->where('id_store', $id)->delete();
        return redirect('pos/store')->with('status1', 'Store Berhasil Dihapus');
    }
}
