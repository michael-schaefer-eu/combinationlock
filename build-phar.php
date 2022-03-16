<?php declare(strict_types=1);

$filename = 'combinationlock.phar';

if (file_exists($filename)) {
    unlink($filename);
}

$phar = new Phar($filename);

$phar->startBuffering();

/**
 * Add index.php and only the src & vendor directories to the phar
 */
$phar->addFile('index.php');
$phar->buildFromDirectory('./', "/(src|vendor).*\.php$/");

/**
 * Make the phar file executable (requires +x mod)
 */
$defaultStub = $phar->createDefaultStub('index.php');
$shebang = "#!/usr/bin/env php\n";
$stub = $shebang . $defaultStub;

$phar->setStub($stub);

$phar->stopBuffering();
