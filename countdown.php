<?php

// the powerset advantage!
include_once 'powerset.php';

$powerset = new Powerset();

// dictionary
$start = microtime(true);
$dic = unserialize(file_get_contents('data/dic.dat'));
$time = ((microtime(true) - $start) * 1000); // ms
echo "\r\nDictionary load time: $time ms\r\n";

$start = microtime(true);

$time = ((microtime(true) - $start) * 1000); // ms
echo "\r\nDictionary processing time: $time ms\r\n";


$start = microtime(true);

$maxResults = isset($argv[2]) ? $argv[2] : 10;

// candidate words
$candidates = [];

// the search space
$search = isset($argv[1]) ? substr($argv[1], 0, 9) : 'hotdogbun';
$search = strtolower($search);  // always lowercase

// search space as an array (set)
$searchArray = str_split($search);
sort($searchArray);

// get the powerset of the search space array (set)
$powerset = $powerset->power_set($searchArray);

// check each powerset entry against the dictionary
foreach ($powerset as $window) {
    // the dictionary is sorted, so sort this set too
    sort($window);
    $chars = join('', $window);
    
    // if matched, then merge the words from the dictionary into the candidates array
    if (isset($dic[$chars])) {
        $candidates = array_merge($candidates, $dic[$chars]);
        
        if (count($candidates) >= $maxResults * 2) {
            break;
        }
    }
}

// remove duplicates
$candidates = array_unique($candidates);
usort($candidates, function ($a, $b){
    return strlen($b) - strlen($a);
});

// put longest matches at the bottom of the list (easier reading in command line output)
$candidates = array_reverse(array_slice($candidates, 0, $maxResults));

$time = ((microtime(true) - $start) * 1000); // ms

print_r($candidates);

echo "\r\nSearch time: $time ms\r\n";

// TODO: Put in Composer and add a after-install script to gen the dictionary rather than include in the repo