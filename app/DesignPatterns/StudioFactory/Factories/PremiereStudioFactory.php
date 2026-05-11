<?php

namespace App\DesignPatterns\StudioFactory\Factories;
use App\DesignPatterns\StudioFactory\Interfaces\StudioFactoryInterface;
use App\DesignPatterns\StudioFactory\Interfaces\SeatInterface;
use App\DesignPatterns\StudioFactory\Object\RegularSeat;

class PremiereStudioFactory implements StudioFactoryInterface 
{
    public function createSeat(): SeatInterface 
    {
        return new PremiereSeat();
    }
}