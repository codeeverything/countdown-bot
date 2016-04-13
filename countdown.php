<?php

// the powerset advantage!
include_once 'powerset.php';

$powerset = new Powerset();

// dictionary
$dic = unserialize(file_get_contents('data/dic.dat'));

// sorted dictionary of characters
$tree = array();
foreach ($dic as $k => $word) {
    $letters = str_split($word);
    sort($letters);
    $sorted = join('', $letters);
    $tree[$sorted][] = $word;
}


$start = microtime(true);

// candidate words
$candidates = [];

// the search space
$search = isset($argv[1]) ? substr($argv[1], 0, 9) : 'hotdogbun';

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
    if (isset($tree[$chars])) {
        $candidates = array_merge($candidates, $tree[$chars]);
    }
}

// remove duplicates
$candidates = array_unique($candidates);

// put longest matches at the bottom of the list (easier reading in command line output)
$candidates = array_reverse($candidates);

$time = ((microtime(true) - $start) * 1000); // ms

print_r($candidates);

echo "\r\nSearch time: $time ms\r\n";