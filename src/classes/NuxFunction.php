<?php

class NuxFunction extends NuxScriptable {

    public function __construct(string $name, bool $enabled = true) {
        parent::__construct($name, $enabled);
        
    }
}