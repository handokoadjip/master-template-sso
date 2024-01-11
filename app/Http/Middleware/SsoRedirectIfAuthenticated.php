<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use DomainException;
use Illuminate\Support\Facades\Cookie;
use InvalidArgumentException;
use UnexpectedValueException;

class SsoRedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // $access_token = Cookie::get('access_token');
        $access_token = @$_COOKIE['access_token'];

        if ($access_token) {

            $publicKey = config('jwt.public_key_access');

            try {
                JWT::decode($access_token, new Key($publicKey, 'RS256'));

                return redirect()->route('homepage.index');
            } catch (ExpiredException $e) {
                $request->session()->flash('error', 'Silahkan login terlebih dahulu!');
            } catch (InvalidArgumentException $e) {
                $request->session()->flash('error', $e->getMessage());
            } catch (DomainException $e) {
                $request->session()->flash('error', $e->getMessage());
            } catch (SignatureInvalidException $e) {
                $request->session()->flash('error', $e->getMessage());
            } catch (BeforeValidException $e) {
                $request->session()->flash('error', $e->getMessage());
            } catch (UnexpectedValueException $e) {
                $request->session()->flash('error', $e->getMessage());
            }
        }

        return $next($request);
    }
}
