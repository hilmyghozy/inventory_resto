<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class POS_ProductStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataitem = DB::table('pos_product_item')->get();

        $search = $request->search;
        $pagination = $request->pagination;
        $index = 5;
        $page_now =1;
        $url = 'pos-config.product.stock';
        $start = 1;

        if($search==null && $pagination ==null){
            $datastock = DB::table('pos_product_stock')
                    ->join('pos_product_item', 'pos_product_stock.id_item', '=', 'pos_product_item.id_item')
                    ->select('pos_product_stock.*', 'pos_product_item.nama_item')
                    ->skip(0)->take($index)->get();;
            $count = DB::table('pos_product_item')->count();
            $count = ceil($count/$index);
        }elseif($search==null&&$pagination!=null){
            $count = DB::table('pos_product_item')->count();
            $count = ceil($count/$index);
            $page_now = $pagination;
            $datastock = DB::table('pos_product_stock')
                    ->join('pos_product_item', 'pos_product_stock.id_item', '=', 'pos_product_item.id_item')
                    ->select('pos_product_stock.*', 'pos_product_item.nama_item')
                    ->skip(($page_now-1)*$index)->take($index)->get();
            $start = (($page_now-1)*$index)+1;
        }elseif($search!=null && $pagination ==null){
            $count = DB::table('pos_product_stock')
                ->join('pos_product_item', 'pos_product_stock.id_item', '=', 'pos_product_item.id_item')
                ->select('pos_product_stock.*', 'pos_product_item.nama_item')
                ->where('pos_product_item.nama_item', 'like', $search.'%')
                ->orWhere('tanggal', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            $page_now = 1;
            $datastock = DB::table('pos_product_stock')
                ->join('pos_product_item', 'pos_product_stock.id_item', '=', 'pos_product_item.id_item')
                ->select('pos_product_stock.*', 'pos_product_item.nama_item')
                ->where('pos_product_item.nama_item', 'like', $search.'%')
                ->orWhere('tanggal', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            $start = 1;
        }else{
            $count = DB::table('pos_product_stock')
                ->join('pos_product_item', 'pos_product_stock.id_item', '=', 'pos_product_item.id_item')
                ->select('pos_product_stock.*', 'pos_product_item.nama_item')
                ->where('pos_product_item.nama_item', 'like', $search.'%')
                ->orWhere('tanggal', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            
            $page_now = $pagination;
            $datastock = DB::table('pos_product_stock')
                ->join('pos_product_item', 'pos_product_stock.id_item', '=', 'pos_product_item.id_item')
                ->select('pos_product_stock.*', 'pos_product_item.nama_item')
                ->where('pos_product_item.nama_item', 'like', $search.'%')
                ->orWhere('tanggal', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            
            $start = (($page_now-1)*$index)+1;
        }

        return view($url, compact ('dataitem', 'datastock', 'page_now', 'search', 'count', 'start'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
