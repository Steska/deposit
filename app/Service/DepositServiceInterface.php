<?php

namespace App\Service;

use App\Model\Deposit;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface DepositServiceInterface
 *
 */
interface DepositServiceInterface
{
    /**
     * @param array $params
     *
     * @return Deposit|null
     */
    public function create(array $params): ?Deposit;

    /**
     * @param Deposit $deposit
     *
     * @return bool
     */
    public function close(Deposit $deposit): bool;

    /**
     * @return Collection
     */
    public function getUserDeposits(): Collection;
}
