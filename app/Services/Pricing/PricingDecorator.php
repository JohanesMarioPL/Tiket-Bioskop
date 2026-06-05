<?php

namespace App\Services\Pricing;

/**
 * Decorator Pattern – Abstract Decorator
 *
 * Base class untuk semua Decorator harga.
 * Menyimpan referensi ke komponen yang dibungkus (wrappee)
 * dan mendelegasikan semua pemanggilan ke dalamnya.
 * Subclass hanya perlu override calculate() untuk menambah
 * atau mengurangi komponen harga tertentu.
 */
abstract class PricingDecorator implements TicketPricingInterface
{
    /**
     * Komponen yang dibungkus oleh decorator ini.
     * Bisa berupa BaseTicketPrice atau Decorator lain (chaining).
     */
    protected TicketPricingInterface $wrappee;

    /**
     * @param TicketPricingInterface $pricing Komponen yang akan di-decorate
     */
    public function __construct(TicketPricingInterface $pricing)
    {
        $this->wrappee = $pricing;
    }

    /**
     * {@inheritdoc}
     * Default: delegasikan ke wrappee. Subclass akan override ini.
     */
    public function calculate(): int
    {
        return $this->wrappee->calculate();
    }

    /**
     * {@inheritdoc}
     * Default: delegasikan ke wrappee. Subclass akan override ini.
     */
    public function getDescription(): string
    {
        return $this->wrappee->getDescription();
    }

    /**
     * {@inheritdoc}
     * Default: delegasikan ke wrappee dan tambahkan entry sendiri.
     */
    public function getBreakdown(): array
    {
        return $this->wrappee->getBreakdown();
    }
}
