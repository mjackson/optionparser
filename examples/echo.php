<?php

require dirname(__FILE__) . '/../lib/OptionParser.php';

$parser = new OptionParser;
$parser->addHead("Echo the parameters of each flag as determined by OptionParser.\n");
$parser->addHead("Usage: " . basename($argv[0]) . " [ options ]\n");
$parser->addRule('a', "A short flag with no parameter");
$parser->addRule('b:', "A short flag with an optional parameter");
$parser->addRule('c::', "A short flag with a required parameter");
$parser->addRule('long-a', "A long flag with no parameter");
$parser->addRule('long-b:', "A long flag with an optional parameter");
$parser->addRule('long-c::', "A long flag with a required parameter");

$args = $argv;

try {
    $parser->parse($args);
} catch (Exception $e) {
    die($parser->getUsage());
}

$flagNames = array('a', 'b', 'c', 'long-a', 'long-b', 'long-c');

echo "Parsed arguments:\n";
foreach ($flagNames as $flag) {
    $param = var_export($parser->getOption($flag), true);
    echo sprintf(' %6s %s', $flag, $param) . "\n";
}

echo "\nRemaining arguments: " . implode(' ', $args) . "\n";

