<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class POS_ProductItemGroupController extends Controller
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
        $url = 'pos-config.product.item-group';
        $start = 1;

        if ($search == null && $pagination == null) {
            $datagroup = DB::table('pos_product_item_group')->skip(0)->take($index)->get();;
            $count = DB::table('pos_product_item_group')->count();
            $count = ceil($count / $index);
        } elseif ($search == null && $pagination != null) {
            $count = DB::table('pos_product_item_group')->count();
            $count = ceil($count / $index);
            $page_now = $pagination;
            $datagroup = DB::table('pos_product_item_group')->skip(($page_now - 1) * $index)->take($index)->get();
            $start = (($page_now - 1) * $index) + 1;
        } elseif ($search != null && $pagination == null) {
            $count = DB::table('pos_product_item_group')
                ->where('nama_group', 'like', '%' . $search . '%')
                ->count();
            $count = ceil($count / $index);
            $page_now = 1;
            $datagroup = DB::table('pos_product_item_group')
                ->where('nama_group', 'like', '%' . $search . '%')
                ->skip(($page_now - 1) * $index)->take($index)
                ->get();
            $start = 1;
        } else {
            $count = DB::table('pos_product_item_group')
                ->where('nama_group', 'like', '%' . $search . '%')
                ->count();
            $count = ceil($count / $index);

            $page_now = $pagination;
            $datagroup = DB::table('pos_product_item_group')
                ->where('nama_group', 'like', '%' . $search . '%')
                ->skip(($page_now - 1) * $index)->take($index)
                ->get();
            $start = (($page_now - 1) * $index) + 1;
        }

        // return $count;

        return view($url, compact('datagroup', 'page_now', 'search', 'count', 'start'));
    }

    public function table()
    {
        $datagroup = DB::table('pos_product_item_group')->get();
        $count = DB::table('pos_product_item_group')->count();

        return view('pos-config.product.item-group-product', compact('datagro$datagroup', 'count'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        DB::table('pos_product_item_group')->insert(
            [
                'nama_item_group' => $request->nama_item_group
            ]
        );

        return redirect('pos/item-group')->with('status1', 'Item Group Berhasil Ditambah');
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
        $datagroup = DB::table('pos_product_item_group')->where('id_item_group', $id)->get();
        return view('pos-config.product.item-group-edit', compact('datagroup'));
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
        DB::table('pos_product_item_group')
            ->where('id_item_group', $id)
            ->update(
                [
                    'nama_item_group' => $request->nama_item_group
                ]
            );

        return redirect('pos/item-group')->with('status1', 'Item Group Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('pos_product_item_group')->where('id_item_group', $id)->delete();

        return redirect('pos/item-group')->with('status1', 'Item Group Berhasil Dihapus');
    }
}
