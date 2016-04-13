<?php
// generate a dictionary from a wordlist source
// word list sourced from: http://www.mieliestronk.com/wordlist.html

$words = file_get_contents('source_data/words.txt');

$words = explode("\n", $words);
print_r(array_slice($words, 0, 10));

$words = array_filter($words, function ($word) {
    return strlen($word) <= 9;
});

sort($words);

$data = serialize($words);

file_put_contents('data/dic.dat', $data);