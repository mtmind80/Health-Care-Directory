<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Session;
use URL;
use ToolTrait;

class TranslationsController extends CommonController
{

    use ToolTrait;

    protected $_segments = [
        'search'              => 'buscar',
        'aboutus'             => 'acercadenosotros',
        'ourhistory'          => 'nuestrahistoria',
        'privacypolicy'       => 'politicasdeprivacidad',
        'termsofuse'          => 'terminosycondiciones',
    ];

    private function _makeAsPattern(& $item)
    {
        if (empty($item)) {
            $item = 'no_slug';
        }
        $item = '/' . $item . '/';
    }

    protected function _getSpPattern($segments)
    {
        $arr = array_values($segments);
        array_walk($arr, [$this, '_makeAsPattern']);

        return $arr;
    }

    protected function _getEnPattern($segments)
    {
        $arr = array_keys($segments);
        array_walk($arr, [$this, '_makeAsPattern']);

        return $arr;
    }

    protected function _buildSegments($segments = [])
    {
        // build here some segments from a table if needed

        return $segments;
    }

    public function language($l)
    {
        $previousUrl = URL::previous();

        $segments = array_merge($this->_buildSegments(), $this->_segments); // add $this->segments at the end

        if ($l == 'sp') {                                                   // change to spanish.
            $pattern = $this->_getEnPattern($segments);
            $url = preg_replace($pattern, $segments, $previousUrl);
        } else {                                                            // change to english.
            $pattern = $this->_getSpPattern($segments);
            $url = preg_replace($pattern, array_keys($segments), $previousUrl);
        }

        if ((strpos($url, 'no_slug-') !== false) || (count(explode('/', rtrim($url, '/'))) !== count(explode('/', rtrim($previousUrl, '/'))))) {
            return redirect()->back()->withError(($l == 'sp') ? 'Lo sentimos, esta p&aacute;gina no tiene versi&oacute;n en espa&ntilde;ol.' : 'Sorry, this page does not have a version in english.');
        }

        Session::put('lang', $l);

        return redirect($url);
    }

}
