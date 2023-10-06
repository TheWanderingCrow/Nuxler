<?php

require __DIR__ . '/classes/autoload.php';


if ($argc < 2) {
    echo "Welcome to Nuxler\n";
    echo "Usage:\n";
    echo "php Nuxler <options>\n";
    echo "-g/--generate <project>: Generate a blank Nuxler project\n";
    echo "-c/--compile: Compile your project to .nxs\n";
} else {
    $shortops = 'g:c';
    $longops = [
        'generate:',
        'compile'
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
            case 'c':
                NuxBackend::stageCompile();
                break;
            case 'compile':
                NuxBackend::stageCompile();
                break;
        }
    }
}

