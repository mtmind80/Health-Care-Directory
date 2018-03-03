<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class ErrorsController extends CommonController
{

    public function error404()
    {
        $data = [
            'seo'        => [
                'pageTitlePrefix' => 'Error 404 | ',
                'pageTitle'       => 'Page Not Found',
            ],
            'unknownUrl' => \Session::get('unknownUrl'),
        ];

        return response()->view('errors.404', $data, 404);  // 3rd parameter: error code. Sending 404 to avoid soft-404 error
    }

}
