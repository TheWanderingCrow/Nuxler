<?php

class NuxBackend
{

    private static ?NuxBackend $instance = null;
    private bool $staged = false;
    private array $nux_directories = ['aliases', 'events', 'functions', 'triggers'];


    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new NuxBackend();
        }
        return self::$instance;
    }

    public static function generate(string $project)
    {
        $cwd = getcwd();
        mkdir($cwd . DIRECTORY_SEPARATOR . $project . DIRECTORY_SEPARATOR . 'aliases', recursive: true);
        mkdir($cwd . DIRECTORY_SEPARATOR . $project . DIRECTORY_SEPARATOR . 'events', recursive: true);
        mkdir($cwd . DIRECTORY_SEPARATOR . $project . DIRECTORY_SEPARATOR . 'functions', recursive: true);
        mkdir($cwd . DIRECTORY_SEPARATOR . $project . DIRECTORY_SEPARATOR . 'triggers', recursive: true);
        $nuxspec = <<<HEREDOC
        {
            "package": "{$project}",
            "version": "1.0.0",
            "author": "You",
            "description": "Nuxler Project Template"
        }
        HEREDOC;
        file_put_contents($cwd . DIRECTORY_SEPARATOR . $project . DIRECTORY_SEPARATOR . 'nuxspec', $nuxspec);
    }

    public static function stageCompile()
    {
        self::$instance->staged = true;
    }

    public static function compileAll()
    {
        if (!self::$instance->staged) {
            trigger_error("Please stage changes before compiling", E_USER_NOTICE);
            return;
        }

        // Step 1: create package and read the nuxspec
        $package = new NuxPackage();

        // Step 2: sanity check to make sure all directories are present
        self::sanityCheck();


        // Step 3: Map directories, subdirectories and files
        self::directoryMap();

        // Step 4: Generate groups for all subdirectories of nux_directories

        // Step 5: Generate objects for each group

        // Step 6: Compile
    }

    private static function sanityCheck()
    {
        foreach (self::$instance->nux_directories as $directory) {
            if (!is_dir($directory)) {
                exit("Directory structure invalid, cannot find " . $directory);
            }
        }
    }

    /**
     * @return array Complete map of directories and files
     */
    private static function directoryMap()
    {
        $dir = getcwd();
        $result = array();
        $cdir = scandir($dir);

        foreach ($cdir as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    $result[$value] = self::directoryMap($dir . DIRECTORY_SEPARATOR . $value);
                } else {
                    $result[] = $value;
                }
            }
        }

        return $result;
    }
}
