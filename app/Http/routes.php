<?php

Route::group(['middleware' => 'web'], function(){

    /*
    Route::get('testmail/{domain?}', function($domain = 'yahoo'){

        switch ($domain) {
            case 'gmail':
                $to = 'jose.vicab@gmail.com';
                break;
            case 'cisneros':
                $to = 'jvidal@cisneros.com';
                break;
            case 'yahoo':
            default:
                $to = 'josei.vidal@yahoo.com';
                break;
        }

        $tags = [
            'body' => 'Username: KIKO',
        ];

        \Mail::send('emails.testing_from_routes', $tags, function ($message) use ($to) {
            $message
                ->from('admin@silvervee.net', 'silvervee.net')
                ->to(env('EMAIL_LOCAL', $to))
                ->subject('Testing email from AWS.');
        });

        return 'testing mail sent to: '.$to;
    });
    */

    /*****************************  Errors  *******************************/
    Route::get('404error', 'ErrorsController@error404')->name('404_error_path');


    /*****************************  Authentication  *******************************/

    Route::get('login', 'Auth\AuthController@showLoginForm')->name('login_path');
    Route::post('login', 'Auth\AuthController@login')->name('login_path');
    Route::get('logout', 'Auth\AuthController@logout')->name('logout_path');

    // Prevent auto-registering. Redirect to login:
    Route::match(['get', 'post'], 'register', function(){
        return redirect('login');
    });

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm')->name('reset_form_path');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail')->name('send_reset_link_path');
    Route::post('password/reset', 'Auth\PasswordController@reset')->name('reset_password_path');
    /** END Authentication */

    Route::match(['get', 'post'], 'lockout', 'Auth\IdleController@lockOut')->name('lockout_path');
    Route::post('unlock', 'Auth\IdleController@unlock')->name('unlock_path')->middleware('GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:2,1');


    /***********************************  Main  ***********************************/

    Route::get('/', 'MainController@home')->name('base_path');
    Route::get('home', 'MainController@home')->name('home_path');
    Route::post('uploadinsertedimage', 'MainController@uploadInsertedImage')->name('main_uploadinsertedimage_path');

    Route::get('language/{l}', 'LanguagesController@language')->name('language_en_path');
    Route::get('idioma/{l}', 'LanguagesController@language')->name('language_sp_path');
    /** END Main */


    /***********************************  Users  ***********************************/

    Route::group(['prefix' => 'users'], function () {
        Route::post('/uploadCanvas', 'UsersController@uploadCanvas')->name('user_upload_canvas_path');
        Route::post('/deleteCanvas', 'UsersController@deleteCanvas')->name('user_delete_canvas_path');
        Route::post('/ajaxfetchrolesprivileges', 'UsersController@ajaxFetchRolesPrivileges')->name('user_fetch_roles_privileges_path');
        Route::get('/', 'UsersController@index')->name('user_list_path');
        Route::match(['get', 'post'], '/search', 'UsersController@search')->name('user_search_path');
        Route::get('profile', 'UsersController@profile')->name('user_profile_path');
        Route::patch('/profile/{user}', 'UsersController@updateProfile')->name('user_update_profile_path');
        Route::get('/create', 'UsersController@create')->name('user_create_path');
        Route::get('/{user}', 'UsersController@show')->name('user_show_path');
        Route::post('/', 'UsersController@store')->name('user_store_path');
        Route::get('/{user}/edit', 'UsersController@edit')->name('user_edit_path');
        Route::get('/{id}/togglestatus', 'UsersController@toggleStatus')->name('user_toggle_status_path');
        Route::post('/inlineupdate', 'UsersController@inlineUpdate')->name('user_inline_update_path');
        Route::patch('/{user}', 'UsersController@update')->name('user_update_path');
        Route::delete('/', 'UsersController@destroy')->name('user_delete_path');
    });
    /** END Users */


    /*********************************** Roles   ***********************************/

    Route::group(['prefix' => 'roles'], function () {
        Route::post('/ajaxcreatefetchprivileges', 'RolesController@ajaxCreateFetchPrivileges')->name('role_create_fetch_privileges_path');
        Route::post('/ajaxeditfetchprivileges', 'RolesController@ajaxEditFetchPrivileges')->name('role_edit_fetch_privileges_path');
        Route::get('/', 'RolesController@index')->name('role_list_path');
        Route::match(['get', 'post'], '/search', 'RolesController@search')->name('role_search_path');
        Route::get('/create', 'RolesController@create')->name('role_create_path');
        Route::post('/', 'RolesController@store')->name('role_store_path');
        Route::post('/inlineupdate', 'RolesController@inlineUpdate')->name('role_inline_update_path');
        Route::get('/{role}/edit', 'RolesController@edit')->name('role_edit_path');
        Route::get('/{id}/togglestatus', 'RolesController@toggleStatus')->name('role_toggle_status_path');
        Route::patch('/{role}', 'RolesController@update')->name('role_update_path');
        Route::delete('/', 'RolesController@destroy')->name('role_delete_path');
    });
    /** END Roles */


    /***********************************  Privileges  ***********************************/

    Route::group(['prefix' => 'privileges'], function () {
        Route::get('/', 'PrivilegesController@index')->name('privilege_list_path');
        Route::match(['get', 'post'], '/search', 'PrivilegesController@search')->name('privilege_search_path');
        Route::get('/create', 'PrivilegesController@create')->name('privilege_create_path');
        Route::post('/', 'PrivilegesController@store')->name('privilege_store_path');
        Route::get('/{privilege}/edit', 'PrivilegesController@edit')->name('privilege_edit_path');
        Route::get('/{id}/togglestatus', 'PrivilegesController@toggleStatus')->name('privilege_toggle_status_path');
        Route::post('/inlineupdate', 'PrivilegesController@inlineUpdate')->name('privilege_inline_update_path');
        Route::delete('/', 'PrivilegesController@destroy')->name('privilege_delete_path');
    });
    /** END Privileges */


    /***********************************  Config  ***********************************/

    Route::group(['prefix' => 'config'], function () {
        Route::get('/', 'ConfigController@index')->name('config_list_path');
        Route::match(['get', 'post'], '/search', 'ConfigController@search')->name('config_search_path');
        Route::get('/create', 'ConfigController@create')->name('config_create_path');
        Route::get('/{config}', 'ConfigController@show')->name('config_show_path');
        Route::post('/', 'ConfigController@store')->name('config_store_path');
        Route::post('/inlineupdate', 'ConfigController@inlineUpdate')->name('config_inline_update_path');
        Route::get('/{id}/togglestatus', 'ConfigController@toggleStatus')->name('config_toggle_status_path');
        Route::delete('/', 'ConfigController@destroy')->name('config_delete_path');
    });
    /** END Config */

    
    /*************  Logins  ***************/

    Route::group(['prefix' => 'logins'], function () {
        Route::get('/', 'LoginsController@index')->name('login_list_path');
        Route::match(['get', 'post'], '/search', 'LoginController@search')->name('login_search_path');
    });
    /** END Logins */


    /*************  Logs  ***************/

    Route::group(['prefix' => 'logs'], function () {
        Route::get('/', 'LogsController@index')->name('log_list_path');
        Route::match(['get', 'post'], '/search', 'LogsController@search')->name('log_search_path');
        Route::get('/show/{log}', 'LogsController@show')->name('log_show_path');
    });
    /** END Logs */


    
    /**
     * 
     *      Lookup Table Section  
     *
     */


    /***********************************  Actions  ***********************************/

    Route::group(['prefix' => 'actions'], function () {
        Route::get('/', 'ActionsController@index')->name('action_list_path');
        Route::match(['get', 'post'], '/search', 'ActionsController@search')->name('action_search_path');
        Route::get('/show/{action}', 'ActionsController@show')->name('action_show_path');
        Route::get('/create', 'ActionsController@create')->name('action_create_path');
        Route::post('/', 'ActionsController@store')->name('action_store_path');
        Route::post('/inlineupdate', 'ActionsController@inlineUpdate')->name('action_inline_update_path');
        Route::delete('/', 'ActionsController@destroy')->name('action_delete_path');
    });
    /** END Actions */


    /***********************************  AddressTypes  ***********************************/

    Route::group(['prefix' => 'addresstypes'], function () {
        Route::get('/', 'AddressTypesController@index')->name('address_type_list_path');
        Route::match(['get', 'post'], '/search', 'AddressTypesController@search')->name('address_type_search_path');
        Route::get('/create', 'AddressTypesController@create')->name('address_type_create_path');
        Route::post('/', 'AddressTypesController@store')->name('address_type_store_path');
        Route::get('/{id}/togglestatus', 'AddressTypesController@toggleStatus')->name('address_type_toggle_status_path');
        Route::post('/inlineupdate', 'AddressTypesController@inlineUpdate')->name('address_type_inline_update_path');
        Route::delete('/', 'AddressTypesController@destroy')->name('address_type_delete_path');
    });
    /** END Addresstypes */


    /***********************************  Bodies  ***********************************/

    Route::group(['prefix' => 'certifyingboards'], function () {
        Route::get('/', 'BodiesController@index')->name('body_list_path');
        Route::match(['get', 'post'], '/search', 'BodiesController@search')->name('body_search_path');
        Route::get('/create', 'BodiesController@create')->name('body_create_path');
        Route::post('/', 'BodiesController@store')->name('body_store_path');
        Route::get('/{id}/togglestatus', 'BodiesController@toggleStatus')->name('body_toggle_status_path');
        Route::post('/inlineupdate', 'BodiesController@inlineUpdate')->name('body_inline_update_path');
        Route::delete('/', 'BodiesController@destroy')->name('body_delete_path');
    });
    /** END Bodies */


    /***********************************  Certifications  ***********************************/

    Route::group(['prefix' => 'certifications'], function () {
        Route::get('/', 'CertificationsController@index')->name('certification_list_path');
        Route::match(['get', 'post'], '/search', 'CertificationsController@search')->name('certification_search_path');
        Route::get('/create', 'CertificationsController@create')->name('certification_create_path');
        Route::post('/', 'CertificationsController@store')->name('certification_store_path');
        Route::get('/{id}/togglestatus', 'CertificationsController@toggleStatus')->name('certification_toggle_status_path');
        Route::post('/inlineupdate', 'CertificationsController@inlineUpdate')->name('certification_inline_update_path');
        Route::delete('/', 'CertificationsController@destroy')->name('certification_delete_path');
    });
    /** END Certifications */


    /***********************************  Conditions  ***********************************/

    Route::group(['prefix' => 'conditions'], function () {
        Route::get('/', 'ConditionsController@index')->name('condition_list_path');
        Route::match(['get', 'post'], '/search', 'ConditionsController@search')->name('condition_search_path');
        Route::get('/create', 'ConditionsController@create')->name('condition_create_path');
        Route::post('/', 'ConditionsController@store')->name('condition_store_path');
        Route::get('/{id}/togglestatus', 'ConditionsController@toggleStatus')->name('condition_toggle_status_path');
        Route::post('/inlineupdate', 'ConditionsController@inlineUpdate')->name('condition_inline_update_path');
        Route::delete('/', 'ConditionsController@destroy')->name('condition_delete_path');
    });
    /** END Conditions */


    /***********************************  Countries  ***********************************/

    Route::group(['prefix' => 'countries'], function () {
        Route::get('/', 'CountriesController@index')->name('country_list_path');
        Route::match(['get', 'post'], '/search', 'CountriesController@search')->name('country_search_path');
        Route::get('/create', 'CountriesController@create')->name('country_create_path');
        Route::post('/', 'CountriesController@store')->name('country_store_path');
        Route::get('/{id}/togglestatus', 'CountriesController@toggleStatus')->name('country_toggle_status_path');
        Route::post('/inlineupdate', 'CountriesController@inlineUpdate')->name('country_inline_update_path');
        Route::delete('/', 'CountriesController@destroy')->name('country_delete_path');
    });
    /** END Countries */


    /***********************************  Degrees  ***********************************/

    Route::group(['prefix' => 'degrees'], function () {
        Route::get('/', 'DegreesController@index')->name('degree_list_path');
        Route::match(['get', 'post'], '/search', 'DegreesController@search')->name('degree_search_path');
        Route::get('/create', 'DegreesController@create')->name('degree_create_path');
        Route::post('/', 'DegreesController@store')->name('degree_store_path');
        Route::get('/{id}/togglestatus', 'DegreesController@toggleStatus')->name('degree_toggle_status_path');
        Route::post('/inlineupdate', 'DegreesController@inlineUpdate')->name('degree_inline_update_path');
        Route::delete('/', 'DegreesController@destroy')->name('degree_delete_path');
    });
    /** END Degrees */
    
    
    /***********************************  Disciplines  ***********************************/

    Route::group(['prefix' => 'disciplines'], function () {
        Route::get('/', 'DisciplinesController@index')->name('discipline_list_path');
        Route::match(['get', 'post'], '/search', 'DisciplinesController@search')->name('discipline_search_path');
        Route::get('/create', 'DisciplinesController@create')->name('discipline_create_path');
        Route::post('/', 'DisciplinesController@store')->name('discipline_store_path');
        Route::get('/{id}/togglestatus', 'DisciplinesController@toggleStatus')->name('discipline_toggle_status_path');
        Route::post('/inlineupdate', 'DisciplinesController@inlineUpdate')->name('discipline_inline_update_path');
        Route::delete('/', 'DisciplinesController@destroy')->name('discipline_delete_path');
    });
    /** END Disciplines */
    

    /***********************************  Exams  ***********************************/

    Route::group(['prefix' => 'exams'], function () {
        Route::get('/', 'ExamsController@index')->name('exam_list_path');
        Route::match(['get', 'post'], '/search', 'ExamsController@search')->name('exam_search_path');
        Route::get('/create', 'ExamsController@create')->name('exam_create_path');
        Route::post('/', 'ExamsController@store')->name('exam_store_path');
        Route::get('/{id}/togglestatus', 'ExamsController@toggleStatus')->name('exam_toggle_status_path');
        Route::post('/inlineupdate', 'ExamsController@inlineUpdate')->name('exam_inline_update_path');
        Route::delete('/', 'ExamsController@destroy')->name('exam_delete_path');
    });
    /** END Exams */


    /***********************************  Customers  ***********************************/

    Route::group(['prefix' => 'customers'], function () {
        Route::get('/', 'CustomersController@index')->name('customer_list_path');
        Route::match(['get', 'post'], '/search', 'CustomersController@search')->name('customer_search_path');
        Route::get('/create', 'CustomersController@create')->name('customer_create_path');
        Route::post('/', 'CustomersController@store')->name('customer_store_path');
        Route::get('/{id}/togglestatus', 'CustomersController@toggleStatus')->name('customer_toggle_status_path');
        Route::post('/inlineupdate', 'CustomersController@inlineUpdate')->name('customer_inline_update_path');
        Route::delete('/', 'CustomersController@destroy')->name('customer_delete_path');
    });
    /** END Customers */


    /***********************************  Document Types  ***********************************/

    Route::group(['prefix' => 'documenttypes'], function () {
        Route::get('/', 'DocumentTypesController@index')->name('document_type_list_path');
        Route::match(['get', 'post'], '/search', 'DocumentTypesController@search')->name('document_type_search_path');
        Route::get('/create', 'DocumentTypesController@create')->name('document_type_create_path');
        Route::post('/', 'DocumentTypesController@store')->name('document_type_store_path');
        Route::get('/{id}/togglestatus', 'DocumentTypesController@toggleStatus')->name('document_type_toggle_status_path');
        Route::post('/inlineupdate', 'DocumentTypesController@inlineUpdate')->name('document_type_inline_update_path');
        Route::delete('/', 'DocumentTypesController@destroy')->name('document_type_delete_path');
    });
    /** END Document Types */


    /***********************************  Document Action Types  ***********************************/

    Route::group(['prefix' => 'documentactiontypes'], function () {
        Route::get('/', 'DocumentActionTypesController@index')->name('document_action_type_list_path');
        Route::match(['get', 'post'], '/search', 'DocumentActionTypesController@search')->name('document_action_type_search_path');
        Route::get('/create', 'DocumentActionTypesController@create')->name('document_action_type_create_path');
        Route::post('/', 'DocumentActionTypesController@store')->name('document_action_type_store_path');
        Route::get('/{id}/togglestatus', 'DocumentActionTypesController@toggleStatus')->name('document_action_type_toggle_status_path');
        Route::post('/inlineupdate', 'DocumentActionTypesController@inlineUpdate')->name('document_action_type_inline_update_path');
        Route::delete('/', 'DocumentActionTypesController@destroy')->name('document_action_type_delete_path');
    });
    /** END Document Action Types */
    

    /***********************************  Offense Types  ***********************************/

    Route::group(['prefix' => 'offensetypes'], function () {
        Route::get('/', 'OffenseTypesController@index')->name('offense_type_list_path');
        Route::match(['get', 'post'], '/search', 'OffenseTypesController@search')->name('offense_type_search_path');
        Route::get('/create', 'OffenseTypesController@create')->name('offense_type_create_path');
        Route::post('/', 'OffenseTypesController@store')->name('offense_type_store_path');
        Route::get('/{id}/togglestatus', 'OffenseTypesController@toggleStatus')->name('offense_type_toggle_status_path');
        Route::post('/inlineupdate', 'OffenseTypesController@inlineUpdate')->name('offense_type_inline_update_path');
        Route::delete('/', 'OffenseTypesController@destroy')->name('offense_type_delete_path');
    });
    /** END Offense Types */
    

    /***********************************  Policy Types  ***********************************/

    Route::group(['prefix' => 'policytypes'], function () {
        Route::get('/', 'PolicyTypesController@index')->name('policy_type_list_path');
        Route::match(['get', 'post'], '/search', 'PolicyTypesController@search')->name('policy_type_search_path');
        Route::get('/create', 'PolicyTypesController@create')->name('policy_type_create_path');
        Route::post('/', 'PolicyTypesController@store')->name('policy_type_store_path');
        Route::get('/{id}/togglestatus', 'PolicyTypesController@toggleStatus')->name('policy_type_toggle_status_path');
        Route::post('/inlineupdate', 'PolicyTypesController@inlineUpdate')->name('policy_type_inline_update_path');
        Route::delete('/', 'PolicyTypesController@destroy')->name('policy_type_delete_path');
    });
    /** END Policy Types */


    /***********************************  Credential Status  ***********************************/

    Route::group(['prefix' => 'credentialstatus'], function () {
        Route::get('/', 'CredentialStatusController@index')->name('credential_status_list_path');
        Route::match(['get', 'post'], '/search', 'CredentialStatusController@search')->name('credential_status_search_path');
        Route::get('/create', 'CredentialStatusController@create')->name('credential_status_create_path');
        Route::post('/', 'CredentialStatusController@store')->name('credential_status_store_path');
        Route::get('/{id}/togglestatus', 'CredentialStatusController@toggleStatus')->name('credential_status_toggle_status_path');
        Route::post('/inlineupdate', 'CredentialStatusController@inlineUpdate')->name('credential_status_inline_update_path');
        Route::delete('/', 'CredentialStatusController@destroy')->name('credential_status_delete_path');
    });
    /** END Credentialstatus */


    /***********************************  Insurers  ***********************************/

    Route::group(['prefix' => 'insurers'], function () {
        Route::get('/', 'InsurersController@index')->name('insurer_list_path');
        Route::match(['get', 'post'], '/search', 'InsurersController@search')->name('insurer_search_path');
        Route::get('/create', 'InsurersController@create')->name('insurer_create_path');
        Route::post('/', 'InsurersController@store')->name('insurer_store_path');
        Route::get('/{insurer}/edit', 'InsurersController@edit')->name('insurer_edit_path');
        Route::get('/{id}/togglestatus', 'InsurersController@toggleStatus')->name('insurer_toggle_status_path');
        Route::post('/inlineupdate', 'InsurersController@inlineUpdate')->name('insurer_inline_update_path');
        Route::patch('/{insurer}', 'InsurersController@update')->name('insurer_update_path');
        Route::delete('/', 'InsurersController@destroy')->name('insurer_delete_path');
    });
    /** END Insurers */


    /***********************************  Identifications  ***********************************/

    Route::group(['prefix' => 'identications'], function () {
        Route::get('/', 'IdentificationsController@index')->name('identification_list_path');
        Route::match(['get', 'post'], '/search', 'IdentificationsController@search')->name('identification_search_path');
        Route::get('/create', 'IdentificationsController@create')->name('identification_create_path');
        Route::post('/', 'IdentificationsController@store')->name('identification_store_path');
        Route::get('/{id}/togglestatus', 'IdentificationsController@toggleStatus')->name('identification_toggle_status_path');
        Route::post('/inlineupdate', 'IdentificationsController@inlineUpdate')->name('identification_inline_update_path');
        Route::delete('/', 'IdentificationsController@destroy')->name('identification_delete_path');
    });
    /** END Identifications */


    /***********************************  InternshipTypes  ***********************************/

    Route::group(['prefix' => 'internshiptypes'], function () {
        Route::get('/', 'InternshipTypesController@index')->name('internship_type_list_path');
        Route::match(['get', 'post'], '/search', 'InternshipTypesController@search')->name('internship_type_search_path');
        Route::get('/create', 'InternshipTypesController@create')->name('internship_type_create_path');
        Route::post('/', 'InternshipTypesController@store')->name('internship_type_store_path');
        Route::get('/{id}/togglestatus', 'InternshipTypesController@toggleStatus')->name('internship_type_toggle_status_path');
        Route::post('/inlineupdate', 'InternshipTypesController@inlineUpdate')->name('internship_type_inline_update_path');
        Route::delete('/', 'InternshipTypesController@destroy')->name('internship_type_delete_path');
    });
    /** END InternshipTypes */


    /***********************************  Languages  ***********************************/

    Route::group(['prefix' => 'languages'], function () {
        Route::get('/', 'LanguagesController@index')->name('language_list_path');
        Route::match(['get', 'post'], '/search', 'LanguagesController@search')->name('language_search_path');
        Route::get('/create', 'LanguagesController@create')->name('language_create_path');
        Route::post('/', 'LanguagesController@store')->name('language_store_path');
        Route::get('/{id}/togglestatus', 'LanguagesController@toggleStatus')->name('language_toggle_status_path');
        Route::post('/inlineupdate', 'LanguagesController@inlineUpdate')->name('language_inline_update_path');
        Route::delete('/', 'LanguagesController@destroy')->name('language_delete_path');
    });
    /** END Languages */



    /***********************************  Procedures  ***********************************/

    Route::group(['prefix' => 'procedures'], function () {
        Route::get('/', 'ProceduresController@index')->name('procedure_list_path');
        Route::match(['get', 'post'], '/search', 'ProceduresController@search')->name('procedure_search_path');
        Route::get('/create', 'ProceduresController@create')->name('procedure_create_path');
        Route::post('/', 'ProceduresController@store')->name('procedure_store_path');
        Route::get('/{id}/togglestatus', 'ProceduresController@toggleStatus')->name('procedure_toggle_status_path');
        Route::post('/inlineupdate', 'ProceduresController@inlineUpdate')->name('procedure_inline_update_path');
        Route::delete('/', 'ProceduresController@destroy')->name('procedure_delete_path');
    });
    /** END Procedures */


    /***********************************  Schools  ***********************************/

    Route::group(['prefix' => 'schools'], function () {
        Route::get('/', 'SchoolsController@index')->name('school_list_path');
        Route::match(['get', 'post'], '/search', 'SchoolsController@search')->name('school_search_path');
        Route::get('/create', 'SchoolsController@create')->name('school_create_path');
        Route::post('/', 'SchoolsController@store')->name('school_store_path');
        Route::get('/{school}/edit', 'SchoolsController@edit')->name('school_edit_path');
        Route::get('/{id}/togglestatus', 'SchoolsController@toggleStatus')->name('school_toggle_status_path');
        Route::post('/inlineupdate', 'SchoolsController@inlineUpdate')->name('school_inline_update_path');
        Route::patch('/{school}', 'SchoolsController@update')->name('school_update_path');
        Route::delete('/', 'SchoolsController@destroy')->name('school_delete_path');
    });
    /** END Schools */


    /***********************************  SpecialityTypes  ***********************************/

    Route::group(['prefix' => 'specialitytypes'], function () {
        Route::get('/', 'SpecialityTypesController@index')->name('speciality_type_list_path');
        Route::match(['get', 'post'], '/search', 'SpecialityTypesController@search')->name('speciality_type_search_path');
        Route::get('/create', 'SpecialityTypesController@create')->name('speciality_type_create_path');
        Route::post('/', 'SpecialityTypesController@store')->name('speciality_type_store_path');
        Route::get('/{id}/togglestatus', 'SpecialityTypesController@toggleStatus')->name('speciality_type_toggle_status_path');
        Route::post('/inlineupdate', 'SpecialityTypesController@inlineUpdate')->name('speciality_type_inline_update_path');
        Route::delete('/', 'SpecialityTypesController@destroy')->name('speciality_type_delete_path');
    });
    /** END SpecialityTypes */


    /***********************************  Speciality Subtypes  ***********************************/

    Route::group(['prefix' => 'specialitysubtypes'], function () {
        Route::get('/{speciality_type_id}', 'SpecialitySubtypesController@index')->name('speciality_subtype_list_path');
        Route::match(['get', 'post'], '/search/{speciality_type_id}', 'SpecialitySubtypesController@search')->name('speciality_subtype_search_path');
        Route::get('/create/{speciality_type_id}', 'SpecialitySubtypesController@create')->name('speciality_subtype_create_path');
        Route::post('/', 'SpecialitySubtypesController@store')->name('speciality_subtype_store_path');
        Route::get('/{id}/togglestatus', 'SpecialitySubtypesController@toggleStatus')->name('speciality_subtype_toggle_status_path');
        Route::post('/inlineupdate', 'SpecialitySubtypesController@inlineUpdate')->name('speciality_subtype_inline_update_path');
        Route::post('/fetch', 'SpecialitySubtypesController@fetch')->name('speciality_subtype_fetch_path');
        Route::delete('/', 'SpecialitySubtypesController@destroy')->name('speciality_subtype_delete_path');
    });
    /** END Speciality Subtypes */


    /***********************************  States  ***********************************/

    Route::group(['prefix' => 'states'], function () {
        Route::get('/{country_id}', 'StatesController@index')->name('state_list_path');
        Route::match(['get', 'post'], '/search/{country_id}', 'StatesController@search')->name('state_search_path');
        Route::get('/create/{country_id}', 'StatesController@create')->name('state_create_path');
        Route::post('/', 'StatesController@store')->name('state_store_path');
        Route::get('/{id}/togglestatus', 'StatesController@toggleStatus')->name('state_toggle_status_path');
        Route::post('/inlineupdate', 'StatesController@inlineUpdate')->name('state_inline_update_path');
        Route::post('/fetch', 'StatesController@fetch')->name('state_fetch_path');
        Route::delete('/', 'StatesController@destroy')->name('state_delete_path');
    });
    /** END States */


    
    /**
     *
     *      Provider Directory Section
     *
     */


    /***********************************  Providers  ***********************************/

    Route::group(['prefix' => 'providers'], function () {
        Route::get('/', 'ProvidersController@index')->name('provider_list_path');
        Route::match(['get', 'post'], '/search', 'ProvidersController@search')->name('provider_search_path');
        Route::get('/{provider}/show', 'ProvidersController@show')->name('provider_show_path');
        Route::get('/create', 'ProvidersController@create')->name('provider_create_path');
        Route::post('/', 'ProvidersController@store')->name('provider_store_path');
        Route::get('/{provider}/edit', 'ProvidersController@edit')->name('provider_edit_path');
        Route::patch('/{provider}', 'ProvidersController@update')->name('provider_update_path');
        Route::delete('/', 'ProvidersController@destroy')->name('provider_delete_path');
        Route::get('/excel', 'ProvidersController@exportToExcel')->name('provider_to_excel_path');
        Route::get('/pdf', 'ProvidersController@exportToPdf')->name('provider_to_pdf_path');
    });
    /** END Providers */


    /***********************************  Provider Addresses  ***********************************/

    Route::model('provideraddress', 'App\ProviderAddress');

    Route::group(['prefix' => 'provideraddresses'], function () {
        Route::get('/{provider_id}', 'ProviderAddressesController@index')->name('provider_address_list_path');
        Route::match(['get', 'post'], '/search/{provider_id}', 'ProviderAddressesController@search')->name('provider_address_search_path');
        Route::get('/create/{provider_id}', 'ProviderAddressesController@create')->name('provider_address_create_path');
        Route::post('/', 'ProviderAddressesController@store')->name('provider_address_store_path');
        Route::get('/{provideraddress}/edit', 'ProviderAddressesController@edit')->name('provider_address_edit_path');
        Route::patch('/{provideraddress}', 'ProviderAddressesController@update')->name('provider_address_update_path');
        Route::delete('/', 'ProviderAddressesController@destroy')->name('provider_address_delete_path');
    });
    /** END Provider_addresses */
    

    /***********************************  Provider Conditions  ***********************************/

    Route::model('providercondition', 'App\ProviderCondition');

    Route::group(['prefix' => 'providerconditions'], function () {
        Route::get('/{provider_id}', 'ProviderConditionsController@index')->name('provider_condition_list_path');
        Route::match(['get', 'post'], '/search/{provider_id}', 'ProviderConditionsController@search')->name('provider_condition_search_path');
        Route::get('/create/{provider_id}', 'ProviderConditionsController@create')->name('provider_condition_create_path');
        Route::post('/', 'ProviderConditionsController@store')->name('provider_condition_store_path');
        Route::get('/{providercondition}/edit', 'ProviderConditionsController@edit')->name('provider_condition_edit_path');
        Route::patch('/{providercondition}', 'ProviderConditionsController@update')->name('provider_condition_update_path');
        Route::post('/inlineupdate', 'ProviderConditionsController@inlineUpdate')->name('provider_condition_inline_update_path');
        Route::delete('/', 'ProviderConditionsController@destroy')->name('provider_condition_delete_path');
    });
    /** END Provider_conditions */
    
    
    /***********************************  Provider Malpractices  ***********************************/

    Route::model('providermalpractice', 'App\ProviderMalpractice');

    Route::group(['prefix' => 'providermalpractices'], function () {
        Route::get('/{provider_id}', 'ProviderMalpracticesController@index')->name('provider_malpractice_list_path');
        Route::match(['get', 'post'], '/search/{provider_id}', 'ProviderMalpracticesController@search')->name('provider_malpractice_search_path');
        Route::get('/create/{provider_id}', 'ProviderMalpracticesController@create')->name('provider_malpractice_create_path');
        Route::post('/', 'ProviderMalpracticesController@store')->name('provider_malpractice_store_path');
        Route::get('/{providermalpractice}/edit', 'ProviderMalpracticesController@edit')->name('provider_malpractice_edit_path');
        Route::patch('/{providermalpractice}', 'ProviderMalpracticesController@update')->name('provider_malpractice_update_path');
        Route::delete('/', 'ProviderMalpracticesController@destroy')->name('provider_malpractice_delete_path');
    });
    /** END Provider_malpractices */


    /***********************************  Provider Malpractice Judgements  ***********************************/

    Route::model('providermalpracticejudgement', 'App\ProviderMalpracticeJudgement');

    Route::group(['prefix' => 'providermalpracticejudgements'], function () {
        Route::get('/{malpractice_id}', 'ProviderMalpracticeJudgementsController@index')->name('provider_malpractice_judgement_list_path');
        Route::match(['get', 'post'], '/search/{malpractice_id}', 'ProviderMalpracticeJudgementsController@search')->name('provider_malpractice_judgement_search_path');
        Route::get('/create/{malpractice_id}', 'ProviderMalpracticeJudgementsController@create')->name('provider_malpractice_judgement_create_path');
        Route::post('/', 'ProviderMalpracticeJudgementsController@store')->name('provider_malpractice_judgement_store_path');
        Route::get('/{providermalpracticejudgement}/edit', 'ProviderMalpracticeJudgementsController@edit')->name('provider_malpractice_judgement_edit_path');
        Route::patch('/{providermalpracticejudgement}', 'ProviderMalpracticeJudgementsController@update')->name('provider_malpractice_judgement_update_path');
        Route::delete('/', 'ProviderMalpracticeJudgementsController@destroy')->name('provider_malpractice_judgement_delete_path');
    });
    /** END Provider Malpractice Judgements */
    

    /***********************************  Provider References  ***********************************/

    Route::model('providerreference', 'App\ProviderReference');

    Route::group(['prefix' => 'providerreferences'], function () {
        Route::get('/{provider_id}', 'ProviderReferencesController@index')->name('provider_reference_list_path');
        Route::match(['get', 'post'], '/search/{provider_id}', 'ProviderReferencesController@search')->name('provider_reference_search_path');
        Route::get('/create/{provider_id}', 'ProviderReferencesController@create')->name('provider_reference_create_path');
        Route::post('/', 'ProviderReferencesController@store')->name('provider_reference_store_path');
        Route::get('/{providerreference}/edit', 'ProviderReferencesController@edit')->name('provider_reference_edit_path');
        Route::patch('/{providerreference}', 'ProviderReferencesController@update')->name('provider_reference_update_path');
        Route::post('/inlineupdate', 'ProviderReferencesController@inlineUpdate')->name('provider_reference_inline_update_path');
        Route::delete('/', 'ProviderReferencesController@destroy')->name('provider_reference_delete_path');
    });
    /** END Provider_references */


    /***********************************  Provider Procedures  ***********************************/

    Route::model('providerprocedure', 'App\ProviderProcedure');

    Route::group(['prefix' => 'providerprocedures'], function () {
        Route::get('/{provider_id}', 'ProviderProceduresController@index')->name('provider_procedure_list_path');
        Route::match(['get', 'post'], '/search/{provider_id}', 'ProviderProceduresController@search')->name('provider_procedure_search_path');
        Route::get('/create/{provider_id}', 'ProviderProceduresController@create')->name('provider_procedure_create_path');
        Route::post('/', 'ProviderProceduresController@store')->name('provider_procedure_store_path');
        Route::get('/{providerprocedure}/edit', 'ProviderProceduresController@edit')->name('provider_procedure_edit_path');
        Route::patch('/{providerprocedure}', 'ProviderProceduresController@update')->name('provider_procedure_update_path');
        Route::post('/inlineupdate', 'ProviderProceduresController@inlineUpdate')->name('provider_procedure_inline_update_path');
        Route::delete('/', 'ProviderProceduresController@destroy')->name('provider_procedure_delete_path');
    });
    /** END Provider_procedures */
    

    /***********************************  Provider Types  ***********************************/

    Route::group(['prefix' => 'providertypes'], function () {
        Route::get('/', 'ProviderTypesController@index')->name('provider_type_list_path');
        Route::match(['get', 'post'], '/search', 'ProviderTypesController@search')->name('provider_type_search_path');
        Route::get('/create', 'ProviderTypesController@create')->name('provider_type_create_path');
        Route::post('/', 'ProviderTypesController@store')->name('provider_type_store_path');
        Route::get('/{id}/togglestatus', 'ProviderTypesController@toggleStatus')->name('provider_type_toggle_status_path');
        Route::post('/inlineupdate', 'ProviderTypesController@inlineUpdate')->name('provider_type_inline_update_path');
        Route::delete('/', 'ProviderTypesController@destroy')->name('provider_type_delete_path');
    });
    /** END Provider_types */


    /***********************************  Provider Subtypes  ***********************************/

    Route::group(['prefix' => 'providersubtypes'], function () {
        Route::get('/{provider_type_id}', 'ProviderSubtypesController@index')->name('provider_subtype_list_path');
        Route::match(['get', 'post'], '/search/{provider_type_id}', 'ProviderSubtypesController@search')->name('provider_subtype_search_path');
        Route::get('/create/{provider_type_id}', 'ProviderSubtypesController@create')->name('provider_subtype_create_path');
        Route::post('/', 'ProviderSubtypesController@store')->name('provider_subtype_store_path');
        Route::get('/{id}/togglestatus', 'ProviderSubtypesController@toggleStatus')->name('provider_subtype_toggle_status_path');
        Route::post('/inlineupdate', 'ProviderSubtypesController@inlineUpdate')->name('provider_subtype_inline_update_path');
        Route::post('/fetch', 'ProviderSubtypesController@fetch')->name('provider_subtype_fetch_path');
        Route::delete('/', 'ProviderSubtypesController@destroy')->name('provider_subtype_delete_path');
    });
    /** END Provider Subtypes */
    

    /***********************************  Professional Affiliations  ***********************************/

    Route::model('professionalaffiliation', 'App\ProfessionalAffiliation');

    Route::group(['prefix' => 'professionalaffiliations'], function () {
        Route::get('/{professional_id}', 'ProfessionalAffiliationsController@index')->name('professional_affiliation_list_path');
        Route::match(['get', 'post'], '/search/{professional_id}', 'ProfessionalAffiliationsController@search')->name('professional_affiliation_search_path');
        Route::get('/create/{professional_id}', 'ProfessionalAffiliationsController@create')->name('professional_affiliation_create_path');
        Route::post('/', 'ProfessionalAffiliationsController@store')->name('professional_affiliation_store_path');
        Route::get('/{professionalaffiliation}/edit', 'ProfessionalAffiliationsController@edit')->name('professional_affiliation_edit_path');
        Route::patch('/{professionalaffiliation}', 'ProfessionalAffiliationsController@update')->name('professional_affiliation_update_path');
        Route::delete('/', 'ProfessionalAffiliationsController@destroy')->name('professional_affiliation_delete_path');
    });
    /** END Professional Affiliations */


    /***********************************  Professional Boards  ***********************************/

    Route::model('professionalboard', 'App\ProfessionalBoard');

    Route::group(['prefix' => 'professionalboards'], function () {
        Route::get('/{professional_id}', 'ProfessionalBoardsController@index')->name('professional_board_list_path');
        Route::match(['get', 'post'], '/search/{professional_id}', 'ProfessionalBoardsController@search')->name('professional_board_search_path');
        Route::get('/create/{professional_id}', 'ProfessionalBoardsController@create')->name('professional_board_create_path');
        Route::post('/', 'ProfessionalBoardsController@store')->name('professional_board_store_path');
        Route::get('/{professionalboard}/edit', 'ProfessionalBoardsController@edit')->name('professional_board_edit_path');
        Route::patch('/{professionalboard}', 'ProfessionalBoardsController@update')->name('professional_board_update_path');
        Route::post('/inlineupdate', 'ProfessionalBoardsController@inlineUpdate')->name('professional_board_inline_update_path');
        Route::delete('/', 'ProfessionalBoardsController@destroy')->name('professional_board_delete_path');
    });
    /** END Professional Boards */

    
    /***********************************  Professional Fellowships  ***********************************/

    Route::model('professionalfellowship', 'App\ProfessionalFellowship');

    Route::group(['prefix' => 'professionalfellowships'], function () {
        Route::get('/{professional_id}', 'ProfessionalFellowshipsController@index')->name('professional_fellowship_list_path');
        Route::match(['get', 'post'], '/search/{professional_id}', 'ProfessionalFellowshipsController@search')->name('professional_fellowship_search_path');
        Route::get('/create/{professional_id}', 'ProfessionalFellowshipsController@create')->name('professional_fellowship_create_path');
        Route::post('/', 'ProfessionalFellowshipsController@store')->name('professional_fellowship_store_path');
        Route::get('/{professionalfellowship}/edit', 'ProfessionalFellowshipsController@edit')->name('professional_fellowship_edit_path');
        Route::patch('/{professionalfellowship}', 'ProfessionalFellowshipsController@update')->name('professional_fellowship_update_path');
        Route::delete('/', 'ProfessionalFellowshipsController@destroy')->name('professional_fellowship_delete_path');
    });
    /** END Professional Fellowships */


    /***********************************  Professional Identifications  ***********************************/

    Route::group(['prefix' => 'professionalidentifications'], function () {
        Route::get('/{professional_id}', 'ProfessionalIdentificationsController@index')->name('professional_identification_list_path');
        Route::match(['get', 'post'], '/search/{professional_id}', 'ProfessionalIdentificationsController@search')->name('professional_identification_search_path');
        Route::get('/create/{professional_id}', 'ProfessionalIdentificationsController@create')->name('professional_identification_create_path');
        Route::post('/', 'ProfessionalIdentificationsController@store')->name('professional_identification_store_path');
        Route::post('/inlineupdate', 'ProfessionalIdentificationsController@inlineUpdate')->name('professional_identification_inline_update_path');
        Route::delete('/', 'ProfessionalIdentificationsController@destroy')->name('professional_identification_delete_path');
    });
    /** END Professional Identifications */


    /***********************************  Professional Internships  ***********************************/

    Route::model('professionalinternship', 'App\ProfessionalInternship');

    Route::group(['prefix' => 'professionalinternships'], function () {
        Route::get('/{professional_id}', 'ProfessionalInternshipsController@index')->name('professional_internship_list_path');
        Route::match(['get', 'post'], '/search/{professional_id}', 'ProfessionalInternshipsController@search')->name('professional_internship_search_path');
        Route::get('/create/{professional_id}', 'ProfessionalInternshipsController@create')->name('professional_internship_create_path');
        Route::post('/', 'ProfessionalInternshipsController@store')->name('professional_internship_store_path');
        Route::get('/{professionalinternship}/edit', 'ProfessionalInternshipsController@edit')->name('professional_internship_edit_path');
        Route::patch('/{professionalinternship}', 'ProfessionalInternshipsController@update')->name('professional_internship_update_path');
        Route::delete('/', 'ProfessionalInternshipsController@destroy')->name('professional_internship_delete_path');
    });
    /** END Professional Internships */


    /***********************************  Professional Residencies  ***********************************/

    Route::model('professionalresidency', 'App\ProfessionalResidency');

    Route::group(['prefix' => 'professionalresidencies'], function () {
        Route::get('/{professional_id}', 'ProfessionalResidenciesController@index')->name('professional_residency_list_path');
        Route::match(['get', 'post'], '/search/{professional_id}', 'ProfessionalResidenciesController@search')->name('professional_residency_search_path');
        Route::get('/create/{professional_id}', 'ProfessionalResidenciesController@create')->name('professional_residency_create_path');
        Route::post('/', 'ProfessionalResidenciesController@store')->name('professional_residency_store_path');
        Route::get('/{professionalresidency}/edit', 'ProfessionalResidenciesController@edit')->name('professional_residency_edit_path');
        Route::patch('/{professionalresidency}', 'ProfessionalResidenciesController@update')->name('professional_residency_update_path');
        Route::delete('/', 'ProfessionalResidenciesController@destroy')->name('professional_residency_delete_path');
    });
    /** END Professional Residencies */


    /***********************************  Professional Schools  ***********************************/

    Route::model('professionalschool', 'App\ProfessionalSchool');

    Route::group(['prefix' => 'professionalschools'], function () {
        Route::get('/{professional_id}', 'ProfessionalSchoolsController@index')->name('professional_school_list_path');
        Route::match(['get', 'post'], '/search/{professional_id}', 'ProfessionalSchoolsController@search')->name('professional_school_search_path');
        Route::get('/create/{professional_id}', 'ProfessionalSchoolsController@create')->name('professional_school_create_path');
        Route::post('/', 'ProfessionalSchoolsController@store')->name('professional_school_store_path');
        Route::get('/{professionalschool}/edit', 'ProfessionalSchoolsController@edit')->name('professional_school_edit_path');
        Route::patch('/{professionalschool}', 'ProfessionalSchoolsController@update')->name('professional_school_update_path');
        Route::post('/inlineupdate', 'ProfessionalSchoolsController@inlineUpdate')->name('professional_school_inline_update_path');
        Route::delete('/', 'ProfessionalSchoolsController@destroy')->name('professional_school_delete_path');
    });
    /** END Professional Schools */



    /**
     *
     *      Credential Section
     *
     */


    /***********************************  Credentials  ***********************************/

    Route::group(['prefix' => 'credentials'], function () {
        Route::get('/', 'CredentialsController@index')->name('credential_list_path');
        Route::match(['get', 'post'], '/search', 'CredentialsController@search')->name('credential_search_path');
        Route::get('/create', 'CredentialsController@create')->name('credential_create_path');
        Route::post('/', 'CredentialsController@store')->name('credential_store_path');
        Route::get('/{credential}/edit', 'CredentialsController@edit')->name('credential_edit_path');
        Route::post('/inlineupdate', 'CredentialsController@inlineUpdate')->name('credential_inline_update_path');
        Route::get('/setascomplete/{id}', 'CredentialsController@setascomplete')->name('credential_set_as_complete_path');
        Route::patch('/{credential}', 'CredentialsController@update')->name('credential_update_path');
    });
    /** END Credentials */


    /***********************************  Credential Documents  ***********************************/

    Route::group(['prefix' => 'credentialdocuments'], function () {
        Route::get('/{credential_id}', 'CredentialDocumentsController@index')->name('credential_document_list_path');
        Route::match(['get', 'post'], '/search/{credential_id}', 'CredentialDocumentsController@search')->name('credential_document_search_path');
        Route::get('/create/{credential_id}', 'CredentialDocumentsController@create')->name('credential_document_create_path');
        Route::post('/', 'CredentialDocumentsController@store')->name('credential_document_store_path');
        Route::delete('/', 'CredentialDocumentsController@destroy')->name('credential_document_delete_path');
    });
    /** END Credential Documents */


    /***********************************  Credential Document Actions  ***********************************/

    Route::model('credentialdocumentaction', 'App\CredentialDocumentAction');

    Route::group(['prefix' => 'credentialdocumentactions'], function () {
        Route::get('/{document_id}', 'CredentialDocumentActionsController@index')->name('credential_document_action_list_path');
        Route::match(['get', 'post'], '/search/{document_id}', 'CredentialDocumentActionsController@search')->name('credential_document_action_search_path');
        Route::get('/create/{document_id}', 'CredentialDocumentActionsController@create')->name('credential_document_action_create_path');
        Route::post('/', 'CredentialDocumentActionsController@store')->name('credential_document_action_store_path');
        Route::get('/{credentialdocumentaction}/edit', 'CredentialDocumentActionsController@edit')->name('credential_document_action_edit_path');
        Route::patch('/{credentialdocumentaction}', 'CredentialDocumentActionsController@update')->name('credential_document_action_update_path');
        Route::delete('/', 'CredentialDocumentActionsController@destroy')->name('credential_document_action_delete_path');
    });
    /** END Credential Document Actions */



    /**
     *
     *      Task Section
     *
     */


    /***********************************  Tasks  ***********************************/

    Route::group(['prefix' => 'tasks'], function () {
        Route::get('/', 'TasksController@index')->name('task_list_path');
        Route::match(['get', 'post'], '/search', 'TasksController@search')->name('task_search_path');
        Route::get('/show/{task}', 'TasksController@show')->name('task_show_path');
        Route::get('/create', 'TasksController@create')->name('task_create_path');
        Route::post('/', 'TasksController@store')->name('task_store_path');
        Route::get('/{task}/edit', 'TasksController@edit')->name('task_edit_path');
        Route::post('/togglestatus', 'TasksController@toggleStatus')->name('task_toggle_status_path');
        Route::post('/inlineupdate', 'TasksController@inlineUpdate')->name('task_inline_update_path');
        Route::patch('/{task}', 'TasksController@update')->name('task_update_path');
        Route::delete('/', 'TasksController@destroy')->name('task_delete_path');
    });
    /** END Tasks */


});




