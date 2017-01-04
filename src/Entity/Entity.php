<?php
namespace kiczek\infakt\Entity;

abstract class Entity {
    protected $object = null;

    public function __construct($data = [])
    {
        foreach($data as $key => $row) {
            $this->{$key} = $row;
        }
    }

    public function toArray() {
        $result = get_object_vars($this);
        unset($result['object']);
        return isset($this->object) ? [$this->object => $result] : $result;
    }
}