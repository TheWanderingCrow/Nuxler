<?php

abstract class NuxObject {

    protected string $name;
    protected bool $enabled;

    public function __construct(string $name, bool $enabled = true) {
        $this->name = $name;
        $this->enabled = $enabled;
    }

    public function getName() {
        return $this->name;
    }

    /**
     * @return string JSON encoded data per the Nexus 3 specification
     */
    protected abstract function compile(): string;

}