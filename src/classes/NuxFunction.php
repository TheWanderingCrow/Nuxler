<?php

class NuxFunction extends NuxScriptable {


    public function __construct(string $name, string $scriptPath, bool $enabled = true) {
        parent::__construct($name, $scriptPath, $enabled);
    }


    public function compile(): string {
        $data = [
            'type'=>'function',
            'name'=>$this->name,
            'enabled'=>$this->enabled,
            'code'=>$this->script ?? ""
        ];

        return json_encode($data);
    }
}