<?php

namespace Countdown;

/**
 * Calculates and returns the Power Set of a given Set
 * 
 * Based on code found here: https://rosettacode.org/wiki/Power_set
 * @author Mike Timms <mike@codeeverything.com>
 * @version 0.1
 * 
 */
class PowerSet {
  
  /**
   * Get the subset of a set
   * 
   * @param array $binary - 
   * @param array $arr
   * @return array
   */
  private function get_subset($binary, $arr) {
    // based on true/false values in $binary array, include/exclude
    // values from $arr
    $subset = array();
    foreach (range(0, count($arr)-1) as $i) {
      if ($binary[$i]) {
        $subset[] = $arr[count($arr) - $i - 1];
      } 
    }
    return $subset;
  }
   
  /**
   * Get the Power Set of a Set 
   * 
   * @param array $arr - The Set to find the Power Set for
   * @return array
   */
  public function power_set($arr) {  
    // create an array, $binary, the same size as the given Set and populate with false
    $binary = array_fill(0, count($arr), false);
    
    // init vars
    $powerset = array();
   
    // loop until $binary is greater in size as the source set
    while (count($binary) <= count($arr)) {
      // get a sub set
      $powerset[] = $this->get_subset($binary, $arr);
      
      $i = 0;
      while (true) {
        if ($binary[$i]) {
          $binary[$i] = false;
          $i += 1;
        } else {
          $binary[$i] = true;
          break;
        }
      }
      
      // mark this position as having been processed
      $binary[$i] = true;
    }
   
    rsort($powerset);
    return $powerset;
  }
   
  /**
   * Helper function to print an array
   * 
   * @param array $arr - The array to print
   * @return void
   */
  private function print_array($arr) {
    $str = '';
    if (count($arr) > 0) {
      $str .= join(" ", $arr);
    } else {
      $str .= "(empty)";
    }
    $str .= "\r\n";
    
    echo $str;
  }
   
  /**
   * Helper function to print the Power Set of a Set
   * 
   * @param array $arr - The Set to print the Power Set for
   * @return void
   */
  public function print_power_sets($arr) {
    echo "POWER SET of [" . join(", ", $arr) . "]\r\n";
    foreach ($this->power_set($arr) as $subset) {
      $this->print_array($subset);
    }
  }
}