<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in('./src')
    ->in('./tests');

$config = new Config('metricalo-cs-fixer');

return $config
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'blank_line_before_statement' => [
            'statements' => [
                'for',
                'foreach',
                'if',
                'switch',
                'return'
            ],
        ],
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
            ],
        ],
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => null,
            'import_functions' => null,
        ],
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'phpdoc_align' => ['align' => 'vertical'],
        'phpdoc_trim' => true,
        'static_lambda' => true,
        'trailing_comma_in_multiline' => [
            'elements' => [
                'arguments',
                'parameters',
            ]
        ],
        'yoda_style' => [
            'equal' => true,
            'identical' => true,
        ],
    ]);
