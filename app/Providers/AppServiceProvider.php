<?php

namespace App\Providers;

use App\Service\DepositService;
use App\Service\DepositServiceInterface;
use App\Service\TransactionService;
use App\Service\TransactionServiceInterface;
use App\Service\UserService;
use App\Service\UserServiceInterface;
use App\Service\WalletService;
use App\Service\WalletServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            UserServiceInterface::class,
            function ($app) {
                return new UserService();
            }
        );

        $this->app->singleton(
            WalletServiceInterface::class,
            function ($app) {
                return new WalletService(resolve(TransactionServiceInterface::class));
            }
        );

        $this->app->singleton(
            TransactionServiceInterface::class,
            function ($app) {
                return new TransactionService();
            }
        );

        $this->app->singleton(
            DepositServiceInterface::class,
            function ($app) {
                return new DepositService(
                    resolve(TransactionServiceInterface::class),
                    resolve(WalletServiceInterface::class)
                );
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
