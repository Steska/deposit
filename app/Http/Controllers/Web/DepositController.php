<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Jobs\DepositJob;
use App\Model\Deposit;
use App\Rules\Balance;
use App\Service\DepositServiceInterface;
use App\Service\WalletServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class DepositController
 *
 */
class DepositController extends Controller
{
    /**
     * @var DepositServiceInterface
     */
    private $depositService;

    /**
     * @var WalletServiceInterface
     */
    private $walletService;

    /**
     * DepositController constructor.
     *
     * @param DepositServiceInterface $depositService
     * @param WalletServiceInterface $walletService
     */
    public function __construct(DepositServiceInterface $depositService, WalletServiceInterface $walletService)
    {
        $this->walletService = $walletService;
        $this->depositService = $depositService;
    }

    /**
     * @return Application|Factory|View
     */
    public function createDepositForm()
    {
        return view('deposit.create');
    }

    /**
     * @param Request $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function create(Request $request)
    {
        validator(
            $request->all(),
            [
                'amount' => ['required', 'numeric', new Balance(), 'min:10', 'max:100'],
            ]
        )->validate();

        $deposit = $this->depositService->create(
            [
                'user_id' => Auth::id(),
                'wallet_id' => $this->walletService->getWalletByCredential(['user_id' => Auth::id()])->getAttribute(
                    'id'
                ),
                'invested' => $request->get('amount'),
                'percent' => Deposit::PERCENT,
                'active' => Deposit::ACTIVE,
                'duration' => Deposit::DURATION,
                'accrue_times' => Deposit::ACCRUE_TIMES,
            ]
        );
        DepositJob::dispatch($deposit->getAttribute('id'));

        return redirect('/home');
    }

    /**
     * @return Application|Factory|View
     */
    public function getDeposits()
    {
        return view(
            'deposit.table',
            [
                'deposits' => $this->depositService->getUserDeposits(),
            ]
        );
    }
}
