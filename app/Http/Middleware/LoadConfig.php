<?php namespace App\Http\Middleware;

use Closure;

class LoadConfig {

	public function handle($request, Closure $next, $guard = null)
	{
        (new \App\Config())->reload();

        if (!($lang = session()->get('lang')) || !in_Array($lang, ['en', 'sp'])) {
            $lang = (!empty($confArray['defaultLanguage'])) ? $confArray['defaultLanguage'] : 'en';
            session()->put('lang', $lang);
        }
        \App::setLocale(($lang == 'sp') ? 'es' : 'en');
        view()->share('lang', $lang);

		return $next($request);
	}

}
