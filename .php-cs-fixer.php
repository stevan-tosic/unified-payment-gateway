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
                'if',
                'return'
            ],
        ],
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
            ],
        ],
        'no_unused_imports' => true,
        'trailing_comma_in_multiline' => [
            'elements' => [
                'parameters'
            ]
        ],
        'static_lambda' => true,
    ]);
