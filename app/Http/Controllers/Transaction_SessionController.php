<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Transaction_SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $tanggal = $request->tanggal;
        date_default_timezone_set('Asia/Jakarta');
        $today = date("Y-m-d");
        if($tanggal == NULL){
            $tanggal = date("Y-m-d");
        }
        $datasession = DB::select("SELECT pos_deposit.id,pos_deposit.id_kasir, pos_kasir.nama, pos_store.id_store, pos_store.nama_store, pos_deposit.deposit, pos_deposit.tanggal, pos_deposit.status FROM `pos_deposit` INNER JOIN pos_store ON pos_deposit.id_store = pos_store.id_store INNER JOIN pos_kasir ON pos_deposit.id_kasir = pos_kasir.id WHERE pos_deposit.tanggal = '$tanggal' ORDER BY pos_deposit.id DESC");
        $total_tunai = array();
        $n = 0;
        foreach($datasession as $key=>$value){
            $total_tunai[$n++] = DB::select("SELECT pos_activity.id_store, pos_activity.id_employee, pos_activity.tanggal, SUM(pos_activity.cash - pos_activity.kembalian) as total_tunai FROM pos_activity WHERE id_store = $value->id_store AND id_employee = $value->id_kasir AND status='success' AND tanggal = '$value->tanggal' GROUP BY pos_activity.id_store, pos_activity.id_employee, pos_activity.tanggal");
        }
        $start = 0;
        return view("transaction.session.session",compact('datasession', 'total_tunai', 'n', 'start', 'tanggal', 'today'));
        // return $total_tunai[1] == null;
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
        $deposit = DB::table('pos_deposit')
                ->where('id_store', $request->id_store)
                ->where('id_kasir', $request->id_kasir)
                ->where('tanggal', $request->tanggal)
                ->select('deposit')
                ->get();
        
        $tunai = DB::select("SELECT SUM(pos_activity.cash - pos_activity.kembalian) as total_tunai FROM pos_activity WHERE id_store = $request->id_store AND id_employee = $request->id_kasir AND status='success' AND tanggal = '$request->tanggal' GROUP BY pos_activity.id_store, pos_activity.id_employee, pos_activity.tanggal");
        
        $debit = DB::select("SELECT pos_activity.tipe_payment, SUM(pos_activity.debit_cash) as total_debit FROM pos_activity WHERE id_store = $request->id_store AND id_employee = $request->id_kasir AND status='success' AND tanggal = '$request->tanggal' AND tipe_payment != 'Tunai' GROUP BY pos_activity.id_store, pos_activity.id_employee, pos_activity.tanggal, pos_activity.tipe_payment");
        
        return view("transaction.session.session-detail",compact('deposit', 'tunai', 'debit'));
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
