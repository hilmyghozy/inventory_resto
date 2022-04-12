<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class POS_ProductPaketController extends Controller
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
        $page_now = 1;
        $url = 'pos-config.product.paket.index';
        $start = 1;

        if ($search == null && $pagination == null) {
            $datapaket = DB::table('pos_product_paket')
                ->join('pos_store', 'pos_store.id_store', '=', 'pos_product_paket.id_store')
                ->select('pos_product_paket.*', 'pos_store.nama_store')
                ->skip(0)->take($index)->get();;
            $count = DB::table('pos_product_paket')->count();
            $count = ceil($count / $index);
        } elseif ($search == null && $pagination != null) {
            $count = DB::table('pos_product_paket')->count();
            $count = ceil($count / $index);
            $page_now = $pagination;
            $datapaket = DB::table('pos_product_paket')
                ->join('pos_store', 'pos_store.id_store', '=', 'pos_product_paket.id_store')
                ->select('pos_product_paket.*', 'pos_store.nama_store')
                ->skip(($page_now - 1) * $index)->take($index)->get();
            $start = (($page_now - 1) * $index) + 1;
        } elseif ($search != null && $pagination == null) {
            $count = DB::table('pos_product_paket')
                ->where('nama_paket', 'like', '%' . $search . '%')
                ->count();
            $count = ceil($count / $index);
            $page_now = 1;
            $datapaket = DB::table('pos_product_paket')
                ->join('pos_store', 'pos_store.id_store', '=', 'pos_product_paket.id_store')
                ->select('pos_product_paket.*', 'pos_store.nama_store')
                ->where('nama_paket', 'like', '%' . $search . '%')
                ->skip(($page_now - 1) * $index)->take($index)
                ->get();
            $start = 1;
        } else {
            $count = DB::table('pos_product_paket')
                ->where('nama_paket', 'like', '%' . $search . '%')
                ->count();
            $count = ceil($count / $index);

            $page_now = $pagination;
            $datapaket = DB::table('pos_product_paket')
                ->join('pos_store', 'pos_store.id_store', '=', 'pos_product_paket.id_store')
                ->select('pos_product_paket.*', 'pos_store.nama_store')
                ->where('nama_paket', 'like', '%' . $search . '%')
                ->skip(($page_now - 1) * $index)->take($index)
                ->get();
            $start = (($page_now - 1) * $index) + 1;
        }

        $datastore = DB::table('pos_store')->get();
        $datakategori = DB::table('pos_product_kategori')->get();

        // return $count;

        return view($url, compact('datapaket', 'datastore', 'datakategori', 'page_now', 'search', 'count', 'start'));
    }

    public function table()
    {
        $datapaket = DB::table('pos_product_paket')->get();
        $count = DB::table('pos_product_paket')->count();

        return view('pos-config.product.kategori-product', compact('datapaket', 'count'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        DB::table('pos_product_paket')->insert(
            [
                'nama_paket' => $request->nama_paket,
                'id_store' => $request->id_store,
                'pajak' => $request->pajak,
                'harga_jual' => $request->harga_jual,
            ]
        );

        return redirect('pos/paket')->with('status1', 'Paket Berhasil Ditambah');
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
        $search = $request->search;
        $pagination = $request->pagination;
        return $search == null;
    }

    public function pagination($id)
    {
        $jumlah = $id;
        return view('pos-config.product.product-pagination', compact('jumlah'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $datastore = DB::table('pos_store')->get();
        $datapaket = DB::table('pos_product_paket')->where('id_paket', $id)
            ->join('pos_store', 'pos_product_paket.id_store', '=', 'pos_store.id_store')
            ->select('pos_product_paket.*', 'pos_store.nama_store')
            ->get();

        return view('pos-config.product.paket.edit', compact('datastore', 'datapaket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {

        DB::table('pos_product_paket')
            ->where('id_paket', $id)
            ->update(
                [
                    'nama_paket' => $request->nama_paket,
                    'id_store' => $request->id_store,
                    'pajak' => $request->pajak,
                    'harga_jual' => $request->harga_jual,
                ]
            );

        return redirect('pos/paket')->with('status1', 'Paket Berhasil Ditambah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        DB::table('pos_product_paket')->where('id_paket', $id)->delete();

        return redirect('pos/paket')->with('status1', 'Berhasil menghapus paket');
    }

    public function kelolaPaket($id, Request $request)
    {
        $datapaket = DB::table('pos_product_paket')->where('id_paket', $id)
            ->join('pos_store', 'pos_product_paket.id_store', '=', 'pos_store.id_store')
            ->select('pos_product_paket.*', 'pos_store.nama_store')
            ->get();

        $datapaketdetail = DB::table('pos_product_paket_detail')
            ->where('id_paket', $id)
            // ->join('pos_product_kategori', 'pos_product_paket_detail.id_kategori', '=', 'pos_product_kategori.id_kategori')
            // ->select('pos_product_paket_detail.*', 'pos_product_kategori.nama_kategori')
            ->get();

        $dataitem = DB::table('pos_product_item')
            ->join('pos_product_kategori', 'pos_product_item.id_kategori', '=', 'pos_product_kategori.id_kategori')
            ->select('pos_product_item.*', 'pos_product_kategori.nama_kategori')
            ->where('id_store', $datapaket[0]->id_store)
            ->get();

        return view('pos-config.product.paket.kelola', compact('datapaket', 'datapaketdetail', 'dataitem'));
    }

    public function addPaketDetail($id, Request $request)
    {
        // return $request->all();

        $dataitem = DB::table('pos_product_item')
            ->select('id_item', 'nama_item')
            ->whereIn('id_item', $request->opsi_menu)->get();
        $id_paket_detail = 1;
        $product_paket_detail = DB::table('pos_product_paket_detail')->latest('id_paket_detail')->first();
        if ($product_paket_detail) $id_paket_detail = $product_paket_detail->id_paket_detail + 1;

        DB::table('pos_product_paket_detail')->insert(
            [
                'id_paket_detail' => $id_paket_detail,
                'id_paket' => $id,
                'nama_paket_detail' => $request->nama_paket_detail,
                'id_kategori' => 0,
                'opsi_menu' => json_encode($dataitem),
            ]
        );


        return redirect('pos/paket/kelola/' . $id)->with('status1', 'Berhasil menambah detail paket');
    }

    public function editPaketDetail($id, $id_detail)
    {
        $datapaket = DB::table('pos_product_paket')->where('id_paket', $id)
            ->join('pos_store', 'pos_product_paket.id_store', '=', 'pos_store.id_store')
            ->select('pos_product_paket.*', 'pos_store.nama_store')
            ->get();

        $dataitem = DB::table('pos_product_item')
            ->join('pos_product_kategori', 'pos_product_item.id_kategori', '=', 'pos_product_kategori.id_kategori')
            ->select('pos_product_item.*', 'pos_product_kategori.nama_kategori')
            ->where('id_store', $datapaket[0]->id_store)
            ->get();


        $datapaketdetail = DB::table('pos_product_paket_detail')
            ->where('id_paket_detail', $id_detail)
            ->get();


        $id_opsi_menu =  json_decode($datapaketdetail[0]->opsi_menu, true);
        $id_opsi_menu = array_column($id_opsi_menu, 'id_item');

        return view('pos-config.product.paket.edit-paket-detail', compact('datapaket', 'datapaketdetail', 'dataitem', 'id_opsi_menu'));
    }



    public function deletePaketDetail($id, $id_detail)
    {
        DB::table('pos_product_paket_detail')->where('id_paket_detail', $id_detail)->delete();

        return redirect('pos/paket/kelola/' . $id)->with('status1', 'Berhasil menghapus detail paket');
    }




    public function updatePaketDetail($id, $id_detail, Request $request)
    {
        // return $request->all();

        $dataitem = DB::table('pos_product_item')
            ->select('id_item', 'nama_item')
            ->whereIn('id_item', $request->opsi_menu)->get();

        DB::table('pos_product_paket_detail')
            ->where('id_paket_detail', $id_detail)
            ->update(
                [
                    'nama_paket_detail' => $request->nama_paket_detail,
                    'opsi_menu' => json_encode($dataitem),
                ]
            );


        return redirect('pos/paket/kelola/' . $id)->with('status1', 'Berhasil merubah detail paket');
    }


    // 
    // updatePaketDetail
}
