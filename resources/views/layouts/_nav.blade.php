<aside id="sidebar_left" class="nano nano-primary">
    <div class="nano-content">
        <ul class="nav sidebar-menu">
            <li class="sidebar-label pt25">Home</li>
            <li class="">
                <a href="{{ asset('/') }}" class="main-controller">
                    <span class="glyphicons glyphicons-dashboard"></span>
                    <span class="sidebar-title">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('task_list_path') }}" class="tasks-controller">
                    <span class="glyphicons glyphicons-alarm"></span>
                    <span class="sidebar-title">Tasks</span>
                </a>
            </li>

            @if (Auth::user()->is(['superadmin', 'admin', 'dataentry']))
                <li class="sidebar-label pt15">Directory</li>
                <li>
                    <a class="accordion-toggle providerconditions-controller providerprocedures-controller providerreferences-controller providermalpracticejudgements-controller providermalpractices-controller policytypes-controller offensetypes-controller professionalaffiliations-controller professionalresidencies-controller professionalinternships-controller professionalfellowships-controller professionalschools-controller professionalidentifications-controller professionalboards-controller bodies-controller insurers-controller schools-controller providers-controller providertypes-controller providersubtypes-controller" href="#">
                        <span class="fa fa-bars"></span>
                        <span class="sidebar-title">Provider Directory</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav">
                        <li>
                            <a href="{{ route('provider_list_path') }}" class="providerconditions-all providerprocedures-all providerreferences-all providermalpracticejudgements-all providermalpractices-all professionalresidencies-all professionalinternships-all professionalfellowships-all professionalschools-all professionalidentifications-all professionalboards-all providers-all">
                                <span class="fa fa-cubes"></span> Providers
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('body_list_path') }}" class="bodies-index bodies-search bodies-show bodies-create bodies-edit">
                                <span class="fa fa-building"></span> Certifying Boards
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('insurer_list_path') }}" class="insurers-index insurers-search insurers-show insurers-create insurers-edit">
                                <span class="glyphicons glyphicons-crown"></span> Insurers
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('offense_type_list_path') }}" class="offensetypes-index offensetypes-search offensetypes-show offensetypes-create offensetypes-edit">
                                <span class="fa fa-flash"></span> Offense Types
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('policy_type_list_path') }}" class="policytypes-index policytypes-search policytypes-show policytypes-create policytypes-edit">
                                <span class="fa fa-life-ring"></span> Policy Types
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('school_list_path') }}" class="schools-index schools-search schools-show schools-create schools-edit">
                                <span class="fa fa-institution"></span> Schools
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('provider_type_list_path') }}" class="providertypes-all providersubtypes-all">
                                <span class="fa fa-industry"></span> Types / Subtypes
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-label pt15">Credential</li>
                <li>
                    <a href="{{ route('credential_list_path') }}" class="credentialdocumentactions-controller credentialdocuments-controller credentials-controller">
                        <span class="glyphicons glyphicons-sheriffs_star"></span>
                        <span class="sidebar-title">Credentials</span>
                    </a>
                </li>

                <li class="sidebar-label pt15">Data</li>

                <li>
                    <a class="accordion-toggle documentactiontypes-controller documenttypes-controller credentialstatus-controller customers-controller actions-controller procedures-controller conditions-controller identifications-controller certifications-controller degrees-controller disciplines-controller exams-controller internshiptypes-controller specialitytypes-controller specialitysubtypes-controller" href="#">
                        <span class="glyphicons glyphicons-sort"></span>
                        <span class="sidebar-title">Credential Data</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav">
                        <li>
                            <a href="{{ route('certification_list_path') }}" class="certifications-index certifications-search certifications-show certifications-create certifications-edit">
                                <span class="fa fa-diamond"></span> Certifications
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('condition_list_path') }}" class="conditions-index conditions-search conditions-show conditions-create conditions-edit">
                                <span class="fa fa-medkit"></span> Conditions
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('credential_status_list_path') }}" class="credentialstatus-index credentialstatus-search credentialstatus-show credentialstatus-create credentialstatus-edit">
                                <span class="fa fa-tasks"></span> Credential Status
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer_list_path') }}" class="customers-index customers-search customers-show customers-create customers-edit">
                                <span class="fa fa-users"></span> Customers
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('degree_list_path') }}" class="degrees-index degrees-search degrees-show degrees-create degrees-edit">
                                <span class="fa fa-graduation-cap"></span> Degrees
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('discipline_list_path') }}" class="disciplines-index disciplines-search disciplines-show disciplines-create disciplines-edit">
                                <span class="fa fa-map-signs"></span> Disciplinary Codes
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('document_type_list_path') }}" class="documenttypes-index documenttypes-search documenttypes-show documenttypes-create documenttypes-edit">
                                <span class="fa fa-file-text-o"></span> Document Types
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('document_action_type_list_path') }}" class="documentactiontypes-index documentactiontypes-search documentactiontypes-show documentactiontypes-create documentactiontypes-edit">
                                <span class="fa fa-th-list"></span> Doc Action Types
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('exam_list_path') }}" class="exams-index exams-search exams-show exams-create exams-edit">
                                <span class="fa fa-edit"></span> Exam Types
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('identification_list_path') }}" class="identifications-index identifications-search identifications-show identifications-create identifications-edit">
                                <span class="fa fa-credit-card"></span> Identifications
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('internship_type_list_path') }}" class="internshiptypes-index internshiptypes-search internshiptypes-show internshiptypes-create internshiptypes-edit">
                                <span class="fa fa-life-ring"></span> Internship Types
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('procedure_list_path') }}" class="procedures-index procedures-search procedures-show procedures-create procedures-edit">
                                <span class="fa fa-stethoscope"></span> Procedures
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('speciality_type_list_path') }}" class="specialitytypes-index specialitytypes-search specialitytypes-show specialitytypes-create specialitytypes-edit specialitysubtypes-index specialitysubtypes-search specialitysubtypes-show specialitysubtypes-create specialitysubtypes-edit">
                                <span class="fa fa-tags"></span> Speciality Types
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="accordion-toggle actions-controller addresstypes-controller states-controller countries-controller languages-controller" href="#">
                        <span class="fa fa-database"></span>
                        <span class="sidebar-title">System Data</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav">
                        @if (Auth::user()->isSuperAdmin())
                            <li>
                                <a href="{{ route('action_list_path') }}" class="actions-index exams-search exams-show exams-create exams-edit">
                                    <span class="fa fa-bolt"></span> Action Types
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('address_type_list_path') }}" class="addresstypes-index addresstypes-search addresstypes-show addresstypes-create addresstypes-edit">
                                <span class="fa fa-map-marker"></span> Address Types
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('country_list_path') }}" class="countries-index countries-search countries-show countries-create countries-edit states-index states-search states-show states-create states-edit">
                                <span class="fa fa-globe"></span> Countries / States
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('language_list_path') }}" class="languages-index languages-search languages-show languages-create languages-edit">
                                <span class="fa fa-language"></span> Languages
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (Auth::user()->isAdmin())
                <li class="sidebar-label pt15">System</li>

                <li>
                    <a href="{{ route('config_list_path') }}" class="config-controller">
                        <span class="glyphicons glyphicons-settings"></span>
                        <span class="sidebar-title">System Settings</span>
                    </a>
                </li>
                <li>
                    <a class="accordion-toggle users-controller roles-controller privileges-controller" href="#">
                        <span class="glyphicons glyphicons-lock"></span>
                        <span class="sidebar-title">Users &amp; Access</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav">
                        <li>
                            <a href="{{ route('user_list_path') }}" class="users-index users-search users-show users-create users-edit">
                                <span class="glyphicons glyphicons-group"></span> Users
                            </a>
                        </li>
                        @if (Auth::user()->isSuperAdmin())
                            <li>
                                <a href="{{ route('role_list_path') }}" class="roles-index roles-search roles-show roles-create roles-edit">
                                    <span class="glyphicons glyphicons-vcard"></span> Roles
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('privilege_list_path') }}" class="privileges-index privileges-search privileges-show privileges-create privileges-edit">
                                    <span class="glyphicons glyphicons-sheriffs_star"></span> Privileges
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                @if (Auth::user()->isSuperAdmin())
                    <li>
                        <a class="accordion-toggle logins-controller logs-controller" href="#">
                            <span class="glyphicons glyphicons-zoom_in"></span>
                            <span class="sidebar-title">Audit</span>
                            <span class="caret"></span>
                        </a>
                        <ul class="nav sub-nav">
                            @if (!empty($config['logUserAuthAction']))
                                <li>
                                    <a href="{{ route('login_list_path') }}" class="logins-index logins-search">
                                        <span class="glyphicons glyphicons-keys"></span> User Logins
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('log_list_path') }}" class="logs-index logs-search logs-show">
                                    <span class="fa fa-bolt"></span> Provider Actions
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif

            <li class="sidebar-label pt15">Session</li>
            <li>
                <a href="{{ route('lockout_path') }}">
                    <span class="glyphicons glyphicons-lock"></span>
                    <span class="sidebar-title">Lock Screen</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout_path') }}">
                    <span class="glyphicons glyphicons-power"></span>
                    <span class="sidebar-title">Logout</span>
                </a>
            </li>
        </ul>
        <div class="sidebar-toggle-mini">
            <a href="#">
                <span class="fa fa-sign-out"></span>
            </a>
        </div>
    </div>
</aside>