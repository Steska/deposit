<?php

namespace App\Service;

use App\Model\Transaction;
use App\Model\Wallet;
use Illuminate\Support\Facades\Auth;

/**
 * Class WalletService
 */
class WalletService implements WalletServiceInterface
{
    /**
     * @var TransactionServiceInterface
     */
    private $transactionService;

    /**
     * WalletService constructor.
     *
     * @param TransactionServiceInterface $transactionService
     */
    public function __construct(TransactionServiceInterface $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * @inheritDoc
     */
    public function create(int $userId)
    {
        Wallet::create(
            [
                'user_id' => $userId
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getWalletByCredential(array $credentials): Wallet
    {
        return Wallet::where($credentials)->first();
    }

    /**
     * @inheritDoc
     */
    public function addBalance(float $balance): bool
    {
        $wallet = $this->getWalletByCredential(['user_id' => Auth::id()]);

        $wallet->setAttribute('balance', $balance);

        $wallet->save();

        $this->transactionService->create(
            [
                'wallet_id' => $wallet->getAttribute('id'),
                'user_id' => Auth::id(),
                'type' => Transaction::ADD_BALANCE,
                'amount' => $balance
            ]
        );

        return true;
    }

    /**
     * @inheritDoc
     */
    public function decrementBalance($amount): bool
    {
        $wallet = $this->getWalletByCredential(['user_id' => Auth::id()]);
        $wallet->setAttribute('balance', ($wallet->getAttribute('balance') - $amount));
        $wallet->save();

        return true;
    }

    /**
     * @inheritDoc
     */
    public function incrementBalance($amount): bool
    {
        $wallet = $this->getWalletByCredential(['user_id' => Auth::id()]);
        $wallet->setAttribute('balance', ($wallet->getAttribute('balance') + $amount));
        $wallet->save();

        return true;
    }
}
