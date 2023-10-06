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
        array_push($this->items, $item);
    }

    public function compile(): string {
        $i = [];
        foreach ($this->items as $item) {
            array_push($i, $item->compile());
        }

        $i = json_encode($i);

        $data = [
            'type'=>'group',
            'name'=>$this->name,
            'enabled'=>$this->enabled,
            'items'=>$i
        ];

        return json_encode($data);
    }
}