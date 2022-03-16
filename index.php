<?php declare(strict_types=1);

/**
 * Use composer autoloader, see
 * @link https://getcomposer.org/doc/01-basic-usage.md#autoloading
 */
require __DIR__.'/vendor/autoload.php';

$scriptName = $argv[0];

function showError(string $text, string $scriptName)
{
    echo $text . PHP_EOL;
    echo 'For example:' . PHP_EOL;
    echo " php $scriptName 5" . PHP_EOL;
    die();
}

if (empty($argv[1])) {
    showError('Help: To start the combination lock application, call it with a numeric length argument.', $scriptName);
}

if (!is_numeric($argv[1])) {
    showError('Error: Wrong length argument type. Please call the application with a numeric length argument.', $scriptName);
}

$length = intval($argv[1]);

if ($length <= 1) {
    showError('Error: Wrong length argument value. Please call the application with a numeric length argument greater then zero (0).', $scriptName);
}

$generator = new \App\CombinationLock\CodeGenerator\SimpleCodeGenerator();
$builder = new \App\CombinationLock\NumberCodeBuilder($generator);
$codes = $builder->buildCodes($length);

foreach ($codes as $code) {
    echo $code . PHP_EOL;
}
