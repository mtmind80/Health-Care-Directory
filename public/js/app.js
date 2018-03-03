$(document).ready(function () {
    "use strict";

    // Init Theme Core
    Core.init();

    handleBackToTop();
    showHidebackToTop();

    $(window).scroll(function() {
        showHidebackToTop();
    });

    /** change language */

    $('#language-widget').on('click', 'a', function () {
        var langId = $(this).attr('id');
        if (lang == langId) {
            $('#lang-button').click();
            return false;
        } else {
            window.location.href = base_url + 'language/' + langId;
        }
        $('#lang-button').click();
    });

    $('form').on('change', 'select', function () {
        if (!$(this).val()) {
            $(this).addClass('grayed');
        } else {
            $(this).removeClass('grayed');
        }
    });

    /** Spinner  (needs spinner.css) **/
    $(function(){
        var $window = $(window),
            width = $window.width(),
            height = $window.height();

        setInterval(function() {
            if ((width != $window.width()) || (height != $window.height())) {
                width = $window.width();
                height = $window.height();

                updateSpinnerDivSize();
            }
        }, 200);
    });
    
    /* END Spinner */

    // table list with column having action dropdown menu:

    $('table.list-table tbody tr td.actions').on('click', 'li.dropdown', function(){
        $('table.list-table tbody tr td.actions ul > li > a i.fa-angle-up').removeClass('fa-angle-up').addClass('fa-angle-down');
        if (!$(this).hasClass('open')) {
            $(this).find('a > i').removeClass('fa-angle-down').addClass('fa-angle-up');
        }
    });
    $(window).click(function(){
        $('table.list-table tbody tr td.actions ul > li > a i.fa-angle-up').removeClass('fa-angle-up').addClass('fa-angle-down');
    });
    /* example of event handler
    $('table.list-table tbody tr td.actions').on('click', 'a.action', function(){
        alert($(this).attr('data-action') + ': id= ' + $(this).attr('data-id'));
    });
    */

    $('.date-picker').datepicker({
        prevText: '<i class="fa fa-chevron-left"></i>',
        nextText: '<i class="fa fa-chevron-right"></i>',
        showButtonPanel: false
    });

    /** popover for i.help */
    $('.i-help').popover({
        placement: $(this).data('placement'),
        html: 'true',
        title: '<span class="text-info"><strong>Hint</strong></span> <button type="button" class="close">&times;</button>',
        content : $(this).data('content')
    });
    $('body').on('click', '.popover .close', function(){
        $(this).parents('.popover').popover('hide');
    });

    /** Implement datepicker with months and year selection using bootstrap
     *
     * needs:
     *   CSS: {!! Html::style($siteUrl . '/vendor/vendor/plugins/datepicker/css/bootstrap-datetimepicker.min.css') !!}
     *   JS:  {!! Html::script($siteUrl . '/vendor/vendor/plugins/datepicker/js/bootstrap-datetimepicker.min.js') !!}
     */
    $('.bootstrap-date-picker').datetimepicker({
        pickTime: false
    });

    /** define new validators */

    $.validator.addMethod('code', function(value, element) {
        return this.optional(element) || isCode(value);
    }, 'Invalid code');
});

/** other validation functions */

function isCode(value)
{
    return /^[a-zA-Z0-9]{1}[a-zA-Z0-9\-]*[a-zA-Z0-9]{1}$/.test(value);
}

/* tinyMCE */
function mceInit(selector, height)
{
    tinymce.init({
        selector: (typeof selector != 'undefined' ? selector : 'textarea'),
        height: (typeof height != 'undefined' ? height : 300),
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor | link image media',
        imagetools_toolbar: "imageoptions",
        image_advtab: true,
        templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
        ],
        content_css: [
            '//fonts.googleapis.com/css?family=Open+Sans:400,600,700',
            site_url + '/css/mce.css',
        ],
        //menubar: 'edit insert view format table tools',
        menu: {
            //file: {title: 'File', items: 'newdocument'},
            edit: {title: 'Edit', items: 'cut copy paste pastetext | selectall'},
            insert: {title: 'Insert', items: 'link media image | hr'},
            view: {title: 'View', items: 'preview | code'},
            format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
            table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'}
        },
        statusbar: false,
        file_browser_callback: function(field_name, url, type){
            if (type == 'image') {
                if ($('mceImageUploadForm').size() == 0) {
                    var html = '<form id="mceImageUploadForm" style="display: none;"><input class="mceImage" name="mceImage" id="mceImage" type="file"></form>';
                    $('body').append(html);
                }
                $('#mceImageUploadForm input[type="file"]').click();
            }
        }
    });
}
function mceUploadFileInit(url, token)
{
    $('body').on('change', '.mceImage', function(){
        var formData = new FormData($('#mceImageUploadForm')[0]);

        $.ajax({
            headers: {'X-XSRF-TOKEN': token},
            data: formData,
            type: "POST",
            url: url,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (request){
                showSpinner();
            },
            complete: function(){
                hideSpinner();
                $('#mceImageUploadForm').remove();
            },
            success: function(response) {
                var result = $.parseJSON(response);
                if (result.success) {
                    $('.mce-combobox .mce-textbox').val(result.url);
                } else {
                    alert(result.message);
                }
            }
        });
    });
}
/* END tinyMCE */

function updateSpinnerDivSize()
{
    $('#spinner').css({
        width : $(window).width(),
        height: $(window).height()
    })
}
function showSpinner()
{
    $('body').append('<div id="spinner"></div>');
    updateSpinnerDivSize();
}
function hideSpinner()
{
    $('#spinner').remove();
}
function handleBackToTop()
{
    $('#back-to-top').click(function(){
        $('html, body').animate({scrollTop:0}, 'slow');
        return false;
    });
}
function showHidebackToTop()
{
    if ($(window).scrollTop() > $(window).height() / 2 ) {
        $("#back-to-top").removeClass('gone');
        $("#back-to-top").addClass('visible');
    } else {
        $("#back-to-top").removeClass('visible');
        $("#back-to-top").addClass('gone');
    }
}

var pastedContent = false;

function cleanPastedText(str)
{
    $('body').prepend('<div id="tmpPastedTextContainer" style="display: none;"></div>');
    $('#tmpPastedTextContainer').html(str);
    str = $('#tmpPastedTextContainer').text();
    $('#tmpPastedTextContainer').remove();
    str = str.replace(/\n+/g, '<br>').replace(/.*<!--.*-->/g, '');
    for (i = 0; i < 10; i++) {
        if (str.substr(0, 4) == '<br>') {
            str = str.replace('<br>', '');
        }
    }
    return str;
}

