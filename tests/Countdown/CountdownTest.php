<?php

namespace Countdown\Test;

use Countdown\Countdown;

class CountdownTest extends \PHPUnit_Framework_TestCase {
    
    private $solver;
    
    public function setup() {
        $this->solver = new Countdown();
    }
    
    public function tearDown() {
        unset($this->solver);
    }
    
    public function testConundrum() {
        $words = $this->solver->solve('hardsemi', 10);
        $this->assertTrue(in_array('misheard', $words));
        
        $words = $this->solver->solve('bumheads', 10);
        $this->assertTrue(in_array('ambushed', $words));
        
        $words = $this->solver->solve('rudenobs', 10);
        $this->assertTrue(in_array('rebounds', $words));
    }
}