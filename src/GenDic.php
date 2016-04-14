<?php
// generate a dictionary from a wordlist source
// word list sourced from: http://www.mieliestronk.com/wordlist.html

namespace Countdown;

class GenDic {
    public static function generate() {
        echo "\r\nLoading Countdown word list...\r\n";
        $words = file_get_contents(__DIR__ . '/source_data/corncob_lowercase.txt');
        
        $words = explode("\r\n", $words);
        
        echo "\r\nFiltering words > 9 characters...\r\n";
        $words = array_filter($words, function ($word) {
            return strlen($word) <= 9;
        });
        
        echo "\r\nSorting word list...\r\n";
        sort($words);
        
        echo "\r\nBuilding Countdown dictionary...\r\n";
        $tree = [];
        foreach ($words as $k => $word) {
            $letters = str_split($word);
            sort($letters);
            $sorted = join('', $letters);
            $tree[$sorted][] = $word;
        }
        
        echo "\r\nSaving Countdown dictionary...\r\n";
        $data = serialize($tree);
        
        file_put_contents(__DIR__ . '/data/dic.dat', $data);
        echo "\r\nCountdown dictionary generated (done)\r\n";
    }
}