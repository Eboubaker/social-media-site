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

    public static function nestedRandomStep(int $limit, int $level, int $step = 1):int
    {
        $result = $limit;
        $steps = 0;
        while($level-- > 0) {
            $result = random_int($steps, $result);
            $steps+=$step;
        }
        return $result;
    }
    public static function randc($percentage): bool
    {
        return (random_int(0, 100) / 100.0) > $percentage;
    }

}
