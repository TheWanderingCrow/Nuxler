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
        $map = self::directoryMap();

        // Step 4: Recurse into directories, generating objects on the fly
        self::generateObjects($map);

        // Step 5: Compile all
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
    public static function directoryMap($dir = null)
    {
        if (is_null($dir)) {
            $dir = getcwd();
        }
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

    public static function generateObjects(array|string $directory, array $objects = []) {
        // enter directory
        $workingDir = $directory;

        // map directory
        $result = self::directoryMap($workingDir);

        // check for subdirs
        $flag = false;
        foreach ($result as $possibleDir) {
            if (is_dir($possibleDir)) {
                $flag = $possibleDir;
                break;
            }
        }

        // if flag set
        $objects = self::generateObjects($flag, $objects);

        // if not
        foreach ($result as $obj) {
            
        }
    }
}
