<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\Wallet;
use App\Service\WalletServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * @var WalletServiceInterface
     */
    private $walletService;

    public function __construct(WalletServiceInterface $walletService)
    {
        $this->walletService = $walletService;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $wallet = $this->walletService->getWalletByCredential(['user_id' => Auth::id()]);

        return view('home.index', ['balance' => $wallet->getAttributeValue('balance')]);
    }

}
