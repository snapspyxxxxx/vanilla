<?php if (!defined('APPLICATION')) exit();

$v8 = new V8Js();

$js = <<<JS
print('<h1>Simple string rendered by V8JS (no React)</h1>');
JS;

$output = null;
try {
    ob_start();
    $v8->executeString($js);
    $output = ob_get_clean();
} catch (\Exception $e) {
    echo '<pre>${$e->getMessage()}</pre>';
}

echo $output;
