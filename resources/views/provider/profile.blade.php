@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('provider_list_path') }}">Providers</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">"{{ $provider->name }}"</a>
                </li>
                <li class="crumb-trail">Profile</li>
            </ol>
        </div>
        <div class="topbar-right">
            <div class="btn-group">
                @include('provider._actionmenu', ['provider_id' => $provider->id])
            </div>
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
                        <div class="panel-body">
                            <div class="section-divider mb30 mt20"><span>Provider Profile</span></div>

                            <section id="data-container">
                                @if ($provider->isProfessional)
                                    <section class="person-data-section">
                                        <div class="section row">
                                            <div class="col-md-6">
                                                {{ Form::jShow($provider->professional->first_name, ['label' => 'First Name']) }}
                                            </div>
                                            <div class="col-md-6">
                                                {{ Form::jShow($provider->professional->last_name, ['label' => 'Last Name']) }}
                                            </div>
                                        </div>
                                        <div class="section row">
                                            <div class="col-md-8">
                                                {{ Form::jShow($provider->professional->title, ['label' => 'Title']) }}
                                            </div>
                                            <div class="col-md-4">
                                                {{ Form::jShow($provider->professional->date_of_birth->format('m/d/Y'), ['label' => 'Date of Birth']) }}
                                            </div>
                                        </div>
                                    </section>
                                @else
                                    <!-- Facility data section -->
                                    <section class="facility-data-section">
                                        <div class="section row">
                                            <div class="col-md-12">
                                                {{ Form::jShow($provider->facility->name, ['label' => 'Name']) }}
                                            </div>
                                        </div>
                                    </section>
                                @endif

                                <!-- Common data section -->
                                <div class="section row">
                                    <div class="col-sm-6">
                                        {{ Form::jShow($provider->type->name, ['label' => 'Type']) }}
                                    </div>
                                    <div class="col-sm-6">
                                        {{ Form::jShow($provider->subType->name, ['label' => 'Sub Type']) }}
                                    </div>
                                </div>
                                <div class="section row">
                                    <div class="col-sm-6">
                                        {{ Form::jShow($provider->phone, ['label' => 'Phone']) }}
                                    </div>
                                    <div class="col-sm-6">
                                        {{ Form::jShow($provider->fax, ['label' => 'Fax']) }}
                                    </div>
                                </div>
                                <div class="section row">
                                    <div class="col-md-6">
                                        {{ Form::jShow($provider->email, ['label' => 'Email']) }}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::jShow($provider->under_contract ? 'Yes' : 'No', ['label' => 'Under Contract']) !!}
                                    </div>
                                </div>

                                <div class="section-divider mt40 mb25">
                                    <span>Main Address</span>
                                </div>
                                <div class="section row">
                                    <div class="col-sm-8">
                                        {{ Form::jShow($provider->address, ['label' => 'Address']) }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::jShow($provider->address_2, ['label' => 'Address 2']) }}
                                    </div>
                                </div>
                                <div class="section row">
                                    <div class="col-sm-6">
                                        {{ Form::jShow($provider->city, ['label' => 'City']) }}
                                    </div>
                                    <div class="col-sm-6">
                                        {{ Form::jShow($provider->zipcode, ['label' => 'Zip Code']) }}
                                    </div>
                                </div>

                                <div class="section row">
                                    <div class="col-sm-6">
                                        {{ Form::jShow($provider->country->name, ['label' => 'Country']) }}
                                    </div>
                                    <div class="col-sm-6">
                                        {{ Form::jShow($provider->state->full_name, ['label' => 'State']) }}
                                    </div>
                                </div>

                                @if ($provider->addresses->count())
                                    <div class="section-divider mt40 mb25">
                                        <span>Secondary Addresses</span>
                                    </div>
                                    @foreach ($provider->addresses as $address)
                                            <div class="section row">
                                                <div class="col-sm-8">
                                                    {{ Form::jShow($address->address, ['label' => 'Address']) }}
                                                </div>
                                                <div class="col-md-4">
                                                    {{ Form::jShow($address->address_2, ['label' => 'Address 2']) }}
                                                </div>
                                            </div>
                                            <div class="section row">
                                                <div class="col-sm-6">
                                                    {{ Form::jShow($address->city, ['label' => 'City']) }}
                                                </div>
                                                <div class="col-sm-6">
                                                    {{ Form::jShow($address->zipcode, ['label' => 'Zip Code']) }}
                                                </div>
                                            </div>

                                            <div class="section row">
                                                <div class="col-sm-6">
                                                    {{ Form::jShow($address->country->name, ['label' => 'Country']) }}
                                                </div>
                                                <div class="col-sm-6">
                                                    {{ Form::jShow($address->state->full_name, ['label' => 'State']) }}
                                                </div>
                                            </div>
                                    @endforeach
                                @endif

                                @if (!$provider->isProfessional)
                                    <!-- Facility data section -->

                                    <section class="facility-data-section">
                                        <div class="section-divider mt40 mb25">
                                            <span>Contact Info</span>
                                        </div>

                                        <div class="section row">
                                            <div class="col-md-12">
                                                {{ Form::jShow($provider->facility->contact_name, ['label' => 'Contact Name']) }}
                                            </div>
                                        </div>
                                    </section>
                                @else
                                    <!-- Professional data section -->
                                    <section class="person-data-section">
                                        @if ($provider->professional->affiliations->count())
                                            <div class="section-divider mt40 mb25">
                                                <span>Hospital Affiliations</span>
                                            </div>
                                            @foreach ($provider->professional->affiliations as $affiliation)
                                                <div class="section row">
                                                    <div class="col-md-12">
                                                        {{ Form::jShow($affiliation->facility->name, ['label' => 'Hospital']) }}
                                                    </div>
                                                </div>
                                                <div class="section row">
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($affiliation->html_started_at, ['label' => 'Started At']) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($affiliation->html_ended_at, ['label' => 'Ended At']) }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                        @if ($provider->professional->boards->count())
                                            <div class="section-divider mt40 mb25">
                                                <span>Boards</span>
                                            </div>
                                            @foreach ($provider->professional->boards as $board)
                                                <div class="section row">
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($board->specialityType->name, ['label' => 'Speciality']) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($board->specialitySubtype->name, ['label' => 'Speciality Subtype']) }}
                                                    </div>
                                                </div>
                                                <div class="section row">
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($board->body->name, ['label' => 'Body']) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($board->certification->name, ['label' => 'Certification']) }}
                                                    </div>
                                                </div>
                                                <div class="section row">
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($board->state->full_name, ['label' => 'State']) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($board->country->name, ['label' => 'Country']) }}
                                                    </div>
                                                </div>
                                                <div class="section row">
                                                    <div class="col-md-6">
                                                        {{ Form::jShow(!empty($board->issued_at) ? $board->issued_at->format('m/d/Y') : '', ['label' => 'Issued']) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($board->htmlExpiredAt, ['label' => 'Expires']) }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                        @if ($provider->conditions->count())
                                            <div class="section-divider mt40 mb25">
                                                <span>Conditions</span>
                                            </div>
                                            @foreach ($provider->conditions as $condition)
                                                <div class="section row">
                                                    <div class="col-sm-12">
                                                        {{ Form::jShow($condition->condition->name, ['label' => 'Name']) }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif    
                                            
                                        @if ($provider->professional->fellowships->count())
                                            <div class="section-divider mt40 mb25">
                                                <span>Fellowships</span>
                                            </div>
                                            @foreach ($provider->professional->fellowships as $fellowship)
                                                <div class="section row">
                                                    <div class="col-md-12">
                                                        {{ Form::jShow($fellowship->facility->name, ['label' => 'Institution']) }}
                                                    </div>
                                                </div>
                                                <div class="section row">
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($fellowship->specialityType->name, ['label' => 'Speciality']) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($fellowship->specialitySubtype->name, ['label' => 'Speciality Subtype']) }}
                                                    </div>
                                                </div>
                                                <div class="section row">
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($fellowship->discipline->name, ['label' => 'Discipline']) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($fellowship->degree->short_name, ['label' => 'Degree']) }}
                                                    </div>
                                                </div>
                                                <div class="section row">
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($fellowship->htmlStartedAt, ['label' => 'Started At']) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($fellowship->htmlEndedAt, ['label' => 'Ended At']) }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        @if ($provider->professional->identifications->count())
                                            <div class="section-divider mt40 mb25">
                                                <span>Identifications</span>
                                            </div>
                                            @foreach ($provider->professional->identifications as $identification)
                                                <div class="section row">
                                                    <div class="col-md-5">
                                                        {{ Form::jShow($identification->identification->name, ['label' => 'Type']) }}
                                                    </div>
                                                    <div class="col-md-5">
                                                        {{ Form::jShow($identification->value, ['label' => 'Value']) }}
                                                    </div>
                                                    <div class="col-md-2">
                                                        {{ Form::jShow($identification->identification->isLicence, ['label' => 'Is Licence?']) }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        @if ($provider->professional->residencies->count())
                                            <div class="section-divider mt40 mb25">
                                                <span>Residencies</span>
                                            </div>
                                            @foreach ($provider->professional->residencies as $residency)
                                                <div class="section row">
                                                    <div class="col-md-12">
                                                        {{ Form::jShow($residency->facility->name, ['label' => 'Institution']) }}
                                                    </div>
                                                </div>
                                                <div class="section row">
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($residency->specialityType->name, ['label' => 'Speciality']) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($residency->specialitySubtype->name, ['label' => 'Speciality Subtype']) }}
                                                    </div>
                                                </div>
                                                <div class="section row">
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($residency->discipline->name, ['label' => 'Discipline']) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($residency->degree->short_name, ['label' => 'Degree']) }}
                                                    </div>
                                                </div>
                                                <div class="section row">
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($residency->htmlStartedAt, ['label' => 'Started At']) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($residency->htmlEndedAt, ['label' => 'Ended At']) }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </section>
                                @endif

                                <!-- Common data section -->

                                @if ($provider->procedures->count())
                                    <div class="section-divider mt40 mb25">
                                        <span>Procedures</span>
                                    </div>
                                    @foreach ($provider->procedures as $procedure)
                                        <div class="section row">
                                            <div class="col-sm-12">
                                                {{ Form::jShow($procedure->procedure->name, ['label' => 'Name']) }}
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                @if ($provider->references->count())
                                    <div class="section-divider mt40 mb25">
                                        <span>References</span>
                                    </div>
                                    @foreach ($provider->references as $reference)
                                        <div class="section row">
                                            <div class="col-sm-8">
                                                {{ Form::jShow($reference->name, ['label' => 'Name']) }}
                                            </div>
                                            <div class="col-md-4">
                                                {{ Form::jShow($reference->title, ['label' => 'Title']) }}
                                            </div>
                                        </div>
                                        <div class="section row">
                                            <div class="col-sm-8">
                                                {{ Form::jShow($reference->address, ['label' => 'Address']) }}
                                            </div>
                                            <div class="col-md-4">
                                                {{ Form::jShow($reference->address_2, ['label' => 'Address 2']) }}
                                            </div>
                                        </div>
                                        <div class="section row">
                                            <div class="col-sm-6">
                                                {{ Form::jShow($reference->city, ['label' => 'City']) }}
                                            </div>
                                            <div class="col-sm-6">
                                                {{ Form::jShow($reference->zipcode, ['label' => 'Zip Code']) }}
                                            </div>
                                        </div>
                                        <div class="section row">
                                            <div class="col-sm-6">
                                                {{ Form::jShow($reference->country->name, ['label' => 'Country']) }}
                                            </div>
                                            <div class="col-sm-6">
                                                {{ Form::jShow($reference->state->full_name, ['label' => 'State']) }}
                                            </div>
                                        </div>
                                        <div class="section row">
                                            <div class="col-sm-6">
                                                {{ Form::jShow($reference->email, ['label' => 'Email']) }}
                                            </div>
                                            <div class="col-sm-6">
                                                {{ Form::jShow($reference->phone, ['label' => 'Phone']) }}
                                            </div>
                                        </div>
                                        <div class="section row">
                                            <div class="col-sm-6">
                                                {{ Form::jShow($reference->fax, ['label' => 'Fax']) }}
                                            </div>
                                            <div class="col-sm-6">
                                                {{ Form::jShow($reference->html_known_at, ['label' => 'Known Since']) }}
                                            </div>
                                        </div>
                                    @endforeach
                                @endif 

                                @if ($provider->isProfessional)
                                    <section class="person-data-section">
                                        @if ($provider->professional->schools->count())
                                            <div class="section-divider mt40 mb25">
                                                <span>Schools</span>
                                            </div>
                                            @foreach ($provider->professional->schools as $school)
                                                <div class="section row">
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($school->school->name, ['label' => 'Name']) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::jShow($school->degree->short_name, ['label' => 'Degree']) }}
                                                    </div>
                                                </div>
                                                <div class="section row">
                                                    <div class="col-md-6">
                                                        {{ Form::jShow(!empty($school->started_at) ? $school->started_at->format('m/d/Y') : '', ['label' => 'From']) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::jShow(!empty($school->ended_at) ? $school->ended_at->format('m/d/Y') : '', ['label' => 'To']) }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </section>
                                @endif
                            </section>
                        </div>
                        <div class="panel-footer text-right">
                            <div class="row">
                                <div class="col-md-6">

                                </div>
                                <div class="col-md-6">
                                    <button id="close-button" class="button btn-default mr10">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js-files')
    <script>
        $(function(){
            $('#close-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('provider_list_path') }}";
            });
        });
    </script>
@stop