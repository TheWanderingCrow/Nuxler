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

        // Step 3: Create base groups
        $baseGroups = [new NuxGroup('aliases'), new NuxGroup('events'), new NuxGroup('functions'), new NuxGroup('triggers')];

        // Step 4: Map directories, subdirectories and files
        $map = self::directoryMap();

        // Step 5: Recurse into directories, generating objects on the fly
        self::generateObjects($map, $baseGroups);

        // Step 6: Compile all
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

    public static function generateObjects(array|string $directory, array $objects = []): array {
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
        $objects = self::generateObjects($directory . DIRECTORY_SEPARATOR . $flag, $objects);

        // if not check for one of the definition files
        $nux_defs = ['aliases.json', 'events.json', 'functions.json', 'triggers.json'];
        $flag = null;
        foreach ($nux_defs as $needle) {
            if (in_array($needle, $result)) {
                $flag = $needle;
                break;
            }
        }

        // if no def file then return to parent
        if (is_null($flag)) {
            return $objects;
        }

        //otherwise read def file
        $defFile = json_decode(file_get_contents($workingDir . DIRECTORY_SEPARATOR . $flag), true);

        // Create new group based on working directory
        $t = explode(DIRECTORY_SEPARATOR, $workingDir);
        $group = new NuxGroup(end($t));

        // get reference to base group (alias, function, ect)
        foreach ($objects as $object) {
            if ($object->getName() == explode('.', $flag)[0]) {
                $ref = &$object;
            }
        }

        // process all def file entries
        foreach ($defFile as $entry) {
            $fileName = $workingDir . preg_replace(' ', '_', $entry['name']) . '.js';
            switch ($flag) {
                case 'aliases.json':
                    $obj = new NuxAlias($entry['name'], $entry['text'], $entry['matching'], $fileName);
                    break;
                case 'events.json':
                    $obj = new NuxEvent($entry['name'], $fileName, $entry['evtype'], $entry['evsubtype']);
                    break;
                case 'functions.json':
                    $obj = new NuxFunction($entry['name'], $fileName);
                    break;
                case 'triggers.json':
                    $obj = new NuxTrigger($entry['name'], $entry['text'], $entry['matching'], $fileName);
                    break;
                default:
                    trigger_error("Unable to process objects", E_USER_ERROR);
                    exit();
                    break;
            }
            array_push($ref, $obj);
        }

        return $objects;
    }
}
