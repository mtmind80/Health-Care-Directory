<header class="navbar navbar-fixed-top bg-light">
    <div class="navbar-branding">
        <a class="navbar-brand" href="{{ route('home_path') }}">
            @if (!empty($config['logo']))
                <img src="{{ $siteUrl. '/images/' . $config['logo'] }}" alt="{{ $config['logo'] }}" id="logo-img">
            @else
                JIPA Network
            @endif
        </a>
        <span id="toggle_sidemenu_l" class="glyphicons glyphicons-show_lines"></span>
        <ul class="nav navbar-nav pull-right hidden">
            <li>
                <a href="#" class="sidebar-menu-toggle">
                    <span class="octicon octicon-ruby fs20 mr10 pull-right "></span>
                </a>
            </li>
        </ul>
    </div>
    <ul class="nav navbar-nav navbar-right">
        @if ($pendingTasks->count())
            <li class="dropdown dropdown-item-slide mr10">
                <a class="dropdown-toggle pl10 pr10" data-toggle="dropdown" href="#">
                    <span class="fa fa-bell-o fs18"></span>
                    <span class="badge badge-hero badge-danger">{{ $pendingTasks->count() }}</span>
                </a>
                <ul class="dropdown-menu dropdown-hover dropdown-persist pn w350 bg-white animated animated-shorter fadeIn" role="menu">
                    <li class="bg-light p8">
                        <span class="fw600 pl5 lh30"> Pending Tasks</span>
                        <span class="label label-warning label-sm pull-right lh20 h-20 mt5 mr5">{{ $pendingTasks->count() }}</span>
                    </li>
                    @foreach ($pendingTasks as $pendingTask)
                        <li class="p10 br-t item-1">
                            <div class="media">
                                <a class="media-left" href="#"> <img src="{{ $siteUrl. '/images/avatars/'.$pendingTask->creator->avatar }}" class="mw40" alt="holder-img"> </a>
                                <div class="media-body va-m">
                                    <h5 class="media-heading mv5">{{ $pendingTask->title }}  </h5> Assigned by
                                    <span class="text-system"> {{ $pendingTask->creator->fullName }}</span>
                                    <small class="db text-mut ed">{!! $pendingTask->isDue() ? '<i class="fa fa-exclamation-triangle mr5 status due"></i>' : '' !!}Due On: {{ !empty($pendingTask->due_at) ? $pendingTask->due_at->format("M. d, Y") : 'Not Set' }}</small>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endif
        <li class="dropdown">
            <a href="#" class="dropdown-toggle fw600 p10" data-toggle="dropdown">
                @if (!empty(Auth::user()->avatar))
                    <img src="{{ $siteUrl.'/images/avatars/'.Auth::user()->avatar }}" alt="{{ Auth::user()->avatar }}" class="mw40 br64 mr5">
                @else
                    <img src="{{ $siteUrl.'/images/avatars/'.$config['defaultAvatar'] }}" alt="default avatar" class="mw40 br64 mr10">
                @endif
                <span>{{ Auth::user()->fullName }}<i class="ml5 fa fa-angle-down"></i></span>
            </a>
            <ul class="dropdown-menu dropdown-persist pn w250 bg-white" role="menu">
                <li class="br-t of-h">
                    <a href="{{ route('task_list_path') }}" class="fw600 p12 animated animated-short fadeInDown">
                        <span class="fa fa-tasks pr5"></span> Tasks
                    </a>
                </li>
                <li class="br-t of-h">
                    <a href="{{ route('user_profile_path') }}" class="fw600 p12 animated animated-short fadeInDown">
                        <span class="fa fa-gear pr5"></span> Profile
                    </a>
                </li>

                <li class="br-t of-h">
                    <a href="{{ route('lockout_path') }}" class="fw600 p12 animated animated-short fadeInDown">
                        <span class="fa fa-lock pr5"></span> Lock Screen
                    </a>
                </li>
                <li class="br-t of-h">
                    <a href="{{ route('logout_path') }}" class="fw600 p12 animated animated-short fadeInDown">
                        <span class="fa fa-power-off pr5"></span> Logout
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</header>