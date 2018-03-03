<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CommonController;

use Illuminate\Http\Request;
use App\Http\Requests;

class IdleController extends CommonController
{

    protected function lockOut()
    {
        \Session::put('lockout', true);

        if (!str_contains(\URL::previous(), 'lockout')) {
            \Session::put('previous_url', \URL::previous());
        }

        $data = [
            'seo' => [
                'pageTitlePrefix' => '',
                'pageTitle'       => 'Unlock Screen',
            ],
        ];

        return view('auth.unlock', $data);
    }

    protected function unlock(Request $request)
    {
        if (\Hash::check($request->password, \Auth::user()->password)){
            $previous_url = \Session::get('previous_url');
            \Session::forget('previous_url');
            \Session::forget('lockout');

            return redirect($previous_url);
        } else {
            return redirect()->back()->withError('Invalid credentials.');
        }
    }

}
