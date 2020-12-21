<?php

namespace App\Jobs;

use App\Model\Deposit;
use App\Model\Transaction;
use App\Service\DepositServiceInterface;
use App\Service\TransactionServiceInterface;
use App\Service\WalletServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class DepositJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var DepositServiceInterface
     */
    private $transactionService;

    private $depositId;

    /**
     * @var WalletServiceInterface
     */
    private $walletService;

    /**
     * @var DepositServiceInterface
     */
    private $depositService;

    public function __construct($depositId)
    {
        $this->depositId = $depositId;
        $this->transactionService = resolve(TransactionServiceInterface::class);
        $this->walletService = resolve(WalletServiceInterface::class);
        $this->depositService = resolve(DepositServiceInterface::class);
    }

    public function handle()
    {
        /** @var Deposit $deposit */
        $deposit = Deposit::find($this->depositId);
        $amount = $deposit->getAttribute('invested');
        $percent = $deposit->getAttribute('percent');
        $times = $deposit->getAttribute('accrue_times');
        $i = 0;
        $add = $amount * ($percent / 100);
        while ($i < $times) {
            sleep(60);

            $this->walletService->incrementBalance($add);
            $i++;
        }
        $this->depositService->close($deposit);

        $this->transactionService->create(
            [
                'deposit_id' => $deposit->getAttribute('id'),
                'user_id' => Auth::id(),
                'type' => Transaction::CLOSE_DEPOSIT,
                'amount' => 0,
            ]
        );
    }
}
