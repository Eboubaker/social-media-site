<?php


namespace Database\Factories;


class FactoryHelper
{
    public static function nestedRandom(int $limit, int $level):int
    {
        $result = $limit;
        while($level-- > 0)
            $result = random_int(0, $result);
        return $result;
    }

    public static function nestedRandomStep(int $limit, int $level, int $step = 1, int $starts = 0):int
    {
        $result = $limit;
        $steps = $starts;
        while($level-- > 0) {
            $result = random_int($steps>$result?$result-1:$steps, $result);
            $steps+=$step;
        }
        return $result;
    }
    public static function randc($percentage): bool
    {
        return (random_int(0, 100) / 100.0) > $percentage;
    }

}
