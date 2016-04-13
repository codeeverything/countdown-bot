<?php
// generate a dictionary from a wordlist source

$words = file_get_contents('source_data/corncob_lowercase.txt');

$words = explode("\r\n", $words);

$words = array_filter($words, function ($word) {
    return strlen($word) <= 9;
});

sort($words);

$data = serialize($words);

file_put_contents('data/dic.dat', $data);