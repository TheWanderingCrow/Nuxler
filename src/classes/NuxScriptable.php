<?php

abstract class NuxScriptable extends NuxObject {
    
    protected string $script;

    public function __construct(string $name, string $scriptPath, bool $enabled = true) {
        parent::__construct($name, $enabled);
        $this->readScript($scriptPath);
    }


    /**
     * @param string $scriptPath path to .js file
     */
    private function readScript($scriptPath) {
        if (file_exists($scriptPath)) {
            $this->script = file_get_contents($scriptPath);
        } else {
            trigger_error("Script was set for " . $this->name . " but no script found at path", E_USER_WARNING);
        }
    }

}