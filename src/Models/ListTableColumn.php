<?php

namespace Rockschtar\WordPress\AdminPage\Models;

final class ListTableColumn {

    private $id;
    private $title;

    /**
     * ListTableColumn constructor.
     * @param $id
     * @param $title
     */
    public function __construct($id, $title) {
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }


}