<?php if (!defined('APPLICATION')) exit();

use Chenos\V8JsModuleLoader\ModuleLoader;
$loader = new ModuleLoader();
$loader->setExtensions('.js', '.json');
$loader->setEntryDir(__DIR__);
$loader->addVendorDir(__DIR__ . '/../../../../node_modules/');
// v8js version > 2.1.0+
$loader->addOverride(['fn' => function (...$args) {}]);
$loader->addOverride('obj', new stdClass());

$v8 = new V8Js();
$v8->setModuleNormaliser([$loader, 'normaliseIdentifier']);
$v8->setModuleLoader([$loader, 'loadModule']);

$props = ['a'=>1, 'b'=>2, 'c'=>3];
$js = [
    'var process = { env: { NODE_ENV: "production" } }',
    'var console = { warn: function() {}, error: print }', // React uses console.warn/error -> convert to V8's "print()"
    file_get_contents(__DIR__ . '/../../../../v8js/dist/dll.min.js'),
    file_get_contents(__DIR__ . '/../../../../v8js/dist/reactBundle.js'),
    file_get_contents(__DIR__ . '/../../../../v8js/dist/HelloWorld.js'),
    'print(ReactDOMServer.renderToString(React.createElement(HelloWorld, '.json_encode($props).')))',
];

try {
    ob_start();
    $v8->executeString(implode(PHP_EOL, $js));
    $html = ob_get_clean();
    echo 'x' . $html . 'x'; // "x" chars here so we can see if nothing is rendered
} catch (\V8JsScriptException $e) {
    ob_get_clean();
    echo '<pre>' . $e->getMessage() . '</pre>';
    echo '<pre>' . $e->getJsFileName() . '</pre>';
    echo '<pre>' . $e->getJsLineNumber() . '</pre>';
    echo '<pre>' . $e->getJsSourceLine() . '</pre>';
    echo '<pre>' . $e->getJsTrace() . '</pre>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
} catch (\Exception $e) {
    ob_get_clean();
    echo '<pre>'. $e->getMessage() .'</pre>';
}

