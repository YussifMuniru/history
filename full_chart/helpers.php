<?php



function streamline_segments(array $callables): array
{

    $periods = [30, 50, 100]; // Define the periods for which you want to generate the data
    $results = [];

    foreach ($periods as $period) {

        foreach ($callables as $column_title => $callable) {

            if (count($callable[1][0]['draw_numbers']) < $period) {
                $results[$period] = [];
                break;
            }
            //get the function name from the callables
            $function_name = $callable[0];
            // add the appropriate count to the array of params for the function
            array_push($callable[1], $period);
            if (!str_starts_with($function_name, '_')) {

                $results[$period][$column_title] = $function_name($callable[1]);
            } else {
                $function_name = substr($function_name, 1);
                $func_results  = $function_name($callable[1]);
                $results[$period] = array_merge($results[$period], $func_results);
            }
        }
    }

    return $results;
}
function winning_and_draw_periods(array $args): array
{

    $results = [];

    $draw_numbers = $args[0];
    $flag         = $args[1];
    $count        = $args[2];


    for ($x = 0; $x < $count; $x++) {
        if(isset($draw_numbers['draw_numbers'][$x])){
            $results['w'][] = $draw_numbers['draw_numbers'][$x];
            $results['d'][] = $draw_numbers['draw_periods'][$x];
        }
      
    }
    return $results[$flag];
}

function findDuplicates($numbers)
{
    // Count the occurrences of each number
    $count = array_count_values($numbers);

    // Filter the counts to find duplicates
    $duplicates = array_filter($count, function ($value) {
        return $value > 1;
    });

    // Return the keys of duplicates (which are the duplicate numbers)
    return array_map('strval', array_keys($duplicates));
}
function findPattern(array $pattern, array $drawNumbers, int $index, int $slice): bool
{
    $count = array_count_values(array_slice($drawNumbers, $index, $slice));
    sort($count);
    sort($pattern);
    return $count == $pattern;
} // end of findPattern.


function spanPattern(array $drawNumbers, int $index, int $slice): int
{

    // Slicing the array from index for the length of slice
    $slicedNumbers = array_slice($drawNumbers, $index, $slice);

    // Sorting the sliced array
    sort($slicedNumbers);


    // Getting the max and min values in the sliced array
    $maxValue = max($slicedNumbers);
    $minValue = min($slicedNumbers);

    // Returning the difference between max and min values
    return $maxValue - $minValue;
} // end of spanPattern. Returns the difference btn the max and min values of the draw number


function sumPattern(array $drawNumbers, int $index, int $slice): int
{
    // Slicing the array from index for the length of slice
    $slicedArray = array_slice($drawNumbers, $index, $slice);

    // Calculating the sum of the sliced array
    $sum = array_sum($slicedArray);

    return $sum;
} // end of sumPattern. Sum the array chunk.


function dragonTigerTiePattern(int $idx1, int $idx2, array $drawNumbers): string
{
    $v1 = $drawNumbers[$idx1];
    $v2 = $drawNumbers[$idx2];

    if ($v1 > $v2) {

        return "D";
    } elseif ($v1 === $v2) {

        return "Tie";
    } else {

        return "T";
    }
} // end of dragonTigerTiePattern. returns the dragon tiger tie relationship btn the numbers

function isPrime($number)
{

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

function checkPrimeOrComposite($number)
{

    // Check if the number is less than 2.
    if ($number == 1 || $number == 0) return $number === 1 ? "P" : "C";



    // Check from 2 to the square root of the number.
    for ($i = 2; $i <= sqrt($number); $i++) {
        if ($number % $i == 0) {
            return "C";
        }
    }
    // If no divisors were found, it's prime.
    return "P";
}
