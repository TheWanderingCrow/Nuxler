<?php

enum MatchType: string {
    case regexp = 'regexp';
    case begins = 'begins';
    case exact = 'exact';
    case substring = 'substring';
}

abstract class NuxMatchable extends NuxScriptable {
    
    protected string $text;
    protected MatchType $matching;
    protected bool $whole_words;
    protected bool $case_sensitive;

    public function __construct(string $name, string $text, MatchType $matching, string $scriptPath, bool $enabled = true, bool $whole_words = true, bool $case_sensitive = true) {
        parent::__construct($name, $scriptPath, $enabled);
        $this->text = $text;
        $this->matching = $matching;
        $this->whole_words = $whole_words;
        $this->case_sensitive = $case_sensitive;
    }

}