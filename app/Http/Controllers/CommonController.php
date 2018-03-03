<?php namespace App\Http\Controllers;

use ActionTrait;
use RuacTrait;

class CommonController extends Controller
{
    use ActionTrait, RuacTrait;

    public
        $s3,
        $siteUrl,
        $lang,
        $action,
        $afterLoginGoTo = 'home',               // or 'previousPage'
        $afterLogoutGoTo = 'login',
        $afterResetPasswordGoTo = 'home',
        $maxLoginAttempts = 3,
        $lockoutTime = 60,                      // lockout time in seconds
        $yesNoCB;

    const ERROR_NOT_ENOUGH_PRIVILEGES = 'You are not allowed to perform the requested action.';

    protected $_crud = [
        'list',
        'search',
        'show',
        'create',
        'update',
        'delete',
    ];

    public function __construct()
    {
        // Allow only authenticated users. If not redirect to login page. Skip auth and password controllers:
        if (!in_array($this->getActionController(), ['auth', 'password'])) {
            $this->middleware('auth');
        }
        if (!in_array($this->getActionController(), ['auth', 'idle'])) {
            $this->middleware('locked');
        }

        $this->siteUrl = rtrim(asset('/'), '/');

        \Session::put('siteUrl', $this->siteUrl);
        \View::share('siteUrl', $this->siteUrl);

        $this->s3 = env('S3_ACTIVE', false);
        $this->mediaUrl = ($this->s3 && ($bucket = env('S3_BUCKET', false))) ? 'http://' . $bucket . '.s3.amazonaws.com/media' : rtrim(asset('/'), '/') . '/media';

        \Session::put('mediaUrl', $this->mediaUrl);
        \View::share('mediaUrl', $this->mediaUrl);

        $this->lang = session()->get('lang');
        view()->share('lang', $this->lang);

        $this->action = $this->getAction();
        view()->share('action', $this->action);

        $config = session()->get('config');
        $seo = [
            'pageTitlePrefix' => !empty($config['seoDefaultTitlePrefix_' . $this->lang]) ? $config['seoDefaultTitlePrefix_' . $this->lang] : '',
            'pageTitle'       => !empty($config['seoDefaultTitle_' . $this->lang]) ? $config['seoDefaultTitle_' . $this->lang] : 'Page Title ',
            'description'     => !empty($config['seoDefaultDescription_' . $this->lang]) ? $config['seoDefaultDescription_' . $this->lang] : 'Page Description',
            'keywords'        => !empty($config['seoDefaultKeywords_' . $this->lang]) ? $config['seoDefaultKeywords_' . $this->lang] : 'keywords',
        ];
        view()->share('defaultSEO', $seo);
        
        view()->share('encToken', app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()));

        $pendingTasks = \Auth::check() ? \App\Task::mine()->pending()->ordered()->get() : [];
        view()->share('pendingTasks', $pendingTasks);

        $this->yesNoCB = [['0' => 'No'], ['1' => 'Yes']];
    }

    public function getOtherLang()
    {
        return ($this->lang != 'sp') ? 'sp' : 'en';
    }

}
