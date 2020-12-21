<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Service\UserServiceInterface;
use App\Service\WalletServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * Create a new controller instance.
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
        $this->middleware('guest');
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('login.index');
    }

    /**
     * @param Request $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function login(Request $request)
    {
        validator(
            $request->all(),
            [
                'login' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
            ]
        )->validate();
        if ($this->userService->login($request->get('login'), $request->get('password'))) {
            return redirect($this->redirectTo);
        }

        return redirect('/login');
    }
}
