<?php

namespace App\Http\Controllers\Sso;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $rootDomain = '.untirta.ac.id';

        setcookie('access_token', '', time() - 1, '/', $rootDomain);
        setcookie('refresh_token', '', time() - 1, '/', $rootDomain);

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to(config('sso.url.login'))->with('success', 'Berhasil keluar sistem');
    }
}
