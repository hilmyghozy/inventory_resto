<?php

namespace App\Http\Controllers;

use App\PosPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class POS_PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function pos_payment(Request $request)
    {
        $search = $request->search;
        $pagination = $request->pagination;
        $index = 4;
        $page_now =1;
        $url = 'pos-config.payment.payment';
        $start = 1;

        if($search==null && $pagination ==null){
            $data = DB::table('pos_payment')->skip(0)->take($index)->get();;
            $count = DB::table('pos_payment')->count();
            $count = ceil($count/$index);
        }elseif($search==null&&$pagination!=null){
            $count = DB::table('pos_payment')->count();
            $count = ceil($count/$index);
            $page_now = $pagination;
            $data = DB::table('pos_payment')->skip(($page_now-1)*$index)->take($index)->get();
            $start = (($page_now-1)*$index)+1;
        }elseif($search!=null && $pagination ==null){
            $count = DB::table('pos_payment')
                ->where('nama_payment', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            $page_now = 1;
            $data = DB::table('pos_payment')
                ->where('nama_payment', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            $start = 1;
        }else{
            $count = DB::table('pos_payment')
                ->where('nama_payment', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            
            $page_now = $pagination;
            $data = DB::table('pos_payment')
                ->where('nama_payment', 'like', '%'.$search.'%')
                ->skip(($page_now-1)*$index)->take($index)
                ->get();
            $start = (($page_now-1)*$index)+1;
        }

        return view($url, compact ('data', 'page_now', 'search', 'count', 'start'));
    }

    public function index()
    {
        //
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

    public function add(Request $request)
    {
        if($request->tipe_payment == 1){
            $is_split = 0;
        }else{
            $is_split = 1;
        }

        $request->validate([
            'nama_payment' => 'required|max:20',
            'gambar_payment' => 'mimes:jpg,jpeg,png|max:512',
        ],[
            'nama_payment.required' => 'Metode pembayaran harus diisi',
            'nama_payment.max' => 'Metode pembayaran maksimal 20 karakter',
            'gambar_payment.mimes' => 'Tipe file berupa jpeg/ png',
            'gambar_payment.max' => 'Gambar maksimal 512 kB',
        ]);

        if($request->file('gambar_payment')){
            $gambar = $request->file('gambar_payment')->store('bank','public');
        }else{
            $gambar = null;
        }

        DB::table('pos_payment')->insert(
            ['id_payment' => null, 'nama_payment' => $request->nama_payment, 'logo' => $gambar, 'tipe_payment' => $request->tipe_payment, 'is_split' => $is_split]
        );
        return redirect('pos/payment')->with('status1', 'Data Berhasil Ditambah');
    }

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
        $data = DB::table('pos_payment')->where('id_payment', $id)->get();
        return view('pos-config/payment/payment-edit', compact('data'));
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
        if($request->tipe_payment == 1){
            $is_split = 0;
        }else{
            $is_split = 1;
        }

        $request->validate([[
            'nama_payment' => 'required|max:20',
            'gambar_payment' => 'mimes:jpg,jpeg,png|max:512',
        ],[
            'nama_payment.required' => 'Metode pembayaran harus diisi',
            'nama_payment.max' => 'Metode pembayaran maksimal 20 karakter',
            'gambar_payment.mimes' => 'Tipe file berupa jpeg/ png',
            'gambar_payment.max' => 'Gambar maksimal 512 kB',
        ]]);

        if($request->gambar_payment){
            $gambar = $request->file('gambar_payment')->store('bank','public');
            if($request->hapus=='yes'){
                self::deletestorage($request->id_payment);

                DB::table('pos_payment')
                    ->where('id_payment', $request->id_payment)
                    ->update(
                        ['nama_payment' => $request->nama_payment,
                        'logo' => null, 'tipe_payment' => $request->tipe_payment, 'is_split' => $is_split]
                );
            }else{
                DB::table('pos_payment')
                    ->where('id_payment', $request->id_payment)
                    ->update(
                        ['nama_payment' => $request->nama_payment,
                        'logo' => $gambar, 'tipe_payment' => $request->tipe_payment, 'is_split' => $is_split]
                );
            }
            
        }else{
            if($request->hapus=='yes'){
                self::deletestorage($request->id_payment);

                DB::table('pos_payment')
                    ->where('id_payment', $request->id_payment)
                    ->update(
                        ['nama_payment' => $request->nama_payment,
                        'logo' => null, 'tipe_payment' => $request->tipe_payment, 'is_split' => $is_split]
                );
            }else{
                DB::table('pos_payment')
                    ->where('id_payment', $request->id_payment)
                    ->update(
                        ['nama_payment' => $request->nama_payment, 'tipe_payment' => $request->tipe_payment, 'is_split' => $is_split]
                );
            }
        }
        return redirect('pos/payment')->with('status1', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        self::deletestorage($id);
        DB::table('pos_payment')->where('id_payment', $id)->delete();
        return redirect('pos/payment')->with('status1', 'Data Berhasil Dihapus');
    }

    public function deletestorage($id)
    {
        $data = DB::table('pos_payment')->where('id_payment', $id)->first();
        
        if($data->logo){
            Storage::delete('public/'.$data->logo);
        }
    }
}
