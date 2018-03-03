<div class="btn-group">
    @if (Auth::user()->isAllowTo('update-provider'))
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench mr10"></i>Actions
            <span class="caret ml5"></span>
        </button>
        <ul class="dropdown-menu right" role="menu">
            <li><a href="{{ route('provider_show_path', ['id' => $provider_id]) }}"><i class="fa fa-eye mr10"></i> Profile</a></li>
            <li><a href="{{ route('provider_address_list_path', ['id' => $provider_id]) }}"><i class="fa fa-map-marker ml3 mr15"></i> Address</a></li>
            @if (!empty($professional_id))
                <li><a href="{{ route('professional_affiliation_list_path', ['id' => $professional_id]) }}"><i class="fa fa-hand-spock-o mr10"></i> Affiliations</a></li>
                <li><a href="{{ route('professional_board_list_path', ['id' => $professional_id]) }}"><i class="fa fa-graduation-cap mr10"></i> Boards</a></li>
            @endif
            <li><a href="{{ route('provider_condition_list_path', ['id' => $provider_id]) }}"><i class="fa fa-heart mr10"></i> Conditions</a></li>
            @if (!empty($professional_id))
                <li><a href="{{ route('professional_fellowship_list_path', ['id' => $professional_id]) }}"><i class="fa fa-users mr10"></i> Fellowships</a></li>
                <li><a href="{{ route('professional_identification_list_path', ['id' => $professional_id]) }}"><i class="fa fa-credit-card mr10"></i> Identifications</a></li>
                <li><a href="{{ route('professional_internship_list_path', ['id' => $professional_id]) }}"><i class="fa fa-book mr10"></i> Internships</a></li>
            @endif
            <li><a href="{{ route('provider_malpractice_list_path', ['id' => $provider_id]) }}"><i class="fa fa-gavel mr10"></i> Malpractices</a></li>
            <li><a href="{{ route('provider_procedure_list_path', ['id' => $provider_id]) }}"><i class="fa fa-magic mr10"></i> Procedures</a></li>
            <li><a href="{{ route('provider_reference_list_path', ['id' => $provider_id]) }}"><i class="fa fa-child ml2 mr10"></i> References</a></li>
            @if (!empty($professional_id))
                <li><a href="{{ route('professional_residency_list_path', ['id' => $professional_id]) }}"><i class="fa fa-building-o mr10"></i> Residencies</a></li>
                <li><a href="{{ route('professional_school_list_path', ['id' => $professional_id]) }}"><i class="fa fa-institution mr10"></i> Schools</a></li>
            @endif
        </ul>
    @endif
</div>