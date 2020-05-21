<?php

/**
 * Created by PhpStorm.
 * User: rocks
 * Date: 28.02.2017
 * Time: 17:24
 */

namespace Rockschtar\WordPress\AdminPage\Models;

class ListTablePagination
{



    /**
     * @var int
     */
    private $total_items = 0;
/**
     * @var int
     */
    private $total_pages = 0;
/**
     * @var int
     */
    private $items_per_page = 0;

    /**
     * ListTablePagination constructor.
     * @param int $total_items
     * @param int $total_pages
     * @param int $items_per_page
     */
    public function __construct($total_items, $total_pages, $items_per_page)
    {
        $this->total_items = $total_items;
        $this->total_pages = $total_pages;
        $this->items_per_page = $items_per_page;
    }

    public function isValid(): bool
    {

        if ($this->getTotalItems() === 0) {
            return false;
        }

        if ($this->getItemsPerPage() === 0) {
            return false;
        }

        if ($this->getTotalPages() === 0) {
            return false;
        }

        return true;
    }

    /**
     * @return int
     */
    public function getTotalItems(): int
    {
        return $this->total_items;
    }

    /**
     * @return int
     */
    public function getItemsPerPage(): int
    {
        return $this->items_per_page;
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->total_pages;
    }
}
