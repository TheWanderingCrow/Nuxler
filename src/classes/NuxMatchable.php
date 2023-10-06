<?php

enum MatchType {
    case regexp;
    case begins;
    case exact;
    case substring;
}

abstract class NuxMatchable extends NuxScriptable {
    
    private string $text;
    private MatchType $matching;
    private bool $whole_words;
    private bool $case_sensitive;

    public function __construct(string $name, string $text, MatchType $matching, bool $enabled = true, bool $whole_words = true, bool $case_sensitive = true) {
        parent::__construct($name, $enabled);
        $this->text = $text;
        $this->matching = $matching;
        $this->whole_words = $whole_words;
        $this->case_sensitive = $case_sensitive;
    }

}