<?php

namespace App\Service;

use App\Model\Wallet;

/**
 * Interface WalletServiceInterface
 */
interface WalletServiceInterface
{
    /**
     * @param int $userId
     *
     * @return mixed
     */
    public function create(int $userId);

    /**
     * @param float $balance
     *
     * @return bool
     */
    public function addBalance(float $balance): bool;

    /**
     * @param array $credentials
     *
     * @return Wallet
     */
    public function getWalletByCredential(array $credentials): Wallet;

    /**
     * @param $amount
     *
     * @return bool
     */
    public function decrementBalance($amount): bool;

    /**
     * @param $amount
     *
     * @return bool
     */
    public function incrementBalance($amount): bool;
}
