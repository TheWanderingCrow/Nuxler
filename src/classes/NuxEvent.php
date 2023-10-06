<?php

class NuxEvent extends NuxScriptable {

    private string $evtype;
    private string $evsubtype;

    public function __construct(string $name, string $scriptPath, string $evtype, string $evsubtype, bool $enabled = true) {
        parent::__construct($name, $scriptPath, $enabled);
        $this->evtype = $evtype;
        $this->evsubtype = $evsubtype;
    }

    public function compile(): string {
        $script = [
            'type'=>'script',
            'enabled'=>true,
            'script'=>$this->script
        ];

        $data = [
            'type'=>'event',
            'name'=>'',
            'enabled'=>$this->enabled,
            'actions'=>[
                $script
            ],
            'evtype'=>$this->evtype,
            'evsubtype'=>$this->evsubtype
        ];

        return json_encode($data);
    }
}