<?php

namespace App\Http\Middleware;

use Closure;
use DomainException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use InvalidArgumentException;
use UnexpectedValueException;

class SsoAuthenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle(Request $request, Closure $next)
    {
        $access_token = @$_COOKIE['access_token'];
        $error = null;

        if (!$access_token) {
            // Refresh Token
            $access_token = RefreshAccessToken();
        }

        $publicKey = config('jwt.public_key_access');

        try {
            $decode = JWT::decode($access_token, new Key($publicKey, 'RS256'));
        } catch (ExpiredException $e) {
            // Refresh Token
            return RefreshAccessToken();
        } catch (InvalidArgumentException $e) {
            $error = ['message' => $e->getMessage()];
        } catch (DomainException $e) {
            $error = ['message' => $e->getMessage()];
        } catch (SignatureInvalidException $e) {
            $error = ['message' => $e->getMessage()];
        } catch (BeforeValidException $e) {
            $error = ['message' => $e->getMessage()];
        } catch (UnexpectedValueException $e) {
            $error = ['message' => $e->getMessage()];
        }

        if ($error) return redirect()->to('https://sso.dev.untirta.ac.id?redirect=' . url()->full());

        $request->session()->put('sso_id', $decode->sso_id);

        $app_excep = DB::connection('sso')->table('pengguna_aplikasi')
            ->select('pengguna_aplikasi_aplikasi_id')
            ->where('pengguna_aplikasi_pengguna_id', '=', $request->session()->get('sso_id'))
            ->get();

        $app_except_arr = [];

        foreach ($app_excep as $key => $v) {
            $app_except_arr[] = $v->pengguna_aplikasi_aplikasi_id;
        }

        $app_list = DB::connection('sso')
            ->table('pengguna_grup')
            ->distinct('aplikasi_id')
            ->select(
                'aplikasi_nama',
                'aplikasi_ikon',
                'aplikasi_ikon_normal',
                'aplikasi_tautan',
                'aplikasi_jenis',
            )
            ->join('grup_aplikasi', 'grup_aplikasi.grup_aplikasi_grup_id', '=', 'pengguna_grup.pengguna_grup_grup_id')
            ->join('aplikasi', 'aplikasi.aplikasi_id', '=', 'grup_aplikasi.grup_aplikasi_aplikasi_id')
            ->leftJoin('aplikasi_peran', 'aplikasi_peran.aplikasi_peran_aplikasi_id', '=', 'aplikasi.aplikasi_id')
            ->where('aplikasi_tautan', '=', request()->root())
            ->where('pengguna_grup_pengguna_id', '=', $request->session()->get('sso_id'))
            ->whereNotIn('aplikasi_id', $app_except_arr)
            ->get()->toArray();

        if ($request->segment(1) != 'backoffice') {
            if (!$app_list) return Redirect::to('https://sso.dev.untirta.ac.id/sso/beranda')->with('warning', 'Anda tidak memiliki akses ke halaman tersebut!');

            return $next($request);
        }

        $app_role_list = DB::connection('sso')
            ->table('pengguna_grup')
            ->distinct('aplikasi_id')
            ->select(
                'aplikasi_nama',
                'aplikasi_ikon',
                'aplikasi_ikon_normal',
                'aplikasi_tautan',
                'aplikasi_jenis',
                'aplikasi_peran_nama',
                'aplikasi_peran_akses'
            )
            ->join('grup_aplikasi', 'grup_aplikasi.grup_aplikasi_grup_id', '=', 'pengguna_grup.pengguna_grup_grup_id')
            ->join('aplikasi', 'aplikasi.aplikasi_id', '=', 'grup_aplikasi.grup_aplikasi_aplikasi_id')
            ->leftJoin('aplikasi_peran', 'aplikasi_peran.aplikasi_peran_aplikasi_id', '=', 'aplikasi.aplikasi_id')
            ->leftJoin('pengguna_aplikasi_peran', 'pengguna_aplikasi_peran.pengguna_aplikasi_peran_aplikasi_peran_id', '=', 'aplikasi_peran.aplikasi_peran_id')
            ->where('aplikasi_tautan', '=', request()->root())
            ->where('pengguna_aplikasi_peran_pengguna_id', '=', $request->session()->get('sso_id'))
            ->whereNotIn('aplikasi_id', $app_except_arr)
            ->where('aplikasi_peran_nama', '=', 'Backoffice')->where('aplikasi_peran_akses', '=', 'true')
            ->get()->toArray();

        if (!$app_role_list) return Redirect::to('https://sso.dev.untirta.ac.id/sso/beranda')->with('warning', 'Anda tidak memiliki akses ke halaman tersebut!');

        Auth::loginUsingId($request->session()->get('sso_id'));

        if ($request->segment(2) == 'masuk' and Auth::check()) return redirect('backoffice/dashboard');

        return $next($request);
    }
}
