<?php namespace App\Listeners;

use App\Events\UserWasLoggedIn;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogLoggedInUser implements ShouldQueue
{

    public function handle(\Illuminate\Auth\Events\Login $event)
    {
		$config = session()->get('config');
		if (!empty($config['logUserAuthAction'])) {
			$login = new \App\Login();

			$login->user_id = $event->user->id;
			$login->ip_address = \Request::getClientIp();
			$login->user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'none';
			$login->session_id = session()->getId();
			$login->logged_in = \Carbon\Carbon::now();

			$login->save();
		}
	}

}
