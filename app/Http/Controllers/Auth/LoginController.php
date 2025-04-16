<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
    protected function reditection()
    {
        if (Auth()->user()->role == 1) {
            return route('admin.dashboard');
        } elseif (Auth()->user()->role == 2) {
            return route('user.dashboard');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $response = Http::timeout(30)
            ->post('https://osave.cloud/api/apiLogin', $request->only(['email', 'password']));

        Log::debug('HR API response body: ', ['body' => $response->body()]);

            if ($response->successful()) {
            $userData = $response->json();
            Log::debug('User data from HR system: ', ['userData' => $userData]);

            if ($userData && isset($userData['name']) && isset($userData['role'])) {
                $name = $userData['name'];
                $role = $userData['role'];
                $token = $userData['token'];

                $financeUser = \App\Models\User::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'name' => $name,
                        'role' => $role,
                        'password' => bcrypt($request->password)
                    ]
                );

                Auth::login($financeUser);

                if ($financeUser->role == 1) {
                    return redirect()->route('admin.dashboard')->with('success', 'Welcome Administrator!');
                } elseif ($financeUser->role == 2) {
                    return redirect()->route('user.dashboard')->with('success', 'Welcome User!');
                }
            } else {
                return redirect()->route('login')->with('error', 'User not found in HR system!');
            }
        } else {
            return redirect()->route('login')->with('error', 'Invalid credentials or HR system error!');
        }
    }
}
