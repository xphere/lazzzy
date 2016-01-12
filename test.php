<?php

require __DIR__ . '/vendor/autoload.php';

class Range implements IteratorAggregate
{
    public function getIterator()
    {
        $count = 0;
        while (++$count) {
            yield $count;
        }
    }
}

$square = function ($value) {
    return $value * $value;
};

$odd = function ($value) {
    return $value % 2 === 0;
};

$limit = function ($value) {
    return $value < 25;
};

$sum = function (array $value) {
    return $value[0] + $value[1];
};

$it = \Lazzzy\Container::from(new Range())
    ->takeWhile($limit)
    ->map($square)
    ->windowed(2, true)
    ->map($sum)
    ->take(5)
;

foreach ($it as $key => $value) {
//    echo $key, ': (', $value[0], ', ', $value[1], ')', PHP_EOL;
    echo $key, ': ', $value, PHP_EOL;
}

foreach ($it as $key => $value) {
//    echo $key, ': (', $value[0], ', ', $value[1], ')', PHP_EOL;
    echo $key, ': ', $value, PHP_EOL;
}
