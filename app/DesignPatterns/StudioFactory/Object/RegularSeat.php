<?php

namespace App\DesignPatterns\StudioFactory\Object;
use App\DesignPatterns\StudioFactory\Interfaces\SeatInterface;

class RegularSeat implements SeatInterface 
{
    public function generateLayout(int $capacity): array 
    {
        $layout = [];
        $rows = range('A', 'Z'); 
        $seatCount = 0;
        foreach ($rows as $row) {
            for ($i = 1; $i <= 14; $i++) {
                if ($seatCount >= $capacity) break 2;
                $layout[] = $row . $i;
                $seatCount++;
            }
        }
        return $layout;
    }
}