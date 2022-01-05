<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class POS_ProductKategoriController extends Controller
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
        $url = 'pos-config.product.kategori';
        $start = 1;

        if($search==null && $pagination ==null){
            $datakategori = DB::table('pos_product_kategori')->skip(0)->take($index)->get();;
            $count = DB::table('pos_product_kategori')->count();
            $count = ceil($count/$index);
        }elseif($search==null&&$pagination!=null){
            $count = DB::table('pos_product_kategori')->count();
            $count = ceil($count/$index);
            $page_now = $pagination;
            $datakategori = DB::table('pos_product_kategori')->skip(($page_now-1)*$index)->take($index)->get();
            $start = (($page_now-1)*$index)+1;
        }elseif($search!=null && $pagination ==null){
            $count = DB::table('pos_product_kategori')
                ->where('nama_kategori', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            $page_now = 1;
            $datakategori = DB::table('pos_product_kategori')
                ->where('nama_kategori', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            $start = 1;
        }else{
            $count = DB::table('pos_product_kategori')
                ->where('nama_kategori', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            
            $page_now = $pagination;
            $datakategori = DB::table('pos_product_kategori')
                ->where('nama_kategori', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            $start = (($page_now-1)*$index)+1;
        }

        // return $count;

        return view($url, compact ('datakategori', 'page_now', 'search', 'count', 'start'));
    }

    public function table()
    {
        $datakategori = DB::table('pos_product_kategori')->get();
        $count = DB::table('pos_product_kategori')->count();

        return view('pos-config.product.kategori-product', compact ('datakategori', 'count'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        DB::table('pos_product_kategori')->insert(
            ['id_kategori' => null, 'nama_kategori' => $request->nama_kategori, 
            'ip_printer1' => $request->ip_printer1, 'ip_printer2' => $request->ip_printer2, 
            'ip_printer3' => $request->ip_printer3, 'print_by' => $request->print_by]
        );

        return redirect('pos/kategori')->with('status1', 'Kategori Berhasil Ditambah');
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
        return $search==null;
    }

    public function pagination($id)
    {
        $jumlah = $id;
        return view('pos-config.product.product-pagination', compact ('jumlah'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datakategori = DB::table('pos_product_kategori')->where('id_kategori', $id)->get();
        return view('pos-config.product.kategori-edit', compact('datakategori'));
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
        DB::table('pos_product_kategori')
              ->where('id_kategori', $request->id_kategori)
              ->update(['nama_kategori' => $request->nama_kategori, 
              'ip_printer1' => $request->ip_printer1, 'ip_printer2' => $request->ip_printer2, 
              'ip_printer3' => $request->ip_printer3, 'print_by' => $request->print_by]);

        // return $request;
        return redirect('pos/kategori')->with('status1', 'Kategori Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('pos_product_kategori')->where('id_kategori', $id)->delete();

        return redirect('pos/kategori')->with('status1', 'Kategori Berhasil Dihapus');
    }
}
