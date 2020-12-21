<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Service\WalletServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class WalletController extends Controller
{
    /**
     * @var WalletServiceInterface
     */
    private $walletService;

    /**
     * WalletController constructor.
     *
     * @param WalletServiceInterface $walletService
     */
    public function __construct(WalletServiceInterface $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * @return Application|Factory|View
     */
    public function balanceForm()
    {
        return view('wallet.balance');
    }

    /**
     * @param Request $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function addBalance(Request $request)
    {
        validator(
            $request->all(),
            [
                'balance' => ['required', 'numeric'],
            ]
        )->validate();

        if($this->walletService->addBalance($request->get('balance')))
        {
            return redirect('/home');
        }

        redirect('/balance');
    }
}
