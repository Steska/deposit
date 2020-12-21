<?php

namespace App\Service;

use App\Model\Deposit;
use App\Model\Transaction;
use App\Model\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepositService implements DepositServiceInterface
{
    /**
     * @var TransactionServiceInterface
     */
    private $transactionService;

    /**
     * @var WalletServiceInterface
     */
    private $walletService;

    /**
     * DepositService constructor.
     *
     * @param TransactionServiceInterface $transactionService
     * @param WalletServiceInterface $walletService
     */
    public function __construct(TransactionServiceInterface $transactionService, WalletServiceInterface $walletService)
    {
        $this->walletService = $walletService;
        $this->transactionService = $transactionService;
    }

    /**
     * @inheritDoc
     */
    public function create(array $params): ?Deposit
    {
        try{
            DB::beginTransaction();
            $this->walletService->decrementBalance($params['invested']);
            $deposit = Deposit::create($params);

            $wallet = $this->walletService->getWalletByCredential(['user_id' => Auth::id()]);
            $this->transactionService->create(
                [
                    'wallet_id' => $wallet->getAttribute('id'),
                    'deposit_id' => $deposit->getAttribute('id'),
                    'user_id' => Auth::id(),
                    'type' => Transaction::CREATE_DEPOSIT,
                    'amount' => $params['invested']
                ]
            );
            DB::commit();
            return $deposit;
        }catch (\Exception $e)
        {
            DB::rollBack();
            throw new \Exception($e->getMessage(), $e->getCode());

        }

    }

    /**
     * @inheritDoc
     */
    public function close(Deposit $deposit): bool
    {
        $deposit->setAttribute('active', 0)->save();

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getUserDeposits(): Collection
    {
        return User::find(Auth::id())->deposits;
    }
}
