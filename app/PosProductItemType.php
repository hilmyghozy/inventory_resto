<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosProductItemType extends Model
{
    protected $table = 'pos_product_item_type';

    protected $primaryKey = 'id_type';

    protected $guarded = ['id_type'];

    public $timestamps = false;
}