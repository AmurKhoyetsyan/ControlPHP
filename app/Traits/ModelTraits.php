<?php


namespace App\Traits;


use Lib\Pagination\Pagination;

/**
 * Trait ModelTraits
 * @package App\Traits
 */
trait ModelTraits
{
    /**
     * @var false|resource
     */
    protected $connection;

    /**
     * @var bool
     */
    protected $db;

    /**
     * @var Pagination
     */
    protected $pagination;

    /**
     * @var string
     */
    protected $option = "";

    /**
     * @var array
     */
    protected $relation = [];

    /**
     * @param string[] $column
     * @return array|mixed
     */
    public function get($column = ['*'])
    {
        $column = (array)$column;

        $content = implode(', ', $column);

        $query = 'SELECT ' . $content . ' FROM ' . $this->table;

        if (mb_strlen($this->option)) {
            $query .= ' ' . $this->option;
        }

        $sel = mysqli_query($this->connection, $query);

        $data = mysqli_fetch_all($sel, MYSQLI_ASSOC);

        if (!is_null($this->relation) && !empty($this->relation)) {
            $relData = $this->relation['data'];
            $relWhere = $this->relation['where'];
            $len = count($data);

            for($i = 0; $i < $len; $i++) {
                $item = $relData[$i];
                $data[$i][$relWhere[0]] = $this->generateValue($item);
            }
        }

        return $data;
    }

    /**
     * @param $id
     * @param string[] $column
     * @return mixed|null
     */
    public function find($id, $column = ['*'])
    {
        try {
            $content = $this->pagination->getContent($column);

            $query = 'SELECT ' . $content . ' FROM ' . $this->table . ' WHERE `id` = ' . $id;

            $sel = mysqli_query($this->connection, $query);

            $data = mysqli_fetch_all($sel, MYSQLI_ASSOC);

            return $data[0];
        } catch (\Exception $err) {
            return null;
        }
    }

    /**
     * @param $data
     * @return bool|mixed|\mysqli_result
     */
    public function create($data)
    {
        $colStr = ' (';
        $valStr = ' (';
        $counter = 0;
        foreach ($data as $item => $value) {
            if ($counter > 0) {
                $colStr .= ', ';
                $valStr .= ', ';
            }
            $colStr .= '`' . $item . '`';
            $valStr .= "'" . $value . "'";
            $counter++;
        }

        $colStr .= ') ';
        $valStr .= ') ';

        $query = "INSERT INTO `" . $this->table . "`" . $colStr . "VALUES" . $valStr;

        return mysqli_query($this->connection, $query);
    }

    /**
     * @param array $condition
     * @return $this
     */
    public function where($condition = ['id', '=', 1])
    {
        $this->option .= ' WHERE ' . $condition[0] . ' ' . $condition[1] . ' ' . $this->isStringToString($condition[2]);
        $this->option = trim($this->option);

        return $this;
    }

    /**
     * @param $relationTable
     * @param string[] $columns
     * @param array $condition
     * @param null $where
     * @return $this
     */
    public function rightJoin($relationTable, $columns = ['*'], $condition = [], $where = null)
    {
        $columns = (array)$columns;

        $content = implode(', ', $columns);

        $query = ' SELECT ' .
            $content . ' FROM `' .
            $this->table . '` RIGHT JOIN ' .
            $relationTable . " ON ". $this->table . '.' .
            $condition[0] . ' ' . $condition[1] . ' ' . $relationTable . '.' . $condition[2];

        if (!is_null($where)) {
            $query .= ' WHERE ' . $where[0] . ' ' . $where[1] . ' ' . $where[2];
        }

        $sel = mysqli_query($this->connection, $query);

        $data = mysqli_fetch_all($sel, MYSQLI_ASSOC);

        $this->relation = [
            'data' => $data,
            'where' => $where
        ];

        return $this;
    }

    /**
     * @param int $limit
     * @param string $order
     * @param string[] $columns
     * @param string $option
     * @return array
     */
    public function pagination($limit = 10, $order = 'ASC', $columns = ['*'], $option = "")
    {
        $data = [];

        if (!empty($_GET) && isset($_GET["page"])) {
            $data = $this->pagination->getPagination($this->table, $columns, $order, (int)$_GET["page"], $limit, $option);
        } else {
            $data = $this->pagination->getPagination($this->table, $columns, $order, 1, $limit, $option);
        }

        return [
            'data' => $data,
            'pagination' => $this->pagination
        ];
    }

    /**
     * @param $id
     * @param $request
     * @return bool|\mysqli_result
     */
    public function update($id, $request)
    {
        $data = '';
        $counter = 0;

        foreach ($request as $key => $value) {
            if ($counter !== 0) {
                $data .= ', ';
            }
            $data .= $key . " = '" . $value . "'";
            $counter++;
        }

        $query = "UPDATE $this->table SET $data WHERE id = $id";

        return mysqli_query($this->connection, $query);
    }

    /**
     * @param $id
     * @return bool|\mysqli_result
     */
    public function delete($id)
    {
        $query = "DELETE FROM $this->table WHERE id = '$id'";

        return mysqli_query($this->connection, $query);
    }
}