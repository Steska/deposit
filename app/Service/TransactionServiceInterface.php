<?php

namespace App\Service;

use Illuminate\Database\Eloquent\Collection;

interface TransactionServiceInterface
{
    /**
     * @param array $params
     *
     * @return bool
     */
    public function create(array $params): bool;

    /**
     * @return Collection
     */
    public function getUserTransactions(): Collection;
}
