<?php

class NuxBackend {

    private static ?NuxBackend $instance = null;
    private bool $staged = false;
    private ?string $projectName = null;

    private function __construct() {}

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new NuxBackend();
        }
        return self::$instance;
    }

    public static function generate(string $project) {
        $cwd = getcwd();
        mkdir($cwd . '/' . $project . '/aliases', recursive: true);
        mkdir($cwd . '/' . $project . '/events', recursive: true);
        mkdir($cwd . '/' . $project . '/functions', recursive: true);
        mkdir($cwd . '/' . $project . '/triggers', recursive: true);
        $nuxspec = <<<HEREDOC
        {
            "package": "{$project}",
            "version": "1.0.0",
            "author": "You",
            "description": "Nuxler Project Template"
        }
        HEREDOC;
        file_put_contents($cwd . '/' . $project . '/nuxspec', $nuxspec);
    }

    public static function setProjectName(string $name) {
        self::$instance->projectName = $name;
    }

    public static function stageCompile() {
        self::$instance->staged = true;
    }

    public static function compileAll() {
        if (!self::$instance->staged) {
            trigger_error("Please stage changes before compiling", E_USER_NOTICE);
            return;
        }

        $package = new NuxPackage();
    }
}