<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
    

class Transaction_LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = $request->date;
        // $search = $request->search;
        $id_store = $request->id_store;
        $pagination = $request->pagination;
        $index = 3;
        $page_now =1;
        $url = 'transaction.log.log';
        $start = 1;
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');
        $datastore  = DB::table('pos_store')->get();

        if($date == null){
            if($id_store == null && $pagination==null || $id_store=='all'){
                $datasales = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->orderBy('pos_activity.tanggal', 'desc')
                    ->orderBy('pos_activity.time', 'desc')
                    ->skip(($pagination-1)*$index)
                    ->take($index)
                    ->get();
                $count = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->count();
                $count = ceil($count/$index);
            }elseif($id_store==null&&$pagination!=null || $id_store=='all'){
                $datasales = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->orderBy('pos_activity.tanggal', 'desc')
                    ->orderBy('pos_activity.time', 'desc')
                    ->skip(($pagination-1)*$index)
                    ->take($index)
                    ->get();
                $count = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->count();
                $count = ceil($count/$index);
    
                $page_now = $pagination;
                $start = (($page_now-1)*$index)+1;
            }elseif($id_store!=null && $pagination ==null){
                $datasales = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.id_store', '=', $id_store)
                    ->orderBy('pos_activity.tanggal', 'desc')
                    ->orderBy('pos_activity.time', 'desc')
                    ->skip(($pagination-1)*$index)
                    ->take($index)
                    ->get();
                $count = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.id_store', '=', $id_store)
                    ->count();
                $count = ceil($count/$index);
    
                $page_now = 1;
                $start = 1;
            }else{
                $datasales = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.id_store', '=', $id_store)
                    ->orderBy('pos_activity.tanggal', 'desc')
                    ->orderBy('pos_activity.time', 'desc')
                    ->skip(($pagination-1)*$index)
                    ->take($index)
                    ->get();
                $count = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.id_store', '=', $id_store)
                    ->count();
                $count = ceil($count/$index);
    
                $page_now = $pagination;
                $start = (($page_now-1)*$index)+1;
            }
        }else{
            if($id_store == null && $pagination==null || $id_store=='all'){
                $datasales = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.tanggal', '=', $date)
                    ->orderBy('pos_activity.tanggal', 'desc')
                    ->orderBy('pos_activity.time', 'desc')
                    ->skip(($pagination-1)*$index)
                    ->take($index)
                    ->get();
                $count = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.tanggal', '=', $date)
                    ->count();
                $count = ceil($count/$index);
            }elseif($id_store==null&&$pagination!=null || $id_store=='all'){
                $datasales = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.tanggal', '=', $date)
                    ->orderBy('pos_activity.tanggal', 'desc')
                    ->orderBy('pos_activity.time', 'desc')
                    ->skip(($pagination-1)*$index)
                    ->take($index)
                    ->get();
                $count = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.tanggal', '=', $date)
                    ->count();
                $count = ceil($count/$index);
    
                $page_now = $pagination;
                $start = (($page_now-1)*$index)+1;
            }elseif($id_store!=null && $pagination ==null){
                $datasales = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.id_store', '=', $id_store)
                    ->where('pos_activity.tanggal', '=', $date)
                    ->orderBy('pos_activity.tanggal', 'desc')
                    ->orderBy('pos_activity.time', 'desc')
                    ->skip(($pagination-1)*$index)
                    ->take($index)
                    ->get();
                $count = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.id_store', '=', $id_store)
                    ->where('pos_activity.tanggal', '=', $date)
                    ->count();
                $count = ceil($count/$index);
    
                $page_now = 1;
                $start = 1;
            }else{
                $datasales = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.id_store', '=', $id_store)
                    ->where('pos_activity.tanggal', '=', $date)
                    ->orderBy('pos_activity.tanggal', 'desc')
                    ->orderBy('pos_activity.time', 'desc')
                    ->skip(($pagination-1)*$index)
                    ->take($index)
                    ->get();
                $count = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.id_store', '=', $id_store)
                    ->where('pos_activity.tanggal', '=', $date)
                    ->count();
                $count = ceil($count/$index);
    
                $page_now = $pagination;
                $start = (($page_now-1)*$index)+1;
            }
        }
        
        // if($search==null && $pagination==null){
        //     $datasales = DB::table('pos_activity')
        //         ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
        //         ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
        //         ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
        //         ->orderBy('pos_activity.tanggal', 'desc')
        //         ->orderBy('pos_activity.time', 'desc')
        //         ->skip(($pagination-1)*$index)
        //         ->take($index)
        //         ->get();
        //     $count = DB::table('pos_activity')
        //         ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
        //         ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
        //         ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
        //         ->count();
        //     $count = ceil($count/$index);
        // }elseif($search==null&&$pagination!=null){
        //     $datasales = DB::table('pos_activity')
        //         ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
        //         ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
        //         ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
        //         ->orderBy('pos_activity.tanggal', 'desc')
        //         ->orderBy('pos_activity.time', 'desc')
        //         ->skip(($pagination-1)*$index)
        //         ->take($index)
        //         ->get();
        //     $count = DB::table('pos_activity')
        //         ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
        //         ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
        //         ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
        //         ->count();
        //     $count = ceil($count/$index);

        //     $page_now = $pagination;
        //     $start = (($page_now-1)*$index)+1;
        // }elseif($search!=null && $pagination ==null){
        //     $datasales = DB::table('pos_activity')
        //         ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
        //         ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
        //         ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
        //         ->where('no_invoice', 'like', '%'.$search.'%')
        //         ->orderBy('pos_activity.tanggal', 'desc')
        //         ->orderBy('pos_activity.time', 'desc')
        //         ->skip(($pagination-1)*$index)
        //         ->take($index)
        //         ->get();
        //     $count = DB::table('pos_activity')
        //         ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
        //         ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
        //         ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
        //         ->where('no_invoice', 'like', '%'.$search.'%')
        //         ->count();
        //     $count = ceil($count/$index);

        //     $page_now = 1;
        //     $start = 1;
        // }else{
        //     $datasales = DB::table('pos_activity')
        //         ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
        //         ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
        //         ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
        //         ->where('no_invoice', 'like', '%'.$search.'%')
        //         ->orderBy('pos_activity.tanggal', 'desc')
        //         ->orderBy('pos_activity.time', 'desc')
        //         ->skip(($pagination-1)*$index)
        //         ->take($index)
        //         ->get();
        //     $count = DB::table('pos_activity')
        //         ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
        //         ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
        //         ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
        //         ->where('no_invoice', 'like', '%'.$search.'%')
        //         ->count();
        //     $count = ceil($count/$index);

        //     $page_now = $pagination;
        //     $start = (($page_now-1)*$index)+1;
        // }

        return view($url, compact ( 'id_store','datasales', 'datastore', 'page_now' , 'start', 'count', 'today'));
    }

    public function index_refund(Request $request){
        $date = $request->date;
        $id_store = $request->id_store;
        $pagination = $request->pagination;
        $index = 10;
        $page_now =1;
        $url = 'transaction.refund.refund';
        $start = 1;
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');
        $datastore  = DB::table('pos_store')->get();
        $datarefund  = DB::table('pos_activity_refund')->get();

        if($date == null){
            if($id_store == null && $pagination==null || $id_store=='all'){
                $datasales = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.status','=','refund')
                    ->orderBy('pos_activity.tanggal', 'desc')
                    ->orderBy('pos_activity.time', 'desc')
                    ->skip(($pagination-1)*$index)
                    ->take($index)
                    ->get();
                $count = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.status','=','refund')
                    ->count();
                $count = ceil($count/$index);
            }elseif($id_store==null&&$pagination!=null || $id_store=='all'){
                $datasales = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.status','=','refund')
                    ->orderBy('pos_activity.tanggal', 'desc')
                    ->orderBy('pos_activity.time', 'desc')
                    ->skip(($pagination-1)*$index)
                    ->take($index)
                    ->get();
                $count = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.status','=','refund')
                    ->count();
                $count = ceil($count/$index);
    
                $page_now = $pagination;
                $start = (($page_now-1)*$index)+1;
            }elseif($id_store!=null && $pagination ==null){
                $datasales = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.status','=','refund')
                    ->where('pos_activity.id_store', '=', $id_store)
                    ->orderBy('pos_activity.tanggal', 'desc')
                    ->orderBy('pos_activity.time', 'desc')
                    ->skip(($pagination-1)*$index)
                    ->take($index)
                    ->get();
                $count = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.status','=','refund')
                    ->where('pos_activity.id_store', '=', $id_store)
                    ->count();
                $count = ceil($count/$index);
    
                $page_now = 1;
                $start = 1;
            }else{
                $datasales = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.status','=','refund')
                    ->where('pos_activity.id_store', '=', $id_store)
                    ->orderBy('pos_activity.tanggal', 'desc')
                    ->orderBy('pos_activity.time', 'desc')
                    ->skip(($pagination-1)*$index)
                    ->take($index)
                    ->get();
                $count = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.status','=','refund')
                    ->where('pos_activity.id_store', '=', $id_store)
                    ->count();
                $count = ceil($count/$index);
    
                $page_now = $pagination;
                $start = (($page_now-1)*$index)+1;
            }
        }else{
            if($id_store == null && $pagination==null || $id_store=='all'){
                $datasales = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.tanggal', '=', $date)
                    ->where('pos_activity.status','=','refund')
                    ->orderBy('pos_activity.tanggal', 'desc')
                    ->orderBy('pos_activity.time', 'desc')
                    ->skip(($pagination-1)*$index)
                    ->take($index)
                    ->get();
                $count = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.status','=','refund')
                    ->where('pos_activity.tanggal', '=', $date)
                    ->count();
                $count = ceil($count/$index);
            }elseif($id_store==null&&$pagination!=null || $id_store=='all'){
                $datasales = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.status','=','refund')
                    ->where('pos_activity.tanggal', '=', $date)
                    ->orderBy('pos_activity.tanggal', 'desc')
                    ->orderBy('pos_activity.time', 'desc')
                    ->skip(($pagination-1)*$index)
                    ->take($index)
                    ->get();
                $count = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.status','=','refund')
                    ->where('pos_activity.tanggal', '=', $date)
                    ->count();
                $count = ceil($count/$index);
    
                $page_now = $pagination;
                $start = (($page_now-1)*$index)+1;
            }elseif($id_store!=null && $pagination ==null){
                $datasales = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.status','=','refund')
                    ->where('pos_activity.id_store', '=', $id_store)
                    ->where('pos_activity.tanggal', '=', $date)
                    ->orderBy('pos_activity.tanggal', 'desc')
                    ->orderBy('pos_activity.time', 'desc')
                    ->skip(($pagination-1)*$index)
                    ->take($index)
                    ->get();
                $count = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.status','=','refund')
                    ->where('pos_activity.id_store', '=', $id_store)
                    ->where('pos_activity.tanggal', '=', $date)
                    ->count();
                $count = ceil($count/$index);
    
                $page_now = 1;
                $start = 1;
            }else{
                $datasales = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.status','=','refund')
                    ->where('pos_activity.id_store', '=', $id_store)
                    ->where('pos_activity.tanggal', '=', $date)
                    ->orderBy('pos_activity.tanggal', 'desc')
                    ->orderBy('pos_activity.time', 'desc')
                    ->skip(($pagination-1)*$index)
                    ->take($index)
                    ->get();
                $count = DB::table('pos_activity')
                    ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                    ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                    ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                    ->where('pos_activity.status','=','refund')
                    ->where('pos_activity.id_store', '=', $id_store)
                    ->where('pos_activity.tanggal', '=', $date)
                    ->count();
                $count = ceil($count/$index);
    
                $page_now = $pagination;
                $start = (($page_now-1)*$index)+1;
            }
        }

        // dd($datasales);
        return view($url, compact ('count', 'id_store','datasales','datarefund', 'datastore', 'page_now' , 'start', 'count', 'today'));
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
    public function show($no_inv)
    {
        $start = 1;
        $data_inv = DB::table('pos_activity')
            ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
            ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
            ->join('pos_activity_item', 'pos_activity.no_invoice', '=', 'pos_activity_item.no_invoice')
            ->select('pos_activity.no_invoice', 'pos_activity.status', 'pos_activity.id_discount', 'pos_activity.tanggal', 'pos_activity.total' , 'pos_activity.subtotal as sub', 'pos_store.nama_store', 'pos_kasir.nama', 'pos_activity_item.nama_item','pos_activity_item.harga','pos_activity_item.qty','pos_activity_item.total as subtotal')
            ->where('pos_activity.no_invoice', $no_inv)
            ->get();

        $datavoucher = DB::table('pos_diskon')->get();
        $datarefund = DB::table('pos_activity_refund')->get();
        

        return view('transaction.log.detail ',compact('data_inv', 'start', 'datavoucher', 'datarefund'));
    }

    public function void($no_inv){
        DB::table('pos_activity_item')
              ->where('no_invoice', $no_inv)
              ->update(['status' => 'refund']);
        
        DB::table('pos_activity')
              ->where('no_invoice', $no_inv)
              ->update(['status' => 'refund']);
        return redirect('transaction/log')->with('status1', 'Invoice Sudah Dibatalkan');
    }

    public function keterangan(Request $request){
        DB::table('pos_activity_refund')->insert(
            ['id' => null, 'no_invoice' => $request->no_inv, 
            'keterangan' => $request->keterangan]
        );
        // return ("keterangan");
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
