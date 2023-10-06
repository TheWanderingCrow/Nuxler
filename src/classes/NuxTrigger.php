<?php

class NuxAlias extends NuxMatchable {

    public function __construct(string $name, string $text, \MatchType $matching, string $scriptPath, bool $enabled = true, bool $whole_words = true, bool $case_sensitive = true) {
        parent::__construct($name, $text, $matching, $scriptPath, $enabled, $whole_words, $case_sensitive);
    }

    public function compile(): string {
        $script = [
            'type'=>'script',
            'enabled'=>true,
            'script'=>$this->script
        ];

        $data = [
            'type'=>'trigger',
            'name'=>$this->name,
            'enabled'=>$this->enabled,
            'actions'=>[
                $script
            ],
            'text'=>$this->text,
            'matching'=>$this->matching->value,
            'whole_words'=>$this->whole_words,
            'case_sensitive'=>$this->case_sensitive,
        ];

        return json_encode($data);
    }

}