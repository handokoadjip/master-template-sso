<?php

use App\Models\Log;
use Harimayco\Menu\Models\Menus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use DomainException;
use Illuminate\Support\Facades\Session;
use InvalidArgumentException;
use UnexpectedValueException;

/**
 * Permission CRUD
 */
function PermissionMenu()
{
    $menu = Menus::where('menu_nama', 'Sidebar')
        ->first()
        ->menuItems()
        ->where('menu_item_tautan', '=', '/' . request()->path())
        ->whereRelation('groups', 'grup_menu_item_grup_id', '=', Auth::user()->groups[0]->grup_id)
        ->get();

    return $menu;
}

/**
 * Permission Action Button
 *
 * @param $url
 *
 */
function PermissionAction($permission)
{
    $routesUuid = collect(explode('/', parse_url($permission, PHP_URL_PATH)));
    $routes = $routesUuid->filter(function ($route) {
        return !Str::isUuid($route);
    });

    try {
        $actions = Menus::where('menu_nama', 'Sidebar')
            ->first()
            ->menuItems()
            ->whereRelation('groups', 'grup_menu_item_grup_id', '=', Auth::user()->groups[0]->grup_id)
            ->whereRelation('actions', 'aksi_tautan', '=', $routes->implode('/', ','))
            ->first()
            ->actions
            ->first()
            ->groups
            ->count();
    } catch (\Throwable $th) {
        $actions = 0;
    }

    if ($actions) return true;
    return false;
}

/**
 * Check Access Token
 */
function CheckAccessToken()
{
    $access_token = @$_COOKIE['access_token'];
    // $access_token = Cookie::get('access_token');
    $error = null;

    if (!$access_token) {
        // Refresh Token
        return RefreshAccessToken();
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

    if ($error) {
        return redirect()->to('https://sso.dev.untirta.ac.id?redirect=' . url()->full());
    }

    Session::put('sso_id', $decode->sso_id);
    if (true) Auth::loginUsingId(Session::get('sso_id'));

    return true;
}

/**
 * Refresh Access Token
 */
function RefreshAccessToken()
{
    $refresh_token = @$_COOKIE['refresh_token'];

    if (!$refresh_token) {
        return redirect()->route('sso.redirect', ['redirect_url' => config('sso.url.login') . '?redirect_url=' . url()->full()])->send();
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => config('sso.url.refresh-token'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $refresh_token
        ),
    ));

    $response = json_decode(curl_exec($curl));
    curl_close($curl);

    if (isset($response->message)) {
        return redirect()->route('sso.redirect', ['redirect_url' => config('sso.url.login') . '?redirect_url=' . url()->full()])->with('warning', $response->message)->send();
    }

    $access_token = $response->access_token;

    $publicKeyAccess = config('jwt.public_key_access');

    $decode = JWT::decode($access_token, new Key($publicKeyAccess, 'RS256'));

    // SET COOKIE
    $rootDomain = '.untirta.ac.id';
    setcookie('access_token', $access_token, $response->exp, '/', $rootDomain);

    Session::put('sso_id', $decode->sso_id);

    return $access_token;
}

/**
 * Get Userinfo from token
 */
function GetUserinfo()
{
    $access_token = @$_COOKIE['access_token'];

    if (!$access_token) $access_token = RefreshAccessToken();

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => config('sso.url.userinfo'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $access_token
        ),
    ));

    $user = json_decode(curl_exec($curl));

    curl_close($curl);

    if (isset($user->message)) return redirect()->route('sso.redirect', ['redirect_url' => config('sso.url.login') . '?redirect_url=' . url()->full()])->with('warning', $response->message)->send();

    return $user;
}

function LogActivy($log_pengguna_id, $log_subjek, $log_keterangan_awal, $log_keterangan_setelah = null)
{
    $log = [];
    $log['log_pengguna_id'] = $log_pengguna_id;
    $log['log_subjek'] = $log_subjek;
    $log['log_tautan'] = Request::fullUrl();
    $log['log_metode'] = Request::method();
    $log['log_keterangan_awal'] = $log_keterangan_awal;
    $log['log_keterangan_setelah'] = $log_keterangan_setelah;
    $log['log_ip'] = Request::ip();
    $log['log_agent'] = Request::header('user-agent');

    Log::create($log);
}
