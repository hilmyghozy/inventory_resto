<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosProductItem extends Model
{
    protected $table = 'pos_product_item';

    protected $primaryKey = 'id_item';

    protected $guarded = ['id_item'];

    public $timestamps = false;

    public function posProductItemType()
    {
        return $this->hasMany(PosProductItemType::class, 'id_item');
    }
}