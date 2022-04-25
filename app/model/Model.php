<?php

namespace App\model;

use Lib\Pagination\Pagination;
use App\db\BaseModel;
use App\Traits\ModelTraits;
use App\Traits\Service;
use App\db\DB;

/**
 * Class Model
 * @package App\model
 */
class Model extends BaseModel
{
    use Service, ModelTraits;

    /**
     * @var string
     */
    protected $table = '';

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->pagination = new Pagination();
        $this->connection = DB::getConnection();
        $this->db = DB::getDB();
    }
}