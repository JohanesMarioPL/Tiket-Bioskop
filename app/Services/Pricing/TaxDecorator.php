<?php

namespace App\Services\Pricing;

/**
 * Decorator Pattern – Concrete Decorator: Pajak Pemerintah
 *
 * Membungkus komponen harga dan menambahkan pajak sebesar
 * persentase tertentu dari total harga sebelum pajak.
 * Default: 5% (simulasi PPn tiket hiburan).
 *
 * Decorator ini menunjukkan bahwa dekorator bisa bergantung
 * pada nilai dinamis (bukan hanya konstanta), dan bisa di-stack
 * dengan decorator lain (misalnya di atas ServiceFeeDecorator).
 */
class TaxDecorator extends PricingDecorator
{
    /** Persentase pajak (default 5%) */
    private float $taxRate;

    /**
     * @param TicketPricingInterface $pricing Komponen yang di-decorate
     * @param float $taxRate                  Persentase pajak, misal 0.05 untuk 5%
     */
    public function __construct(TicketPricingInterface $pricing, float $taxRate = 0.05)
    {
        parent::__construct($pricing);
        $this->taxRate = $taxRate;
    }

    /**
     * {@inheritdoc}
     * Total = harga dari wrappee + (harga_wrappee × tax_rate)
     */
    public function calculate(): int
    {
        $subtotal  = $this->wrappee->calculate();
        $taxAmount = (int) round($subtotal * $this->taxRate);
        return $subtotal + $taxAmount;
    }

    /**
     * Hitung hanya nilai pajaknya saja.
     */
    public function getTaxAmount(): int
    {
        return (int) round($this->wrappee->calculate() * $this->taxRate);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        $pct = (int) ($this->taxRate * 100);
        return $this->wrappee->getDescription() . " + Pajak {$pct}%";
    }

    /**
     * {@inheritdoc}
     */
    public function getBreakdown(): array
    {
        $breakdown   = $this->wrappee->getBreakdown();
        $pct         = (int) ($this->taxRate * 100);
        $breakdown[] = [
            'label'  => "Pajak Hiburan ({$pct}%)",
            'amount' => $this->getTaxAmount(),
            'type'   => 'add',
        ];
        return $breakdown;
    }
}
