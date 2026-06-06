<?php
namespace App\DesignPatterns\StudioFactory\Interfaces;

interface SeatInterface 
{
    public function generateLayout(int $capacity): array;
}