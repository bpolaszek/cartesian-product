<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('src/Swagger')
;

return (new PhpCsFixer\Config())
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setRules([
        'array_syntax' => ['syntax' => 'short'],
        'ordered_class_elements' => true,
        'global_namespace_import' => true,
        'phpdoc_to_comment' => ['ignored_tags' => ['var']],
        'linebreak_after_opening_tag' => true,
        'mb_str_functions' => true,
        'no_php4_constructor' => true,
        'no_unreachable_default_argument_value' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'phpdoc_order' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'blank_line_between_import_groups' => true,
        'single_line_throw' => false,
        'single_line_empty_body' => true,
        'nullable_type_declaration_for_default_null_value'  => true,
        'array_indentation' => false,
        'ordered_types' => false,
        'phpdoc_scalar' => false,
        'fully_qualified_strict_types' => false,
        'blank_line_after_opening_tag' => false,
        'nullable_type_declaration' => false,
        'native_function_invocation' => false,
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
;
