<?php

namespace App\DesignPatterns\StudioFactory\Interfaces;

interface StudioFactoryInterface 
{
    public function createSeat(): SeatInterface;
}