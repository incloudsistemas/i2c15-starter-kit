<?php

foreach (glob(__DIR__ . '/*.php') as $filename) {
    if (basename($filename) !== 'helpers_loader.php') {
        require_once $filename;
    }
}
