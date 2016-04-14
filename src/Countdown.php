<?php

namespace Countdown;

// the powerset advantage!
use Countdown\PowerSet;

class Countdown {
    
    private function getScrabbleScore($string, $scores) {
        $chars = str_split($string);
        $score = 0;
        foreach ($chars as $k => $char) {
            $score += $scores[$char];
        }
        
        return $score;
    }
    
    private $scrabbleScores = [
        1 => 'aeiounrostl',
        2 => 'gd',
        3 => 'mbcp',
        4 => 'yfvwh',
        5 => 'k',
        8 => 'jx',
        10 => 'z',
    ];
    
    private $scores = [];
    
    private $powerset = null;
    
    private $dic = [];
    
    public function __construct() {
        // get scrabble scores
        $this->scores = [];
        foreach ($this->scrabbleScores as $score => $letters) {
            $letters = str_split($letters);
            $letters = array_fill_keys($letters, $score);
            $this->scores = array_merge($this->scores, $letters);
        }
        
        $this->powerset = new PowerSet();
        
        // dictionary
        $this->dic = unserialize(file_get_contents(__DIR__ . '/data/dic.dat'));
    }
    
    public function solve($search, $maxResults) {
        if (!$maxResults) {
            $maxResults = 10;
        }
    
        if (!$search) {
            throw new Exception('Countdown: No search supplied to solve on');
        }
        
        $start = microtime(true);
        
        // candidate words
        $candidates = [];
        
        // the search space
        $search = strtolower($search);  // always lowercase
        
        // search space as an array (set)
        $searchArray = str_split($search);
        sort($searchArray);
        
        // get the powerset of the search space array (set)
        $powerset = $this->powerset->power_set($searchArray);
        
        // check each powerset entry against the dictionary
        foreach ($powerset as $subset) {
            // the dictionary is sorted, so sort this set too
            sort($subset);
            $chars = join('', $subset);
            
            // if matched, then merge the words from the dictionary into the candidates array
            if (isset($this->dic[$chars])) {
                $candidates = array_merge($candidates, $this->dic[$chars]);
                
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
        
        return $candidates;
    }
}