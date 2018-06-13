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


// @see http://trumpipsum.net/?paras=9&type=make-it-great
$props = [
    'items' => [
        ['id' => 1000, 'name' => 'one', 'description' => 'This placeholder text is gonna be HUGE. We have so many things that we have to do better... and certainly ipsum is one of them. I will write some great placeholder text – and nobody writes better placeholder text than me, believe me – and I’ll write it very inexpensively. I will write some great, great text on your website’s Southern border, and I will make Google pay for that text. Mark my words.'],
        ['id' => 1001, 'name' => 'two', 'description' => 'If Trump Ipsum weren’t my own words, perhaps I’d be dating it. My placeholder text, I think, is going to end up being very good with women. Lorem Ipsum is the single greatest threat. We are not - we are not keeping up with other websites. This placeholder text is gonna be HUGE.'],
        ['id' => 1002, 'name' => 'three', 'description' => 'Look at that text! Would anyone use that? Can you imagine that, the text of your next webpage?! Look at that text! Would anyone use that? Can you imagine that, the text of your next webpage?! You have so many different things placeholder text has to be able to do, and I don\'t believe Lorem Ipsum has the stamina.'],
        ['id' => 1003, 'name' => 'four', 'description' => 'That other text? Sadly, it’s no longer a 10. I was going to say something extremely rough to Lorem Ipsum, to its family, and I said to myself, "I can\'t do it. I just can\'t do it. It\'s inappropriate. It\'s not nice."'],
        ['id' => 1004, 'name' => 'five', 'description' => 'I know words. I have the best words. I know words. I have the best words. Some people have an ability to write placeholder text... It\'s an art you\'re basically born with. You either have it or you don\'t.'],
        ['id' => 1005, 'name' => 'six', 'description' => 'This placeholder text is gonna be HUGE. Lorem Ipsum is FAKE TEXT! Look at these words. Are they small words? And he referred to my words - if they\'re small, something else must be small. I guarantee you there\'s no problem, I guarantee. I think the only card she has is the Lorem card.'],
        ['id' => 1006, 'name' => 'seven', 'description' => 'Some people have an ability to write placeholder text... It\'s an art you\'re basically born with. You either have it or you don\'t. All of the words in Lorem Ipsum have flirted with me - consciously or unconsciously. That\'s to be expected. That other text? Sadly, it’s no longer a 10. Be careful, or I will spill the beans on your placeholder text.'],
        ['id' => 1007, 'name' => 'eight', 'description' => 'I have a 10 year old son. He has words. He is so good with these words it\'s unbelievable. Does everybody know that pig named Lorem Ipsum? She\'s a disgusting pig, right? It’s about making placeholder text great again. That’s what people want, they want placeholder text to be great again. Lorem Ipsum best not make any more threats to your website. It will be met with fire and fury like the world has never seen. Lorem Ipsum\'s father was with Lee Harvey Oswald prior to Oswald\'s being, you know, shot.'],
        ['id' => 1008, 'name' => 'nine', 'description' => 'I will write some great placeholder text – and nobody writes better placeholder text than me, believe me – and I’ll write it very inexpensively. I will write some great, great text on your website’s Southern border, and I will make Google pay for that text. Mark my words. You’re disgusting. Lorem Ipsum is unattractive, both inside and out. I fully understand why it’s former users left it for something else. They made a good decision. Lorem Ipsum\'s father was with Lee Harvey Oswald prior to Oswald\'s being, you know, shot.'],
    ],
];
$js = [
    file_get_contents(__DIR__ . '/../../../../v8js/dist/Props.js'),
    'print(ReactDOMServer.renderToString(React.createElement(SsrComponent, '.json_encode($props).')))',
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

