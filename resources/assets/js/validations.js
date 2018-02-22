module.exports = {
    addError: function (target, message) {
        /*shows the error div with the specified message 
         *and sets the input field class to error*/
        $(target.concat("_error")).html(message);
        $(target.concat("_error")).show();
        $(target).addClass("parsley-error");
    },
    removeError: function (target) {
        /*hides the error div and sets the input field class to success*/
        $(target.concat("_error")).hide();
        $(target).removeClass("parsley-error");
        $(target).addClass("parsley-success");
    },
//PERSON RELATED CHECKS
    check_name: function (fieldname) {
        /*checks name fields if they are correct and returns a boolean. 
         *Also sets the Error on the specified field. The error div needs to have 
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var name = $(fieldname);

        if (name.val().length < 2 || name.val().length > 20) {
            module.exports.addError(fieldname, "The name should be between 2 and 20 characters");
            localerror = true;
        } else if (!name.val().match(/^[a-z ,.'-]+$/i)) {
            module.exports.addError(fieldname, "Only letters and hyphens(-) are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    },
    check_university_email: function (fieldname) {
        /*checks university email fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var email = $(fieldname);

        if(email.val().length < 11 || email.val().length > 30){
            module.exports.addError(fieldname,"Email is too short or too long");
            localerror = true;
        } else if(!email.val().match(/^([a-zA-Z0-9_.+-])+\@soton.ac.uk$/)){
            module.exports.addError(fieldname, "Only @soton.ac.uk emails are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    },
    check_university_id_number: function (fieldname) {
        /*checks University ID number fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var id = $(fieldname).val();

        if(id.length < 1){
            module.exports.addError(fieldname, "Id cannot be empty");
            localerror = true;
        }else if (id[0].match(/^[1]/) && id.length !== 8) {
            module.exports.addError(fieldname, "Id of a member of staff must be 8 digits long");
            localerror = true;
        }else if (id[0].match(/^[2345]/) && id.length !== 9) {
            module.exports.addError(fieldname, "The id of students must be 9 digits long");
            localerror = true;
        }else if (!id.match(/^[0-9]+$/)) {
            module.exports.addError(fieldname, "Only digits are allowed");
            localerror = true;
        }else if(id[0].match(/^[67890]/)){
            module.exports.addError(fieldname, "This does not seem to be a valid university ID");
            localerror = true;
        }else{
            module.exports.removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    },
    check_phone: function (fieldname) {
        /*checks phone number fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var phone = $(fieldname);

        if(!phone.val().length === 11){
            module.exports.addError(fieldname, "The phone number must be 11 digits long");
            localerror = true;
        } else if(!phone.val().match(/^\d{11}$/)) {
            module.exports.addError(fieldname, "Only numbers are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    },
    check_password: function (fieldname) {
        /*checks password fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var password = $(fieldname);
        if(password.val().length < 6 || password.val().length > 16){
            module.exports.addError(fieldname, "The password must be 6 to 16 character long and contain at least one upper case letter, one lower case letter, and one digit");
            localerror = true;
        } else if(!password.val().match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,16}$/)){
            module.exports.addError(fieldname, "The password must be 6 to 16 character long and contain at least one upper case letter, one lower case letter, and one digit");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
//PRINTER RELATED CHECKS
    check_printer_number_select: function (fieldname) {
        /*checks that a printer number has been selected from the drop-down list*/
        var localerror = true;
        var printerno = $(fieldname).find(":selected").text();

        if (!isNaN(parseFloat(printerno)) && isFinite(printerno)){
            module.exports.removeError(fieldname);
            localerror = false;
        } else {
            module.exports.addError(fieldname, "Please select a printer number");
            localerror = true;
        }
        return localerror;
    },
    check_printer_number_input: function (fieldname) {
        /*checks printer number fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var printerno = $(fieldname).val();

        if(printerno.length < 1 || printerno.length > 3){
            module.exports.addError(fieldname, "Printer number should contain between 1 and 3 digits");
            localerror = true;
        }else if(!printerno.match(/^[0-9]+$/)){
            module.exports.addError(fieldname, "Only digits are allowed");
            localerror = true;
        }else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    check_printer_serial: function (fieldname) {
        /*checks printer serial number fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var printerno = $(fieldname).val();
        if(printerno.length < 1 || printerno.length > 20){
            module.exports.addError(fieldname, "The serial number must be between 1 and 20 digits long");
            localerror = true;
        }else if(!printerno.match(/^[A-Z a-z-0-9]+$/)){
            module.exports.addError(fieldname, "Only letters, numbers and hyphens (-) are allowed");
            localerror = true;
        }else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    check_printer_type_radio: function (fieldname,otherfieldname) {
        /*checks printer type radio button group if they are correct and returns
         *a boolean. Also checks if the "Other" option was selected and shows the 
         *otherfieldname which should have an _group appended to it. (i.e. if 
         *otherfieldname is "#other", then #other_group will be shown or hidden 
         *depending on the users selection.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var fieldvalue = $('input[name = "'.fieldname.'"]:checked').val();

        if (!fieldvalue){
            module.exports.addError(fieldname, "Please select a printer type");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
            if(fieldvalue !== "Other"){
                //should be like "#printer_type_other_group" to hide field and label
                $(otherfieldname.concat("_group")).hide();
            } else {
                $(otherfieldname.concat("_group")).show();
                module.exports.check_printer_type_input(otherfieldname,fieldname);
            }
        }
        return localerror;
    },
    check_printer_type_input: function (fieldname,radiogroup) {
        /*checks printer serial number fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var fieldvalue = $(fieldname).val();
        var radioselection = $('input[name = "'.radiogroup.'"]:checked').val();
        if(radioselection !== "Other" ){
            module.exports.removeError(fieldname);
            localerror = false;
        }else if(fieldvalue.length < 1 || fieldvalue.length > 20){
            //TODO: check if this should be 10, 20 or 100 -> I found different number sin different files, so check with database!
            module.exports.addError(fieldname, "The printer type must be between 1 and 20 characters long");
            localerror = true;
        }else if(!fieldvalue.match(/^[a-z A-Z0-9.,!]+$/)){
            module.exports.addError(fieldname, "Not permitted characters are inputted");
            localerror = true;
        }else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
//PRINT RELATED CHECKS
    check_print_duration: function (hrsdropdown,mindropdown,group) {
        /*checks print duration fields if they are correct and returns
         *a boolean. Requires a reference to the drop-down for hours and
         *minutes, as well as group div. the group div should have an _error
         *associated with it.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var varhours = $(hrsdropdown).find(":selected").text();
        var varminutes = $(mindropdown).find(":selected").text();
        if (varhours === "Hours" || varminutes === "Minutes"){
            module.exports.addError(group, "Please set the printing time");
            localerror = true;
        } else if(parseInt(varhours) + parseInt(varminutes) == 0){
            module.exports.addError(group, "The printing time cannot be zero");
            localerror = true;
        } else {
            module.exports.removeError(group);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    },
    check_material_amount: function (fieldname) {
        /*checks printing material amount fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var material = $(fieldname);

        if(material.val().length < 1){
            module.exports.addError(fieldname, "The value must be between 0.1 and 9999 in grams");
            localerror = true;
        } else if (!material.val().match(/^(?!0(\.?0*)?$)\d{0,3}(\.?\d{0,1})?$/)) {
            module.exports.addError(fieldname, "The value must be between 0.1 and 9999 in grams");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    },
    check_cost_code: function (fieldname,budgetholder) {
        /*checks University cost code fields if they are correct and returns
         *a boolean. This function also requires the field for budget holder.
         *Note that there needs to be a div surrounding the Budget Holder input
         *field and its label called the same as the budget holder field but
         *with _group appended.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var use_case = $(fieldname);

        if(use_case.val().length < 3 || use_case.val().length > 15) {
            module.exports.addError(fieldname, "Either 9 digit university cost code or standard module name are allowed");
            localerror = true;
        } else if((!use_case.val().match(/^[A-Z]{3}/) &&
        !use_case.val().match(/^[a-z0-9]+$/i))){
            module.exports.addError(fieldname, "Either 9 digit cost code or standard module name are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
            if(!$.isNumeric(use_case.val())){
                //should be like "#budget_holder_group" to hide field and label
                $(budgetholder.concat("_group")).hide();
            } else {
                $(budgetholder.concat("_group")).show();
                module.exports.check_budget_holder(budgetholder,fieldname);
            }
        }
        return localerror;
    },
    check_budget_holder: function (fieldname,costcode) {
        /*checks University cost code Budget Holder fields if they are correct
         *and returns a boolean. This function also requires the field containing
         *the cost code.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var budget_holder = $(fieldname);
        var use_case = $(costcode);
        if(!$.isNumeric(use_case.val())){
            module.exports.removeError(fieldname);
            localerror = false;
        } else if(budget_holder.val().length < 3 || budget_holder.val().length > 100){
            module.exports.addError(fieldname,"The name should be between 2 and 20 characters");
            localerror = true;
        } else if(!budget_holder.val().match(/^[a-z ,.'-]+$/i)){
            module.exports.addError(fieldname,"Only letters and hyphens(-) are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },

    check_claim_id: function (fieldname) {
        /*check DropOff claim id fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var claim_id = $(fieldname);
        if(claim_id.val().length !== 16){
            module.exports.addError(fieldname, "The claim ID must contain 16 characters");
            localerror = true;
        } else if(!claim_id.val().match(/^[a-zA-Z0-9-]+$/i)){
            module.exports.addError(fieldname, "Only alpha-numeric characters are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    },
    check_claim_passcode: function (fieldname) {
        /*check DropOff claim passcode fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var claim_passcode = $(fieldname);
        if(claim_passcode.val().length !== 16){
            module.exports.addError(fieldname, "The claim passcode must contain 16 characters");
            localerror = true;
        } else if(!claim_passcode.val().match(/^[a-zA-Z0-9-]+$/i)){
            module.exports.addError(fieldname, "Only alpha-numeric characters are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    },
    check_job_title: function (fieldname) {
        /*check Job Title fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var job_title= $(fieldname);

        if(job_title.val().length < 8 || job_title.val().length > 256) {
            module.exports.addError(fieldname, 'The title should be between 8 and 256 characters');
            localerror = true;
        } else if(!job_title.val().match(/^[a-zA-Z0-9 ,.'-]+$/i)){
            module.exports.addError(fieldname,"Only these special characters are allowed: ,.'-");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    check_issue_title: function (fieldname) {
        /*check Issue Title fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var issue_title = $(fieldname).val();

        if(issue_title.length < 8 || issue_title.length > 180) {
            module.exports.addError(fieldname, 'The title should be between 8 and 180 characters');
            localerror = true;
        } else if(!issue_title.match(/^[a-zA-Z0-9 .,!?']+$/)){
            module.exports.addError(fieldname,"Only these special characters are allowed: ,.!?'");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    check_message: function (fieldname,minlength,maxlength) {
        /*check message fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var message = $(fieldname).val();

        if(message.length < 8 || message.length > maxlength){
            module.exports.addError(fieldname, "The message must be between 8 and "+maxlength+" characters long");
            localerror = true;
        } else if(!message.match(/^[a-z A-Z0-9-.,!?()/']+$/)){
            module.exports.addError(fieldname, "No special characters are allowed");
            localerror = true;
        }else{
            $(fieldname.concat("_error")).html("Remaining characters : " + (maxlength - message.length));
            $(fieldname.concat("_error")).show();
            $(fieldname).removeClass("parsley-error");
            $(fieldname).addClass("parsley-success");
            localerror = false;
        }
        return localerror;
    },
    check_comment: function (fieldname) {
        /*checks optional comment fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var maxlength = 300;
        return module.exports.check_message(fieldname,0,maxlength)
    },
    check_message_long: function (fieldname) {
        var maxlength = 2048;
        return module.exports.check_message(fieldname,8,maxlength);
    },
    check_message_default: function(fieldname) {
        var maxlength = 300;
        return module.exports.check_message(fieldname,8,maxlength);
    }
};
