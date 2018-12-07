<?php


/**
 * Function for sieve of Eratosthenes
 * @param $number it is number which input user
 * @return array get primes value
 */
function getPrimes($number)
{
    $is_composite_num = [];
    for ($i = 4; $i <= $number; $i += 2){
        $is_composite_num[$i] = true;
    }
    $next_prime = 3;
    while ($next_prime <= (int)sqrt($number)){
        for ($i = $next_prime << 1; $i <= $number ; $i += $next_prime){
            $is_composite_num[$i] = true;
        }
        $next_prime += 2;
        while ($next_prime <= $number && isset($is_composite_num[$next_prime])){
            $next_prime +=2 ;
        }
    }
    $primes = [];
    for ($i = 2; $i <= $number; $i++){
        if (!isset($is_composite_num[$i]))
            $primes[] = $i;
    }
    return $primes;
}

/**
 * Create partial sums
 * @param $primes array  primes value
 * @param $number it is number which input user
 * @return array|null result
 */
function createSums($primes, $number) {
    $partial_sum = [0,2];
    for ($i = 2; $partial_sum[$i-1] <= $number; $i++){
        $partial_sum[] = $primes[$i]+ $partial_sum[$i-1];
    }
    for($r = count($partial_sum)-1; $r >= 0; $r--) {
        for($l = 1; $l < count($partial_sum); $l++) {
            $res = $partial_sum[$r] - $partial_sum[$l];
            $terms = $r-$l;
            if(in_array($res, $primes)){
                return ["number" => $res, "terms" => $terms];
            }
        }
    }
    return null;
}


/**
 * It's Facade function
 * @param $number it is number which input user
 */
function getSumAndTerms($number){
    if($number < 2){
        echo "Sorry it's not prime";
    } else {
        $primes = getPrimes($number);
        $result= [];
        if($number < 5){
            $result["terms"] = 1;
            $result["number"] = end($primes);
        } else {
            $result = createSums($primes, $number);
        }
        echo "contains {$result["terms"]} and it is equal to {$result["number"]}";
    }

}

getSumAndTerms(41);
