<?php if (!defined('APPLICATION')) exit();

use Chenos\V8JsModuleLoader\ModuleLoader;
$loader = new ModuleLoader();
$loader->setExtensions('.js', '.json');
$loader->setEntryDir(__DIR__);
$loader->addVendorDir(__DIR__ . '/../../../../node_modules/');
// v8js version > 2.1.0+
$loader->addOverride(['fn' => function (...$args) {}]);
$loader->addOverride('obj', new stdClass());

// build a snapshot to use, if it doesn't already exist
// @see http://stesie.github.io/2016/02/snapshot-performance
$snapshotPath = __DIR__ . '/../../../../v8js/snapshot.bin';
if (!file_exists($snapshotPath)) {
    $js = [
        'var process = { env: { NODE_ENV: "production" } }',
        file_get_contents(__DIR__ . '/../../../../v8js/dist/dll.min.js'),
        file_get_contents(__DIR__ . '/../../../../v8js/dist/reactBundle.js'),
    ];
    $src = implode(';', $js);

    $snapshot = \V8Js::createSnapshot($src);

    file_put_contents($snapshotPath, $snapshot);
}

// use a snapshot of all react components to speed-up V8JS
$snapshot = file_get_contents($snapshotPath);
$v8 = new V8Js('PHP', [], [], true, $snapshot);
$v8->setModuleNormaliser([$loader, 'normaliseIdentifier']);
$v8->setModuleLoader([$loader, 'loadModule']);

$js = [
    file_get_contents(__DIR__ . '/../../../../v8js/dist/HelloWorldSnapshot.js'),
    'print(ReactDOMServer.renderToString(React.createElement(SsrComponent)))',
];

try {
    ob_start();
    $v8->executeString(implode(PHP_EOL, $js));
    echo ob_get_clean();
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

