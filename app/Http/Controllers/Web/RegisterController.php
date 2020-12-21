<?php

namespace App\Http\Controllers\Web;

use App\Service\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Service\WalletServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var WalletServiceInterface
     */
    private $walletService;

    /**
     * Create a new controller instance.
     *
     * @param UserServiceInterface $userService
     * @param WalletServiceInterface $walletService
     */
    public function __construct(UserServiceInterface $userService, WalletServiceInterface $walletService)
    {
        $this->userService = $userService;
        $this->walletService = $walletService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('register.index');
    }

    /**
     * @param Request $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function register(Request $request)
    {
        validator(
            $request->all(),
            [
                'login' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]
        )->validate();
        $user = $this->userService->create($request->only('login', 'email', 'password'));
        $this->walletService->create($user->getAttribute('id'));

        if ($this->userService->login($request->get('login'), $request->get('password'))){

            return redirect($this->redirectTo);
        }
        return redirect('/login');
    }
}
