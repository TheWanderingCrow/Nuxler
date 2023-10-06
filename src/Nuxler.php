<?php

require __DIR__ . '/classes/autoload.php';


if ($argc < 2) {
    echo "Welcome to Nuxler\n";
    echo "Usage:\n";
    echo "php Nuxler <options>\n";
    echo "-g/--generate <project>: Generate a blank Nuxler project\n";
    echo "-c/--compile: Compile your project to .nxs\n";
    echo "-o/--output <filename>: Select file name for output, default is directory name\n";
} else {
    $shortops = 'g:co:';
    $longops = [
        'generate:',
        'compile',
        'output:'
    ];
    
    $options = getopt($shortops, $longops);

    foreach ($options as $option => $value) {
        switch ($option) {
            case 'g':
                NuxBackend::generate($value ?? "template");
                break;
            case 'generate':
                NuxBackend::generate($value ?? "template");
                break;
            case 'o':
                NuxBackend::setProjectName($value);
                break;
            case 'output':
                NuxBackend::setProjectName($value);
                break;
            case 'c':
                NuxBackend::stageCompile();
                break;
            case 'compile':
                NuxBackend::stageCompile();
                break;
        }
    }
}

