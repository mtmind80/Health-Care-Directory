<!-- Start: Right Sidebar -->
<aside id="sidebar_right" class="nano admin-form">
    <div class="sidebar_right_content nano-content">
        <div class="tab-block sidebar-block br-n">
            <ul class="nav nav-tabs tabs-border nav-justified hidden">
                <li class="active">
                    <a href="#sidebar-right-tab1" data-toggle="tab"></a>
                </li>
            </ul>
            <div class="tab-content br-n">
                <div id="sidebar-right-tab1" class="tab-pane active">

                    <h5 class="title-divider text-muted mb20 pl0"> Filter Providers By:</h5>

                    <div class="row">
                        <div class="col-xs-7 text-muted fs13 fwn mb10 pr5">
                            {{ Form::jText('city', ['value' => !empty($city) ? $city : '', 'label' => 'City', 'placeholder' => 'city', 'attributes' => [] ]) }}
                        </div>
                        <div class="col-xs-5 text-muted fs13 fwn mb10 pl5">
                            {{ Form::jText('zipcode', ['value' => !empty($zipcode) ? $zipcode : '', 'label' => 'Zip Code', 'placeholder' => 'zip code', 'attributes' => [] ]) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-muted fs13 fwn mb10">
                            {{ Form::jSelect('country_id', $countriesCB, ['selected' => !empty($country_id) ? $country_id : 0, 'label' => 'Country' , 'class' => '', 'iconClass' => 'fa fa-globe', 'attributes' => ['id' => 'country_id',]]) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-muted fs13 fwn mb10">
                            {{ Form::jSelect('state_id', $statesCB, ['selected' => !empty($state_id) ? $state_id : 0, 'label' => 'State', 'hint' => '(Select Country first)', 'class' => '', 'iconClass' => 'fa fa-tree', 'attributes' => ['id' => 'state_id',]]) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 text-muted fs13 fwn mb10">
                            {{ Form::jSelect('provider_type_id', $providerTypesCB, ['selected' => !empty($provider_type_id) ? $provider_type_id : 0, 'label' => 'Type', 'class' => '', 'iconClass' => 'fa fa-sliders', 'attributes' => ['id' => 'provider_type_id',]]) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-muted fs13 fwn mb10">
                            {{ Form::jSelect('provider_subtype_id', $providerSubtypesCB, ['selected' => !empty($provider_subtype_id) ? $provider_subtype_id : 0, 'label' => 'Sub Type', 'hint' => '(Select Type first)', 'class' => '', 'iconClass' => 'fa fa-sitemap', 'attributes' => ['id' => 'provider_subtype_id',]]) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 text-muted fs13 fwn mb10">
                            {{ Form::jSelect('condition_id', $conditionsCB, ['selected' => !empty($condition_id) ? $condition_id : 0, 'label' => 'Condition', 'class' => '', 'iconClass' => 'fa fa-heart', 'attributes' => ['id' => 'condition_id',]]) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-muted fs13 fwn mb10">
                            {{ Form::jSelect('procedure_id', $proceduresCB, ['selected' => !empty($procedure_id) ? $procedure_id : 0, 'label' => 'Procedure', 'class' => '', 'iconClass' => 'fa fa-magic', 'attributes' => ['id' => 'procedure_id',]]) }}
                        </div>
                    </div>

                    <div class="row mt10">
                        <div class="col-xs-12">
                            <a id="go_filter" data-route="{{ route('provider_list_path', Request::query()) }}" href="javascript:void(0)" class="db w100per btn btn-info">Filter</a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- end: .tab-content -->
        </div>
    </div>
</aside>
<!-- End: Right Sidebar -->