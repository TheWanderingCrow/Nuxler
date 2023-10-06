<?php

require __DIR__ . '/classes/autoload.php';

if ($argc < 2) {
    echo "Welcome to Nuxler\n";
    echo "Usage:\n";
    echo "php Nuxler <options>\n";
    echo "-g/--generate [project]: Generate a blank Nuxler project\n";
    echo "-c/--compile [project]: Compile your project to .nxs\n";
    echo "-o/--output <filename>: Select file name for output, default is directory name\n";
} else {

}

