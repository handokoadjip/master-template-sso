<?php

namespace App\Http\Controllers\Sso;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [
            'title'         => 'Silahkan login SSO Untirta',
            'redirect_url'  => $request->redirect_url
        ];

        return view('sso.redirect', compact('data'));
    }
}
