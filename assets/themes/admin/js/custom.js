var FormWizard = function() {
    var wizardContent = $('#wanwizz');
    var wizardForm = $('#form');
    var initWizard = function() {
        // function to initiate Wizard Form
        wizardContent.smartWizard({
            selected: 0,
            keyNavigation: false,
            onLeaveStep: leaveAStepCallback,
            onShowStep: onShowStep,
        });
        var numberOfSteps = 0;
        animateBar();
        //initValidator();
    };
    var animateBar = function(val) {
        if ((typeof val == 'undefined') || val == "")
        {
            val = 1;
        }

        numberOfSteps = $('.swMain > ul > li').length;
        var valueNow = Math.floor(100 / numberOfSteps * val);
        $('.step-bar').css('width', valueNow + '%');
    };
    var initValidator = function() {
        return true;
      
    };
    var displayConfirm = function() {
        $('.display-value', form).each(function() {
            var input = $('[name="' + $(this).attr("data-display") + '"]', form);
            if (input.attr("type") == "text" || input.attr("type") == "email" || input.is("textarea")) {
                $(this).html(input.val());
            } else if (input.is("select")) {
                $(this).html(input.find('option:selected').text());
            } else if (input.is(":radio") || input.is(":checkbox")) {
                $(this).html(input.filter(":checked").parent('label').text());
            } else if ($(this).attr("data-display") == 'card_expiry') {
                $(this).html($('[name="card_expiry_mm"]', form).val() + '/' + $('[name="card_expiry_yyyy"]', form).val());
            }
        });
    };
    var onShowStep = function(obj, context) {
        $(".next-step").unbind("click").click(function(e) {
            e.preventDefault();
            wizardContent.smartWizard("goForward");
        });
        $(".back-step").unbind("click").click(function(e) {
            e.preventDefault();
            wizardContent.smartWizard("goBackward");
        });
        $(".finish-step").unbind("click").click(function(e) {
            e.preventDefault();
            onFinish(obj, context);
        });
    };
    var leaveAStepCallback = function(obj, context) {
        return validateSteps(context.fromStep, context.toStep);
        // return false to stay on step and true to continue navigation
    };
    var onFinish = function(obj, context) {
        alert('form submit function');
        $('.anchor').children("li").last().children("a").removeClass('selected').addClass('done');
        // if (validateAllSteps()) {
        //wizardForm.submit();
        //    }
    };
    var validateSteps = function(stepnumber, nextstep) {
        var isStepValid = false;
        if (numberOfSteps !== nextstep) {
            // cache the form element selector
            //   if (wizardForm.valid()) { // validate the form
            //    wizardForm.validate().focusInvalid();
            //focus the invalid fields
            animateBar(nextstep);
            isStepValid = true;
            return true;
            // }                ;
        } else {
            //displayConfirm();
            animateBar(nextstep);
            return true;
        }

    };
    var validateAllSteps = function() {
        var isStepValid = true;
        // all step validation logic
        return isStepValid;
    };
    return {
        init: function() {
            initWizard();
        }
    };
}();

$(document).ready(function() {
    FormWizard.init();
    
    $("body").removeClass('smf');
});