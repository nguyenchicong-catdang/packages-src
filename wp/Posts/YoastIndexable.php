<?php
// Posts/YoastIndexable.php
namespace Vendorpath\Wp\Posts;

use Illuminate\Database\Eloquent\Model;

class YoastIndexable extends Model
{
    protected $connection = 'wordpress';
    protected $table = 'yoast_indexable';
    protected $primaryKey = 'id';

    // Thêm hàm này để "khóa" tên bảng lại, không cho phép Prefix can thiệp
    // public function getTable()
    // {
    //     return $this->table;
    // }
}