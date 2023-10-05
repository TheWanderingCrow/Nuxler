<?php

class NuxGroup extends NuxObject {

    private array $items = [];


    /**
     * @param string $name
     * @param bool $enabled defaults to true
     */
    public function __construct(string $name, bool $enabled = true) {
        parent::__construct($name, $enabled);
    }

    public function addItem(NuxObject $item) {
        
    }
}