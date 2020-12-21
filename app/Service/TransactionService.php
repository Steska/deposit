<?php

namespace App\Service;

use App\Model\Transaction;
use App\Model\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Class TransactionService
 */
class TransactionService implements TransactionServiceInterface
{
    /**
     * @inheritDoc
     */
    public function create(array $params): bool
    {
        Transaction::create($params);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getUserTransactions(): Collection
    {
        return User::find(Auth::id())->transactions;
    }
}
