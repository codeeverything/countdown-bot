<?php
// generate a dictionary from a wordlist source
// word list sourced from: http://www.mieliestronk.com/wordlist.html

$words = file_get_contents(__DIR__ . '/source_data/corncob_lowercase.txt');

$words = explode("\r\n", $words);

$words = array_filter($words, function ($word) {
    return strlen($word) <= 9;
});

print_r(array_slice($words, 0, 10));

sort($words);

$tree = [];
foreach ($words as $k => $word) {
    $letters = str_split($word);
    sort($letters);
    $sorted = join('', $letters);
    $tree[$sorted][] = $word;
}

$data = serialize($tree);

file_put_contents(__DIR__ . '/data/dic.dat', $data);