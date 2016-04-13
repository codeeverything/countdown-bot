<?php

class Powerset {
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
   
  public function power_set($arr) {  
    $binary = array();
    foreach (range(1, count($arr)) as $i) {
      $binary[] = false;
    }
    $n = count($arr);
    $powerset = array();
   
    while (count($binary) <= count($arr)) {
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
      $binary[$i] = true;
    }
   
    rsort($powerset);
    return $powerset;
  }
   
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
   
  public function print_power_sets($arr) {
    echo "POWER SET of [" . join(", ", $arr) . "]\r\n";
    foreach ($this->power_set($arr) as $subset) {
      $this->print_array($subset);
    }
  }
}