<?php

abstract class NuxScriptable extends NuxObject {
    private string $script;

    public function __construct(string $name, bool $enabled = true) {
        parent::__construct($name, $enabled);
    }


    /**
     * @param string $scriptPath path to the .js file for this object
     */
    public function commitScript($scriptPath) {
        if (file_exists($scriptPath)) {
            $this->script = file_get_contents($scriptPath);
        } else {
            trigger_error($this->name . " script not found at " . $scriptPath, E_USER_WARNING);
        }
    }
}