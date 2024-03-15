$(document).ready(function ()
{
    // Bootstrap tooltip
    $(".tip").tooltip({placement: 'top', trigger: 'hover'});
    $(".tipb").tooltip({placement: 'bottom', trigger: 'hover'});
    $(".tipl").tooltip({placement: 'left', trigger: 'hover'});
    $(".tipr").tooltip({placement: 'right', trigger: 'hover'});
    if ($('#main_calendar').length > 0)
    {
        // fullcalendar
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var calendar = $('#main_calendar').fullCalendar({
            header: {
                left: 'prev,next',
                center: 'title',
                right: '',
                right: 'month,agendaWeek,agendaDay'
            },
            selectable: true,
            selectHelper: true,
            select: function (start, end)
            {
                $('#fcAddEvent').modal('show');
                $("#fcAddEventButton").click(function ()
                {
                    var title = $("#fcAddEventTitle").val();
                    if (title)
                    {
                        calendar.fullCalendar('renderEvent',
                                {
                                    title: title,
                                    start: start,
                                    end: end
                                }, true
                                );
                        notify('Fullcalendar', 'New Event: ' + title + ';<br/>start: ' + start + ';<br/>end: ' + end + ';');
                    }
                    $('#fcAddEvent').modal('hide');
                    $("#fcAddEventTitle").val('');
                    calendar.fullCalendar('unselect');
                });
            },
            editable: true,
            eventDrop: function (event, delta)
            {
                notify('Fullcalendar', 'Event: ' + event.title + ' = ' + delta);
            },
            //eventSources: ['php/ajax_fullcalendar.php']            
            events: {
                url: "php/ajax_fullcalendar.php",
                success: function ()
                {
                    notify('Fullcalendar', 'Success ajax load');
                }
            }
        });
    }
    // Pnotify notifier
    $.pnotify.defaults.history = false;
    $.pnotify.defaults.delay = 3000;
    // Fancybox
    if ($("a.fb").length > 0)
    {
        $("a.fb").fancybox({padding: 10,
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 600,
            'speedOut': 200
        });
    }
    // Uniform
    $("input:checkbox, input:radio").not('input.ibtn').not('.switchx').not('.twg input').not('input[type=checkbox].sck').uniform();
    // Select2
    if ($(".select").length > 0)
    {
        $(".select").select2({'placeholder': 'Please Select', 'width': '300px'});
        $(".select").on("change", function (e)
        {
            // notify('Select', 'Value changed: ' +e.added.text);
            notify('Select', 'Value changed: ' + e.val);
        });
    }

    // Masked input        
    if ($("input[class^=mask_]").length > 0)
    {
        $("input.mask_tin").mask('99-9999999', {completed: function ()
            {
                notify('Masked input', 'mask_tin completed');
            }});
        $("input.mask_ssn").mask('999-99-9999', {completed: function ()
            {
                notify('Masked input', 'mask_ssn completed');
            }});
        $("input.mask_date").mask('9999-99-99', {completed: function ()
            {
                notify('Masked input', 'mask_date completed');
            }});
        $("input.mask_product").mask('a*-999-a999', {completed: function ()
            {
                notify('Masked input', 'mask_product completed');
            }});
        $("input.mask_mobile").mask('9999999999', {completed: function ()
            {
                notify('Masked input', 'mask_mobile completed');
            }});
        $("input.mask_phone").mask('99 (999) 999-99-99', {completed: function ()
            {
                notify('Masked input', 'mask_phone completed');
            }});
        $("input.mask_phone_ext").mask('99 (999) 999-9999? x99999', {completed: function ()
            {
                notify('Masked input', 'mask_phone_ext completed');
            }});
        $("input.mask_credit").mask('9999-9999-9999-9999', {completed: function ()
            {
                notify('Masked input', 'mask_credit completed');
            }});
        $("input.mask_percent").mask('99%', {completed: function ()
            {
                notify('Masked input', 'mask_percent completed');
            }});
    }
    // Multiselect    
    if ($("#ms").length > 0)
        $("#ms").multiSelect({
            afterSelect: function (value, text)
            {
                notify('Multiselect', 'Selected: ' + text + '[' + value + ']');
            },
            afterDeselect: function (value, text)
            {
                notify('Multiselect', 'Deselected: ' + text + '[' + value + ']');
            }});
    if ($("#msc").length > 0)
    {
        $("#msc").multiSelect({
            selectableHeader: "<div class='multipleselect-header'>Selectable item</div>",
            selectedHeader: "<div class='multipleselect-header'>Selected items</div>",
            afterSelect: function (value, text)
            {
                notify('Multiselect', 'Selected: ' + text + '[' + value + ']');
            },
            afterDeselect: function (value, text)
            {
                notify('Multiselect', 'Deselected: ' + text + '[' + value + ']');
            }
        });
        $("#ms_select").click(function ()
        {
            $('#msc').multiSelect('select_all');
        });
        $("#ms_deselect").click(function ()
        {
            $('#msc').multiSelect('deselect_all');
        });
    }
    // Validation
    if ($("#validate").length > 0)
        $("#validate, #validate_custom").validationEngine('attach', {promptPosition: "topLeft"});
    // Wizard
    if ($("#wizard").length > 0)
        $('#wizard').stepy();
    if ($("#wizard_validate").length > 0)
    {
        $("#wizard_validate").validationEngine('attach', {promptPosition: "topLeft"});
        $('#wizard_validate').stepy({
            back: function (index)
            {
                //if(!$("#wizard_validate").validationEngine('validate')) return false; //uncomment if u need to validate on back click                
            },
            next: function (index)
            {
                if (!$("#wizard_validate").validationEngine('validate'))
                    return false;
            },
            finish: function (index)
            {
                if (!$("#wizard_validate").validationEngine('validate'))
                    return false;
                var postData = $("#wizard_validate").serialize();
                var opr = $('#ad_finish').attr('title'); //determine whether Create or Edit Operation
                if (opr == 'create')
                {
                    $.ajax({
                        type: 'POST',
                        url: BASE_URL + 'admin/admission/ajax_save/',
                        data: postData,
                        success: function (data)
                        {
                            //console.log(data);
                            notify('New Admission', 'Admission Data Saved:<br/>');
                            window.location.href = BASE_URL + 'admin/admission/';
                        }
                    });
                }
                else if (opr == 'edit')
                {
                    var REC = $('#opr').attr('title');
                    $.ajax({
                        type: 'POST',
                        url: BASE_URL + 'admin/admission/ajax_edit/' + REC,
                        data: postData,
                        success: function (data)
                        {
                            console.log(data);
                            notify('Update Admission Record', 'Admission Data Updated Successfully:<br/>');
                            window.location.href = BASE_URL + 'admin/admission/';
                        }
                    });
                }
                else
                {
                    //
                }
            }
        });
    }
    // accordion
    if ($(".accordion").length > 0)
        $(".accordion").accordion({heightStyle: "content"});
    // eof accordion
    // tabs
    if ($(".tabs").length > 0)
        $(".tabs").tabs();
    // eof tabs
    // sortable    
    if ($("#sort_1").length > 0)
    {
        $("#sort_1").sortable();
        $("#sort_1").disableSelection();
    }
    // eof sortable
    // selectable 
    if ($("#select_1").length > 0)
        $("#select_1").selectable();
    //eof selectable
    // progressbars
    if ($("#progressbar_default").length > 0)
        $("#progressbar_default").progressbar({value: 65});
    if ($("#progressbar_animated").length > 0)
    {
        $("#progressbar_animated").progressbar({value: 0});
        $("#sAProgress").click(function ()
        {
            $("#progressbar_animated").progressbar('destroy');
            var iNow = new Date().setTime(new Date().getTime() + 0 * 1000);
            var iEnd = new Date().setTime(new Date().getTime() + 5 * 1000);
            $("#progressbar_animated").anim_progressbar({start: iNow, finish: iEnd, interval: 1});
        });
    }
    if ($("#progressbar_delay").length > 0)
    {
        $("#progressbar_delay").progressbar({value: 0});
        $("#sWDProgress").click(function ()
        {
            $("#progressbar_delay").progressbar('destroy');
            var iNow1 = new Date().setTime(new Date().getTime() + 3 * 1000);
            var iEnd1 = new Date().setTime(new Date().getTime() + 6 * 1000);
            $("#progressbar_delay").anim_progressbar({start: iNow1, finish: iEnd1, interval: 1});
        });
    }
    // eof progressbars
    // spinner
    $("#spinner").spinner();
    $("#spinner1").spinner({culture: "en-US", min: 5, max: 1000, step: 10, start: 10, numberFormat: "C"});
    // eof spinner
    // eof sliders
    // popovers
    $("#popover_top").popover({placement: 'top', title: 'Popover title', content: 'Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit.'});
    $("#popover_right").popover({placement: 'right', title: 'Popover title', content: 'Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit.'});
    $("#popover_bottom").popover({placement: 'bottom', title: 'Popover title', content: 'Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit.'});
    $("#popover_left").popover({placement: 'left', title: 'Popover title', content: 'Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit.'});
    // eof popovers
    // jQuery dialogs
    $("#jDialog_default").dialog({autoOpen: false});
    $("#jDialog_default_button").click(function ()
    {
        $("#jDialog_default").dialog('open');
    });
    $("#jDialog_modal").dialog({autoOpen: false, modal: true});
    $("#jDialog_modal_button").click(function ()
    {
        $("#jDialog_modal").dialog('open');
    });
    $("#jDialog_form").dialog({autoOpen: false,
        modal: true,
        width: 400,
        buttons: {
            "Submit": function ()
            {
                $(this).dialog("close");
            },
            Cancel: function ()
            {
                $(this).dialog("close");
            }
        }});
    $("#jDialog_form_button").click(function ()
    {
        $("#jDialog_form").dialog('open');
    });
    // eof dialogs
    // dataTable
    if ($(".xtable").length > 0)
        $(".xtable").dataTable({bFilter: false, bInfo: false, bPaginate: false, bLengthChange: false,
            bSort: true,
            bAutoWidth: true,
            "aoColumnDefs": [{"bSortable": false,
                    "aTargets": [-1, 0]}]});
    if ($(".fTable").length > 0)
        $(".fTable").dataTable({bSort: true,
            "iDisplayLength": flist, "aLengthMenu": [[10, 25, 50, 250, -1], [10, 25, 50, 250, "All"]], // can be removed for basic 10 items per page
            "aoColumnDefs": [{"bSortable": false,
                    "aTargets": [-1, 0]}]});
    if ($(".fpTable").length > 0)
        $(".fpTable").dataTable({bSort: true,
            bAutoWidth: true,
            "iDisplayLength": flist, "aLengthMenu":  [[10, 25, 50, 250, -1], [10, 25, 50, 250, "All"]], // can be removed for basic 10 items per page
            "sPaginationType": "full_numbers",
            "aoColumnDefs": [{"bSortable": false,
                    "aTargets": [-1, 0]}]});
    // eif dataTable
    //wysiwyg editor
    if ($("#wysiwyg").length > 0)
    {
        wEditor = $("#wysiwyg").cleditor({width: "100%", height: "90px"});
    }
    //wysiwyg editor
    if ($(".wysiwyg").length > 0)
    {
        wEditor = $(".wysiwyg").cleditor({width: "100%", height: "120px"});
    }
    if ($("#mail_wysiwyg").length > 0)
        m_editor = $("#mail_wysiwyg").cleditor({width: "100%", height: "100%", controls: "bold italic underline strikethrough | font size style | color highlight removeformat | bullets numbering | outdent alignleft center alignright justify"})[0].focus();
    // eof wysiwyg editor
    // File uploader
    if ($("#uploader_v5").length > 0)
    {
        $("#uploader_v5").pluploadQueue({
            runtimes: 'html5',
            url: 'php/pluploader/upload.php',
            max_file_size: '1mb',
            chunk_size: '1mb',
            unique_names: true,
            dragdrop: true,
            resize: {width: 320, height: 240, quality: 100},
            filters: [
                {title: "Image files", extensions: "jpg,gif,png"},
                {title: "Zip files", extensions: "zip"}
            ],
            FilesAdded: function (editor, files)
            {
                alert(files);
            }
        });
    }
    if ($("#uploader_v4").length > 0)
    {
        $("#uploader_v4").pluploadQueue({
            runtimes: 'html4',
            url: 'php/pluploader/upload.php',
            unique_names: true,
            filters: [
                {title: "Image files", extensions: "jpg,gif,png"},
                {title: "Zip files", extensions: "zip"}
            ]
        });
    }
    // eof file uploader
    // draggable blocks //
    $(".sortableContent .column").sortable({
        connectWith: ".sortableContent .column",
        items: "> .widget",
        handle: ".head",
        placeholder: "sortablePlaceholder",
        start: function (event, ui)
        {
            $(".sortablePlaceholder").height(ui.item.height());
        },
        stop: function (event, ui)
        {
            var sorted = '';
            $(".sortableContent .column").each(function ()
            {
                sorted += $(this).index() + ': ';
                $(this).find('.widget').each(function ()
                {
                    sorted += '#' + $(this).attr('id') + ', ';
                });
                sorted += ';<br/>';
            });
            notify('Sorting', sorted);
        }
    }).disableSelection();
    // eof draggable blocks
    // slidernav
    if ($(".slidernav").length > 0)
        $(".slidernav").sliderNav();
    // eof slidernav
    // isotope gallery
    if ($('#isotope').length > 0)
        $('#isotope').isotope({
            itemSelector: '.item',
            layoutMode: 'fitRows'
        });
    $("#removeFilter").click(function ()
    {
        $('#isotope').isotope({filter: ''});
    });
    $("#filterByCity").click(function ()
    {
        $('#isotope').isotope({filter: '.city'});
    });
    $("#filterByNature").click(function ()
    {
        $('#isotope').isotope({filter: '.nature'});
    });
    $("#filterByCats").click(function ()
    {
        $('#isotope').isotope({filter: '.cat'});
    });
    // eof isotope gallery
    // eof jNotes
    //ibuttons
    if ($('.ibtn').length > 0)
        $('.ibtn').iButton();
    // eof ibuttons
    // new selector case insensivity        
    $.expr[':'].containsi = function (a, i, m)
    {
        return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
    };
    // 
});
$(window).load(function ()
{
    // custom scrollbar        
    if ($(".scroll").length > 0)
        $(".scroll").mCustomScrollbar();
    // eof custom scrollbar    
    // Scroll up plugin
    $.scrollUp({scrollText: '^'});
    // eof scroll up plugin
});
$('.wrapper').resize(function ()
{
    if ($("#wysiwyg").length > 0)
        editor.refresh();
    if ($("#mail_wysiwyg").length > 0)
        m_editor.refresh();
});
function notify(title, text)
{
    $.pnotify({
        title: title,
        text: text,
        addclass: 'custom',
        hide: true,
        opacity: 100,
        nonblock: true,
        nonblock_opacity: .5
    });
}
$(function ()
{
    $('a[href*=#]:not([href=#])').click(function ()
    {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname)
        {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length)
            {
                $('html,body').animate({
                    scrollTop: target.offset().top - 80
                }, 1000);
                //  return false;
            }
        }
    }); // code courtesy of CSS-Tricks
    // apply the class of nav-active to the current nav link
    $('a').on('click', function (e)
    {
        //e.preventDefault();
        $('li.nav-active').removeClass('nav-active');
        $(this).parent('li').addClass('nav-active');
    });
    // get an array of 'href' of each a tag
    var navLink = $('ul.navHighlighter a');
    var aArray = [];
    for (var i = 0; i < navLink.length; i++)
    {
        var aChild = navLink[i];
        var navArray = $(aChild).attr('href');
        aArray.push(navArray);
        var selector = aArray.join(" , ");
    }
    $(window).scroll(function ()
    {
        var scrollTop = $(window).scrollTop();
        var tops = [];
        $(selector).each(function ()
        {
            var top = $(this).position().top - 90;
            if (scrollTop > top)
            {
                var id = $(this).attr('id');
                $('.nav-active').removeClass('nav-active');
                $('a[href="#' + id + '"]').parent().addClass('nav-active');
            }
            tops.push(top);
        });
    });
});