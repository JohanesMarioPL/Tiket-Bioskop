<?php

namespace App\Services\Pricing;

/**
 * Decorator Pattern – Concrete Decorator: Diskon Promo
 *
 * Membungkus komponen harga dan memberikan potongan diskon
 * dalam nilai nominal (rupiah). Decorator ini bisa diaktifkan
 * atau dinonaktifkan secara dinamis – jika tidak ada promo,
 * cukup tidak di-wrap dengan DiscountDecorator.
 *
 * Ini menunjukkan kekuatan Decorator: fitur bisa ditambah/dihapus
 * tanpa mengubah kelas yang sudah ada (Open/Closed Principle).
 */
class DiscountDecorator extends PricingDecorator
{
    private int    $discountAmount;
    private string $promoLabel;

    /**
     * @param TicketPricingInterface $pricing   Komponen yang di-decorate
     * @param int    $discountAmount            Nilai diskon dalam rupiah
     * @param string $promoLabel                Label promo (misal: "PROMO WEEKEND")
     */
    public function __construct(
        TicketPricingInterface $pricing,
        int $discountAmount,
        string $promoLabel = 'Diskon Promo'
    ) {
        parent::__construct($pricing);
        $this->discountAmount = $discountAmount;
        $this->promoLabel     = $promoLabel;
    }

    /**
     * {@inheritdoc}
     * Total = harga dari wrappee - diskon (minimal 0, tidak bisa negatif)
     */
    public function calculate(): int
    {
        return max(0, $this->wrappee->calculate() - $this->discountAmount);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return $this->wrappee->getDescription() . " - {$this->promoLabel}";
    }

    /**
     * {@inheritdoc}
     */
    public function getBreakdown(): array
    {
        $breakdown   = $this->wrappee->getBreakdown();
        $breakdown[] = [
            'label'  => $this->promoLabel,
            'amount' => $this->discountAmount,
            'type'   => 'subtract',
        ];
        return $breakdown;
    }
}
