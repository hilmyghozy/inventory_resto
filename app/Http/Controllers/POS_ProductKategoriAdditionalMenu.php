<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POS_ProductKategoriAdditionalMenu extends Controller
{
    public function index(Request $request)
    {
        $datakategori = DB::table('pos_product_kategori')->get();
        $datastore = DB::table('pos_store')->get();

        $search = $request->search;
        $pagination = $request->pagination;
        $index = 10;
        $page_now =1;
        $url = 'pos-config.product.kategori-additional-menu';
        $start = 1;

        if($search==null && $pagination ==null){
            $dataitem = DB::table('pos_product_kategori_additional')
                    ->join('pos_product_kategori', 'pos_product_kategori_additional.id_kategori', '=', 'pos_product_kategori.id_kategori')
                    ->join('pos_store', 'pos_product_kategori_additional.id_store', '=', 'pos_store.id_store')
                    ->select('pos_product_kategori_additional.*', 'pos_product_kategori.nama_kategori', 'pos_store.nama_store')
                    ->skip(0)->take($index)->get();;
            $count = DB::table('pos_product_kategori_additional')->count();
            $count = ceil($count/$index);
        }elseif($search==null&&$pagination!=null){
            $count = DB::table('pos_product_kategori_additional')->count();
            $count = ceil($count/$index);
            $page_now = $pagination;
            $dataitem = DB::table('pos_product_kategori_additional')
                    ->join('pos_product_kategori', 'pos_product_kategori_additional.id_kategori', '=', 'pos_product_kategori.id_kategori')
                    ->join('pos_store', 'pos_product_kategori_additional.id_store', '=', 'pos_store.id_store')
                    ->select('pos_product_kategori_additional.*', 'pos_product_kategori.nama_kategori', 'pos_store.nama_store')
                    ->skip(($page_now-1)*$index)->take($index)->get();
            $start = (($page_now-1)*$index)+1;
        }elseif($search!=null && $pagination ==null){
            $count = DB::table('pos_product_kategori_additional')
                ->join('pos_product_kategori', 'pos_product_kategori_additional.id_kategori', '=', 'pos_product_kategori.id_kategori')
                ->join('pos_store', 'pos_product_kategori_additional.id_store', '=', 'pos_store.id_store')
                ->select('pos_product_kategori_additional.*', 'pos_product_kategori.nama_kategori', 'pos_store.nama_store')
                ->where('nama_item', 'like', $search.'%')
                ->orWhere('pos_product_kategori.nama_kategori', 'like', '%'.$search.'%')
                ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            $page_now = 1;
            $dataitem = DB::table('pos_product_kategori_additional')
                ->join('pos_product_kategori', 'pos_product_kategori_additional.id_kategori', '=', 'pos_product_kategori.id_kategori')
                ->join('pos_store', 'pos_product_kategori_additional.id_store', '=', 'pos_store.id_store')
                ->select('pos_product_kategori_additional.*', 'pos_product_kategori.nama_kategori', 'pos_store.nama_store')
                ->where('nama_item', 'like', $search.'%')
                ->orWhere('pos_product_kategori.nama_kategori', 'like', '%'.$search.'%')
                ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            $start = 1;
        }else{
            $count = DB::table('pos_product_kategori_additional')
                ->join('pos_product_kategori', 'pos_product_kategori_additional.id_kategori', '=', 'pos_product_kategori.id_kategori')
                ->join('pos_store', 'pos_product_kategori_additional.id_store', '=', 'pos_store.id_store')
                ->select('pos_product_kategori_additional.*', 'pos_product_kategori.nama_kategori', 'pos_store.nama_store')
                ->where('nama_item', 'like', $search.'%')
                ->orWhere('pos_product_kategori.nama_kategori', 'like', '%'.$search.'%')
                ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            
            $page_now = $pagination;
            $dataitem = DB::table('pos_product_kategori_additional')
                ->join('pos_product_kategori', 'pos_product_kategori_additional.id_kategori', '=', 'pos_product_kategori.id_kategori')
                ->join('pos_store', 'pos_product_kategori_additional.id_store', '=', 'pos_store.id_store')
                ->select('pos_product_kategori_additional.*', 'pos_product_kategori.nama_kategori', 'pos_store.nama_store')
                ->where('nama_item', 'like', '%'.$search.'%')
                ->orWhere('pos_product_kategori.nama_kategori', 'like', '%'.$search.'%')
                ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            
            $start = (($page_now-1)*$index)+1;
        }

        // return $count;

        return view($url, compact ('dataitem', 'datastore', 'datakategori', 'page_now', 'search', 'count', 'start'));
    }

    public function create(Request $request)
    {
        DB::table('pos_product_kategori_additional')->insert(
            [
                'nama_additional_menu' => $request->nama_item, 
                'id_kategori' => $request->id_kategori, 
                'id_store' => $request->id_store,
                'harga' => $request->harga,
            ]
        );

        return redirect('pos/kategori/additional-menu')->with('status1', 'Additional Menu Berhasil Ditambah');
    }

    public function edit($id)
    {
        $dataitem = DB::table('pos_product_kategori_additional')->where('id', $id)->get();
        $datakategori = DB::table('pos_product_kategori')->get();
        $datastore = DB::table('pos_store')->get();

        return view('pos-config.product.kategori-additional-menu-edit', compact (['dataitem', 'datakategori', 'datastore']));
    }

    public function update(Request $request)
    {
        DB::table('pos_product_kategori_additional')
            ->where('id', $request->id)
            ->update([
                'nama_additional_menu' => $request->nama_additional_menu,
                'id_kategori' => $request->id_kategori,
                'id_store' => $request->id_store,
                'harga' => $request->harga
            ]);

        return redirect('pos/kategori/additional-menu')->with('status1', 'Additional Menu Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        DB::table('pos_product_kategori_additional')->where('id', $id)->delete();

        return redirect('pos/kategori/additional-menu')->with('status1', 'Additional Menu Berhasil Dihapus');
    }
}