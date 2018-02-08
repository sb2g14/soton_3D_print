$(function () {
    $("#customer_name_error").hide();
    $("#customer_email_error").hide();
    $("#customer_id_error").hide();
    $("#use_case_error").hide();
    $("#budget_holder_error").hide();
    $("#claim_id_error").hide();
    $("#claim_passcode_error").hide();
    $("#job_title_error").hide();

    var error_customer_name = true;
    var error_customer_email = true;
    var error_customer_id = true;
    var error_use_case = true;
    var error_budget_holder = true;
    var error_claim_id = true;
    var error_claim_passcode = true;
    var error_job_title = true;

    $( window ).load(function() {
        $("#budget_holder_group").hide();
        check_all_fields();
    });

    function check_all_fields(){
        if( !error_customer_name && !error_customer_email && !error_customer_id &&
            !error_use_case && !error_budget_holder && error_claim_id &&
            !error_job_title && !error_claim_passcode){
            $("#submit").addClass("btn-success");
            $("#submit").trigger("cssClassChanged");
            $("#submit").prop('disabled', false);
        } else {
            $("#submit").removeClass("btn-success");
        }
    }
    function addError(target, message){
        $(target.concat("_error")).html(message);
        $(target.concat("_error")).show();
        $(target).addClass("parsley-error");
    }
    function removeError(target){
        $(target.concat("_error")).hide();
        $(target).removeClass("parsley-error");
        $(target).addClass("parsley-success");
    }

    var check_name = function check_name() {
     var name = $("#customer_name");
     console.log('check_name called');

     if(name.val().length < 3 || name.val().length > 100){
         addError("#customer_name","The name should be between 2 and 20 characters");
         error_customer_name = true;
     } else if (!name.val().match(/^[a-z ,.'-]+$/i)){
         addError("#customer_name","Only letters and hyphens(-) are allowed");
         error_customer_name = true;
     } else {
         removeError("#customer_name");
         error_customer_name = false;
     }
     check_all_fields();
    };
    var check_email = function check_email() {
        var email = $("#customer_email");
        console.log('check_email called');

        if(email.val().length < 11 || email.val().length > 30){
            addError("#customer_email","Email is too short or too long");
            error_customer_email = true;
        } else if(!email.val().match(/^([a-zA-Z0-9_.+-])+\@soton.ac.uk$/)){
            addError("#customer_email", "Only @soton.ac.uk emails are allowed");
            error_customer_email = true;
        } else {
            removeError("#customer_email");
            error_customer_email = false;
        }
        check_all_fields();
    };
    var check_id = function check_id() {
        var id = $("#customer_id");
        console.log('check_id called');

        if(id.val().length < 1){
            addError("#customer_id", "Id cannot be empty");
            error_customer_id = true;
        }else if (id.val()[0].match(/^[1]/) && id.val().length !== 8) {
            addError("#customer_id", "Id of a member of staff must be 8 digits long");
            error_customer_id = true;
        } else if (id.val()[0].match(/^[2345]/) && id.val().length !== 9) {
            addError("#customer_id", "The id of students must be 9 digits long");
            error_customer_id = true;
        } else if (!id.val().match(/^[0-9]+$/)) {
            addError("#customer_id", "Only digits are allowed");
            error_customer_id = true;
        } else {
            removeError("#customer_id");
            error_customer_id = false;
        }
        check_all_fields();
    };
    var check_use_case = function check_use_case() {
        var use_case = $("#use_case");

        if(use_case.val().length < 3 || use_case.val().length > 15) {
            addError("#use_case", "Either 9 digit cost code or standard module name are allowed");
            error_use_case = true;
        } else if((!use_case.val().match(/^[A-Z]{3}/) &&
        !use_case.val().match(/^[a-z0-9]+$/i))){
            addError("#use_case", "Either 9 digit cost code or standard module name are allowed");
            error_use_case = true;
        } else {
            removeError("#use_case");
            error_use_case = false;
            if(!$.isNumeric(use_case.val())){
                $("#budget_holder_group").hide();
            } else {
                $("#budget_holder_group").show();
                check_budget_holder();
            }
        }
        check_all_fields();
    };
    var check_budget_holder = function check_budget_holder() {
        var budget_holder = $("#budget_holder");
        var use_case = $("#use_case");
        if(!$.isNumeric(use_case.val())){
            removeError("#budget_holder");
            error_budget_holder = false;
        } else if(budget_holder.val().length < 3 || budget_holder.val().length > 100){
            addError("#budget_holder","The name should be between 2 and 20 characters");
            error_budget_holder = true;
        } else if(!budget_holder.val().match(/^[a-z ,.'-]+$/i)){
            addError("#budget_holder","Only letters and hyphens(-) are allowed");
            error_budget_holder = true;
        } else {
            removeError("#budget_holder");
            error_budget_holder = false;
        }
        check_all_fields();
    };
    var check_claim_id = function check_claim_id() {
      var  claim_id = $("#claim_id");
      if(claim_id.val().length !== 16){
          addError("#claim_id", "The claim ID must contain 16 characters");
          error_claim_id = true;
      } else if(!claim_id.val().match(/^[a-zA-Z0-9-]+$/i)){
          addError("#claim_id", "Only alpha-numeric characters are allowed");
          error_claim_id = true;
      } else {
          removeError("#claim_id");
          error_claim_id = false;
      }
        check_all_fields();
    };
    var check_claim_passcode = function check_claim_passcode() {
        var  claim_passcode = $("#claim_passcode");
        if(claim_passcode.val().length !== 16){
            addError("#claim_passcode", "The claim passcode must contain 16 characters");
            error_claim_passcode = true;
        } else if(!claim_passcode.val().match(/^[a-zA-Z0-9-]+$/i)){
            addError("#claim_passcode", "Only alpha-numeric characters are allowed");
            error_claim_passcode = true;
        } else {
            removeError("#claim_passcode");
            error_claim_passcode = false;
        }
        check_all_fields();
    };
    var check_job_title = function check_job_title() {
        var job_title= $("#job_title");

        if(job_title.val().length < 8 || job_title.val().length > 256) {
            addError("#job_title", 'The title should be between 8 and 256 characters');
            error_job_title = true;
        } else if(!job_title.val().match(/^[a-zA-Z0-9 ,.'-]+$/i)){
            addError("#job_title","Only these special characters are allowed: ,.'-");
            error_job_title = true;
        } else {
            removeError("#job_title");
            error_job_title = false;
        }
        check_all_fields();
    };

    var html_triggers = ["#customer_name", "#customer_email", "#customer_id", "#use_case",
        "#budget_holder", "#claim_id", "#claim_passcode", "#job_title"];
    var funcs = [check_name, check_email, check_id, check_use_case,
        check_budget_holder, check_claim_id, check_claim_passcode, check_job_title];
    // alert(html_triggers);
    alert(funcs);
    for(var i = 0; i <= html_triggers.length; i++ ){
        $(html_triggers[i]).keyup(function () {funcs[i];});
        $(html_triggers[i]).focusout(function () {funcs[i];});
    }
    $("#submit").click(function () {
        for(var i = 0; i <= html_triggers.length; i++ ){
            $(html_triggers[i]).hide();
            $(html_triggers[i]).removeClass("parsley-success");
        }
    });
});
