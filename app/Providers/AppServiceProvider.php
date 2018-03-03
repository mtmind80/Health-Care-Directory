<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /** jText, jPassword, jTextarea & jCalendar params:
            'label',
            'id',
            'value',
            'hint',
            'required',
            'placeholder',
            'attributes' => [], // other field attributes
            'iconClass',
        */
        \Form::component('jText', 'components.form.text', ['name', 'params' => []]);
        \Form::component('jPassword', 'components.form.password', ['name', 'params' => []]);
        \Form::component('jTextarea', 'components.form.textarea', ['name', 'params' => []]);
        \Form::component('jCalendar', 'components.form.calendar', ['name', 'params' => []]);

        /** jSwitch params:
            'label',
            'id',
            'on',
            'off'
            'checked',
         */
        \Form::component('jSwitch', 'components.form.switch', ['name', 'params' => []]);

        /** jSelect params:
            'label',
            'id',
            'required',
            'attributes' => [], // other field attributes
            'iconClass',
         */
        \Form::component('jSelect', 'components.form.select', ['name', 'data', 'params' => []]);

        /** jDropzone params:
            'name',
            'class',
            'label',
            'hint',
            'image',
            'id',         // object (row) id
            'width',
            'height',
            'required',
            'originalSize',
            'resize',
         */
        \Form::component('jDropzone', 'components.form.dropzone', ['id', 'uploadUrl', 'removeUrl', 'token', 'params' => []]);

        /** jVerification params:
            'id',
            'name',
            'placeholder',
            'iconClass',
         */
        \Form::component('jVerification', 'components.form.verification', ['equation', 'params' => []]);

        /** jVerification params:
        'submit-id',
        'submit-label',
        'cancel-id',
        'cancel-label',
         */
        \Form::component('jCancelSubmit', 'components.form.cancel-submit', ['params' => []]);

        /** jVerification params:
        'submit-id',
        'submit-label',
         */
        \Form::component('jSubmit', 'components.form.submit', ['params' => []]);

        /** jCheckbox params:
        'label',
        'id',
        'title',  // add tooltip if defined
         */
        \Form::component('jCheckbox', 'components.form.checkbox', ['name', 'params' => []]);

        /** jMce params:
        'label',
        'value',
        'required', default: false
        'id',
        'hint',
        'title',
         */
        \Form::component('jMce', 'components.form.mce', ['name', 'params' => []]);

        /** jShow params:
        'label',
        'class',
         */
        \Form::component('jShow', 'components.form.show', ['value', 'params' => []]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
