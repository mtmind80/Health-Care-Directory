<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Login;
use App\Http\Requests\SearchRequest;

class LoginsController extends CommonController
{
    public function index(Request $request)
    {
        if ($this->authUserCannot('list-login')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $logins = Login::ordered()->paginate($perPage);

        $data = [
            'logins' => $logins,
            'needle' => null,
            'seo'    => [
                'pageTitle' => 'Logins',
            ],
        ];

        return view('login.index', $data);
    }

    public function search(SearchRequest $request)
    {
        if ($this->authUserCannot('search-login')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $logins = Login::search($needle)->ordered()->paginate($perPage);
        $data = [
            'logins' => $logins,
            'needle' => $needle,
            'seo'    => [
                'pageTitle' => 'Logins',
            ],
        ];

        return view('login.index', $data);
    }

}
