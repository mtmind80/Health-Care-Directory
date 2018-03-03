@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Users &amp; Access</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('role_list_path') }}">Roles</a>
                </li>
                <li class="crumb-trail">Create</li>
            </ol>
        </div>
        <div class="topbar-right">
        </div>
    </header>
@stop

@section('content')
    <section id="content" class="animated fadeIn list-items admin-form">
        <div class="row">
            <div class="col-md-9 center-block">
                @include('errors._list')
                <div class="admin-form theme-primary">
                    <div class="panel">
                        {!! Form::open(['url' => route('role_store_path'), 'id' => 'createRoleForm']) !!}
                        @include('role._form', ['formTitle' => 'New Role', 'submitButtonText' => 'Create Role', 'newRole' => true, 'roleId' => ''])
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js-files')
    <script>
        $(function(){
            $( "#createRoleForm" ).validate({
                rules: {
                    role_name: {
                        required : true,
                        lower    : true,
                        minlength: 3
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                }
            });

            $('#privileges').multiselect({
                includeSelectAllOption: true,
                /*
                onDropdownShow: function(event) {
                    if (!$('#parent_id').val()) {
                        uiAlert({type: 'error', text: 'Por favor, seleccione el Parent Role.', lang: 'sp'});
                    }
                }
                */
            });

            $('#submit-button').click(function(ev){
                if ($('#privileges option:selected').size() == 0) {
                    ev.preventDefault();
                    uiConfirm({callback: 'confirmSubmitForm', text: 'There is no privilege assigned to this role. Do you want to submit the form anyway?.', params: []});
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('role_list_path') }}";
            });
        });

        function confirmSubmitForm(params)
        {
            $('#createRoleForm').submit();
        }
    </script>
@stop