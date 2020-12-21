<?php

namespace App\Rules;

use App\Model\Wallet;
use App\Service\WalletServiceInterface;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

/**
 * Class Balance
 */
class Balance implements Rule
{
    /**
     * @var WalletServiceInterface
     */
    private $walletService;

    public function __construct()
    {
        $this->walletService = resolve(WalletServiceInterface::class);
    }

    /**
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $wallet = $this->walletService->getWalletByCredential(['user_id' => Auth::id()]);

        return $value <= $wallet->getAttribute('balance');
    }

    /**
     * @return array|string|null
     */
    public function message()
    {
        return __('Error Balance');
    }
}
