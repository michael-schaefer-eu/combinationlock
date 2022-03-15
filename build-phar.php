<?php declare(strict_types=1);

$filename = 'combinationlock.phar';

if (file_exists($filename)) {
    unlink($filename);
}

$phar = new Phar($filename);

$phar->startBuffering();

$defaultStub = $phar->createDefaultStub('index.php', '/index.php');

$phar->buildFromDirectory('src/');

$shebang = "#!/usr/bin/env php\n";

$stub = $shebang . $defaultStub;

$phar->setStub($stub);

$phar->stopBuffering();
