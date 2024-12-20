<?php
/**
 * @link      https://github.com/161io/laminas-new-recaptcha
 * @copyright (c) 161 SARL - contact(at)161.io
 * @license   MIT License
 */

declare(strict_types=1);

//$rootPath = realpath(__DIR__ . '/../../..');  // module/
$rootPath = realpath(__DIR__ . '/../../../..'); // vendor/
chdir($rootPath);

if (is_file('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
    return;
}
