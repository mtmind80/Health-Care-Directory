{!! Form::hidden('avatar', null, ['id' => 'avatar']) !!}
@if (!empty($user))
    {!! Form::hidden('old_avatar', $user->avatar, ['id' => 'old_avatar']) !!}
    {!! Form::hidden('old_password', $user->password, ['id' => 'old_password']) !!}
@else
    {!! Form::hidden('old_avatar', null, ['id' => 'old_avatar']) !!}
@endif

<div class="panel-body">
    <div class="section-divider mb20 mt20"><span>{{ $formTitle }}</span></div>

    <span class="form-field-label">Picture: <em class="hint">(150 x 150 px)</em></span>

    <div class="dropzone user field"
         data-originalsize="false"
         {!! !empty($user) ? 'data-image="'. $siteUrl . '/images/avatars/' . $user->avatar . '" data-userId="'.$user->id.'"' : '' !!}
         data-width="150"
         data-height="150"
         data-resize="true"
         data-url="{{ route('user_upload_canvas_path') }}"
         data-removeurl="{{ route('user_delete_canvas_path') }}"
         data-token="{{ $encToken }}">
        <input type="file" name="thumb" id="avatarFileField"{!! !empty($newUser) ? ' required="required"' : '' !!} />
    </div>

    <div class="section row mt20">
        <div class="col-xs-12 col-sm-6">
            <span class="form-field-label">First Name:<i class="field-required fa fa-asterisk" data-toggle="tooltip" title="this field is required"></i></span>
            <label for="first_name" class="field prepend-icon">
                {!! Form::text('first_name', null, ['class' => 'gui-input', 'id' => 'first_name', 'placeholder' => 'First name...']) !!}
                <span class="field-icon"><i class="fa fa-user"></i></span>
            </label>
        </div>
        <div class="col-xs-12 col-sm-6">
            <span class="form-field-label">Last Name:<i class="field-required fa fa-asterisk" data-toggle="tooltip" title="this field is required"></i></span>
            <label for="last_name" class="field prepend-icon">
                {!! Form::text('last_name', null, ['class' => 'gui-input', 'id' => 'last_name', 'placeholder' => 'Last name...']) !!}
                <span class="field-icon"><i class="fa fa-user"></i></span>
            </label>
        </div>
    </div>
    <div class="section row">
        <div class="col-xs-12 col-sm-6">
            <span class="form-field-label">Email:<i class="field-required fa fa-asterisk" data-toggle="tooltip" title="this field is required"></i></span>
            <label for="email" class="field prepend-icon">
                {!! Form::text('email', null, ['class' => 'gui-input', 'id' => 'email', 'placeholder' => 'Email...']) !!}
                <span class="field-icon"><i class="fa fa-envelope"></i></span>
            </label>
        </div>
        <div class="xs-hidden col-sm-6">
            
        </div>
    </div>
    <div class="section row">
        <div class="col-xs-12 col-sm-6">
            <span class="form-field-label">Password:{!! !empty($newUser) ? '<i class="field-required fa fa-asterisk" data-toggle="tooltip" title="this field is required"></i>' : '' !!}</span>
            <label for="password" class="field prepend-icon">
                <input type="password" name="password" id="password" class="gui-input" placeholder="Password">
                <span class="field-icon"><i class="fa fa-lock"></i></span>
            </label>
        </div>
        <div class="col-xs-12 col-sm-6">
            <span class="form-field-label">Repeat Password:{!! !empty($newUser) ? '<i class="field-required fa fa-asterisk" data-toggle="tooltip" title="this field is required"></i>' : '' !!}</span>
            <label for="repeat_password" class="field prepend-icon">
                <input type="password" name="repeat_password" id="repeat_password" class="gui-input" placeholder="Repeat password">
                <span class="field-icon"><i class="fa fa-unlock-alt"></i></span>
            </label>
        </div>
    </div>

    @if (empty($profile))
        <div class="section-divider mb20 mt40"><span>Roles and Privileges {!! !empty($profile) ? '<i class="i-help fa fa-question" data-content="<p>You cannot modify your own roles/privileges on your profile form.</p><p>Grant/revoke privileges to/from roles can only be done on Roles section." data-placement="top" title='. "'" .'<span class="text-info"><strong>Roles and Privileges</strong></span> <button type="button" class="close">&times;</button>'. "'" .'></i>' : '' !!}</span></div>

        <div class="section row mb10">
            <div class="col-xs-12 col-sm-6">
                <span class="form-field-label">Roles:<i class="field-required fa fa-asterisk" data-toggle="tooltip" title="this field is required"></i></span>
                <div class="form-group">
                    <select id="roles" name="roles[]" multiple="multiple" {!! !empty($profile) ? ' class="multiselect"' : '' !!}>
                        @if (!empty($rolesCB))
                            @foreach ($rolesCB as $key => $value)
                                <option value="{{ $key }}"{!! (!empty($user->roleIds) && in_array($key, $user->roleIds)) ? ' selected="selected"' : ''!!}{!! (!empty($profile) || Auth::user()->isNotAllowTo('modify-user-roles')) ? ' disabled="disabled"' : '' !!}>{{ $value }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="xs-hidden col-sm-6">

            </div>
        </div>
        <div class="section row mb10">
            <div class="col-xs-12 col-sm-6">
                <span class="form-field-label">Role-related Privileges:
                    <i class="i-help fa fa-question"
                       data-content="Those are the privileges granted to the roles this user have.<br>Grant/revoke privileges to/from roles can only be done on Roles section."
                       data-placement="top"
                       title='<span class="text-info"><strong>Role-related Privileges</strong></span> <button type="button" class="close">&times;</button>'>
                    </i>
                </span>
                <div class="form-group">
                    <select id="rolesPrivileges" name="rolesPrivileges[]" multiple="multiple"{!! !empty($profile) ? ' class="multiselect"' : '' !!}>
                        @if (!empty($privilegesCB))
                            @foreach ($privilegesCB as $key => $value)
                                <option value="{{ $key }}"{!! (!empty($user) && in_array($key, $rolesPrivilegesCB)) ? ' selected="selected"' : ''!!}{!! !empty($profile) || Auth::user()->isNotAllowTo('modify-user-privileges') ? ' disabled="disabled"' : '' !!}>{{ $value }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <span class="form-field-label">User-related Privileges:
                    <i class="i-help fa fa-question"
                       data-content="Those are the privileges directly granted to this user besides the privileges granted from his/her roles."
                       data-placement="top"
                       title='<span class="text-info"><strong>User-related Privileges</strong></span> <button type="button" class="close">&times;</button>'>
                    </i>
                </span>
                <div class="form-group">
                    <select id="privileges" name="privileges[]" multiple="multiple" {!! !empty($profile) ? ' class="multiselect"' : '' !!}>
                        @if (!empty($privilegesCB))
                            @foreach ($privilegesCB as $key => $value)
                                <option value="{{ $key }}"{!! (!empty($user->assignedPrivilegeIds) && in_array($key, $user->assignedPrivilegeIds)) ? ' selected="selected"' : ''!!}{!! (!empty($profile) || Auth::user()->cannot('modify-user-privileges')) ? ' disabled="disabled"' : '' !!}>{{ $value }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    @endif

    @if (empty($user) || Auth::user()->id != $user->id)
        <div class="section row">
            <div class="col-md-12">
                <label class="switch block switch-primary pull-left input-align mt5">
                    <input type="checkbox" name="disabled" id="disabled" value="1" {{ !empty($user->disabled) ? 'checked' : ''}}>
                    <label for="disabled" data-on="YES" data-off="NO"></label>
                    <span>Disabled</span>
                </label>
            </div>
        </div>
    @endif
</div>
<div class="panel-footer text-right">
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            @if (empty($config['simpleFormSubmission']))
                <div class="smart-widget sm-left sml-120">
                    <label for="verification" class="field prepend-icon">
                        <input name="verification" id="verification" class="gui-input" placeholder="Solve equation" type="text">
                        <span class="field-icon"><i class="fa fa-shield"></i></span>
                    </label>
                    <label for="verification" class="button">{{ $equation['equation'] }} =</label>
                </div>
            @endif
        </div>
        <div class="col-xs-12 col-sm-6">
            <button id="cancel-button" class="button btn-default mr10">Cancel</button>
            {!! Form::submit($submitButtonText, ['class' => 'button btn-primary', 'id' => 'submit-button']) !!}
        </div>
    </div>
</div>