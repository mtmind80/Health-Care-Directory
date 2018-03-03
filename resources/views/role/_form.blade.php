<div class="panel-body">
    <div class="section-divider mb20 mt20"><span>{{ $formTitle }}</span></div>


    <div class="section row">
        <div class="col-md-6 mt15">
            <span class="form-field-label">Role Name:<i class="field-required fa fa-asterisk" data-toggle="tooltip" title="this field is required"></i></span>
            <label for="role_name" class="field prepend-icon">
                {!! Form::text('role_name', null, ['class' => 'gui-input', 'id' => 'role_name', 'placeholder' => 'Role name...']) !!}
                <span class="field-icon"><i class="fa fa-bookmark"></i></span>
            </label>
        </div>
        <div class="col-md-6">
            <span class="form-field-label mt15">Role-related Privileges:</span>
            <div class="form-group">
                <select id="privileges" name="privileges[]" multiple="multiple" class="multiselect">
                    @if (!empty($privilegesCB))
                        @foreach ($privilegesCB as $key => $value)
                            <option value="{{ $key }}"{!! (!empty($role->privilegeNames) && in_array($value, $role->privilegeNames)) ? ' selected="selected"' : ''!!}>{{ $value }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>

    <div class="section row">
        <div class="col-md-12">
            <label class="switch block switch-primary pull-left input-align mt5">
                <input type="checkbox" name="disabled" id="disabled" value="1" {{ !empty($role->disabled) ? 'checked' : ''}}>
                <label for="disabled" data-on="YES" data-off="NO"></label>
                <span>Disabled</span>
            </label>
        </div>
    </div>
</div>
<div class="panel-footer text-right">
    <div class="row">
        <div class="col-md-6">
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
        <div class="col-md-6">
            <button id="cancel-button" class="button btn-default mr10">Cancel</button>
            {!! Form::submit($submitButtonText, ['class' => 'button btn-primary', 'id' => 'submit-button']) !!}
        </div>
    </div>
</div>