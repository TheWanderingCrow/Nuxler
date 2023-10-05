<?php

abstract class NuxObject {

    private string $name;
    private bool $enabled;

    public function __construct(string $name, bool $enabled = true) {
        $this->name = $name;
        $this->enabled = $enabled;
    }

    protected abstract function compile(): string;

}