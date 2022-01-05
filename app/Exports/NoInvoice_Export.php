<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NoInvoice_Export implements FromCollection, WithHeadings
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
        if($val['status'] != 'all'){
            $data = DB::table('pos_activity')
            ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
            ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
            ->select('pos_activity.no_invoice', 'pos_store.nama_store', 'pos_kasir.nama', 'pos_activity.total','pos_activity.tanggal','pos_activity.status')
            ->where('tanggal','>=', $val['from'])
            ->where('tanggal','<=', $val['to'])
            ->where('status', $val['status'])
            ->get();
        }else{
            $data = DB::table('pos_activity')
            ->join('pos_store', 'pos_activity.id_store', '=', 'pos_store.id_store')
            ->join('pos_kasir', 'pos_activity.id_employee', '=', 'pos_kasir.id')
            ->select('pos_activity.no_invoice', 'pos_store.nama_store', 'pos_kasir.nama', 'pos_activity.total','pos_activity.tanggal','pos_activity.status')
            ->where('tanggal','>=', $val['from'])
            ->where('tanggal','<=', $val['to'])
            ->get();
        }
        return $data;
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
                'Store',
                'Kasir',
                'Total',
                'Tanggal',
                'Status'
            ]
        ];
    }
}
