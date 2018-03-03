<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Log;
use App\Http\Requests\SearchRequest;

class LogsController extends CommonController
{
    public function index(Request $request)
    {
        if ($this->authUserCannot('list-log')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $logs = Log::ordered()->paginate($perPage);

        $data = [
            'logs'   => $logs,
            'needle' => null,
            'seo'    => [
                'pageTitle' => 'Logs',
            ],
        ];

        return view('log.index', $data);
    }

    public function search(SearchRequest $request)
    {
        if ($this->authUserCannot('search-log')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $logs = Log::search($needle)->ordered()->paginate($perPage);
        $data = [
            'logs'   => $logs,
            'needle' => $needle,
            'seo'    => [
                'pageTitle' => 'Logs',
            ],
        ];

        return view('log.index', $data);
    }


    public function show(Log $log)
    {
        if ($this->authUserCannot('show-log')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        // dd($log->modifications);

        $data = [
            'log' => $log,
            'seo' => [
                'pageTitle' => 'Provider Modification',
            ],
        ];

        return view('log.details', $data);
    }
}
