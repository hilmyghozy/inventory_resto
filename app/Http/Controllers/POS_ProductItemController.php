<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class POS_ProductItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $dataitem = DB::table('pos_product_item')
        //     ->join('pos_product_kategori', 'pos_product_item.id_kategori', '=', 'pos_product_kategori.id_kategori')
        //     ->join('pos_store', 'pos_product_item.id_store', '=', 'pos_store.id_store')
        //     ->select('pos_product_item.*', 'pos_product_kategori.nama_kategori', 'pos_store.nama_store')
        //     ->get();

        $datakategori = DB::table('pos_product_kategori')->get();
        $datastore = DB::table('pos_store')->get();

        $search = $request->search;
        $pagination = $request->pagination;
        $index = 10;
        $page_now =1;
        $url = 'pos-config.product.item';
        $start = 1;

        if($search==null && $pagination ==null){
            $dataitem = DB::table('pos_product_item')
                    ->join('pos_product_kategori', 'pos_product_item.id_kategori', '=', 'pos_product_kategori.id_kategori')
                    ->join('pos_store', 'pos_product_item.id_store', '=', 'pos_store.id_store')
                    ->select('pos_product_item.*', 'pos_product_kategori.nama_kategori', 'pos_store.nama_store')
                    ->skip(0)->take($index)->get();;
            $count = DB::table('pos_product_item')->count();
            $count = ceil($count/$index);
        }elseif($search==null&&$pagination!=null){
            $count = DB::table('pos_product_item')->count();
            $count = ceil($count/$index);
            $page_now = $pagination;
            $dataitem = DB::table('pos_product_item')
                    ->join('pos_product_kategori', 'pos_product_item.id_kategori', '=', 'pos_product_kategori.id_kategori')
                    ->join('pos_store', 'pos_product_item.id_store', '=', 'pos_store.id_store')
                    ->select('pos_product_item.*', 'pos_product_kategori.nama_kategori', 'pos_store.nama_store')
                    ->skip(($page_now-1)*$index)->take($index)->get();
            $start = (($page_now-1)*$index)+1;
        }elseif($search!=null && $pagination ==null){
            $count = DB::table('pos_product_item')
                ->join('pos_product_kategori', 'pos_product_item.id_kategori', '=', 'pos_product_kategori.id_kategori')
                ->join('pos_store', 'pos_product_item.id_store', '=', 'pos_store.id_store')
                ->select('pos_product_item.*', 'pos_product_kategori.nama_kategori', 'pos_store.nama_store')
                ->where('nama_item', 'like', $search.'%')
                ->orWhere('pos_product_kategori.nama_kategori', 'like', '%'.$search.'%')
                ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            $page_now = 1;
            $dataitem = DB::table('pos_product_item')
                ->join('pos_product_kategori', 'pos_product_item.id_kategori', '=', 'pos_product_kategori.id_kategori')
                ->join('pos_store', 'pos_product_item.id_store', '=', 'pos_store.id_store')
                ->select('pos_product_item.*', 'pos_product_kategori.nama_kategori', 'pos_store.nama_store')
                ->where('nama_item', 'like', $search.'%')
                ->orWhere('pos_product_kategori.nama_kategori', 'like', '%'.$search.'%')
                ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            $start = 1;
        }else{
            $count = DB::table('pos_product_item')
                ->join('pos_product_kategori', 'pos_product_item.id_kategori', '=', 'pos_product_kategori.id_kategori')
                ->join('pos_store', 'pos_product_item.id_store', '=', 'pos_store.id_store')
                ->select('pos_product_item.*', 'pos_product_kategori.nama_kategori', 'pos_store.nama_store')
                ->where('nama_item', 'like', $search.'%')
                ->orWhere('pos_product_kategori.nama_kategori', 'like', '%'.$search.'%')
                ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            
            $page_now = $pagination;
            $dataitem = DB::table('pos_product_item')
                ->join('pos_product_kategori', 'pos_product_item.id_kategori', '=', 'pos_product_kategori.id_kategori')
                ->join('pos_store', 'pos_product_item.id_store', '=', 'pos_store.id_store')
                ->select('pos_product_item.*', 'pos_product_kategori.nama_kategori', 'pos_store.nama_store')
                ->where('nama_item', 'like', '%'.$search.'%')
                ->orWhere('pos_product_kategori.nama_kategori', 'like', '%'.$search.'%')
                ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            
            $start = (($page_now-1)*$index)+1;
        }

        // return $count;

        return view($url, compact ('dataitem', 'datastore', 'datakategori', 'page_now', 'search', 'count', 'start'));

        // return view('pos-config.product.item', compact (['dataitem', 'datakategori', 'datastore']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        DB::table('pos_product_item')->insert(
            ['id_item' => null, 'nama_item' => $request->nama_item, 
            'harga' => $request->harga, 'id_kategori' => $request->id_kategori, 
            'id_store' => $request->id_store, 'pajak' => $request->pajak, 
            'harga_jual' => $request->harga_jual, 'thirdparty' => $request->thirdparty]
        );

        return redirect('pos/item')->with('status1', 'Item Berhasil Ditambah');
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
        $dataitem = DB::table('pos_product_item')->where('id_item', $id)->get();
        $datakategori = DB::table('pos_product_kategori')->get();
        $datastore = DB::table('pos_store')->get();

        return view('pos-config.product.item-edit', compact (['dataitem', 'datakategori', 'datastore']));
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
        DB::table('pos_product_item')
              ->where('id_item', $request->id_item)
              ->update(['nama_item' => $request->nama_item, 'id_kategori' => $request->id_kategori,
              'id_store' => $request->id_store, 'harga' => $request->harga, 'pajak' => $request->pajak,
              'harga_jual' => $request->harga_jual, 'thirdparty' => $request->thirdparty]);

        return redirect('pos/item')->with('status1', 'Item Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('pos_product_item')->where('id_item', $id)->delete();

        return redirect('pos/item')->with('status1', 'Item Berhasil Dihapus');
    }
}
