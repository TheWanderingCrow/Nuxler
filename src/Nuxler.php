<?php

require __DIR__ . '/classes/autoload.php';


if ($argc < 2) {
    echo "Welcome to Nuxler\n";
    echo "Usage:\n";
    echo "php Nuxler <options>\n";
    echo "-g/--generate=[project]: Generate a blank Nuxler project\n";
    echo "-c/--compile=[project]: Compile your project to .nxs\n";
    echo "-o/--output=<filename>: Select file name for output, default is directory name\n";
} else {
    $shortops = 'g::c::o:';
    $longops = [
        'generate::',
        'compile::',
        'output:'
    ];
    
    $options = getopt($shortops, $longops);

    foreach ($options as $option => $value) {
        switch ($option) {
            case 'g':
                NuxBackend::generate($value ?? "Nuxler Package");
                break;
            case 'generate':
                NuxBackend::generate($value ?? "Nuxler Package");
                break;
            case 'c':
                NuxBackend::compileAll();
                break;
            case 'compile':
                NuxBackend::compileAll();
                break;
            case 'o':
                break;
            case 'output':
                break;
        }
    }
}

