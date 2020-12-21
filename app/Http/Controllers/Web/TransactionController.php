<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Service\TransactionServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * @var TransactionServiceInterface
     */
    private $transactionService;

    /**
     * TransactionController constructor.
     *
     * @param TransactionServiceInterface $transactionService
     */
    public function __construct(TransactionServiceInterface $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * @return Application|Factory|View
     */
    public function getTransactions()
    {
        return view(
            'transaction.table',
            [
                'transactions' => $this->transactionService->getUserTransactions(),
            ]
        );
    }
}
