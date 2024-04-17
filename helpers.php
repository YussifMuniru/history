<?php


function get_history() {
    
if(isset($_SERVER) && isset($_SERVER['REQUEST_METHOD'])){

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $lottery_id = $_GET['lottery_id'];
    $type       = $_GET['type'];
    if(!isset($lottery_id) || !isset($type)){
        echo json_encode(['status' => 'error', 'message' =>'Invalid request.']);
        return;
    }
   echo fetch_cached_history($lottery_id,$type);
}
}
}


function findPattern(Array $pattern,Array $drawNumbers) : bool{
   $count = array_count_values($drawNumbers);
   sort($count); sort($pattern);
    return $count == $pattern;
}// end of findPattern.


function spanPattern(Array $drawNumbers, int $index, int $slice) : int  {
    
    // Slicing the array from index for the length of slice
    $slicedNumbers = array_slice($drawNumbers, $index, $slice);
   
    // Sorting the sliced array
    sort($slicedNumbers);

    
    // Getting the max and min values in the sliced array
   $maxValue = max($slicedNumbers);
   $minValue = min($slicedNumbers);

    // Returning the difference between max and min values
    return $maxValue - $minValue;

}// end of spanPattern. Returns the difference btn the max and min values of the draw number


function sumPattern(Array $drawNumbers, int $index,int $slice) : int {
    // Slicing the array from index for the length of slice
    $slicedArray = array_slice($drawNumbers, $index, $slice);

    // Calculating the sum of the sliced array
    $sum = array_sum($slicedArray);

    return $sum;
} // end of sumPattern. Sum the array chunk.


function dragonTigerTiePattern(int $idx1,int $idx2,Array $drawNumbers) : string{
    $v1 = $drawNumbers[$idx1];
    $v2 = $drawNumbers[$idx2];

    if ($v1 > $v2) {
      
        return "D";
    } elseif ($v1 === $v2) {
       
        return "Tie";
    } else {
       
        return "T";
    }
}// end of dragonTigerTiePattern. returns the dragon tiger tie relationship btn the numbers

function isPrime($number) {
    
    if ($number == 0) return false;

    if ($number <= 3) {
        return true; // 2 and 3 are prime numbers
    }

    // Check from 2 to sqrt(number) for any divisors
    $sqrt = sqrt($number);
    for ($i = 2; $i <= $sqrt; $i++) {
        if ($number % $i == 0) {
            return false; // Number is divisible by some number other than 1 and itself
        }
    }

    // If we find no divisors, it's a prime number
    return true;
}

