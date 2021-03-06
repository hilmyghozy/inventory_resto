<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\PosProductItemType;
use Illuminate\Support\Facades\DB;

class POS_ProductItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $dataitem = DB::table('pos_product_item')
        //     ->join('pos_product_kategori', 'pos_product_item.id_kategori', '=', 'pos_product_kategori.id_kategori')
        //     ->join('pos_store', 'pos_product_item.id_store', '=', 'pos_store.id_store')
        //     ->select('pos_product_item.*', 'pos_product_kategori.nama_kategori', 'pos_store.nama_store')
        //     ->get();

        $datakategori = DB::table('pos_product_kategori')->get();
        $datastore = DB::table('pos_store')->get();

        $search = $request->search;
        $pagination = $request->pagination;
        $index = 10;
        $page_now =1;
        $url = 'pos-config.product.item';
        $start = 1;
        $dataitem = DB::table('pos_product_item')
            ->join('pos_product_kategori', 'pos_product_item.id_kategori', '=', 'pos_product_kategori.id_kategori')
            ->join('pos_store', 'pos_product_item.id_store', '=', 'pos_store.id_store')
            ->select('pos_product_item.*', 'pos_product_kategori.nama_kategori', 'pos_store.nama_store')
            ->get();
        $count = count($dataitem);
        
        // return $count;

        return view($url, compact ('dataitem', 'datastore', 'datakategori', 'page_now', 'search', 'count', 'start'));

        // return view('pos-config.product.item', compact (['dataitem', 'datakategori', 'datastore']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $item_types = $request->input('nama_item_type') ?: [];
        $item_sizes = $request->input('nama_item_size') ?: [];
        $harga_item_sizes = $request->input('harga_item_size') ?: [];
        $pajak_item_sizes = $request->input('pajak_item_size') ?: [];
        $harga_thirdparty_item_sizes = $request->input('harga_thirdparty_item_size') ?: [];
        $pajak_thirdparty_item_sizes = $request->input('pajak_thirdparty_item_size') ?: [];
        DB::beginTransaction();
        $item = DB::table('pos_product_item')->insertGetId([
            'id_item' => null, 'nama_item' => $request->nama_item, 
            'harga' => $request->harga ?: 0, 'id_kategori' => $request->id_kategori, 
            'id_store' => $request->id_store, 'pajak' => $request->pajak ?: 0, 
            'harga_jual' => $request->harga_jual ?: 0, 'harga_thirdparty' => $request->harga_thirdparty ?: 0, 'pajak_thirdparty' => $request->pajak_thirdparty ?: 0, 'thirdparty' => $request->thirdparty ?: 0
        ]);
        $data_item_type = [];
        foreach ($item_types as $type => $item_type) {
            $id_item_type = DB::table('pos_product_item_type')->insertGetId([
                'nama_type' => $item_type,
                'id_item' => $item,
                'id_store' => $request->id_store
            ]);
            foreach ($item_sizes[$type] as $size => $item_size) {
                $nama_type = "$item_type $item_size";
                $harga = $harga_item_sizes[$type][$size];
                $pajak = $pajak_item_sizes[$type][$size];
                $total = $harga + $pajak;
                $harga_thirdparty = $harga_thirdparty_item_sizes[$type][$size];
                $pajak_thirdparty = $pajak_thirdparty_item_sizes[$type][$size];
                $total_thirdparty = $harga_thirdparty + $pajak_thirdparty;
                array_push($data_item_type, [
                    'nama_type' => $nama_type,
                    'id_store' => $request->id_store,
                    'id_item' => $item,
                    'item_type' => $item_type,
                    'item_size' => $item_size,
                    'harga' => $harga,
                    'pajak' => $pajak,
                    'harga_jual' => $total,
                    'harga_thirdparty' => $harga_thirdparty,
                    'pajak_thirdparty' => $pajak_thirdparty,
                    'thirdparty' => $total_thirdparty,
                    'id_item_type' => $id_item_type
                ]);
            }
        }
        DB::table('pos_product_item_type')->insert($data_item_type);
        DB::commit();
        
        return redirect('pos/item')->with('status1', 'Item Berhasil Ditambah');
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $opsi_menu = [];
        $dataitem = DB::table('pos_product_item')
            ->join('pos_product_kategori', 'pos_product_kategori.id_kategori', '=', 'pos_product_item.id_kategori')
            ->select('pos_product_item.*', 'pos_product_kategori.is_paket')
            ->where('id_item', $id)->get();
        $index = 0;
        $selected_item_opsi_menu = [];
        $dataitem = $dataitem->map(function ($item) {
            $item_types = DB::table('pos_product_item_type')->where('id_item', $item->id_item)->where('id_item_type', null)->get();
            $opsi_menu = DB::table('pos_product_item_menu')->where('id_item', $item->id_item)->get();
            $opsi_menu = $opsi_menu->map(function ($menu) {
                $menu_type = DB::table('pos_product_item_menu_type')->where([
                    'id_item' => $menu->id_item,
                    'id_item_paket' => $menu->id_item_paket
                ])->get();
                $menu->menu_type = $menu_type;
                return $menu;
            });
            $item->opsi_menu = $opsi_menu;
            $item_types = $item_types->map(function($type) {
                $item_sizes = DB::table('pos_product_item_type')->where('id_item_type', $type->id_type)->get();
                $type->item_sizes = $item_sizes;
                return $type;
            });
            if ($item->harga_thirdparty == 0) $item->harga_thirdparty = $item->thirdparty - $item->pajak_thirdparty;
            $item->item_types = $item_types;
            return $item;
        });
        foreach ($dataitem as $item) {
            foreach ($item->opsi_menu as $opsi_menu) {
                $item_opsi_menu_exists = collect($selected_item_opsi_menu)->where('jumlah', $opsi_menu->jumlah)->where('id_kategori', $opsi_menu->id_kategori)->first();
                if (!$item_opsi_menu_exists) array_push($selected_item_opsi_menu, (object)[
                    'id_kategori' => $opsi_menu->id_kategori,
                    'jumlah' => $opsi_menu->jumlah,
                    'opsi_menu' => collect($item->opsi_menu)->where('jumlah', $opsi_menu->jumlah)->where('id_kategori', $opsi_menu->id_kategori)->values()
                ]);
            }
        }
        $datakategori = DB::table('pos_product_kategori')->get();
        $datastore = DB::table('pos_store')->get();
        if ($dataitem->count() > 0) {
            $data = $dataitem[0];
            if ($data->is_paket) {
                $opsi_menu = DB::table('pos_product_item')
                ->join('pos_product_kategori', 'pos_product_kategori.id_kategori', '=', 'pos_product_item.id_kategori')
                ->select('pos_product_item.*', 'pos_product_kategori.is_paket')
                ->where('pos_product_kategori.is_paket', 0)
                ->where('id_store', $data->id_store)->get();
            }
            if (count($data->opsi_menu) > 0) {
                $selected_opsi_menu = $data->opsi_menu;
                $index = 0;
                while ($index < count($opsi_menu)) {
                    $item_opsi_menu = $opsi_menu[$index];
                    $item_opsi_menu->selected = false;
                    $menu = 0;
                    while ($menu < count($selected_opsi_menu)) {
                        $item_selected_opsi_menu = $selected_opsi_menu[$menu];
                        if ($item_opsi_menu->id_item === $item_selected_opsi_menu->id_item_paket) {
                            // $item_opsi_menu->selected = true;
                            $menu_type = DB::table('pos_product_item_menu_type')
                                ->join('pos_product_item_type', 'pos_product_item_type.id_type', '=', 'pos_product_item_menu_type.id_item_type')
                                ->where([
                                    'pos_product_item_menu_type.id_item' => $dataitem[0]->id_item,
                                    'pos_product_item_menu_type.id_item_paket' => $item_opsi_menu->id_item
                                ])->select('pos_product_item_type.nama_type')->get()->map(function ($type) use ($item_opsi_menu) {
                                    $type->nama_item = $item_opsi_menu->nama_item . "($type->nama_type)";
                                    return $type;
                                });
                            $item_opsi_menu->menu_type = $menu_type;
                        }
                        $menu += 1;
                    }
                    $index += 1;
                }
            }
        }
        // return response()->json($selected_item_opsi_menu);
        return view('pos-config.product.item-edit', compact (['dataitem', 'datakategori', 'datastore', 'opsi_menu', 'selected_item_opsi_menu']));
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
        DB::beginTransaction();
        $opsi_menu = [];
        $input_opsi_menu = $request->input('opsi_menu') ?: [];
        $input_jumlah_opsi_menu = $request->input('jumlah_opsi_menu') ?: [];
        $input_kategori_opsi_menu = $request->input('kategori_opsi_menu') ?: [];
        $paket_item_menu = $request->input('paket_item_menu') ?: [];
        $select_all_opsi_menu = $request->input('select_all_opsi_menu') ?: [];
        
        $delete_item_types = $request->input('delete_item_types') ?: [];
        $item_type_id = $request->input('item_type_id') ?: [];
        $nama_item_type = $request->input('nama_item_type') ?: [];
        $item_size_id = $request->input('item_size_id') ?: [];
        $nama_item_size = $request->input('nama_item_size') ?: [];
        $harga_item_size = $request->input('harga_item_size') ?: [];
        $pajak_item_size = $request->input('pajak_item_size') ?: [];
        $harga_thirdparty_item_size = $request->input('harga_thirdparty_item_size') ?: [];
        $pajak_thirdparty_item_size = $request->input('pajak_thirdparty_item_size') ?: [];
        
        foreach ($item_type_id as $type => $type_id) {
            $id_type = $type_id != 0 ? $type : 0;
            $data_item_type = [
                'nama_type' => $nama_item_type[$type],
                'id_store' => $request->id_store,
                'id_item' => $request->id_item
            ];
            if ($id_type == 0) {
                $id_type = DB::table("pos_product_item_type")->insertGetId($data_item_type);
            } else {
                DB::table('pos_product_item_type')->where('id_type', $id_type)->update($data_item_type);
            }
            $item_sizes = $item_size_id[$type];
            foreach ($item_sizes as $size => $item_size) {
                $harga = $harga_item_size[$type][$size];
                $pajak = $pajak_item_size[$type][$size];
                $harga_jual = $harga + $pajak;
                $harga_thirdparty = $harga_thirdparty_item_size[$type][$size];
                $pajak_thirdparty = $pajak_thirdparty_item_size[$type][$size];
                $thirdparty = $harga_thirdparty + $pajak_thirdparty;
                $data_item_type = [
                    'id_item_type' => $id_type,
                    'nama_type' => $nama_item_type[$type] . ' ' . $nama_item_size[$type][$size],
                    'id_store' => $request->id_store,
                    'id_item' => $request->id_item,
                    'harga' => $harga,
                    'pajak' => $pajak,
                    'harga_jual' => $harga_jual,
                    'harga_thirdparty' => $harga_thirdparty,
                    'pajak_thirdparty' => $pajak_thirdparty,
                    'thirdparty' => $thirdparty,
                    'item_type' => $nama_item_type[$type],
                    'item_size' => $nama_item_size[$type][$size]
                ];
                if ($item_size == 0) {
                    DB::table('pos_product_item_type')->insert($data_item_type);
                } else {
                    DB::table('pos_product_item_type')->where('id_type', $item_size)->update($data_item_type);
                }
            }
        }
        DB::table('pos_product_item_type')->whereIn('id_type', $delete_item_types)->delete();
        if ($request->input('opsi_menu')) {
            DB::table('pos_product_item_menu')->where('id_item', $request->id_item)->delete();
            DB::table('pos_product_item_menu_type')->where([
                'id_item' => $request->id_item
            ])->delete();
            foreach ($input_opsi_menu as $key => $item) {
                $jumlah_opsi_menu = $input_jumlah_opsi_menu[$key][0];
                $kategori_opsi_menu = $input_kategori_opsi_menu[$key][0];
                $jumlah_menu_kategori = DB::table('pos_product_item')->where('id_kategori', $kategori_opsi_menu)->count();
                foreach ($item as $id_menu) {
                    if (isset($select_all_opsi_menu[$key])) {
                        $paket_item_menu[$id_menu] = [];
                        $menu_type = DB::table('pos_product_item_type')->where('id_item_type', '!=', null)->where('id_item', $id_menu)->get();
                        foreach ($menu_type as $type) {
                            array_push($paket_item_menu[$id_menu], $type->id_type);
                        }
                    }
                    $id_pos_product_item_opsi_menu = DB::table('pos_product_item_menu')->insertGetId([
                        'id_item' => $request->id_item,
                        'id_item_paket' => $id_menu,
                        'jumlah' => $jumlah_opsi_menu,
                        'id_kategori' => $kategori_opsi_menu
                    ]);
                    if (isset($paket_item_menu[$id_menu])) {
                        foreach ($paket_item_menu[$id_menu] as $available_menu) {
                            DB::table('pos_product_item_menu_type')->insert([
                                'id_item' => $request->id_item,
                                'id_item_paket' => $id_menu,
                                'id_pos_product_item_opsi_menu' => $id_pos_product_item_opsi_menu,
                                'id_item_type' => $available_menu
                            ]);
                        }
                    }
                }
            }
        }
        DB::table('pos_product_item')
              ->where('id_item', $request->id_item)
              ->update(['nama_item' => $request->nama_item, 'id_kategori' => $request->id_kategori,
              'id_store' => $request->id_store, 'harga' => $request->harga ?: 0, 'pajak' => $request->pajak ?: 0,
              'harga_jual' => $request->harga_jual ?: 0, 'harga_thirdparty' => $request->harga_thirdparty ?: 0, 'pajak_thirdparty' => $request->pajak_thirdparty ?: 0, 'thirdparty' => $request->thirdparty ?: 0,
              'has_type' => $request->has_type, 'has_size' => $request->has_size]);
        DB::commit();
        return redirect('pos/item')->with('status1', 'Item Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('pos_product_item')->where('id_item', $id)->delete();

        return redirect('pos/item')->with('status1', 'Item Berhasil Dihapus');
    }
}
