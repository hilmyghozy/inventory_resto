<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Diskon_Export implements FromCollection, WithHeadings
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
            $data = DB::select("SELECT pos_activity.no_invoice,  (pos_activity.subtotal-pos_activity.total) as total_diskon, pos_diskon.nama_voucher, pos_store.nama_store, pos_activity.tanggal, pos_activity.status FROM `pos_activity` INNER JOIN pos_diskon ON pos_activity.id_discount = pos_diskon.id_voucher INNER JOIN pos_store  ON pos_activity.id_store = pos_store.id_store WHERE tanggal >= '$from' AND tanggal <= '$to' AND status = '$status'");
        }else{
            $data = DB::select("SELECT pos_activity.no_invoice, (pos_activity.subtotal-pos_activity.total) as total_diskon, pos_diskon.nama_voucher, pos_store.nama_store, pos_activity.tanggal, pos_activity.status FROM `pos_activity` INNER JOIN pos_diskon ON pos_activity.id_discount = pos_diskon.id_voucher INNER JOIN pos_store  ON pos_activity.id_store = pos_store.id_store WHERE tanggal >= '$from' AND tanggal <= '$to'");
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
                ''
            ],
            [
                'No Invoice',
                'Nominal Diskon',
                'Nama Voucher',
                'Nama Store',
                'Tanggal',
                'Status'
            ]
        ];
    }
}
