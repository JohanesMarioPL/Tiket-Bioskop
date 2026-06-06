<?php

namespace App\Services\Pricing;

/**
 * Decorator Pattern – Concrete Component
 *
 * Komponen dasar yang merepresentasikan harga tiket tanpa
 * tambahan apapun: hanya harga_per_tiket × jumlah_tiket.
 * Semua Decorator akan membungkus (wrap) objek ini.
 */
class BaseTicketPrice implements TicketPricingInterface
{
    private int $pricePerTicket;
    private int $quantity;

    /**
     * @param int $pricePerTicket Harga dasar per tiket (base_price dari schedule)
     * @param int $quantity       Jumlah tiket yang dipesan
     */
    public function __construct(int $pricePerTicket, int $quantity)
    {
        $this->pricePerTicket = $pricePerTicket;
        $this->quantity       = $quantity;
    }

    /**
     * {@inheritdoc}
     * Harga dasar = harga_per_tiket × jumlah_tiket
     */
    public function calculate(): int
    {
        return $this->pricePerTicket * $this->quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return "Harga tiket ({$this->quantity}x)";
    }

    /**
     * {@inheritdoc}
     */
    public function getBreakdown(): array
    {
        return [
            [
                'label'  => "Harga Tiket (×{$this->quantity})",
                'amount' => $this->calculate(),
                'type'   => 'base',
            ]
        ];
    }
}
