<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POS_ProductItemTypeController extends Controller
{
    public function index(Request $request)
    {
        $datakategori = DB::table('pos_product_kategori')->get();
        $datastore = DB::table('pos_store')->get();

        $search = $request->search;
        $pagination = $request->pagination;
        $index = 10;
        $page_now =1;
        $url = 'pos-config.product.type.index';
        $start = 1;

        if($search==null && $pagination ==null){
            $dataitem = DB::table('pos_product_item_type')
                    ->join('pos_store', 'pos_product_item_type.id_store', '=', 'pos_store.id_store')
                    ->select('pos_product_item_type.*', 'pos_store.nama_store')
                    ->skip(0)->take($index)->get();
            $count = DB::table('pos_product_item_type')->count();
            $count = ceil($count/$index);
        }elseif($search==null&&$pagination!=null){
            $count = DB::table('pos_product_item_type')->count();
            $count = ceil($count/$index);
            $page_now = $pagination;
            $dataitem = DB::table('pos_product_item_type')
                    ->join('pos_store', 'pos_product_item_type.id_store', '=', 'pos_store.id_store')
                    ->select('pos_product_item_type.*', 'pos_store.nama_store')
                    ->skip(($page_now-1)*$index)->take($index)->get();
            $start = (($page_now-1)*$index)+1;
        }elseif($search!=null && $pagination ==null){
            $count = DB::table('pos_product_item_type')
                ->join('pos_store', 'pos_product_item_type.id_store', '=', 'pos_store.id_store')
                ->select('pos_product_item_type.*', 'pos_store.nama_store')
                ->where('nama_item', 'like', $search.'%')
                ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            $page_now = 1;
            $dataitem = DB::table('pos_product_item_type')
                ->join('pos_store', 'pos_product_item_type.id_store', '=', 'pos_store.id_store')
                ->select('pos_product_item_type.*', 'pos_store.nama_store')
                ->where('nama_item', 'like', $search.'%')
                ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            $start = 1;
        }else{
            $count = DB::table('pos_product_item_type')
                ->join('pos_store', 'pos_product_item_type.id_store', '=', 'pos_store.id_store')
                ->select('pos_product_item_type.*', 'pos_store.nama_store')
                ->where('nama_item', 'like', $search.'%')
                ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            
            $page_now = $pagination;
            $dataitem = DB::table('pos_product_item_type')
                ->join('pos_store', 'pos_product_item_type.id_store', '=', 'pos_store.id_store')
                ->select('pos_product_item_type.*', 'pos_store.nama_store')
                ->where('nama_item', 'like', '%'.$search.'%')
                ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            
            $start = (($page_now-1)*$index)+1;
        }

        return view($url, compact ('dataitem', 'datastore', 'datakategori', 'page_now', 'search', 'count', 'start'));
    }

    public function create(Request $request)
    {
        DB::table('pos_product_item_type')->insert(
            [
                'nama_size' => $request->nama_size,
                'harga' => $request->harga,
                'kode_size' => $request->nama_size,
                'id_store' => $request->id_store
            ]
        );

        return redirect('pos/item-size')->with('status1', 'Item Size Berhasil Ditambah');
    }

    public function edit($id)
    {
        $data = DB::table('pos_product_item_type')
            ->join('pos_store', 'pos_store.id_store', '=', 'pos_product_item_type.id_store')
            ->where('pos_product_item_type.id_size', $id)->get();

        $datastore = DB::table('pos_store')->get();

        return view('pos-config.product.type.edit', compact('data', 'datastore'));
    }

    public function update(Request $request)
    {
        DB::table('pos_product_item_type')
        ->where('id_size', $request->id)
        ->update([
            'nama_size' => $request->nama_size,
            'kode_size' => $request->nama_size,
            'id_store' => $request->id_store,
            'harga' => $request->harga
        ]);

        return redirect('pos/item-size')->with('status1', 'Item Size Berhasil Diperbarui');
    }

    public function destroy($id)
    {
      DB::table('pos_product_item_type')->where('id_size', $id)->delete();

      return redirect('pos/item-size')->with('status1', 'Item Size Berhasil Dihapus');
    }

    public function getProductItemType($id_item)
    {
        $item = DB::table('pos_product_item')->where('id_item', $id_item)->first();
        if ($item) {
            $product_item_type = DB::table('pos_product_item_type')
                ->where('id_item', $id_item)->where('id_item_type', '!=', null)->get();
            $product_item_type = $product_item_type->map(function ($data) use ($item) {
                $data->text = "$item->nama_item ($data->nama_type)";
                return $data;
            });
            return response()->json($product_item_type);
        }
        return response()->json(['code' => 404], 404);
    }
}