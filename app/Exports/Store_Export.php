<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Store_Export implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $param = array();

    function __construct($param) {
            $this->param = $param;
    }

    public function collection()
    {
        $val = $this->param;
        $from = $val['from'];
        $to = $val['to'];
        $status = $val['status'];
        
        if($val['status'] != 'all'){
            $data = DB::select("SELECT pos_store.nama_store, SUM(pos_activity_item.total) as total_penjualan ,SUM(pos_activity_item.qty) as total_qty FROM pos_activity_item INNER JOIN pos_store ON pos_activity_item.id_store = pos_store.id_store WHERE date(created_at) >= '$from' AND date(created_at) <= '$to' AND pos_activity_item.status = '$status' GROUP BY pos_store.nama_store");
        }else{
            $data = DB::select("SELECT pos_store.nama_store, SUM(pos_activity_item.total) as total_penjualan ,SUM(pos_activity_item.qty) as total_qty FROM pos_activity_item INNER JOIN pos_store ON pos_activity_item.id_store = pos_store.id_store WHERE date(created_at) >= '$from' AND date(created_at) <= '$to' GROUP BY pos_store.nama_store");
        }
        
        return collect($data);
    }

    public function headings(): array{
        return [
            [
                'Total',
                $this->param['total']
            ],
            [
                'Total Item',
                $this->param['total_item']
            ],
            [
                ''
            ],
            [
                'Nama Store',
                'Total Penjualan',
                'Total Harga Penjualan'
            ]
        ];
    }
}
