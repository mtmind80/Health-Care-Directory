<?php namespace App\Listeners;

use App\Events\UserWasLoggedOut;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogLoggedOutUser implements ShouldQueue
{

	public function handle(\Illuminate\Auth\Events\Logout $event)
	{
		$config = session()->get('config');
		if (!empty($config['logUserAuthAction'])) {
			$logout = \App\Login::where('user_id', $event->user->id)->where('session_id', session()->getId())->first();
			if ($logout) {
				$logout->logged_out = \Carbon\Carbon::now();
				$logout->save();
			}
		}
		session()->forget('authUser');
	}

}
