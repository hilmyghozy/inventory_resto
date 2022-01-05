<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Kasir_Export implements FromCollection, WithHeadings
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
            $data = DB::select("SELECT pos_kasir.nama, SUM(pos_activity.total) as total_penjualan FROM pos_activity INNER JOIN pos_kasir ON pos_activity.id_employee = pos_kasir.id WHERE date(tanggal) >= '$from' AND date(tanggal) <= '$to' AND pos_activity.status = '$status' GROUP BY pos_kasir.nama");
        }else{
            $data = DB::select("SELECT pos_kasir.nama, SUM(pos_activity.total) as total_penjualan FROM pos_activity INNER JOIN pos_kasir ON pos_activity.id_employee = pos_kasir.id WHERE date(tanggal) >= '$from' AND date(tanggal) <= '$to' GROUP BY pos_kasir.nama");
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
                'Nama Kasir',
                'Total Harga Penjualan'
            ]
        ];
    }
}
