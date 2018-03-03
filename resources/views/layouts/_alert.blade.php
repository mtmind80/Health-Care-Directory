@if (!empty($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="fa fa-remove pr10"></i>
        Error
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@elseif (session('error'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="fa fa-remove pr10"></i>
        <strong>Error!</strong> {!! session('error') !!}
    </div>
@elseif (session('warning'))
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="fa fa-warning pr10"></i>
        <strong>Warning!</strong> {!! session('warning') !!}
    </div>
@elseif (session('success'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="fa fa-check pr10"></i>
        <strong>Success!</strong> {!! session('success') !!}
    </div>
@elseif (session('info'))
    <div class="banner alert_box alert r_corners color_green info alert-dismissable mb20">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="fa fa-info-circle"></i><p>{!! session('info') !!}</p>
    </div>
@endif
