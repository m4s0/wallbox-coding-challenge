<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('tests/Fixtures')
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests'
    ])
;

$config = new PhpCsFixer\Config();
$config
    ->setLineEnding("\r\n")
    ->setRiskyAllowed(true)
    ->setRules([
        'array_syntax' => ['syntax' => 'short'],
        'declare_strict_types' => true,
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'ordered_class_elements' => true,
    ])
    ->setFinder($finder)
;

return $config;
