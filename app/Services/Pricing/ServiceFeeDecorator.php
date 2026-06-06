<?php

namespace App\Services\Pricing;

/**
 * Decorator Pattern – Concrete Decorator: Biaya Layanan
 *
 * Membungkus komponen harga dan menambahkan biaya layanan
 * aplikasi sebesar Rp 2.000 per tiket. Decorator ini
 * tidak mengubah komponen yang dibungkus sama sekali –
 * ia hanya menambahkan nilainya sendiri di atas hasil wrappee.
 */
class ServiceFeeDecorator extends PricingDecorator
{
    /** Biaya layanan per tiket (dalam rupiah) */
    private const FEE_PER_TICKET = 2000;

    private int $quantity;

    /**
     * @param TicketPricingInterface $pricing Komponen yang di-decorate
     * @param int $quantity                   Jumlah tiket
     */
    public function __construct(TicketPricingInterface $pricing, int $quantity)
    {
        parent::__construct($pricing);
        $this->quantity = $quantity;
    }

    /**
     * {@inheritdoc}
     * Total = harga dari wrappee + (biaya_layanan × jumlah_tiket)
     */
    public function calculate(): int
    {
        return $this->wrappee->calculate() + (self::FEE_PER_TICKET * $this->quantity);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return $this->wrappee->getDescription() . ' + Biaya Layanan';
    }

    /**
     * {@inheritdoc}
     */
    public function getBreakdown(): array
    {
        $breakdown   = $this->wrappee->getBreakdown();
        $breakdown[] = [
            'label'  => 'Biaya Layanan Aplikasi (×' . $this->quantity . ')',
            'amount' => self::FEE_PER_TICKET * $this->quantity,
            'type'   => 'add',
        ];
        return $breakdown;
    }
}
