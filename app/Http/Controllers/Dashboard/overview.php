<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class overview extends Controller
{
    public function index(Request $request) {
        $from = ($request->from==null? date('2021-05-01') : $request->from);
        $to = ($request->to==null? date('Y-m-d') : $request->to);
        $group_by = $request->group_by;

        if (Session::get('status') == 'login') {
            if($group_by==null || $group_by=='store'){
                $data = DB::select("SELECT pos_store.nama_store as nama, SUM(pos_activity.total) as total_total FROM pos_activity INNER JOIN pos_store ON pos_activity.id_store = pos_store.id_store WHERE pos_activity.tanggal >= '$from' AND pos_activity.tanggal <= '$to' AND pos_activity.status = 'success' GROUP BY pos_store.nama_store");
            }else if($group_by=='item'){
                $data = DB::select("SELECT nama_item as nama, SUM(qty) as total_total FROM pos_activity_item WHERE date(created_at) >= '$from' AND date(created_at) <= '$to' AND status = 'success' GROUP BY nama_item");
            }
            $data1 = array();
            $data2 = array();
            foreach ($data as $key=>$value){
                array_push($data1, $value->nama);
                array_push($data2, $value->total_total);
            }

            return view('dashboard.overview', compact('from', 'to', 'group_by', 'data1', 'data2', 'data'));
            // return $group_by;
        } else {
            return redirect('admin/login');
        }
    }

    public function data(Request $request){
        $from = $request->from;
        $to = $request->to;
        $group_by = $request->group_by;

        if($group_by==null || $group_by=='store'){
            $data = DB::select("SELECT pos_store.nama_store as nama, SUM(pos_activity.total) as total_total FROM pos_activity INNER JOIN pos_store ON pos_activity.id_store = pos_store.id_store WHERE pos_activity.tanggal >= '$from' AND pos_activity.tanggal <= '$to' AND pos_activity.status = 'success' GROUP BY pos_store.nama_store");
        }else if($group_by=='item'){
            $data = DB::select("SELECT nama_item as nama, SUM(qty) as total_total FROM pos_activity_item WHERE date(created_at) >= '$from' AND date(created_at) <= '$to' AND status = 'success' GROUP BY nama_item");
        }
        
        return json_encode($data);
    }
}
