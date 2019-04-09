<?php


namespace Rockschtar\WordPress\AdminPage\Views;


class ListTableView extends AdminPage {

    public function __construct($id, ListTable $list_table) {
        parent::__construct($id);
        $this->setContent($list_table->getTableHtml());
    }
}