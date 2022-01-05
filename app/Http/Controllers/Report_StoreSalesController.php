<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Report_StoreSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datastore  = DB::table('pos_store')->get();

        return view("report.store_sales.store_sales",compact('datastore'));
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
    public function show(Request $request)
    {
        $date = $request->date;
        $status = $request->status;
        // $search = ($request->search!=null?$request->search : null);
        $pagination = ($request->pagination!=null?$request->pagination : 1);
        $start = 1;
        $index = 10;
        $search = ($request->search!=null?$request->search : null);
        $store = $request->id_store;
        $datastore  = DB::table('pos_store')->where('id_store','=',$store)->get();
        $datavoucher = DB::table('pos_diskon')->get();
        $datarefund = DB::table('pos_activity_refund')->get();

        if($store=='all'){
            $datastore  = null;
            if($status=='all'){
                if($search==null){
                    $datasales = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama' )
                        ->where('tanggal','=', date($date))
                        ->skip(($pagination-1)*$index)
                        ->take($index)
                        ->get();
                    $count = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama' )
                        ->where('tanggal','=', date($date))
                        ->count();
                    $count = ceil($count/$index);
                    $dataitems = DB::table('pos_activity_item')
                         ->where('created_at','like', '%'.date($date).'%')
                        ->get();
                }else{
                    $datasales = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama' )
                        ->where('tanggal','=', date($date))
                        ->where('pos_activity.no_invoice','like', '%'.$search.'%')
                        ->skip(($pagination-1)*$index)
                        ->take($index)
                        ->get();
                    $count = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama' )
                        ->where('tanggal','=', date($date))
                        ->where('pos_activity.no_invoice','like', '%'.$search.'%')
                        ->count();
                    $count = ceil($count/$index);
                    $dataitems = DB::table('pos_activity_item')
                         ->where('created_at','like', '%'.date($date).'%')
                        ->get();
                }
            }else{
                if($search==null){
                    $datasales = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama' )
                        ->where('tanggal','=', date($date))
                        ->where('pos_activity.status','=',$status)
                        ->skip(($pagination-1)*$index)
                        ->take($index)
                        ->get();
                    $count = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama' )
                        ->where('tanggal','=', date($date))
                        ->where('pos_activity.status','=',$status)
                        ->count();
                    $count = ceil($count/$index);
                    $dataitems = DB::table('pos_activity_item')
                         ->where('created_at','like', '%'.date($date).'%')
                        ->get();
                }else{
                    $datasales = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama' )
                        ->where('tanggal','=', date($date))
                        ->where('pos_activity.no_invoice','like', '%'.$search.'%')
                        ->where('pos_activity.status','=',$status)
                        ->skip(($pagination-1)*$index)
                        ->take($index)
                        ->get();
                    $count = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama' )
                        ->where('tanggal','=', date($date))
                        ->where('pos_activity.no_invoice','like', '%'.$search.'%')
                        ->where('pos_activity.status','=',$status)
                        ->count();
                    $count = ceil($count/$index);
                    $dataitems = DB::table('pos_activity_item')
                         ->where('created_at','like', '%'.date($date).'%')
                        ->get();
                }
            }
        }else{
            if($status=='all'){
                if($search==null){
                    $datasales = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama' )
                        ->where('tanggal','=', date($date))
                        ->where('pos_activity.id_store', '=', $store)
                        ->skip(($pagination-1)*$index)
                        ->take($index)
                        ->get();
                    $count = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama' )
                        ->where('tanggal','=', date($date))
                        ->where('pos_activity.id_store', '=', $store)
                        ->count();
                    $count = ceil($count/$index);
                    $dataitems = DB::table('pos_activity_item')
                         ->where('created_at','like', '%'.date($date).'%')
                        ->get();
                }else{
                    $datasales = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama' )
                        ->where('tanggal','=', date($date))
                        ->where('pos_activity.no_invoice','like', '%'.$search.'%')
                        ->where('pos_activity.id_store', '=', $store)
                        ->skip(($pagination-1)*$index)
                        ->take($index)
                        ->get();
                    $count = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama' )
                        ->where('tanggal','=', date($date))
                        ->where('pos_activity.no_invoice','like', '%'.$search.'%')
                        ->where('pos_activity.id_store', '=', $store)
                        ->count();
                    $count = ceil($count/$index);
                    $dataitems = DB::table('pos_activity_item')
                         ->where('created_at','like', '%'.date($date).'%')
                        ->get();
                }
            }else{
                if($search==null){
                    $datasales = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama' )
                        ->where('tanggal','=', date($date))
                        ->where('pos_activity.status','=',$status)
                        ->where('pos_activity.id_store', '=', $store)
                        ->skip(($pagination-1)*$index)
                        ->take($index)
                        ->get();
                    $count = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama' )
                        ->where('tanggal','=', date($date))
                        ->where('pos_activity.status','=',$status)
                        ->where('pos_activity.id_store', '=', $store)
                        ->count();
                    $count = ceil($count/$index);
                    $dataitems = DB::table('pos_activity_item')
                         ->where('created_at','like', '%'.date($date).'%')
                        ->get();
                }else{
                    $datasales = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama' )
                        ->where('tanggal','=', date($date))
                        ->where('pos_activity.no_invoice','like', '%'.$search.'%')
                        ->where('pos_activity.status','=',$status)
                        ->where('pos_activity.id_store', '=', $store)
                        ->skip(($pagination-1)*$index)
                        ->take($index)
                        ->get();
                    $count = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama' )
                        ->where('tanggal','=', date($date))
                        ->where('pos_activity.no_invoice','like', '%'.$search.'%')
                        ->where('pos_activity.status','=',$status)
                        ->where('pos_activity.id_store', '=', $store)
                        ->count();
                    $count = ceil($count/$index);
                    $dataitems = DB::table('pos_activity_item')
                        ->where('created_at','like', '%'.date($date).'%')
                        ->get();
                }
            }
        }
        // dd($dataitems);
        return view('report.store_sales.store_sales_report',compact('date','store', 'status', 'datarefund', 'datavoucher', 'datastore', 'pagination', 'count', 'start', 'search', 'dataitems', 'datasales'));
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
