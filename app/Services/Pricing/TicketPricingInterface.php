<?php

namespace App\Services\Pricing;

/**
 * Decorator Pattern – Component Interface
 *
 * Mendefinisikan kontrak untuk komponen harga tiket,
 * baik ConcreteComponent (harga dasar) maupun Decorator.
 * Semua kelas dalam hierarki ini mengimplementasikan
 * interface yang sama, sehingga dapat di-wrap berulang kali.
 */
interface TicketPricingInterface
{
    /**
     * Hitung total harga setelah semua lapisan dekorator diterapkan.
     *
     * @return int Harga dalam rupiah (integer)
     */
    public function calculate(): int;

    /**
     * Dapatkan deskripsi breakdown harga untuk ditampilkan ke user.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Dapatkan breakdown rinci setiap komponen harga.
     * Format: [['label' => '...', 'amount' => 0, 'type' => 'add|subtract']]
     *
     * @return array
     */
    public function getBreakdown(): array;
}
