<?php

abstract class NuxScriptable extends NuxObject {
    private array $script;

    public function __construct(string $name, bool $enabled = true) {
        parent::__construct($name, $enabled);
    }
}