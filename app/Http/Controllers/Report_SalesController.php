<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\NoInvoice_Export;
use App\Exports\Item_Export;
use App\Exports\Kategori_Export;
use App\Exports\Store_Export;
use App\Exports\Diskon_Export;
use App\Exports\Kasir_Export;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class Report_SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return $data;
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
        $from = $request->from;
        $to = $request->to;
        $status = $request->sort_by;
        $search = ($request->search!=null?$request->search : null);
        $pagination = ($request->pagination!=null?$request->pagination : 1);
        $start = 1;
        $index = 3;
        $group_by = $request->group_by;
        // $status = $request->sort_by;
        if($group_by=='no_invoice'){
            if($status!='all'){
                if($search != null){
                    $datasales = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                        ->where('no_invoice', 'like', '%'.$search.'%')
                        ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                        ->where('tanggal','>=', date($from))
                        ->where('tanggal','<=', date($to))
                        ->where('status', $status)
                        ->skip(($pagination-1)*$index)
                        ->take($index)
                        ->get();
                    $count = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                        ->where('no_invoice', 'like', '%'.$search.'%')
                        ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                        ->where('tanggal','>=', date($from))
                        ->where('tanggal','<=', date($to))
                        ->where('status', $status);
                    $jumlah = 0;
                    foreach($count->get() as $key=>$value){
                        $jumlah += $value->total;
                    }
                    $count = $count->count();
                    $count = ceil($count/$index);
                    $start = ($pagination-1)*$index+1;
                }else{
                    $datasales = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                        ->where('tanggal','>=', date($from))
                        ->where('tanggal','<=', date($to))
                        ->where('status', $status)
                        ->skip(($pagination-1)*$index)
                        ->take($index)
                        ->get();
                    $count = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                        ->where('tanggal','>=', date($from))
                        ->where('tanggal','<=', date($to))
                        ->where('status', $status);
                    $jumlah = 0;
                    foreach($count->get() as $key=>$value){
                        $jumlah += $value->total;
                    }
                    $count = $count->count();
                    $count = ceil($count/$index);
                    $start = ($pagination-1)*$index+1;
                }
            }else{
                if($search != null){
                    $datasales = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                        ->where('no_invoice', 'like', '%'.$search.'%')
                        ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                        ->where('tanggal','>=', date($from))
                        ->where('tanggal','<=', date($to))
                        ->skip(($pagination-1)*$index)
                        ->take($index)
                        ->get();
                    $count = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                        ->where('no_invoice', 'like', '%'.$search.'%')
                        ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                        ->where('tanggal','>=', date($from))
                        ->where('tanggal','<=', date($to));
                    $jumlah = 0;
                    foreach($count->get() as $key=>$value){
                        $jumlah += $value->total;
                    }
                    $count = $count->count();
                    $count = ceil($count/$index);
                    $start = ($pagination-1)*$index+1;
                }else{
                    $datasales = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                        ->where('tanggal','>=', date($from))
                        ->where('tanggal','<=', date($to))
                        ->skip(($pagination-1)*$index)
                        ->take($index)
                        ->get();
                    $count = DB::table('pos_activity')
                        ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
                        ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
                        ->select('pos_activity.*', 'pos_store.nama_store', 'pos_kasir.nama')
                        ->where('tanggal','>=', date($from))
                        ->where('tanggal','<=', date($to));
                    $jumlah = 0;
                    foreach($count->get() as $key=>$value){
                        $jumlah += $value->total;
                    }
                    $count = $count->count();
                    $count = ceil($count/$index);
                    $start = ($pagination-1)*$index+1;
                }
            }
            return view('report.sales.sales-invoice', compact ('search', 'datasales', 'start', 'status', 'pagination', 'count', 'to', 'from', 'group_by', 'jumlah'));
        }elseif($group_by=='item'){
            
            if($status!='all'){
                $offset = (($pagination-1)*$index);
                $dataitem = DB::select("SELECT nama_item, pos_store.nama_store, SUM(total) as total_penjualan ,SUM(qty) as total_qty FROM pos_activity_item INNER JOIN pos_store ON pos_activity_item.id_store = pos_store.id_store WHERE date(created_at) >= '$from' AND date(created_at) <= '$to' AND status = '$status' GROUP BY nama_item, pos_store.nama_store LIMIT $index OFFSET $offset");
                $datacount = DB::select("SELECT nama_item, SUM(total) as total_penjualan ,SUM(qty) as total_qty FROM pos_activity_item WHERE date(created_at) >= '$from' AND date(created_at) <= '$to' AND nama_item LIKE '%$search%' AND status = '$status' GROUP BY nama_item");
                $count = 0;
                $jumlah = 0;
                $jumlah_qty = 0;
                foreach($datacount as $key=>$value){
                    $count++;
                    $jumlah += $value->total_penjualan;
                    $jumlah_qty += $value->total_qty;
                }
                $count = ceil($count/$index);
                $start = $offset+1;
            }else{
                $offset = (($pagination-1)*$index);
                $dataitem = DB::select("SELECT nama_item, pos_store.nama_store, SUM(total) as total_penjualan ,SUM(qty) as total_qty FROM pos_activity_item INNER JOIN pos_store ON pos_activity_item.id_store = pos_store.id_store WHERE date(created_at) >= '$from' AND date(created_at) <= '$to' AND nama_item LIKE '%$search%' GROUP BY nama_item, pos_store.nama_store LIMIT $index OFFSET $offset");
                $datacount = DB::select("SELECT nama_item, SUM(total) as total_penjualan ,SUM(qty) as total_qty FROM pos_activity_item WHERE date(created_at) >= '$from' AND date(created_at) <= '$to' AND nama_item LIKE '%$search%' GROUP BY nama_item");
                $count = 0;
                $jumlah = 0;
                $jumlah_qty = 0;
                foreach($datacount as $key=>$value){
                    $count++;
                    $jumlah += $value->total_penjualan;
                    $jumlah_qty += $value->total_qty;
                }
                $count = ceil($count/$index);
                $start = $offset+1;
            }
            return view('report.sales.sales-item', compact ('search', 'dataitem', 'start', 'status', 'pagination', 'count', 'to', 'from', 'group_by', 'jumlah', 'jumlah_qty'));
            // return $dataitem;
        }elseif($group_by=='kategori'){
            $item = DB::table('pos_product_kategori')->get();
            if($status!='all'){
                $offset = (($pagination-1)*$index);
                $datakategori = DB::select("SELECT pos_product_kategori.nama_kategori, pos_store.nama_store, SUM(pos_activity_item.total) as total_penjualan ,SUM(pos_activity_item.qty) as total_qty FROM pos_activity_item INNER JOIN pos_product_kategori ON pos_activity_item.id_kategori = pos_product_kategori.id_kategori INNER JOIN pos_store ON pos_activity_item.id_store = pos_store.id_store WHERE date(created_at) >= '$from' AND date(created_at) <= '$to' AND pos_activity_item.status = '$status' AND pos_product_kategori.nama_kategori LIKE '%$search%' GROUP BY pos_product_kategori.nama_kategori, pos_store.nama_store LIMIT $index OFFSET $offset");
                $datacount = DB::select("SELECT pos_product_kategori.nama_kategori, pos_store.nama_store, SUM(pos_activity_item.total) as total_penjualan ,SUM(pos_activity_item.qty) as total_qty FROM pos_activity_item INNER JOIN pos_product_kategori ON pos_activity_item.id_kategori = pos_product_kategori.id_kategori INNER JOIN pos_store ON pos_activity_item.id_store = pos_store.id_store WHERE date(created_at) >= '$from' AND date(created_at) <= '$to' AND pos_activity_item.status = '$status' AND pos_product_kategori.nama_kategori LIKE '%$search%' GROUP BY pos_product_kategori.nama_kategori, pos_store.nama_store");
                
                $count = 0;
                $jumlah = 0;
                $jumlah_qty = 0;
                foreach($datacount as $key=>$value){
                    $count++;
                    $jumlah += $value->total_penjualan;
                    $jumlah_qty += $value->total_qty;
                }
                $count = ceil($count/$index);
                $start = $offset+1;
            }else{
                $offset = (($pagination-1)*$index);
                $datakategori = DB::select("SELECT pos_product_kategori.nama_kategori, pos_store.nama_store, SUM(pos_activity_item.total) as total_penjualan ,SUM(pos_activity_item.qty) as total_qty FROM pos_activity_item INNER JOIN pos_product_kategori ON pos_activity_item.id_kategori = pos_product_kategori.id_kategori INNER JOIN pos_store ON pos_activity_item.id_store = pos_store.id_store WHERE date(created_at) >= '$from' AND date(created_at) <= '$to' AND pos_product_kategori.nama_kategori LIKE '%$search%' GROUP BY pos_product_kategori.nama_kategori, pos_store.nama_store LIMIT $index OFFSET $offset");
                $datacount = DB::select("SELECT pos_product_kategori.nama_kategori, pos_store.nama_store, SUM(pos_activity_item.total) as total_penjualan ,SUM(pos_activity_item.qty) as total_qty FROM pos_activity_item INNER JOIN pos_product_kategori ON pos_activity_item.id_kategori = pos_product_kategori.id_kategori INNER JOIN pos_store ON pos_activity_item.id_store = pos_store.id_store WHERE date(created_at) >= '$from' AND date(created_at) <= '$to' AND pos_product_kategori.nama_kategori LIKE '%$search%' GROUP BY pos_product_kategori.nama_kategori, pos_store.nama_store");
                $count = 0;
                $jumlah = 0;
                $jumlah_qty = 0;
                foreach($datacount as $key=>$value){
                    $count++;
                    $jumlah += $value->total_penjualan;
                    $jumlah_qty += $value->total_qty;
                }
                $count = ceil($count/$index);
                $start = $offset+1;
            }
            return view('report.sales.sales-kategori', compact ('search', 'datakategori', 'start', 'status', 'pagination', 'count', 'to', 'from', 'group_by', 'item', 'jumlah', 'jumlah_qty'));
            // return $datakategori;
        }elseif($group_by=='store'){
            $item = DB::table('pos_store')->get();
            if($status!='all'){
                $offset = (($pagination-1)*$index);
                $datastore = DB::select("SELECT pos_activity_item.id_store, SUM(pos_activity_item.total) as total_penjualan ,SUM(pos_activity_item.qty) as total_qty FROM pos_activity_item INNER JOIN pos_store ON pos_activity_item.id_store = pos_store.id_store WHERE date(created_at) >= '$from' AND date(created_at) <= '$to' AND pos_activity_item.status = '$status' AND pos_store.nama_store LIKE '%$search%' GROUP BY pos_activity_item.id_store LIMIT $index OFFSET $offset");
                $datacount = DB::select("SELECT pos_activity_item.id_store, SUM(pos_activity_item.total) as total_penjualan ,SUM(pos_activity_item.qty) as total_qty FROM pos_activity_item INNER JOIN pos_store ON pos_activity_item.id_store = pos_store.id_store WHERE date(created_at) >= '$from' AND date(created_at) <= '$to' AND pos_activity_item.status = '$status' AND pos_store.nama_store LIKE '%$search%' GROUP BY pos_activity_item.id_store");
                
                $count = 0;
                $jumlah = 0;
                $jumlah_qty = 0;
                foreach($datacount as $key=>$value){
                    $count++;
                    $jumlah += $value->total_penjualan;
                    $jumlah_qty += $value->total_qty;
                }
                $count = ceil($count/$index);
                $start = $offset+1;
            }else{
                $offset = (($pagination-1)*$index);
                $datastore = DB::select("SELECT pos_activity_item.id_store, SUM(pos_activity_item.total) as total_penjualan ,SUM(pos_activity_item.qty) as total_qty FROM pos_activity_item INNER JOIN pos_store ON pos_activity_item.id_store = pos_store.id_store WHERE date(created_at) >= '$from' AND date(created_at) <= '$to' AND pos_store.nama_store LIKE '%$search%' GROUP BY pos_activity_item.id_store LIMIT $index OFFSET $offset");
                $datacount = DB::select("SELECT pos_activity_item.id_store, SUM(pos_activity_item.total) as total_penjualan ,SUM(pos_activity_item.qty) as total_qty FROM pos_activity_item INNER JOIN pos_store ON pos_activity_item.id_store = pos_store.id_store WHERE date(created_at) >= '$from' AND date(created_at) <= '$to' AND pos_store.nama_store LIKE '%$search%' GROUP BY pos_activity_item.id_store");
                $count = 0;
                $jumlah = 0;
                $jumlah_qty = 0;
                foreach($datacount as $key=>$value){
                    $count++;
                    $jumlah += $value->total_penjualan;
                    $jumlah_qty += $value->total_qty;
                }
                $count = ceil($count/$index);
                $start = $offset+1;
            }
            return view('report.sales.sales-store', compact ('search', 'datastore', 'start', 'status', 'pagination', 'count', 'to', 'from', 'group_by', 'item', 'jumlah', 'jumlah_qty'));
            // return $datakategori;
        }elseif($group_by=='diskon'){
            $item = DB::table('pos_diskon')->get();
            // $search = "BNI";
            if($status!='all'){
                $offset = (($pagination-1)*$index);
                $datadiskon = DB::select("SELECT pos_activity.no_invoice, pos_activity.tanggal, pos_activity.status, (pos_activity.subtotal-pos_activity.total) as total_diskon,  pos_activity.id_discount, pos_diskon.nama_voucher, pos_store.nama_store FROM `pos_activity` INNER JOIN pos_diskon ON pos_activity.id_discount = pos_diskon.id_voucher INNER JOIN pos_store  ON pos_activity.id_store = pos_store.id_store WHERE tanggal >= '$from' AND tanggal <= '$to' AND status = '$status' LIMIT  $index OFFSET $offset");
                $datacount = DB::select("SELECT pos_activity.no_invoice, pos_activity.tanggal, pos_activity.status, (pos_activity.subtotal-pos_activity.total) as total_diskon, pos_activity.id_discount, pos_diskon.nama_voucher, pos_store.nama_store FROM `pos_activity` INNER JOIN pos_diskon ON pos_activity.id_discount = pos_diskon.id_voucher INNER JOIN pos_store  ON pos_activity.id_store = pos_store.id_store WHERE tanggal >= '$from' AND tanggal <= '$to' AND status = '$status'");
                $count = 0;
                $jumlah = 0;
                foreach($datacount as $key=>$value){
                    $count++;
                    $jumlah += $value->total_diskon;
                }
                $count = ceil($count/$index);
                $start = $offset+1;
            }else{
                $offset = (($pagination-1)*$index);
                $datadiskon = DB::select("SELECT pos_activity.no_invoice, pos_activity.tanggal, pos_activity.status, (pos_activity.subtotal-pos_activity.total) as total_diskon, pos_activity.id_discount, pos_diskon.nama_voucher, pos_store.nama_store FROM `pos_activity` INNER JOIN pos_diskon ON pos_activity.id_discount = pos_diskon.id_voucher INNER JOIN pos_store  ON pos_activity.id_store = pos_store.id_store WHERE tanggal >= '$from' AND tanggal <= '$to' LIMIT  $index OFFSET $offset");
                $datacount = DB::select("SELECT pos_activity.no_invoice, pos_activity.tanggal, pos_activity.status, (pos_activity.subtotal-pos_activity.total) as total_diskon, pos_activity.id_discount, pos_diskon.nama_voucher, pos_store.nama_store FROM `pos_activity` INNER JOIN pos_diskon ON pos_activity.id_discount = pos_diskon.id_voucher INNER JOIN pos_store  ON pos_activity.id_store = pos_store.id_store WHERE tanggal >= '$from' AND tanggal <= '$to' ");
                $count = 0;
                $jumlah = 0;
                foreach($datacount as $key=>$value){
                    $count++;
                    $jumlah += $value->total_diskon;
                }
                $count = ceil($count/$index);
                $start = $offset+1;
            }
            return view('report.sales.sales-diskon', compact ('search', 'datadiskon', 'start', 'status', 'pagination', 'count', 'to', 'from', 'group_by', 'item', 'jumlah'));
            // return $datadiskon;
        }elseif($group_by=='kasir'){
            $item = DB::table('pos_kasir')->get();
            if($status!='all'){
                $offset = (($pagination-1)*$index);
                $datakasir = DB::select("SELECT pos_activity.id_employee, SUM(pos_activity.total) as total_penjualan FROM pos_activity INNER JOIN pos_kasir ON pos_activity.id_employee = pos_kasir.id WHERE date(tanggal) >= '$from' AND date(tanggal) <= '$to' AND pos_activity.status = '$status' AND pos_kasir.nama LIKE '%$search%' GROUP BY pos_activity.id_employee LIMIT $index OFFSET $offset");
                $datacount = DB::select("SELECT pos_activity.id_employee, SUM(pos_activity.total) as total_penjualan FROM pos_activity INNER JOIN pos_kasir ON pos_activity.id_employee = pos_kasir.id WHERE date(tanggal) >= '$from' AND date(tanggal) <= '$to' AND pos_activity.status = '$status' AND pos_kasir.nama LIKE '%$search%' GROUP BY pos_activity.id_employee");
                
                $count = 0;
                $jumlah = 0;
                foreach($datacount as $key=>$value){
                    $count++;
                    $jumlah += $value->total_penjualan;
                }
                $count = ceil($count/$index);
                $start = $offset+1;
            }else{
                $offset = (($pagination-1)*$index);
                $datakasir = DB::select("SELECT pos_activity.id_employee, SUM(pos_activity.total) as total_penjualan FROM pos_activity INNER JOIN pos_kasir ON pos_activity.id_employee = pos_kasir.id WHERE date(tanggal) >= '$from' AND date(tanggal) <= '$to' AND pos_kasir.nama LIKE '%$search%' GROUP BY pos_activity.id_employee LIMIT $index OFFSET $offset");
                $datacount = DB::select("SELECT pos_activity.id_employee, SUM(pos_activity.total) as total_penjualan FROM pos_activity INNER JOIN pos_kasir ON pos_activity.id_employee = pos_kasir.id WHERE date(tanggal) >= '$from' AND date(tanggal) <= '$to' AND pos_kasir.nama LIKE '%$search%' GROUP BY pos_activity.id_employee");
                $count = 0;
                $jumlah = 0;
                foreach($datacount as $key=>$value){
                    $count++;
                    $jumlah += $value->total_penjualan;
                }
                $count = ceil($count/$index);
                $start = $offset+1;
            }
            return view('report.sales.sales-kasir', compact ('search', 'datakasir', 'start', 'status', 'pagination', 'count', 'to', 'from', 'group_by', 'item', 'jumlah'));
            // return $datakasir;
        }


        // return $search;
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

    public function export_invoice(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $date = date("d-m-Y");
        $param = array(
            'status' => $request->sort_by,
            'from' => $request->from,
            'to' => $request->to,
            'total' => $request->total
        );
        // return $param;
        return Excel::download(new NoInvoice_Export($param), 'Report-Invoice_'.$date.'.xlsx');
    }

    public function export_item(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $date = date("d-m-Y");
        $param = array(
            'status' => $request->sort_by,
            'from' => $request->from,
            'to' => $request->to,
            'total' => $request->total,
            'total_item' => $request->total_item
        );
        // return new Item_Export($param);
        return Excel::download(new Item_Export($param), 'Report-Item_'.$date.'_'.$request->sort_by.'.xlsx');
    }

    public function export_kategori(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $date = date("d-m-Y");
        $param = array(
            'status' => $request->sort_by,
            'from' => $request->from,
            'to' => $request->to,
            'total' => $request->total,
            'total_item' => $request->total_item
        );
        // return new Item_Export($param);
        return Excel::download(new Kategori_Export($param), 'Report-Kategori_'.$date.'_'.$request->sort_by.'.xlsx');
    }

    public function export_store(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $date = date("d-m-Y");
        $param = array(
            'status' => $request->sort_by,
            'from' => $request->from,
            'to' => $request->to,
            'total' => $request->total,
            'total_item' => $request->total_item
        );
        // return new Item_Export($param);
        return Excel::download(new Store_Export($param), 'Report-Store_'.$date.'_'.$request->sort_by.'.xlsx');
    }

    public function export_diskon(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $date = date("d-m-Y");
        $param = array(
            'status' => $request->sort_by,
            'from' => $request->from,
            'to' => $request->to,
            'total' => $request->total
        );
        // return new Item_Export($param);
        return Excel::download(new Diskon_Export($param), 'Report-Diskon_'.$date.'_'.$request->sort_by.'.xlsx');
    }

    public function export_kasir(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $date = date("d-m-Y");
        $param = array(
            'status' => $request->sort_by,
            'from' => $request->from,
            'to' => $request->to,
            'total' => $request->total
        );
        return Excel::download(new Kasir_Export($param), 'Report-Kasir'.$date.'_'.$request->sort_by.'.xlsx');
    }
}
