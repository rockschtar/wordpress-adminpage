<?php

/**
 * Created by PhpStorm.
 * User: rocks
 * Date: 27.02.2017
 * Time: 20:44
 */

namespace Rockschtar\WordPress\AdminPage\Models;

class ListTableColumns
{



    /**
     * ListTableColumn[]
     */
    private $columns;

    /**
     * ListTableColumns constructor.
     * @param ListTableColumn[] $columns
     */
    public function __construct(array $columns = array())
    {
        $this->columns = $columns;
    }

    public function addColumn(ListTableColumn $column)
    {
        $this->columns[] = $column;
    }

    /**
     * @return ListTableColumn[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    public function getColumnCount()
    {
        return count($this->columns);
    }
}
