$( document ).ready(function() {

     $( "#home-tab" ).click(function() { $( '#home-tabpostlink' ).trigger('click'); });
     $( "#profile-tab" ).click(function() { $( '#profile-tabpostlink' ).trigger('click'); });
     $( "#cronic_pain_assessment-tab" ).click(function() { $( '#chronic-pain-tabpostlink' ).trigger('click'); });
     $( "#contact-tab" ).click(function() { $( '#contact-tabpostlink' ).trigger('click'); });
     $( "#family-tab" ).click(function() { $( '#family-tabpostlink' ).trigger('click'); });
     $( "#allergies-tab" ).click(function() { $( '#allergies-tabpostlink' ).trigger('click'); });
     $( "#other_detail-tab" ).click(function() { $( '#other_detail-tabpostlink' ).trigger('click'); });
     $( "#general_updates-tab" ).click(function() { $( '#general_updates-tabpostlink' ).trigger('click'); });
     $( "#pain_updates-tab" ).click(function() { $( '#pain_updates-tabpostlink' ).trigger('click'); });
     $( "#screening-tab" ).click(function() { $( '#screening-tabpostlink' ).trigger('click'); });
     $( "#post_checkup_detail-tab" ).click(function() { $( '#post_checkup_detail-tabpostlink' ).trigger('click'); });
     $( "#procedure_detail-tab" ).click(function() { $( '#procedure_detail-tabpostlink' ).trigger('click'); });

     $( "#pre_op_medications-tab" ).click(function() { $( '#pre_op_medications-tabpostlink' ).trigger('click'); });
     $( "#pre_op_allergies-tab" ).click(function() { $( '#pre_op_allergies-tabpostlink' ).trigger('click'); });
     $( "#disease-tab" ).click(function() { $( '#disease-tabpostlink' ).trigger('click'); });
     $( "#disease_detail-tab" ).click(function() { $( '#disease_detail-tabpostlink' ).trigger('click'); });
     $( "#mad_refill_drug-tab" ).click(function() { $( '#mad_refill_drug-tabpostlink' ).trigger('click'); });
     $( "#follow_up_sx_detail-tab" ).click(function() { $( '#follow_up_sx_detail-tabpostlink' ).trigger('click'); });

     $( "#covid_detail-tab" ).click(function() { $( '#covid_detail-tabpostlink' ).trigger('click'); });
     $( "#phq_9-tab" ).click(function() { $( '#phq_9-tabpostlink' ).trigger('click'); });
     $( "#focused_history-tab" ).click(function() { $( '#focused_history-tabpostlink' ).trigger('click'); });
     $( "#chronic_condition-tab" ).click(function() { $( '#chronic_condition-tabpostlink' ).trigger('click'); });
    $( "#chronic_assessment-tab" ).click(function() { $( '#chronic_assessment-tabpostlink' ).trigger('click'); });

    $( "#padt-tab" ).click(function() { $( '#padt-tabpostlink' ).trigger('click'); });
    $( "#dast-tab" ).click(function() { $( '#dast-tabpostlink' ).trigger('click'); });
    $( "#soapp-tab" ).click(function() { $( '#soapp-tabpostlink' ).trigger('click'); });
    $( "#comm-tab" ).click(function() { $( '#comm-tabpostlink' ).trigger('click'); });
    $( "#dmii-tab" ).click(function() { $( '#dmii-tabpostlink' ).trigger('click'); });

    $( "#cad-tab" ).click(function() { $( '#cad-tabpostlink' ).trigger('click'); });
    $( "#chf-tab" ).click(function() { $( '#chf-tabpostlink' ).trigger('click'); });
    $( "#htn-tab" ).click(function() { $( '#htn-tabpostlink' ).trigger('click'); });
    $( "#copd-tab" ).click(function() { $( '#copd-tabpostlink' ).trigger('click'); });
    $( "#asthma-tab" ).click(function() { $( '#asthma-tabpostlink' ).trigger('click'); });

    // Pain Management
    $( "#pain_assessments-tab" ).click(function() { $('#pain_assessments-tabpostlink').trigger('click'); });
    $( "#treatment_history-tab" ).click(function() { $( '#treatment_history-tabpostlink' ).trigger('click'); });
    $( "#opioid_overdose_risk-tab" ).click(function() { $( '#opioid_overdose_risk-tabpostlink' ).trigger('click'); });
    $( "#opioid_risk_tool-tab" ).click(function() { $('#opioid_risk_tool-tabpostlink' ).trigger('click'); });
    // End pain management
    $( "#chronic-general-tab" ).click(function() { $( '#chronic-general-tabpostlink' ).trigger('click'); });
    $( "#cancer_cc-tab" ).click(function() { $( '#cancer_cc-tabpostlink' ).trigger('click'); });
    $( "#cancer_history-tab" ).click(function() { $( '#cancer_history-tabpostlink' ).trigger('click'); });
    $( "#cancer_assessments-tab" ).click(function() { $( '#cancer_assessments-tabpostlink' ).trigger('click'); });
    $( "#cancer_medical_history-tab" ).click(function() { $( '#cancer_medical_history-tabpostlink' ).trigger('click'); });
    $( "#pre_op_post_op-tab" ).click(function() { $( '#pre_op_post_op-tabpostlink' ).trigger('click'); });
    $( "#oncology_general-tab" ).click(function() { $( '#oncology_general-tabpostlink' ).trigger('click'); });
    $( "#oncology_medical_history-tab" ).click(function() { $( '#oncology_medical_history-tabpostlink' ).trigger('click'); });

    $( "#hospital_er_info-tab" ).click(function() { $( '#hospital_er_info-tabpostlink' ).trigger('click'); });


     // below code for back button edit
     // for tab 2 back button
     $( "#profile-tab-backbtn" ).click(function() { $( '#home-tabpostlink' ).trigger('click'); });
     // for tab 3 back button
     $( "#contact-tab-backbtn" ).click(function() { $( '#profile-tabpostlink' ).trigger('click'); });
     // for tab 4 back button
     $( "#family-tab-backbtn" ).click(function() { $( '#contact-tabpostlink' ).trigger('click'); });
     // for tab 5 back button
     $( "#allergies-tab-backbtn" ).click(function() { $( '#family-tabpostlink' ).trigger('click'); });
     $( "#other_detail-tab-backbtn" ).click(function() { $( '#other_detail-tabpostlink' ).trigger('click'); });
     //$( "#allergies-tab-backbtn" ).click(function() { $( '#family-tabpostlink' ).trigger('click'); });
     $( "#general_updates-tab-backbtn" ).click(function() { $( '#general_updates-tabpostlink' ).trigger('click'); });
     $( "#pain_updates-tab-backbtn" ).click(function() { $( '#pain_updates-tabpostlink' ).trigger('click'); });

     $( "#screening-backbtn" ).click(function() { $( '#screening-tabpostlink' ).trigger('click'); });
     $( "#post_checkup_detail-backbtn" ).click(function() { $( '#post_checkup_detail-tabpostlink' ).trigger('click'); });

     $( "#procedure_detail-backbtn" ).click(function() { $( '#procedure_detail-tabpostlink' ).trigger('click'); });

     $( "#pre_op_medications-backbtn" ).click(function() { $( '#pre_op_medications-tabpostlink' ).trigger('click'); });

     $( "#pre_op_allergies-backbtn" ).click(function() { $( '#pre_op_allergies-tabpostlink' ).trigger('click'); });

    $( "#disease-backbtn" ).click(function() { $( '#disease-tabpostlink' ).trigger('click'); });
    $( "#disease_detail-backbtn" ).click(function() { $( '#disease_detail-tabpostlink' ).trigger('click'); });
    $( "#mad_refill_drug-backbtn" ).click(function() { $( '#mad_refill_drug-tabpostlink' ).trigger('click'); });
    $( "#primary-tab-backbtn" ).click(function() { $( '#contact-tabpostlink' ).trigger('click'); });
    $( "#covid_detail-backbtn" ).click(function() { $( '#covid_detail-tabpostlink' ).trigger('click'); });
    $( "#phq_9-backbtn" ).click(function() { $( '#phq_9-tabpostlink' ).trigger('click'); });
   // $("#focus_history-backbtn").click(function() { alert('dfd');$('#focus_history-tabpostlink').trigger('click'); });
    $( "#focus_history-backbtn" ).click(function() { $( '#focused_history-tabpostlink' ).trigger('click'); });
    $( "#chronic_condition-backbtn" ).click(function() { $( '#chronic_condition-tabpostlink' ).trigger('click'); });
    $( "#chronic_assessment-backbtn" ).click(function() { $( '#chronic_assessment-tabpostlink' ).trigger('click'); });
    $( "#cancer_cc-backbtn" ).click(function() { $( '#cancer_cc-tabpostlink' ).trigger('click'); });
    $( "#cancer_history-backbtn" ).click(function() { $( '#cancer_history-tabpostlink' ).trigger('click'); });
    $( "#cancer_assessments-backbtn" ).click(function() { $( '#cancer_assessments-tabpostlink' ).trigger('click'); });
    $( "#cancer_medical_history-backbtn" ).click(function() { $( '#cancer_medical_history-tabpostlink' ).trigger('click'); });
    // Pain Management
    $( "#chronic_opioid_risk_tool-backbtn" ).click(function() { $( '#opioid_overdose_risk-tabpostlink' ).trigger('click'); });
    $( "#chronic_opioid_overdose_risk-backbtn" ).click(function() { $( '#treatment_history-tabpostlink' ).trigger('click'); });
    $( "#chronic_treatment_history-backbtn" ).click(function() { $( '#pain_assessments-tabpostlink' ).trigger('click'); });
    // End PAin management
        $( "#pre_op_post_op-backbtn" ).click(function() { $( '#pre_op_post_op-tabpostlink' ).trigger('click'); });

    $( "#oncology_general-backbtn" ).click(function() { $( '#oncology_general-tabpostlink' ).trigger('click'); });
    $( "#oncology_medical_history-backbtn" ).click(function() { $( '#oncology_medical_history-tabpostlink' ).trigger('click'); });

    $( "#hospital_er_info-backbtn" ).click(function() { $( '#hospital_er_info-tabpostlink' ).trigger('click'); });
});


//tab number 4 js
$(document).ready(function(){

$(".go_to_part_2").click(function(){

        $("#profile-tab222").trigger("click");
         $("body").scrollTop(0);
    });
    $(".back_to_part_1").click(function(){
        $("#home-tab222").trigger("click");
         $("body").scrollTop(0);
    });

    $(".go_to_part_3").click(function(){


        $("#chronic-tab222").trigger("click");
         $("body").scrollTop(0);
    });

    $(".go_to_part_4").click(function(){


        $("#chronic-tab333").trigger("click");
         $("body").scrollTop(0);
    });

    $(".go_to_part_5").click(function(){

        $("#chronic-tab444").trigger("click");
         $("body").scrollTop(0);
    });


    $(".go_to_part_6").click(function(){

        $("#chronic-tab555").trigger("click");
         $("body").scrollTop(0);
    });

    $("#profile-tab222").click(function(event){

        // first check all the checkbox input is checked start
        // home222
        var cnt = 1;
        var cntflg = false ;
        var field_empty = false;
        $('#home222 .row').each(function( index, element ) {
            $(element).find('input[type=radio]').each(function( inindex, inelement ) {
                if(!cntflg) cntflg =  $(inelement).is(":checked");
            });
            if(!cntflg) field_empty = true;
            cntflg = false;
        });
        if(field_empty){
            event.stopPropagation();
            $("#form_tab_4 div.errorHolder").addClass('alert alert-danger').html("Please fill all fields.");// alert('');
            return;
        }
    });

    $("#chronic-tab222").click(function(event){

        var cnt = 1;
        var cntflg = false ;
        var field_empty = false;
        $('#profile222 .row').each(function( index, element ) {

            $(element).find('input[type=radio]').each(function( inindex, inelement ) {

                if(!cntflg) cntflg =  $(inelement).is(":checked");
            });
            if(!cntflg) field_empty = true;
            cntflg = false;
        });
        if(field_empty){
            event.stopPropagation();
            //alert('Please fill all fields in First Tab.');
            $("#form_tab_4 div.errorHolder").addClass(' alert alert-danger').html("Please fill all fields.");
            return;
        }
    });

    $("#chronic-tab333").click(function(event){
        var cnt = 1;
        var cntflg = false ;
        var field_empty = false;
        $('#chronic222 .row').each(function( index, element ) {
            // console.log($('input[name="question_symptom[28]"]:checked'));
            $(element).find('input[type=radio]').each(function( inindex, inelement ) {
                 console.log($(inelement).is(":checked"));
                if(!cntflg) cntflg =  $(inelement).is(":checked");
            });
            if(!cntflg) field_empty = true;
                cntflg = false;

        });
        if(field_empty){
            event.stopPropagation();
            $("#form_tab_4 div.errorHolder").addClass(' alert alert-danger').html("Please fill all fields.");
            return;
        }
    });

    $("#chronic-tab444").click(function(event){
        var cnt = 1;
        var cntflg = false ;
        var field_empty = false;
        $('#chronic333 .row').each(function( index, element ) {
            // console.log($('input[name="question_symptom[28]"]:checked'));
            $(element).find('input[type=radio]').each(function( inindex, inelement ) {
                // console.log($(inelement).is(":checked"));
                if(!cntflg) cntflg =  $(inelement).is(":checked");
            });
                if(!cntflg) field_empty = true;
                cntflg = false;

        });
        if(field_empty){
            event.stopPropagation();
            $("#form_tab_4 div.errorHolder").addClass(' alert alert-danger').html("Please fill all fields.");
            return;
        }
    });

    $("#chronic-tab555").click(function(event){
        var cnt = 1;
        var cntflg = false ;
        var field_empty = false;
        $('#chronic444 .row').each(function( index, element ) {
            // console.log($('input[name="question_symptom[28]"]:checked'));
            $(element).find('input[type=radio]').each(function( inindex, inelement ) {
                // console.log($(inelement).is(":checked"));
                if(!cntflg) cntflg =  $(inelement).is(":checked");
            });
                if(!cntflg) field_empty = true;
                cntflg = false;

        });
        if(field_empty){
            event.stopPropagation();
            $("#form_tab_4 div.errorHolder").addClass(' alert alert-danger').html("Please fill all fields.");
            return;
        }
    });
 });

let loading = async(msg ='') => {
        var homeLoader = $('.dashboard_content').loadingIndicator({
                    useImage: false,
                }).data("loadingIndicator");
    }
let formsubmit = async(form = '') =>{
            var form = 
            form.submit();
            loading();
            homeLoader.hide();

        
}

$(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip();

    $("#form_tab_2").validate({

        rules: {
            'details_question[38][]': {
                required: true,
                minlength: 1
            },
            'details_question[2][]': {
                required: true,
                minlength: 1
            },
            'details_question[39][]': {
                required: true,
                minlength: 1
            },
            'details_question[36][]': {
                required: true,
                minlength: 1
            },
            'details_question[37][]': {
                required: true,
                minlength: 1
            },
            'details_question[30][]': {
                required: true,
                minlength: 1
            },
            'details_question[19][]': {
                required: true,
                minlength: 1
            },
            'details_question[23][]': {
                required: true,
                minlength: 1
            },
            'details_question[54][]': {
                required: true,
                minlength: 1
            },
            'details_question[42][]': {
                required: true,
                minlength: 1
            }

        },
        ignore: ':hidden:not(.do_not_ignore)',
        showErrors: function(errorMap, errorList) {
                if(errorList.length>0){
                    $("#form_tab_2 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
                }
        },
        submitHandler: function(form) {
            formsubmit(form);
        }
       
    });

    $("#form_tab_3").validate({

        showErrors: function(errorMap, errorList) {

            if(errorList.length>0){
                $("#form_tab_3 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

     });

    $("#form_tab_4").validate({
                // Use this one to place the error
        ignore: ".ignore_fld",

   // errorLabelContainer: $("#form_tab_2 div.errorHolder")

        showErrors: function(errorMap, errorList) {
                var tmp_step_id = "<?php echo $step_id?$step_id:'' ?>" ;
                //console.log(errorList);
                if(errorList.length>0){
                    if(tmp_step_id == 4)
                        $("#form_tab_4 div.errorHolder").addClass(' alert alert-danger').html("* Please add at least one medication. <br>*All fields in both sections must be completed before you submit the form.");
                    else
                         $("#form_tab_4 div.errorHolder").addClass(' alert alert-danger').html("*All fields in both sections must be completed before you submit the form.");
                }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

     });

    $("#form_tab_6").validate({

        ignore: ':hidden:not(.do_not_ignore)',
        showErrors: function(errorMap, errorList) {
                if(errorList.length>0){
                    $("#form_tab_6 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
                }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

    });

    $("#form_tab_7").validate({

        ignore: ':hidden:not(.do_not_ignore)',
        showErrors: function(errorMap, errorList) {
                if(errorList.length>0){
                    $("#form_tab_6 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
                }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

    });

    $("#form_tab_8").validate({

        ignore: ':hidden:not(.do_not_ignore)',
        showErrors: function(errorMap, errorList) {
                if(errorList.length>0){
                    $("#form_tab_8 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
                }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

    });

    $("#form_tab_9").validate({

        ignore: ':hidden:not(.do_not_ignore)',
        showErrors: function(errorMap, errorList) {
                if(errorList.length>0){
                    $("#form_tab_9 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
                }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

    });

    $("#form_tab_10").validate({

        ignore: ':hidden:not(.do_not_ignore)',
        showErrors: function(errorMap, errorList) {
                if(errorList.length>0){
                    $("#form_tab_10 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
                }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

    });

    $("#form_tab_11").validate({

        ignore: ':hidden:not(.do_not_ignore)',
        showErrors: function(errorMap, errorList) {
                console.log(errorList);
                if(errorList.length>0){
                    $("#form_tab_11 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
                }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

    });

    $("#form_tab_12").validate({

        ignore: ':hidden:not(.do_not_ignore)',
        showErrors: function(errorMap, errorList) {
                console.log(errorList);
                if(errorList.length>0){
                    $("#form_tab_12 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
                }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

    });

    $("#form_tab_13").validate({

        ignore: ':hidden:not(.do_not_ignore)',
        showErrors: function(errorMap, errorList) {
                console.log(errorList);
                if(errorList.length>0){
                    $("#form_tab_13 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
                }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

    });

    $("#form_tab_15").validate({

        ignore: ':hidden:not(.do_not_ignore)',
        showErrors: function(errorMap, errorList) {
                if(errorList.length>0){
                    $("#form_tab_15 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
                }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

    });

     $("#form_tab_16_soapp").validate({
        // Use this one to place the error
        ignore: ".ignore_fld",

       // errorLabelContainer: $("#form_tab_2 div.errorHolder")

      showErrors: function(errorMap, errorList) {
            if(errorList.length>0){

                $("#mad_refill_drug div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

     });

    $("#form_tab_16_comm").validate({
        // Use this one to place the error
        ignore: ".ignore_fld",

      showErrors: function(errorMap, errorList) {
            if(errorList.length>0){

                $("#mad_refill_drug div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

     });


    $("#form_tab_16_dast").validate({
        // Use this one to place the error
        ignore: ".ignore_fld",

      showErrors: function(errorMap, errorList) {
            if(errorList.length>0){

                $("#mad_refill_drug div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

     });


    $("#form_tab_16_padt").validate({
        // Use this one to place the error
        ignore: ".ignore_fld",

      showErrors: function(errorMap, errorList) {
            if(errorList.length>0){

                $("#mad_refill_drug div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

     });

    $("#form_tab_17").validate({

        ignore: ':hidden:not(.do_not_ignore)',
        showErrors: function(errorMap, errorList) {
                console.log(errorList);
                if(errorList.length>0){
                    $("#form_tab_17 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
                }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

    });

    $("#form_tab_18").validate({

        ignore: ':hidden:not(.do_not_ignore)',
        showErrors: function(errorMap, errorList) {
                console.log(errorList);
                if(errorList.length>0){
                    $("#form_tab_18 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
                }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

    });

    $("#form_tab_19").validate({

        ignore: ':hidden:not(.do_not_ignore)',
        showErrors: function(errorMap, errorList) {
                console.log(errorList);
                if(errorList.length>0){
                    $("#form_tab_19 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
                }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

    });

    // Pain Management 
    $("#form_tab_20_tmb").validate({
        // Use this one to place the error

        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {            
            console.log(errorMap);
            console.log(errorList);
            if(errorList.length>0)
            {
                $("#cronic_pain_assessment div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        }
    });

     $("#form_tab_20_treatment_history").validate({
        // Use this one to place the error

        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {            
            console.log(errorMap);
            console.log(errorList);
            if(errorList.length>0)
            {
                $("#cronic_pain_assessment div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        }
    });

    $("#form_tab_20_overdose_risk").validate({
        // Use this one to place the error

        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {            
            console.log(errorMap);
            console.log(errorList);
            if(errorList.length>0)
            {
                $("#cronic_pain_assessment div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        }
    });

    $("#form_tab_20_opioid_risk_tool").validate({
        // Use this one to place the error

        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {            
            console.log(errorMap);
            console.log(errorList);
            if(errorList.length>0)
            {
                $("#cronic_pain_assessment div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        }
    });
    // End Pai Management

    $("#form_tab_22").validate({

        ignore: ':hidden:not(.do_not_ignore)',
        showErrors: function(errorMap, errorList) {
                console.log(errorList);
                if(errorList.length>0){
                    $("#form_tab_22 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
                }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#form_tab_23_dmii").validate({
        // Use this one to place the error

        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {
            console.log('dmii');
            console.log(errorMap);
            console.log(errorList);
            if(errorList.length>0)
            {
                $("#chronic_assessment div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#form_tab_23_cad").validate({
        // Use this one to place the error
        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {
            console.log('cad');
            console.log(errorMap);
            console.log(errorList);
            if(errorList.length>0)
            {
                $("#chronic_assessment div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#form_tab_23_htn").validate({
        // Use this one to place the error

        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {
            console.log('htn');
            console.log(errorMap);
            console.log(errorList);
            if(errorList.length>0)
            {
                $("#chronic_assessment div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#form_tab_23_chf").validate({
        // Use this one to place the error
        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {
            console.log('cad');
            console.log(errorMap);
            console.log(errorList);
            if(errorList.length>0)
            {
                $("#chronic_assessment div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#form_tab_23_copd").validate({
        // Use this one to place the error
        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {
            console.log('cad');
            console.log(errorMap);
            console.log(errorList);
            if(errorList.length>0)
            {
                $("#chronic_assessment div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#form_tab_23_asthma").validate({
        // Use this one to place the error
        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {
            if(errorList.length>0)
            {
                $("#chronic_assessment div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#form_tab_23_general").validate({
        // Use this one to place the error

        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {
            console.log('general');
            console.log(errorMap);
            console.log(errorList);
            if(errorList.length>0)
            {
                $("#chronic_assessment div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });


    $("#form_tab_5").validate({
        // Use this one to place the error

        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {
            console.log('dmii');
            console.log(errorMap);
            console.log(errorList);
            if(errorList.length>0)
            {
                $("#form_tab_5 div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#form_tab_24").validate({

       // ignore: ':hidden:not(.do_not_ignore)',
        showErrors: function(errorMap, errorList) {
                console.log(errorList);
                if(errorList.length>0){
                    $("#form_tab_24 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
                }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#form_tab_14").validate({

  	ignore: ':hidden:not(.do_not_ignore)',
    	showErrors: function(errorMap, errorList) {
    			console.log(errorList);
    		  	if(errorList.length>0){
          		$("#form_tab_14 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
      		}
   	},
    submitHandler: function(form) {
            formsubmit(form);

        }
  });

    $("#form_tab_25").validate({
        // Use this one to place the error

        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {

            if(errorList.length>0)
            {
                $("#form_tab_25 div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#form_tab_26").validate({
        // Use this one to place the error

        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {

            if(errorList.length>0)
            {
                $("#form_tab_26 div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#form_tab_27").validate({
        // Use this one to place the error

        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {

            if(errorList.length>0)
            {
                $("#form_tab_27 div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#form_tab_32").validate({
        // Use this one to place the error

        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {

            if(errorList.length>0)
            {
                $("#form_tab_32 div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });


    $("#form_tab_28").validate({
        // Use this one to place the error

        //ignore: "not:hidden",
        showErrors: function(errorMap, errorList) {

            if(errorList.length>0)
            {
                $("#form_tab_28 div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#form_tab_29").validate({
        showErrors: function(errorMap, errorList) {
            if(errorList.length>0)
            {
                $("#form_tab_29 div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#form_tab_30").validate({
        showErrors: function(errorMap, errorList) {
            if(errorList.length>0)
            {
                $("#form_tab_30 div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#form_tab_31").validate({
        showErrors: function(errorMap, errorList) {
            if(errorList.length>0)
            {
                $("#form_tab_30 div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#form_tab_33").validate({
        showErrors: function(errorMap, errorList) {
            if(errorList.length>0)
            {
                $("#form_tab_33 div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }
    });

    $("#post_payment_form").validate({
        showErrors: function(errorMap, errorList) {
            if(errorList.length>0)
            {
                $("#post_payment_form div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },       
    });



    


    $("#verify_insurance").validate({
        showErrors: function(errorMap, errorList) {
            if(errorList.length>0)
            {                
                $("#verify_insurance div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },        
    });

     $("#add_race").validate({
        showErrors: function(errorMap, errorList) {
            if(errorList.length>0)
            {                
                $("#add_race div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
            }
        },        
    });


});

$( document ).ready(function() {
    $( ".trigger_click_if_checked" ).trigger("click"); // trigger click event on the checked radio buttom so that its child question made visible .
});
var date = new Date();
$('.chronic_dmii_question_238').datepicker({maxDate: date});



$(document).on("click", "input[type='radio'].chronic_dmii_question_240", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {
        	$('.chronic_dmii_question_226').val('');
           // $('.chronic_dmii_question_225_226').hide();

            $('.chronic_dmii_question_225_226').hide();
        	$('.chronic_dmii_question_240_225').hide();
        	$('.chronic_dmii_question_225_228').hide();
        	$('.chronic_dmii_question_225_229').hide();

        }else{

        	$('.chronic_dmii_question_225_226').removeClass('display_none_at_load_time').show();
        	$('.chronic_dmii_question_240_225').removeClass('display_none_at_load_time').show();
        	$('.chronic_dmii_question_225_228').removeClass('display_none_at_load_time').show();
        	$('.chronic_dmii_question_225_229').removeClass('display_none_at_load_time').show();

        }
    }
});

$(document).on("click", "input[type='checkbox'].chronic_dmii_question_223", function () {
	//console.log('dfdsf');
    if($(this).is(':checked')) {
    	//alert($(this).val());
        if ($(this).val() == 'No Special Diet') {

        	var id = $(this).attr('id');
        	$(".chronic_dmii_question_223").prop("checked", false);
        	$(".chronic_dmii_question_223#"+id).prop("checked", true);

        }else{


        	$('.chronic_dmii_question_223').each(function(index, value){

        		if($(this).val() == 'No Special Diet'){

        			$(this).prop("checked", false);
        		}
        	})


        }
    }
});

$(document).on("click", "input[type='checkbox'].chronic_dmii_question_226", function () {
	//console.log('dfdsf');
    if($(this).is(':checked')) {
    	//alert($(this).val());
        if ($(this).val() == 'None') {

        	var id = $(this).attr('id');
        	$(".chronic_dmii_question_226").prop("checked", false);
        	$(".chronic_dmii_question_226#"+id).prop("checked", true);

        }else{


        	$('.chronic_dmii_question_226').each(function(index, value){

        		if($(this).val() == 'None'){

        			$(this).prop("checked", false);
        		}
        	})


        }
    }
});

$(document).on("click", "input[type='radio'].chronic_dmii_question_230", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {
        	$('.chronic_dmii_question_231').val('');
            $('.chronic_dmii_question_230_231').hide();
        }
        else{

        	$('.chronic_dmii_question_230_231').removeClass('display_none_at_load_time').show();


        }
    }
});




$(document).on("click", "input[type='radio'].chronic_dmii_question_232", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {
        	$('.chronic_dmii_question_233').val('');
            $('.chronic_dmii_question_232_233').hide();
        }else{

        	$('.chronic_dmii_question_232_233').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='checkbox'].chronic_dmii_question_226", function () {

	var flag = false;
    $( "input[type='checkbox'].chronic_dmii_question_226" ).each(function( index, element ) {

	  	//alert($(element).val());

	  	if($(element).is(':checked') && $(element).val() == 'Other'){

	    	 flag = true;
	  	}
	  });

    if(flag){

    	$('.chronic_dmii_question_225_227').removeClass('display_none_at_load_time').show();
    }
    else{

    	$('.chronic_dmii_question_225_227').hide();
    }
});

$(document).ready(function () {

	var flag = false;
	$( "input[type='checkbox'].chronic_dmii_question_226" ).each(function( index, element ) {

	  	//alert($(element).val());

	  	if($(element).is(':checked') && $(element).val() == 'Other'){

	    	 flag = true;
	  	}
	  });

    if(flag){

    	$('.chronic_dmii_question_225_227').removeClass('display_none_at_load_time').show();
    }
    else{

    	$('.chronic_dmii_question_225_227').hide();
    }
});

$(document).on("click", "input[type='radio'].chronic_dmii_question_235", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

        	$('.chronic_dmii_question_235_add_reading_btn').hide();
        	$('.currentreadingfld_section').hide();
        }
        else{

        	$('.chronic_dmii_question_235_add_reading_btn').removeClass('display_none_at_load_time').show();
        	$('.currentreadingfld_section').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='radio'].chronic_htn_question_243", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.bp_add_reading_btn').hide();
            $('.currentbpreadingfld_section').hide();
        }
        else{

            $('.bp_add_reading_btn').removeClass('display_none_at_load_time').show();
            $('.currentbpreadingfld_section').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click",".currentbpreadingfldadd",function() {

    //patient can add up to 10 readings
    var bp_reading_rows = $('.currentbpreadingfld_section .currentbpreadingfld').length;
    if(bp_reading_rows < 10){

        var cloneob = $( ".clone_purpose_bp_reading_field_display_none" ).clone() ;
        $(cloneob).removeClass('clone_purpose_bp_reading_field_display_none').addClass('currentbpreadingfld');
        //$( cloneob ).find('input.med_suggestion').addClass('medicationbox');
        $(cloneob).insertAfter( ".currentbpreadingfld:last" );
    }
    else{

        $("#chronic_assessment div.errorHolder").addClass(' alert alert-danger').html("You cannot add more than 10 readings.");
        //alert('You cannot add more than 10 readings.');
    }

});

$(document).on("click",".currentbpreadingfldtimes",function() {
    //count the number of bp reading row.
    //patient cant remove the last row
    var bp_reading_rows = $('.currentbpreadingfld_section .currentbpreadingfld').length;
    if(bp_reading_rows > 1){
        $(this).parents('.currentbpreadingfld').remove();
    }
    else{

        $("#chronic_assessment div.errorHolder").addClass(' alert alert-danger').html("You have to fill at least one reading.");
        //alert('You cannot remove last reading.');
    }
});

$(document).on("click", "input[type='radio'].chronic_htn_question_292", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.current_htn_medicationfld_section').hide();
        }
        else{

            $('.current_htn_medicationfld_section').removeClass('display_none_at_load_time').show();
        }
    }
});

$('body').on('focus',".bp_reading_date", function(){
    var date = new Date();
    $(this).datepicker({
        maxDate: date
    });
});

$(document).on("click", "input[type='radio'].chronic_general_question_252", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {
            $('.chronic_general_question_253').val('');
            $('.chronic_general_question_252_253').hide();
        }
        else{

            $('.chronic_general_question_252_253').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='radio'].chronic_general_question_254", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {
            $('.chronic_general_question_255').val('');
            $('.chronic_general_question_254_255').hide();
        }
        else{

            $('.chronic_general_question_254_255').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='checkbox'].chronic_general_question_248", function () {

    var flag = false;
    $( "input[type='checkbox'].chronic_general_question_248" ).each(function( index, element ) {

        //alert($(element).val());

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.chronic_general_question_248_249').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.chronic_general_question_248_249').hide();
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].chronic_general_question_248" ).each(function( index, element ) {

        //alert($(element).val());

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.chronic_general_question_248_249').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.chronic_general_question_248_249').hide();
    }
});

$(document).on("click", "input[type='radio'].chronic_general_question_246", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {
            $('.chronic_dmii_question_247').val('');
            $('.chronic_general_question_246_247').hide();
            $('.chronic_general_question_246_248').hide();
            $('.chronic_general_question_246_250').hide();
            $('.chronic_general_question_246_251').hide();

        }else{

            $('.chronic_general_question_246_247').removeClass('display_none_at_load_time').show();
            $('.chronic_general_question_246_248').removeClass('display_none_at_load_time').show();
            $('.chronic_general_question_246_250').removeClass('display_none_at_load_time').show();
            $('.chronic_general_question_246_251').removeClass('display_none_at_load_time').show();

        }
    }
});

$(document).on("click", "input[type='checkbox'].chronic_general_question_244", function () {
    //console.log('dfdsf');
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == 'No Special Diet') {

            var id = $(this).attr('id');
            $(".chronic_general_question_244").prop("checked", false);
            $(".chronic_general_question_244#"+id).prop("checked", true);

        }else{


            $('.chronic_general_question_244').each(function(index, value){

                if($(this).val() == 'No Special Diet'){

                    $(this).prop("checked", false);
                }
            })


        }
    }
});

$(document).on("click", "input[type='checkbox'].chronic_general_question_248", function () {
    //console.log('dfdsf');
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == 'None') {

            var id = $(this).attr('id');
            $(".chronic_general_question_248").prop("checked", false);
            $(".chronic_general_question_248#"+id).prop("checked", true);

        }else{


            $('.chronic_general_question_248').each(function(index, value){

                if($(this).val() == 'None'){

                    $(this).prop("checked", false);
                }
            })


        }
    }
});


$(document).on("click", "input[type='radio'].chronic_general_question_258", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.chronic_general_question_259').prop("checked", false);
            $('.chronic_general_question_258_259').hide();
            $('.chronic_general_question_258_coffee').hide();
            $('.chronic_general_question_258_energy_drinks').hide();
            $('.chronic_general_question_258_green_black_tea').hide();

        }else{

            $('.chronic_general_question_258_259').removeClass('display_none_at_load_time').show();

        }
    }
});

$(document).on("click", "input[type='checkbox'].chronic_general_question_259", function () {

    var checked_arr = [];

  $( "input[type='checkbox'].chronic_general_question_259" ).each(function( index, element ) {


    if($(element).is(':checked')){

        if($(element).val() == 'Coffee'){

            $('.chronic_general_question_258_coffee').removeClass('display_none_at_load_time').show();
            checked_arr.push(260);
        }

        if($(element).val() == 'Energy drinks'){

            $('.chronic_general_question_258_energy_drinks').removeClass('display_none_at_load_time').show();
            checked_arr.push(261);
        }

        if($(element).val() == 'Green or black tea'){

            $('.chronic_general_question_258_green_black_tea').removeClass('display_none_at_load_time').show();
            checked_arr.push(262);
        }
    }
  });


    if(checked_arr.indexOf(260) == -1)
    {
        $('.chronic_general_question_260').prop('checked',false);
        $('.chronic_general_question_258_coffee').hide();
    }

    if(checked_arr.indexOf(261) == -1)
    {
        $('.chronic_general_question_261').prop('checked',false);
       $('.chronic_general_question_258_energy_drinks').hide();
    }

    if(checked_arr.indexOf(262) == -1)
    {
        $('.chronic_general_question_262').prop('checked',false);
       $('.chronic_general_question_258_green_black_tea').hide();
    }

});

$(document).ready(function () {

    var checked_arr = [];

  $( "input[type='checkbox'].chronic_general_question_259" ).each(function( index, element ) {


    if($(element).is(':checked')){

        if($(element).val() == 'Coffee'){

            $('.chronic_general_question_258_coffee').removeClass('display_none_at_load_time').show();
            checked_arr.push(260);
        }

        if($(element).val() == 'Energy drinks'){

            $('.chronic_general_question_258_energy_drinks').removeClass('display_none_at_load_time').show();
            checked_arr.push(261);
        }

        if($(element).val() == 'Green or black tea'){

            $('.chronic_general_question_258_green_black_tea').removeClass('display_none_at_load_time').show();
            checked_arr.push(262);
        }
    }
  });

    if(checked_arr.indexOf(260) == -1)
    {
        $('.chronic_general_question_260').prop('checked',false);
        $('.chronic_general_question_258_coffee').hide();
    }

    if(checked_arr.indexOf(261) == -1)
    {
        $('.chronic_general_question_261').prop('checked',false);
       $('.chronic_general_question_258_energy_drinks').hide();
    }

    if(checked_arr.indexOf(262) == -1)
    {
        $('.chronic_general_question_262').prop('checked',false);
       $('.chronic_general_question_258_green_black_tea').hide();
    }

});
//copd condition js

$(document).on("click", "input[type='checkbox'].chronic_copd_question_263", function () {

    var flag = false;
    $( "input[type='checkbox'].chronic_copd_question_263" ).each(function( index, element ) {

        //alert($(element).val());

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.chronic_copd_question_263_264').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.chronic_copd_question_264').val('');
        $('.chronic_copd_question_263_264').hide();
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].chronic_copd_question_263" ).each(function( index, element ) {

        //alert($(element).val());

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.chronic_copd_question_263_264').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.chronic_copd_question_264').val('');
        $('.chronic_copd_question_263_264').hide();
    }
});


$(document).on("click", "input[type='radio'].chronic_copd_question_278", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {

            $('.chronic_copd_question_278_279').removeClass('display_none_at_load_time').show();
            $('.chronic_copd_question_278_283').removeClass('display_none_at_load_time').show();
            $('.chronic_copd_question_278_280').removeClass('display_none_at_load_time').show();
            $('.chronic_copd_question_278_284').removeClass('display_none_at_load_time').show();
            $('.chronic_copd_question_278_285').removeClass('display_none_at_load_time').show();
        }
        else{
            $('.chronic_copd_question_280').prop('checked',false);
            $('.chronic_copd_question_279').val('');
            $('.chronic_copd_question_278_279').hide();
            $('.chronic_copd_question_278_280').hide();
            $('.chronic_copd_question_283').prop('checked',false);
            $('.chronic_copd_question_284').prop('checked',false);
            $('.chronic_copd_question_285').prop('checked',false);

            $('.chronic_copd_question_281').prop('checked',false);
            $('.chronic_copd_question_282').prop('checked',false);
            $('.chronic_copd_question_280_281').hide();
            $('.chronic_copd_question_281_282').hide();
            $('.chronic_copd_question_278_283').hide();
            $('.chronic_copd_question_278_284').hide();
            $('.chronic_copd_question_278_285').hide();
            $('.chronic_copd_question_286').val('');
            $('.chronic_copd_question_285_286').hide();
            $('.chronic_copd_question_287').prop('checked',false);
            $('.chronic_copd_question_285_287').hide();
            $('.chronic_copd_question_288').val('');
            $('.chronic_copd_question_287_288').hide();

        }
    }
});


$(document).on("click", "input[type='radio'].chronic_copd_question_280", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {

            $('.chronic_copd_question_280_281').removeClass('display_none_at_load_time').show();
        }
        else{

            $('.chronic_copd_question_281').prop('checked',false);
            $('.chronic_copd_question_282').prop('checked',false);
            $('.chronic_copd_question_280_281').hide();
            $('.chronic_copd_question_281_282').hide();
        }
    }
});


$(document).on("click", "input[type='radio'].chronic_copd_question_281", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.chronic_copd_question_282').prop('checked',false);
            $('.chronic_copd_question_281_282').hide();
        }
        else{

            $('.chronic_copd_question_281_282').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='radio'].chronic_copd_question_285", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {

            $('.chronic_copd_question_285_286').removeClass('display_none_at_load_time').show();
            $('.chronic_copd_question_285_287').removeClass('display_none_at_load_time').show();
        }
        else{

            $('.chronic_copd_question_286').val('');
            $('.chronic_copd_question_285_286').hide();
            $('.chronic_copd_question_287').prop('checked',false);
            $('.chronic_copd_question_285_287').hide();
            $('.chronic_copd_question_288').val('');
            $('.chronic_copd_question_287_288').hide();
        }
    }
});

$(document).on("click", "input[type='radio'].chronic_copd_question_287", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {

            $('.chronic_copd_question_287_288').removeClass('display_none_at_load_time').show();
        }
        else{
            $('.chronic_copd_question_288').val('');
            $('.chronic_copd_question_287_288').hide();
        }
    }
});



$(document).on("click", "input[type='radio'].chronic_copd_question_265", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {
            $('.chronic_copd_question_266').val('');
            $('.chronic_copd_question_265_266').hide();
        }
        else{

            $('.chronic_copd_question_265_266').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='radio'].chronic_copd_question_270", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {
            $('.chronic_copd_question_271').val('');
            $('.chronic_copd_question_272').val('');
           // $('.chronic_copd_question_273').val('');
            $('.chronic_copd_question_273').prop('checked',false);
            $('.chronic_copd_question_270_271').hide();
            $('.chronic_copd_question_270_272').hide();
            $('.chronic_copd_question_270_273').hide();
        }
        else{

            $('.chronic_copd_question_270_271').removeClass('display_none_at_load_time').show();
            $('.chronic_copd_question_270_272').removeClass('display_none_at_load_time').show();
            $('.chronic_copd_question_270_273').removeClass('display_none_at_load_time').show();

        }
    }
});

$(document).on("click", "input[type='radio'].chronic_copd_question_275", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {

            $('.chronic_copd_question_275_276').removeClass('display_none_at_load_time').show();
            $('.chronic_copd_question_275_320').removeClass('display_none_at_load_time').show();
        }
        else{

            $('.chronic_copd_question_276').val('');
            $('.chronic_copd_question_320').prop('checked',false);
            $('.chronic_copd_question_275_276').hide();
            $('.chronic_copd_question_275_320').hide();
        }
    }
});

$(document).on("click", "input[type='checkbox'].chronic_copd_question_320", function () {
    //console.log('dfdsf');
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == "I'm not sure") {

            var id = $(this).attr('id');
            $(".chronic_copd_question_320").prop("checked", false);
            $(".chronic_copd_question_320#"+id).prop("checked", true);

        }else{


            $('.chronic_copd_question_320').each(function(index, value){

                if($(this).val() == "I'm not sure"){

                    $(this).prop("checked", false);
                }
            })


        }
    }
});


$(document).on("click", "input[type='checkbox'].chronic_copd_question_289", function () {

    var flag = false;
    $( "input[type='checkbox'].chronic_copd_question_289" ).each(function( index, element ) {

        //alert($(element).val());

        if($(element).is(':checked') && $(element).val() == 'Medication'){

             flag = true;
        }
      });

    if(flag){

        $('.chronic_copd_question_289_290').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.chronic_copd_question_291').val('');
        $('.chronic_copd_question_290').prop('checked',false);
        $('.chronic_copd_question_289_290').hide();
        $('.chronic_copd_question_290_291').hide();
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].chronic_copd_question_289" ).each(function( index, element ) {

        //alert($(element).val());

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.chronic_copd_question_289_290').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.chronic_copd_question_291').val('');
        $('.chronic_copd_question_290').prop('checked',false);
        $('.chronic_copd_question_289_290').hide();
        $('.chronic_copd_question_290_291').hide();
    }
});


$(document).on("click", "input[type='checkbox'].chronic_copd_question_290", function () {

    var flag = false;
    $( "input[type='checkbox'].chronic_copd_question_290" ).each(function( index, element ) {

        //alert($(element).val());

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.chronic_copd_question_290_291').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.chronic_copd_question_291').val('');
        $('.chronic_copd_question_290_291').hide();
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].chronic_copd_question_290" ).each(function( index, element ) {

        //alert($(element).val());

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.chronic_copd_question_290_291').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.chronic_copd_question_291').val('');
        $('.chronic_copd_question_290_291').hide();
    }
});

$(document).on("click",".chronic_currentmedicationfldtimes",function() {

    var med_length = $('.currentmedicationfld').length;
    //alert(med_length);
    if(med_length > 1){
        $(this).parents('.currentmedicationfld').remove();
    }
    else{

        $("#chronic_assessment div.errorHolder").addClass(' alert alert-danger').html("You have to fill at least one medication.");
        //alert('You have to fill at least one medication.');
    }
 });

$(document).on("click", "input[type='radio'].chronic_cad_question_292", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.current_cad_medicationfld_section').hide();
        }
        else{

            $('.current_cad_medicationfld_section').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='radio'].chronic_chf_question_292", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.current_chf_medicationfld_section').hide();
        }
        else{

            $('.current_chf_medicationfld_section').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='radio'].chronic_dmii_question_292", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.current_dmii_medicationfld_section').hide();
        }
        else{

            $('.current_dmii_medicationfld_section').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='checkbox'].chronic_asthma_question_293", function () {

    var flag = false;
    $( "input[type='checkbox'].chronic_asthma_question_293" ).each(function( index, element ) {

        //alert($(element).val());

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.chronic_asthma_question_293_294').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.chronic_asthma_question_294').val('');
        $('.chronic_asthma_question_293_294').hide();
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].chronic_asthma_question_293" ).each(function( index, element ) {

        //alert($(element).val());

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.chronic_asthma_question_293_294').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.chronic_asthma_question_294').val('');
        $('.chronic_asthma_question_293_294').hide();
    }
});

$(document).on("click", "input[type='radio'].chronic_asthma_question_301", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {

            $('.chronic_asthma_question_301_302').removeClass('display_none_at_load_time').show();
        }
        else{

            $('.chronic_asthma_question_302').val('');
            $('.chronic_asthma_question_301_302').hide();
        }
    }
});

$(document).on("click", "input[type='radio'].chronic_asthma_question_303", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {

            $('.chronic_asthma_question_303_304').removeClass('display_none_at_load_time').show();
            $('.chronic_asthma_question_303_305').removeClass('display_none_at_load_time').show();
            $('.chronic_asthma_question_303_306').removeClass('display_none_at_load_time').show();
        }
        else{


            $('.chronic_asthma_question_304').val('');
            $('.chronic_asthma_question_303_304').hide();
            $('.chronic_asthma_question_305').prop('checked',false);
            $('.chronic_asthma_question_303_305').hide();
            $('.chronic_asthma_question_306').prop('checked',false);
            $('.chronic_asthma_question_303_306').hide();


            $('.chronic_asthma_question_307').val('');
            $('.chronic_asthma_question_306_307').hide();
            $('.chronic_asthma_question_308').prop('checked',false);
            $('.chronic_asthma_question_306_308').hide();
        }
    }
});

$(document).on("click", "input[type='radio'].chronic_asthma_question_306", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {

            $('.chronic_asthma_question_306_307').removeClass('display_none_at_load_time').show();
            $('.chronic_asthma_question_306_308').removeClass('display_none_at_load_time').show();
        }
        else{

            $('.chronic_asthma_question_307').val('');
            $('.chronic_asthma_question_306_307').hide();
            $('.chronic_asthma_question_308').prop('checked',false);
            $('.chronic_asthma_question_306_308').hide();
        }
    }
});

$(document).on("click", "input[type='radio'].chronic_asthma_question_313", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {

            $('.chronic_asthma_question_313_314').removeClass('display_none_at_load_time').show();
        }
        else{

            // $('.chronic_asthma_question_314').val('');
            $('.chronic_asthma_question_313_314').hide();
            $('.chronic_asthma_question_314').prop('checked',false);
        }
    }
});


$(document).on("click", "input[type='radio'].chronic_general_question_315", function () {

    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {

            $('.chronic_general_question_315_316').removeClass('display_none_at_load_time').show();
            $('.chronic_general_question_315_319').removeClass('display_none_at_load_time').show();
        }
        else{


            $('.chronic_asthma_question_316').val('');
            $('.chronic_asthma_question_319').prop('checked',false);
            $('.chronic_general_question_315_316').hide();
            $('.chronic_general_question_315_319').hide();
        }
    }
});



$(document).on("click", "input[type='radio'].chronic_general_question_317", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {

            $('.chronic_general_question_317_318').removeClass('display_none_at_load_time').show();
        }
        else{

            $('.chronic_general_question_318').val('');
            $('.chronic_general_question_317_318').hide();
        }
    }
});

$(document).on("click", "input[type='radio'].followup_medical_history_question_476", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.followup_general_question_476').hide();
        }
        else{
        	$('.followup_general_question_476').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='radio'].followup_medical_history_question_477", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {
            $('.followup_general_question_477').hide();
        }
        else{
        	$('.followup_general_question_477').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='radio'].followup_medical_history_question_497", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {
            $('.followup_general_question_497').hide();
        }
        else{
        	$('.followup_general_question_497').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='radio'].followup_medical_history_question_491", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {
            $('.followup_general_question_491_492').hide();
        }
        else{
        	$('.followup_general_question_491_492').removeClass('display_none_at_load_time').show();
        }
    }
});



$(document).on("click", "input[type='radio'].followup_medical_history_question_493", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {
            $('.followup_general_question_493_494').hide();
        }
        else{
        	$('.followup_general_question_493_494').removeClass('display_none_at_load_time').show();
        }
    }
});


// Pain Management
$(document).on("click", "input[type='checkbox'].chronic_pain_assessment_ques_170", function () {



    if($(this).is(':checked') == true &&   $(this).attr('fixval') == 'spinal injections') {                          

              $('.chornic_assessment_170_0').removeClass('display_none_at_load_time').show();                            
    }
    else if($(this).is(':checked') == false &&  $(this).attr('fixval') == 'spinal injections' )
    {
        $('.chornic_assessment_170_0').hide();
    } 

    
    if($(this).is(':checked') == true &&  $(this).attr('fixval') == 'joint injections') {             
              $('.chornic_assessment_170_1').removeClass('display_none_at_load_time').show();                
    }
    else if($(this).is(':checked') == false &&  $(this).attr('fixval') == 'joint injections' )
    {
        $('.chornic_assessment_170_1').hide();
    }  


   if($(this).is(':checked') == true &&   $(this).attr('fixval') == 'physical therapy') {                          
              $('.chornic_assessment_170_2').removeClass('display_none_at_load_time').show();                            
    }
    else if($(this).is(':checked') == false &&  $(this).attr('fixval') == 'physical therapy' )
    {
        $('.chornic_assessment_170_2').hide();
    } 
});

$(document).on("click", "input[type='checkbox'].chronic_pain_assessment_ques_173", function () {



    if($(this).is(':checked') == true &&   $(this).attr('fixval') == 'spinal injections') {                          

              $('.chornic_assessment_173_0').removeClass('display_none_at_load_time').show();                            
    }
    else if($(this).is(':checked') == false &&  $(this).attr('fixval') == 'spinal injections' )
    {
        $('.chornic_assessment_173_0').hide();
    } 

    
    if($(this).is(':checked') == true &&  $(this).attr('fixval') == 'joint injections') {             
              $('.chornic_assessment_173_1').removeClass('display_none_at_load_time').show();                
    }
    else if($(this).is(':checked') == false &&  $(this).attr('fixval') == 'joint injections' )
    {
        $('.chornic_assessment_173_1').hide();
    }  


   if($(this).is(':checked') == true &&   $(this).attr('fixval') == 'physical therapy') {                          
              $('.chornic_assessment_173_2').removeClass('display_none_at_load_time').show();                            
    }
    else if($(this).is(':checked') == false &&  $(this).attr('fixval') == 'physical therapy' )
    {
        $('.chornic_assessment_173_2').hide();
    } 


});

$(document).ready(function () {
    var flag = false;
    $( "input[type='checkbox'].chronic_pain_assessment_ques_170" ).each(function( index, element ) {

        if($(element).is(':checked') && $(this).attr('fixval') == 'spinal injections'){
             flag = true;
        }
      });

    if(flag){
        $('.chornic_assessment_170_0').removeClass('display_none_at_load_time').show();
    }
    else{
        $('.cancer_medical_question_357').val('');
        $('.chornic_assessment_170_0').hide();
    }
});


$(document).ready(function () {
    var flag = false;
    $( "input[type='checkbox'].chronic_pain_assessment_ques_170" ).each(function( index, element ) {

        if($(element).is(':checked') && $(this).attr('fixval') == 'joint injections'){
             flag = true;
        }
      });

    if(flag){
        $('.chornic_assessment_170_1').removeClass('display_none_at_load_time').show();
    }
    else{
        $('.cancer_medical_question_357').val('');
        $('.chornic_assessment_170_1').hide();
    }
});


$(document).ready(function () {
    var flag = false;
    $( "input[type='checkbox'].chronic_pain_assessment_ques_170" ).each(function( index, element ) {

        if($(element).is(':checked') && $(this).attr('fixval') == 'physical therapy'){
             flag = true;
        }
      });

    if(flag){
        $('.chornic_assessment_170_2').removeClass('display_none_at_load_time').show();
    }
    else{
        $('.cancer_medical_question_357').val('');
        $('.chornic_assessment_170_2').hide();
    }
});


$(document).ready(function () {
    var flag = false;
    $( "input[type='checkbox'].chronic_pain_assessment_ques_173" ).each(function( index, element ) {

        if($(element).is(':checked') && $(this).attr('fixval') == 'spinal injections'){
             flag = true;
        }
      });

    if(flag){
        $('.chornic_assessment_173_0').removeClass('display_none_at_load_time').show();
    }
    else{
        $('.cancer_medical_question_357').val('');
        $('.chornic_assessment_173_0').hide();
    }
});


$(document).ready(function () {
    var flag = false;
    $( "input[type='checkbox'].chronic_pain_assessment_ques_173" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'joint injections'){
             flag = true;
        }
      });

    if(flag){
        $('.chornic_assessment_173_1').removeClass('display_none_at_load_time').show();
    }
    else{
        $('.cancer_medical_question_357').val('');
        $('.chornic_assessment_173_1').hide();
    }
});



$(document).ready(function () {
    var flag = false;
    $( "input[type='checkbox'].chronic_pain_assessment_ques_173" ).each(function( index, element ) {

        if($(element).is(':checked') && $(this).attr('fixval') == 'physical therapy'){
             flag = true;
        }
      });

    if(flag){
        $('.chornic_assessment_173_2').removeClass('display_none_at_load_time').show();
    }
    else{
        $('.cancer_medical_question_357').val('');
        $('.chornic_assessment_173_2').hide();
    }
});

$(document).on("click", "input[type='radio'].chronic_pain_question_169", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {
            $('.chronic_treatmenthistory_question_168_170').removeClass('display_none_at_load_time').show();
        }
        else{            
            $('.chronic_treatmenthistory_question_168_170').hide();
            $('.chornic_assessment_170_0').hide();
            $('.chornic_assessment_170_1').hide();
            $('.chornic_assessment_170_2').hide();
            
            $('.chronic_pain_history170').prop("checked", false);

            $('.chronic_treatmenthistory_question_170').hide();

            $('.chronic_pain_assessment_ques_170').each(function(index, value){
                    $(this).prop("checked", false);                
            })
        }
    }
});

$(document).on("click", "input[type='radio'].chronic_pain_question_172", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {
            $('.chronic_treatmenthistory_question_172_173').removeClass('display_none_at_load_time').show();
        }
        else{
            $('.chronic_pain_assessment_ques_172').val('');
            $('.chronic_treatmenthistory_question_172_173').hide();

            $('.chornic_assessment_173_0').hide();
            $('.chornic_assessment_173_1').hide();
            $('.chornic_assessment_173_2').hide();
            
            $('.chronic_pain_history173').prop("checked", false);

            $('.chronic_treatmenthistory_question_173').hide();

            $('.chronic_pain_assessment_ques_173').each(function(index, value){
                    $(this).prop("checked", false);                
            })
        }
    }
});

$(document).on("click", "input[type='checkbox'].chronic_pain_assessment_ques_170", function () {    
    if($(this).is(':checked') == true && $(this).attr('fixval') == 'medication' ){                
            $('.chronic_treatmenthistory_question_170').removeClass('display_none_at_load_time').show();
            }        
        else if($(this).is(':checked') == false && $(this).attr('fixval') == 'medication'){               
            $('.chronic_treatmenthistory_question_170').hide();
        }   
});

$(document).on("click", "input[type='checkbox'].chronic_pain_assessment_ques_173", function () {    
    if($(this).is(':checked') == true && $(this).attr('fixval') == 'medication' ){                
            $('.chronic_treatmenthistory_question_173').removeClass('display_none_at_load_time').show();
            }        
        else if($(this).is(':checked') == false && $(this).attr('fixval') == 'medication'){               
            $('.chronic_treatmenthistory_question_173').hide();
        }   
});

$(document).ready(function () {

    var checked_arr = [];

  $("input[type='checkbox'].chronic_pain_assessment_ques_170" ).each(function( index, element ) {


    if($(element).is(':checked')){

        if($(element).val() == 'medication'){

            $('.chronic_treatmenthistory_question_170').removeClass('display_none_at_load_time').show();            
        }      
    }
  });
});

$(document).ready(function () {

    var checked_arr = [];

  $("input[type='checkbox'].chronic_pain_assessment_ques_173" ).each(function( index, element ) {


    if($(element).is(':checked')){

        if($(element).val() == 'medication'){

            $('.chronic_treatmenthistory_question_173').removeClass('display_none_at_load_time').show();            
        }      
    }
  });
});

$(document).on("click", "input[type='radio'].chronic_overdose_risk_question_191", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {

            $('.chronic_overdose_risk_question_191_192').removeClass('display_none_at_load_time').show();
        }
        else{            
            $('.chronic_overdose_risk_question_191_192').hide();
        }
    }
});


$(document).on("click", "input[type='radio'].chronic_overdose_risk_question_193", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {

            $('.opioid_overdose_risk_question_193_194').removeClass('display_none_at_load_time').show();
            $('.opioid_overdose_risk_question_193_195').removeClass('display_none_at_load_time').show();
        }
        else{            
            $('.opioid_overdose_risk_question_193_194').hide();
            $('.opioid_overdose_risk_question_193_195').hide();
        }
    }
});


$(document).on("click","input[type='checkbox'].check_pain",function() {

        if($(this).is(":checked")){
            // alert("Checkbox is checked.");
         $(this).parents('.shotshistoryfld').find('input').removeClass('on_load_display_none_cls');
        } else{
            // alert("Checkbox is not checked.");
       $(this).parents('.shotshistoryfld').find('input').addClass('on_load_display_none_cls');
        }
    });

$('body').on('focus',".chronicpain", function(){
    var date = new Date();
    $(this).datepicker({
        maxDate: date
    });
});

// End Pain management

// Pain Management
$('body').on('focus',".opioid_overdose_question_195", function(){
    var date = new Date();
    $(this).datepicker({
        maxDate: date
    });
});
// End Pain management


$('body').on('focus',".chronic_general_question_318", function(){
    var date = new Date();
    $(this).datepicker({
        maxDate: date
    });
});

$('body').on('focus',".pre_op_post_op461, .pre_op_post_op464", function(){
    var date = new Date();
    $(this).datepicker({
        maxDate: date
    });
});



$('body').on('focus',".peak_flow_reading_date", function(){
    var date = new Date();
    $(this).datepicker({
        maxDate: date
    });
});


$(document).on("click",".currentpeakflowreadingfldadd",function() {

    //patient can add up to 10 readings
    var peakflow_reading_rows = $('.currentpeakflowreadingfld_section .currentpeakflowreadingfld').length;
    if(peakflow_reading_rows < 10){

        var cloneob = $( ".clone_purpose_peak_flow_reading_field_display_none" ).clone() ;
        $(cloneob).removeClass('clone_purpose_peak_flow_reading_field_display_none').addClass('currentpeakflowreadingfld');
        //$( cloneob ).find('input.med_suggestion').addClass('medicationbox');
        $(cloneob).insertAfter( ".currentpeakflowreadingfld:last" );
    }
    else{

        $("#chronic_assessment div.errorHolder").addClass(' alert alert-danger').html("You cannot add more than 10 readings.");
        //alert('You cannot add more than 10 readings.');
    }

});

$(document).on("click",".currentpeakflowreadingfldtimes",function() {
    //count the number of bp reading row.
    //patient cant remove the last row
    var peakflow_reading_rows = $('.currentpeakflowreadingfld_section .currentpeakflowreadingfld').length;
    if(peakflow_reading_rows > 1){
        $(this).parents('.currentpeakflowreadingfld').remove();
    }
    else{

        $("#chronic_assessment div.errorHolder").addClass(' alert alert-danger').html("You have to fill at least one reading.");
        //alert('You cannot remove last reading.');
    }
});

$(document).on("click", "input[type='radio'].chronic_asthma_question_295", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.currentpeakflowreadingfld_section').hide();
        }
        else{

            $('.currentpeakflowreadingfld_section').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='checkbox'].chronic_general_question_319", function () {
    //console.log('dfdsf');
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == "I'm not sure") {

            var id = $(this).attr('id');
            $(".chronic_general_question_319").prop("checked", false);
            $(".chronic_general_question_319#"+id).prop("checked", true);

        }else{


            $('.chronic_general_question_319').each(function(index, value){

                if($(this).val() == "I'm not sure"){

                    $(this).prop("checked", false);
                }
            })
        }
    }
});


//cancer module tab number 25 js

/*$(document).on("click", "input[type='radio'].cancer_cc_question_320", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.cancer_cc_question_321').prop("checked", false);
            $('.cancer_cc_question_322').val('');

            $('.cancer_cc_question_320_321').hide();
            $('.cancer_cc_question_321_322').hide();

        }
        else{

            $('.cancer_cc_question_320_321').removeClass('display_none_at_load_time').show();


        }
    }
});*/

/*
$(document).on("click", "input[type='radio'].cancer_cc_question_333", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {

            $('.cancer_cc_question_332').prop("checked", false);
            $('.cancer_cc_question_333_332').hide();

            //hide child questions of 332

            $('.cancer_cc_question_321').prop("checked", false);
            $('.cancer_cc_question_322').val('');
            $('.cancer_cc_question_320_321').hide();
            $('.cancer_cc_question_321_322').hide();
            $('.cancer_cc_question_323').prop("checked", false);
            $('.cancer_cc_question_324').val('');
            $('.cancer_cc_question_332_323').hide();
            $('.cancer_cc_question_323_324').hide();
            $('.cancer_cc_question_325').prop("checked", false);
            $('.cancer_cc_question_332_325').hide();
            $('.cancer_cc_question_326').val('');
            $('.cancer_cc_question_325_326').hide();

        }
        else{

            $('.cancer_cc_question_333_332').removeClass('display_none_at_load_time').show();
        }
    }
});*/

$(document).on("click", "input[type='checkbox'].cancer_cc_question_332", function () {
    //console.log('dfd');
    var show_question = [];
    $("input[type='checkbox'].cancer_cc_question_332" ).each(function( index, element ) {

        if($(element).is(':checked')) {

            if ($(element).val() == 'I have a new cancer diagnosis'){

                //show_question = 321;
                show_question.push(321);

                $('.cancer_cc_question_320_321').removeClass('display_none_at_load_time').show();
            }
            else if($(element).val() == 'Something else'){

                //show_question = 326;
                show_question.push(326);
                $('.cancer_cc_question_325_326').removeClass('display_none_at_load_time').show();
            }
            else if($(element).val() == 'Referral for abnormal test result'){

               // show_question = 323;
               show_question.push(323);
                $('.cancer_cc_question_332_323').removeClass('display_none_at_load_time').show();
            }
            else if($(element).val() == 'Second opinion'){

                //show_question = 325;
                show_question.push(325);
                $('.cancer_cc_question_332_325').removeClass('display_none_at_load_time').show();
            }
        }

    });

    //logic for hide the questions

    if(show_question.indexOf(321) == -1){

        $('.cancer_cc_question_321').prop("checked", false);
        $('.cancer_cc_question_322').val('');

        $('.cancer_cc_question_320_321').hide();
        $('.cancer_cc_question_321_322').hide();
    }
    if(show_question.indexOf(323) == -1){

        $('.cancer_cc_question_323').prop("checked", false);
        $('.cancer_cc_question_324').val('');

        $('.cancer_cc_question_332_323').hide();
        $('.cancer_cc_question_323_324').hide();
    }
    if(show_question.indexOf(325) == -1){

        $('.cancer_cc_question_325').prop("checked", false);
        $('.cancer_cc_question_332_325').hide();
    }
    if(show_question.indexOf(326) == -1){

        $('.cancer_cc_question_326').val('');
        $('.cancer_cc_question_325_326').hide();
    }

});


$(document).ready(function () {
    //console.log('dfd');
    var show_question = [];
    $("input[type='checkbox'].cancer_cc_question_332" ).each(function( index, element ) {

        if($(element).is(':checked')) {

            if ($(element).val() == 'I have a new cancer diagnosis'){

                //show_question = 321;
                show_question.push(321);

                $('.cancer_cc_question_320_321').removeClass('display_none_at_load_time').show();
            }
            else if($(element).val() == 'Something else'){

                //show_question = 326;
                show_question.push(326);
                $('.cancer_cc_question_325_326').removeClass('display_none_at_load_time').show();
            }
            else if($(element).val() == 'Referral for abnormal test result'){

               // show_question = 323;
               show_question.push(323);
                $('.cancer_cc_question_332_323').removeClass('display_none_at_load_time').show();
            }
            else if($(element).val() == 'Second opinion'){

                //show_question = 325;
                show_question.push(325);
                $('.cancer_cc_question_332_325').removeClass('display_none_at_load_time').show();
            }
        }

    });

    //logic for hide the questions

    if(show_question.indexOf(321) == -1){

        $('.cancer_cc_question_321').prop("checked", false);
        $('.cancer_cc_question_322').val('');

        $('.cancer_cc_question_320_321').hide();
        $('.cancer_cc_question_321_322').hide();
    }
    if(show_question.indexOf(323) == -1){

        $('.cancer_cc_question_323').prop("checked", false);
        $('.cancer_cc_question_324').val('');

        $('.cancer_cc_question_332_323').hide();
        $('.cancer_cc_question_323_324').hide();
    }
    if(show_question.indexOf(325) == -1){

        $('.cancer_cc_question_325').prop("checked", false);
        $('.cancer_cc_question_332_325').hide();
    }
    if(show_question.indexOf(326) == -1){

        $('.cancer_cc_question_326').val('');
        $('.cancer_cc_question_325_326').hide();
    }

});

$(document).on("click", "input[type='checkbox'].cancer_cc_question_321", function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_cc_question_321" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_cc_question_321_322').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_cc_question_322').val('');
        $('.cancer_cc_question_321_322').hide();
    }
});


$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_cc_question_321" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_cc_question_321_322').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_cc_question_322').val('');
        $('.cancer_cc_question_321_322').hide();
    }
});


/*$(document).on("click", "input[type='checkbox'].cancer_cc_question_325", function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_cc_question_325" ).each(function( index, element ) {
        console.log($(element).val());
        if($(element).is(':checked') && $(element).val() == 'Something else'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_cc_question_325_326').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_cc_question_326').val('');
        $('.cancer_cc_question_325_326').hide();
    }
});*/

/*$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_cc_question_325" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Something else'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_cc_question_325_326').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_cc_question_326').val('');
        $('.cancer_cc_question_325_326').hide();
    }
});*/


$(document).on("click", "input[type='radio'].cancer_cc_question_327", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.cancer_cc_question_328').prop("checked", false);
            $('.cancer_cc_question_327_328').hide();

        }
        else{

            $('.cancer_cc_question_327_328').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='radio'].cancer_cc_question_329", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.cancer_cc_question_330').val('');
            $('.cancer_cc_question_329_330').hide();

        }
        else{

            $('.cancer_cc_question_329_330').removeClass('display_none_at_load_time').show();
        }
    }
});


//breast cancer js

$(document).on("click", "input[type='radio'].cancer_history_question_336", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.cancer_history_question_337').val('');
            $('.cancer_history_question_338').prop("checked", false);
            $('.cancer_history_question_336_337').hide();
            $('.cancer_history_question_336_338').hide();

        }
        else{

            $('.cancer_history_question_336_337').removeClass('display_none_at_load_time').show();
            $('.cancer_history_question_336_338').removeClass('display_none_at_load_time').show();
        }
    }
});


$(document).on("click", "input[type='radio'].cancer_history_question_342", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.cancer_history_question_343').prop("checked", false);
            $('.cancer_history_question_342_343').hide();
            $('.cancer_history_question_343_551').hide();
            $('.cancer_history_question_343_552').hide();
            $('.cancer_history_question_343_553').hide();
            $('.cancer_history_question_343_554').hide();
            $('.cancer_history_question_343_555').hide(); 

        }
        else{

            $('.cancer_history_question_342_343').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click","input[type='checkbox'].check_had_shot",function() {

        if($(this).is(":checked")){
            // alert("Checkbox is checked.");
         $(this).parents('.shotshistoryfld').find('select').removeClass('on_load_display_none_cls');
        } else{
            // alert("Checkbox is not checked.");
       $(this).parents('.shotshistoryfld').find('select').addClass('on_load_display_none_cls');
        }
    });

//cancer medical history js


$(document).on("click", "input[type='radio'].cancer_medical_question_344", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.cancer_medical_question_345').prop("checked", false);
            $('.cancer_medical_question_346').val('');
            $('.cancer_medical_question_344_345').hide();
            $('.cancer_medical_question_344_346').hide();

        }else if ($(this).val() == "I don't remember when") {
            $('.cancer_medical_question_345').prop("checked", false);
            $('.cancer_medical_question_346').val('');
            $('.cancer_medical_question_344_345').hide();
            $('.cancer_medical_question_344_346').hide();
        }
        else{

            $('.cancer_medical_question_344_345').removeClass('display_none_at_load_time').show();
            $('.cancer_medical_question_344_346').removeClass('display_none_at_load_time').show();
        }
    }
});


$(document).on("click", "input[type='radio'].cancer_medical_question_347", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.cancer_medical_question_348').val('');
            $('.cancer_medical_question_347_348').hide();

        }
        else{

            $('.cancer_medical_question_347_348').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='radio'].cancer_medical_question_349", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.cancer_medical_question_350').val('');
            $('.cancer_medical_question_349_350').hide();

        }
        else{

            $('.cancer_medical_question_349_350').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='radio'].cancer_medical_question_351", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.cancer_medical_question_352').val('');
            $('.cancer_medical_question_351_352').hide();

        }
        else{

            $('.cancer_medical_question_351_352').removeClass('display_none_at_load_time').show();
        }
    }
});



$(document).on("click", "input[type='radio'].cancer_medical_question_539", function () {
    if($(this).is(':checked')) {        

        if ($(this).val() == 'No') {
            $('.cancer_medical_question_540').prop('checked',false);
            $('.cancer_medical_question_541').prop('checked',false);
            $('.cancer_medical_question_543').prop('checked',false);            
            $('.cancer_medical_question_539_540').hide();
            $('.cancer_medical_question_539_541').hide();
            $('.cancer_medical_question_539_543').hide();

        }
        else{

            $('.cancer_medical_question_539_540').removeClass('display_none_at_load_time').show();
            $('.cancer_medical_question_539_541').removeClass('display_none_at_load_time').show();
            $('.cancer_medical_question_539_543').removeClass('display_none_at_load_time').show();
        }
        $('.cancer_medical_question_542').prop('checked',false);
        $('.cancer_medical_question_541_542').hide();
    }
});


$(document).on("click", "input[type='radio'].cancer_medical_question_541", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == 'No') {
            $('.cancer_medical_question_542').prop('checked',false);
            $('.cancer_medical_question_541_542').hide();
        }
        else{

            $('.cancer_medical_question_541_542').removeClass('display_none_at_load_time').show();
        }
    }
});


$(document).on("click", "input[type='checkbox'].cancer_personal_history", function () {
    var que_id = $(this).attr('data-que_id');
    console.log(que_id);
    if($(this).is(":checked")){
    //input element where you put value
    $(this).val("Yes");
    $(this).attr("fixval","Yes");
    // console.log($("#isClicked").val());              
  }
  else if($(this).is(":not(:checked)")){
    $(this).val("No");
    $(this).attr("fixval","No");
    //  console.log( $("#isClicked").val());
  }
});

$(document).ready(function () {
    $( "input[type='checkbox'].cancer_personal_history" ).each(function( index, element ) {
        // alert($(element).val())
        var que_id = $(element).attr('data-que_id');
        if($(element).is(':checked') && $(element).val() == 'Yes'){
             if(que_id == 528)
             {
                $('.cancer_medical_question_528_548').removeClass('display_none_at_load_time').show();
             }
        }
        else
        {
           if(que_id == 528)
             {
                $('.cancer_medical_question_548').prop("checked", false);
                $('.cancer_medical_question_528_548').hide();
             }
        }
      });

});

$(document).on("click", "input[type='checkbox'].cancer_family_history", function () {
    var que_id = $(this).attr('data-que_id');
    console.log(que_id);
    if($(this).is(":checked")){
    //input element where you put value
    $(this).val("Yes");
    $(this).attr("fixval","Yes");
    // console.log($("#isClicked").val());              
  }
  else if($(this).is(":not(:checked)")){
    $(this).val("No");
    $(this).attr("fixval","No");
    //  console.log( $("#isClicked").val());
  }
      if ($(this).val() == 'No') {
           $('.cancer_family_members_'+que_id).prop("checked", false);
           $('.cancer_family_members_que_'+que_id).hide();

           if(que_id == 362){
               var family_members = ['Mother', 'Father', 'Sister', 'Brother', "Cousin(mom's side)", "Cousin(dad's side)", "Grandmother(mom's side)",
                                "Grandmother(dad's side)", "Grandfather(mom's side)", "Grandfather(dad's side)", "Aunt(mom's side)",
                                "Aunt(dad's side)", "Uncle(mom's side)", "Uncle(dad's side)"];
               var family_members_key = [ 'mother', 'father', 'sister', 'brother', 'maternal cousin', 'paternal cousin',
                                   'maternal GM', 'paternal GM', 'maternal GF', 'paternal GF', 'maternal aunt', 'paternal aunt', 'maternal uncle', 'paternal uncle'];
               family_members_key.forEach((element) => {
                   element=element.replace(" ","_");
                   $('.diabetes_show_'+element).find('input[type="radio"]').prop("checked", false);
                   $('.diabetes_show_'+element).attr("style", "display: none !important");

               });
           }
       }
        else{
            $('.cancer_family_members_que_'+que_id).removeClass('display_none_at_load_time').show();
        }
});

$(document).ready(function () {
    $( "input[type='checkbox'].cancer_family_history" ).each(function( index, element ) {
        // alert($(element).val())
        var que_id = $(element).attr('data-que_id');
        if($(element).is(':checked') && $(element).val() == 'Yes'){

             $('.cancer_family_members_que_'+que_id).removeClass('display_none_at_load_time').show();
             if(que_id == 370)
             {
                $('.cancer_medical_question_370_371').removeClass('display_none_at_load_time').show();
             }
        }
        else
        {
            $('.cancer_family_members_'+que_id).prop("checked", false);
           $('.cancer_family_members_que_'+que_id).hide();
           if(que_id == 370)
             {
                $('.cancer_medical_question_371').val('');
                $('.cancer_medical_question_370_371').hide();
             }
        }
      });

});

// $(document).ready(function () {
//     $( "input[type='checkbox'].cancer_medical_question_370" ){
//         // alert($(element).val())
//         if ($(this).val() == 'No') {

//             $('.cancer_medical_question_371').val('');
//             $('.cancer_medical_question_370_371').hide();

//         }
//         else{

//             $('.cancer_medical_question_370_371').removeClass('display_none_at_load_time').show();
//         }
// }
// });


$(document).on("click", "input[type='checkbox'].cancer_medical_question_370", function () {


        if ($(this).val() == 'No') {

            $('.cancer_medical_question_371').val('');
            $('.cancer_medical_question_370_371').hide();

        }
        else{

            $('.cancer_medical_question_370_371').removeClass('display_none_at_load_time').show();
        }
});

$(document).on("click", "input[type='radio'].cancer_medical_question_362", function () {

    if($(this).is(':checked')) {
        // alert($(this).val())

        if ($(this).val() == 'No') {

            $('.cancer_medical_question_363').prop("checked", false);
            $('.cancer_medical_question_362_363').hide();

        }
        else{

            $('.cancer_medical_question_362_363').removeClass('display_none_at_load_time').show();
        }
    }
});




/*$(document).on("click", "input[type='checkbox'].cancer_medical_question_356", function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_medical_question_356" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_medical_question_356_357').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_medical_question_357').val('');
        $('.cancer_medical_question_356_357').hide();
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_medical_question_356" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_medical_question_356_357').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_medical_question_357').val('');
        $('.cancer_medical_question_356_357').hide();
    }
});*/


/*$(document).on("click", "input[type='checkbox'].cancer_history_question_334", function () {

    var is_show_other = false;
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'None of these'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_history_question_334" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             is_show_other = true;
        }

      });

    if(is_show_other){

        $('.cancer_history_question_334_372').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_medical_question_372').val('');
        $('.cancer_history_question_334_372').hide();
    }

    if(is_uncheck_all){

        $('.cancer_history_question_334').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);
        $('.cancer_medical_question_372').val('');
        $('.cancer_history_question_334_372').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_334" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'None of these'){

               $(this).prop("checked", false);
            }
        });
    }
});*/

$(document).on("click", "input[type='checkbox'].cancer_history_question_334", function () {

    var show_question_arr = [];
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'None of these'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_history_question_334" ).each(function( index, element ) {


        if($(element).is(':checked')){
            
            if($(element).val() == 'Nipple discharge'){

                show_question_arr.push(505);
                $('.cancer_history_question_334_505').removeClass('display_none_at_load_time').show();
                $('.cancer_history_question_334_506').removeClass('display_none_at_load_time').show();
            }
            
            if($(element).val() == 'Breast pain'){

                show_question_arr.push(507);
                $('.cancer_history_question_334_507').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Breast grew in size'){

                show_question_arr.push(508);
                $('.cancer_history_question_334_508').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Lump or swelling in armpit'){

                show_question_arr.push(509);
                $('.cancer_history_question_334_509').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Arm swelling'){

                show_question_arr.push(510);
                $('.cancer_history_question_334_510').removeClass('display_none_at_load_time').show();
            }


            if($(element).val() == 'Nipple changes'){

                show_question_arr.push(511);
                $('.cancer_history_question_334_511').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Nipple cratering (inversion)'){

                show_question_arr.push(513);
                $('.cancer_history_question_334_513').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Dimpling or puckering of breast skin'){

                show_question_arr.push(514);
                $('.cancer_history_question_334_514').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Other'){

                show_question_arr.push(515);
                $('.cancer_history_question_334_515').removeClass('display_none_at_load_time').show();
                $('.cancer_history_question_334_372').removeClass('display_none_at_load_time').show();
            }
        }

      });

    if(show_question_arr.includes(505) == false){

        $('.cancer_history_question_505').val('');
        $('.cancer_history_question_334_505').hide();
        $('.cancer_medical_question_506').prop('checked',false);
        $('.cancer_history_question_334_506').hide();
    }

    if(show_question_arr.includes(507) == false){

        $('.cancer_history_question_507').val('');
        $('.cancer_history_question_334_507').hide();
    }

    if(show_question_arr.includes(508) == false){

        $('.cancer_history_question_508').val('');
        $('.cancer_history_question_334_508').hide();
    }

    if(show_question_arr.includes(509) == false){

        $('.cancer_history_question_509').val('');
        $('.cancer_history_question_334_509').hide();
    }
    if(show_question_arr.includes(510) == false){

        $('.cancer_history_question_510').val('');
        $('.cancer_history_question_334_510').hide();
    }
    if(show_question_arr.includes(511) == false){

        $('.cancer_history_question_511').val('');
        $('.cancer_history_question_334_511').hide();
    }
    if(show_question_arr.includes(513) == false){

        $('.cancer_history_question_513').val('');
        $('.cancer_history_question_334_513').hide();
    }
    if(show_question_arr.includes(514) == false){

        $('.cancer_history_question_514').val('');
        $('.cancer_history_question_334_514').hide();
    }
    if(show_question_arr.includes(515) == false){

        $('.cancer_history_question_515').val('');
        $('.cancer_history_question_334_515').hide();
        $('.cancer_medical_question_372').val('');
        $('.cancer_history_question_334_372').hide();
    }

    if(is_uncheck_all){

        $('.cancer_history_question_334').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);

        $('.cancer_history_question_505').val('');
        $('.cancer_history_question_334_505').hide();
        $('.cancer_medical_question_506').prop('checked',false);
        $('.cancer_history_question_334_506').hide();
        $('.cancer_history_question_507').val('');
        $('.cancer_history_question_334_507').hide();
        $('.cancer_history_question_508').val('');
        $('.cancer_history_question_334_508').hide();
        $('.cancer_history_question_509').val('');
        $('.cancer_history_question_334_509').hide();
        $('.cancer_history_question_510').val('');
        $('.cancer_history_question_334_510').hide();
        $('.cancer_history_question_511').val('');
        $('.cancer_history_question_334_511').hide();
        $('.cancer_history_question_513').val('');
        $('.cancer_history_question_334_513').hide();
        $('.cancer_history_question_514').val('');
        $('.cancer_history_question_334_514').hide();
        $('.cancer_history_question_515').val('');
        $('.cancer_history_question_334_515').hide();
        $('.cancer_medical_question_372').val('');
        $('.cancer_history_question_334_372').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_334" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'None of these'){

               $(this).prop("checked", false);
            }
        });
    }

});


$(document).on("click", "input[type='checkbox'].cancer_history_question_343", function () {

   var show_question_arr = [];
   $( "input[type='checkbox'].cancer_history_question_343" ).each(function( index, element ) {


        if($(element).is(':checked')){
            
            if($(element).val() == 'Surgery'){
                show_question_arr.push(343);                
                $('.cancer_history_question_343_551').removeClass('display_none_at_load_time').show();
                $('.cancer_history_question_343_552').removeClass('display_none_at_load_time').show();
                $('.cancer_history_question_343_553').removeClass('display_none_at_load_time').show();
                $('.cancer_history_question_343_554').removeClass('display_none_at_load_time').show();
                $('.cancer_history_question_343_555').removeClass('display_none_at_load_time').show();
            }        
        }
      });

       if(show_question_arr.includes(343) == false){            
            $('.cancer_history_question_343_551').hide();
            $('.cancer_history_question_551').val('');
            $('.cancer_history_question_343_552').hide();
            $('.cancer_history_question_552').val('');
            $('.cancer_history_question_343_553').hide();
            $('.cancer_history_question_553').val('');
            $('.cancer_history_question_343_554').hide();
            $('.cancer_history_question_554').val('');
            $('.cancer_history_question_343_555').hide();           
            $('.cancer_history_question_555').val('');
        }
});

$(document).ready(function () {

    /*var flag = false;
    $( "input[type='checkbox'].cancer_history_question_334" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_history_question_334_372').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_medical_question_372').val('');
        $('.cancer_history_question_334_372').hide();
    }*/

    var show_question_arr = [];
    $( "input[type='checkbox'].cancer_history_question_334" ).each(function( index, element ) {


        if($(element).is(':checked')){
            
            if($(element).val() == 'Nipple discharge'){

                show_question_arr.push(505);
                $('.cancer_history_question_334_505').removeClass('display_none_at_load_time').show();
                $('.cancer_history_question_334_506').removeClass('display_none_at_load_time').show();
            }
            
            if($(element).val() == 'Breast pain'){

                show_question_arr.push(507);
                $('.cancer_history_question_334_507').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Breast grew in size'){

                show_question_arr.push(508);
                $('.cancer_history_question_334_508').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Lump or swelling in armpit'){

                show_question_arr.push(509);
                $('.cancer_history_question_334_509').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Arm swelling'){

                show_question_arr.push(510);
                $('.cancer_history_question_334_510').removeClass('display_none_at_load_time').show();
            }


            if($(element).val() == 'Nipple changes'){

                show_question_arr.push(511);
                $('.cancer_history_question_334_511').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Nipple cratering (inversion)'){

                show_question_arr.push(513);
                $('.cancer_history_question_334_513').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Dimpling or puckering of breast skin'){

                show_question_arr.push(514);
                $('.cancer_history_question_334_514').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Other'){

                show_question_arr.push(515);
                $('.cancer_history_question_334_515').removeClass('display_none_at_load_time').show();
                $('.cancer_history_question_334_372').removeClass('display_none_at_load_time').show();
            }
        }

      });

    if(show_question_arr.includes(505) == false){

        $('.cancer_history_question_505').val('');
        $('.cancer_history_question_334_505').hide();
        $('.cancer_medical_question_506').prop('checked',false);
        $('.cancer_history_question_334_506').hide();
    }

    if(show_question_arr.includes(507) == false){

        $('.cancer_history_question_507').val('');
        $('.cancer_history_question_334_507').hide();
    }

    if(show_question_arr.includes(508) == false){

        $('.cancer_history_question_508').val('');
        $('.cancer_history_question_334_508').hide();
    }

    if(show_question_arr.includes(509) == false){

        $('.cancer_history_question_509').val('');
        $('.cancer_history_question_334_509').hide();
    }
    if(show_question_arr.includes(510) == false){

        $('.cancer_history_question_510').val('');
        $('.cancer_history_question_334_510').hide();
    }
    if(show_question_arr.includes(511) == false){

        $('.cancer_history_question_511').val('');
        $('.cancer_history_question_334_511').hide();
    }
    if(show_question_arr.includes(513) == false){

        $('.cancer_history_question_513').val('');
        $('.cancer_history_question_334_513').hide();
    }
    if(show_question_arr.includes(514) == false){

        $('.cancer_history_question_514').val('');
        $('.cancer_history_question_334_514').hide();
    }
    if(show_question_arr.includes(515) == false){

        $('.cancer_history_question_515').val('');
        $('.cancer_history_question_334_515').hide();
        $('.cancer_medical_question_372').val('');
        $('.cancer_history_question_334_372').hide();
    }
});



$(document).ready(function () {


    var show_question_arr = [];
    $( "input[type='checkbox'].cancer_history_question_343" ).each(function( index, element ) {


        if($(element).is(':checked')){
            
            if($(element).val() == 'Surgery'){                

                show_question_arr.push(505);
                $('.cancer_history_question_343_551').removeClass('display_none_at_load_time').show();
                $('.cancer_history_question_343_552').removeClass('display_none_at_load_time').show();
                $('.cancer_history_question_343_553').removeClass('display_none_at_load_time').show();
                $('.cancer_history_question_343_554').removeClass('display_none_at_load_time').show();
                $('.cancer_history_question_343_555').removeClass('display_none_at_load_time').show();

            }            
        }

      });
  });

$(document).on("click", "input[type='checkbox'].cancer_history_question_506", function () {

    if($(this).is(':checked') && $(this).val() == 'Not sure'){
        $('.cancer_history_question_506').prop("checked", false);
        var checkbox_id = $(this).attr('id');
        $('#'+checkbox_id).prop("checked", true);
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_506" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'Not sure'){

               $(this).prop("checked", false);
            }
        });
    }
});


$(document).on("click", "input[type='checkbox'].cancer_history_question_341", function () {

    if($(this).is(':checked') && $(this).val() == 'Dont know'){
        $('.cancer_history_question_341').prop("checked", false);
        var checkbox_id = $(this).attr('id');
        $('#'+checkbox_id).prop("checked", true);
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_341" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'Dont know'){

               $(this).prop("checked", false);
            }
        });
    }
});


$(document).on("click", "input[type='checkbox'].cancer_history_question_343", function () {

    if($(this).is(':checked') && $(this).val() == 'Not sure'){
        $('.cancer_history_question_343').prop("checked", false);
        var checkbox_id = $(this).attr('id');
        $('#'+checkbox_id).prop("checked", true);
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_343" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'Not sure'){

               $(this).prop("checked", false);
            }
        });
    }
});

$(document).on("click", "input[type='checkbox'].cancer_cc_question_323", function () {

    var is_show_other = false;
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'Not sure'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_cc_question_323" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             is_show_other = true;
        }

      });

    if(is_show_other){

        $('.cancer_cc_question_323_324').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_cc_question_324').val('');
        $('.cancer_cc_question_323_324').hide();
    }

    if(is_uncheck_all){

        $('.cancer_cc_question_323').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);
        $('.cancer_cc_question_324').val('');
        $('.cancer_cc_question_323_324').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_cc_question_323" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'Not sure'){

               $(this).prop("checked", false);
            }
        });
    }
});


/*$(document).on("click", "input[type='checkbox'].cancer_cc_question_323", function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_cc_question_323" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_cc_question_323_324').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_cc_question_324').val('');
        $('.cancer_cc_question_323_324').hide();
    }
});*/

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_cc_question_323" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_cc_question_323_324').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_cc_question_324').val('');
        $('.cancer_cc_question_323_324').hide();
    }
});


$(document).on("click", "input[type='radio'].cancer_medical_question_384", function () {

    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            console.log('no');
            $('.cancer_medical_question_385').val('');
            $('.cancer_medical_question_386').val('');
            $('.cancer_medical_question_387').val('');
            $('.cancer_medical_question_388').prop("checked", false);
            $('.cancer_medical_question_384_385').hide();
            $('.cancer_medical_question_384_386').hide();
            $('.cancer_medical_question_384_387').hide();
            $('.cancer_medical_question_384_388').hide();

            $('.cancer_medical_question_384_389').removeClass('display_none_at_load_time').show();


        }
        else if ($(this).val() == 'Yes') {

            console.log('yes');
            $('.cancer_medical_question_389').prop("checked", false);
            $('.cancer_medical_question_384_389').hide();
            $('.cancer_medical_question_390').val('');
            $('.cancer_medical_question_389_390').hide();
            $('.cancer_medical_question_392').val('');
            $('.cancer_medical_question_391_392').hide();
            $('.cancer_medical_question_391').prop("checked", false);
            $('.cancer_medical_question_389_391').hide();

            $('.cancer_medical_question_384_385').removeClass('display_none_at_load_time').show();
            $('.cancer_medical_question_384_386').removeClass('display_none_at_load_time').show();
            $('.cancer_medical_question_384_387').removeClass('display_none_at_load_time').show();
            $('.cancer_medical_question_384_388').removeClass('display_none_at_load_time').show();

        }
        else{

            $('.cancer_medical_question_385').val('');
            $('.cancer_medical_question_386').val('');
            $('.cancer_medical_question_387').val('');
            $('.cancer_medical_question_388').prop("checked", false);
            $('.cancer_medical_question_389').prop("checked", false);
            $('.cancer_medical_question_384_385').hide();
            $('.cancer_medical_question_384_386').hide();
            $('.cancer_medical_question_384_387').hide();
            $('.cancer_medical_question_384_388').hide();
            $('.cancer_medical_question_384_389').hide();

            $('.cancer_medical_question_390').val('');
            $('.cancer_medical_question_389_390').hide();
            $('.cancer_medical_question_392').val('');
            $('.cancer_medical_question_391_392').hide();
            $('.cancer_medical_question_391').prop("checked", false);
            $('.cancer_medical_question_389_391').hide();
        }
    }
});


$(document).on("click", "input[type='radio'].cancer_medical_question_391", function () {

    if($(this).is(':checked')) {

        if ($(this).val() == 'Other') {
          $('.cancer_medical_question_391_392').removeClass('display_none_at_load_time').show();
        }
        else{
            $('.cancer_medical_question_392').val('');
            $('.cancer_medical_question_391_392').hide();
        }
    }
});


$(document).on("click", "input[type='radio'].cancer_medical_question_389", function () {

    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {

            $('.cancer_medical_question_392').val('');
            $('.cancer_medical_question_391_392').hide();
            $('.cancer_medical_question_391').prop("checked", false);
            $('.cancer_medical_question_389_391').hide();

            $('.cancer_medical_question_389_390').removeClass('display_none_at_load_time').show();
        }
        else if ($(this).val() == 'No') {

            $('.cancer_medical_question_390').val('');
            $('.cancer_medical_question_389_390').hide();
            $('.cancer_medical_question_389_391').removeClass('display_none_at_load_time').show();
        }
        else{
            $('.cancer_medical_question_390').val('');
            $('.cancer_medical_question_389_390').hide();
            $('.cancer_medical_question_392').val('');
            $('.cancer_medical_question_391_392').hide();
            $('.cancer_medical_question_391').prop("checked", false);
            $('.cancer_medical_question_389_391').hide();
        }
    }
});


$(document).on("click", "input[type='checkbox'].cancer_medical_question_374", function () {

    var show_question_arr = [];

    $( "input[type='checkbox'].cancer_medical_question_374" ).each(function( index, element ) {


        if($(element).is(':checked')){
            console.log($(element).val());
            if($(element).val() == 'Birth control pills'){

                show_question_arr.push(375);
                $('.cancer_medical_question_374_375').removeClass('display_none_at_load_time').show();
            }
            /*if($(element).val() == 'Patches'){

                show_question_arr.push(376);
                $('.cancer_medical_question_374_376').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Estrogen creams'){

                show_question_arr.push(377);
                $('.cancer_medical_question_374_377').removeClass('display_none_at_load_time').show();
            }*/
            if($(element).val() == 'Depot injections'){

                show_question_arr.push(378);
                $('.cancer_medical_question_374_378').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Vaginal rings'){

                show_question_arr.push(379);
                $('.cancer_medical_question_374_379').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'IUD'){

                show_question_arr.push(380);
                $('.cancer_medical_question_374_380').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Implants'){

                show_question_arr.push(381);
                $('.cancer_medical_question_374_381').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Pellets'){

                show_question_arr.push(504);
                $('.cancer_medical_question_374_504').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Other'){

                show_question_arr.push(382);
                $('.cancer_medical_question_374_382').removeClass('display_none_at_load_time').show();
                $('.cancer_medical_question_374_383').removeClass('display_none_at_load_time').show();
            }
        }

      });

    if(show_question_arr.includes(375) == false){

        $('.cancer_medical_question_375').val('');
        $('.cancer_medical_question_374_375').hide();
    }

    /*if(show_question_arr.includes(376) == false){
        $('.cancer_medical_question_376').val('');
        $('.cancer_medical_question_374_376').hide();
    }

    if(show_question_arr.includes(377) == false){
        $('.cancer_medical_question_377').val('');
        $('.cancer_medical_question_374_377').hide();
    }*/

    if(show_question_arr.includes(378) == false){
        $('.cancer_medical_question_378').val('');
        $('.cancer_medical_question_374_378').hide();
    }
    if(show_question_arr.includes(379) == false){
        $('.cancer_medical_question_379').val('');
        $('.cancer_medical_question_374_379').hide();
    }
    if(show_question_arr.includes(380) == false){
        $('.cancer_medical_question_380').val('');
        $('.cancer_medical_question_374_380').hide();
    }
    if(show_question_arr.includes(381) == false){
        $('.cancer_medical_question_381').val('');
        $('.cancer_medical_question_374_381').hide();
    }
    if(show_question_arr.includes(382) == false){
        $('.cancer_medical_question_382').val('');
        $('.cancer_medical_question_374_382').hide();
        $('.cancer_medical_question_383').val('');
        $('.cancer_medical_question_374_383').hide();
    }
    if(show_question_arr.includes(504) == false){

        $('.cancer_medical_question_504').val('');
        $('.cancer_medical_question_374_504').hide();
    }

});

$(document).ready(function () {

    var show_question_arr = [];

    $( "input[type='checkbox'].cancer_medical_question_374" ).each(function( index, element ) {


        if($(element).is(':checked')){
            console.log($(element).val());
            if($(element).val() == 'Birth control pills'){

                show_question_arr.push(375);
                $('.cancer_medical_question_374_375').removeClass('display_none_at_load_time').show();
            }
            /*if($(element).val() == 'Patches'){

                show_question_arr.push(376);
                $('.cancer_medical_question_374_376').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Estrogen creams'){

                show_question_arr.push(377);
                $('.cancer_medical_question_374_377').removeClass('display_none_at_load_time').show();
            }*/
            if($(element).val() == 'Depot injections'){

                show_question_arr.push(378);
                $('.cancer_medical_question_374_378').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Vaginal rings'){

                show_question_arr.push(379);
                $('.cancer_medical_question_374_379').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'IUD'){

                show_question_arr.push(380);
                $('.cancer_medical_question_374_380').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Implants'){

                show_question_arr.push(381);
                $('.cancer_medical_question_374_381').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Pellets'){

                show_question_arr.push(504);
                $('.cancer_medical_question_374_504').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Other'){

                show_question_arr.push(382);
                $('.cancer_medical_question_374_382').removeClass('display_none_at_load_time').show();
                $('.cancer_medical_question_374_383').removeClass('display_none_at_load_time').show();
            }
        }

      });

    if(show_question_arr.includes(375) == false){

        $('.cancer_medical_question_375').val('');
        $('.cancer_medical_question_374_375').hide();
    }

    /*if(show_question_arr.includes(376) == false){
        $('.cancer_medical_question_376').val('');
        $('.cancer_medical_question_374_376').hide();
    }

    if(show_question_arr.includes(377) == false){
        $('.cancer_medical_question_377').val('');
        $('.cancer_medical_question_374_377').hide();
    }*/

    if(show_question_arr.includes(378) == false){
        $('.cancer_medical_question_378').val('');
        $('.cancer_medical_question_374_378').hide();
    }
    if(show_question_arr.includes(379) == false){
        $('.cancer_medical_question_379').val('');
        $('.cancer_medical_question_374_379').hide();
    }
    if(show_question_arr.includes(380) == false){
        $('.cancer_medical_question_380').val('');
        $('.cancer_medical_question_374_380').hide();
    }
    if(show_question_arr.includes(381) == false){
        $('.cancer_medical_question_381').val('');
        $('.cancer_medical_question_374_381').hide();
    }
    if(show_question_arr.includes(382) == false){
        $('.cancer_medical_question_382').val('');
        $('.cancer_medical_question_374_382').hide();
        $('.cancer_medical_question_383').val('');
        $('.cancer_medical_question_374_383').hide();
    }
    if(show_question_arr.includes(504) == false){

        $('.cancer_medical_question_504').val('');
        $('.cancer_medical_question_374_504').hide();
    }

});

$(document).on("click", "input[type='radio'].cancer_medical_question_373", function () {

    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.cancer_medical_question_374').prop("checked", false);
            $('.cancer_medical_question_373_374').hide();
            $('.cancer_medical_question_375').val('');
            $('.cancer_medical_question_374_375').hide();

           /* $('.cancer_medical_question_376').val('');
            $('.cancer_medical_question_374_376').hide();
            $('.cancer_medical_question_377').val('');
            $('.cancer_medical_question_374_377').hide();*/
            $('.cancer_medical_question_378').val('');
            $('.cancer_medical_question_374_378').hide();
            $('.cancer_medical_question_379').val('');
            $('.cancer_medical_question_374_379').hide();
            $('.cancer_medical_question_380').val('');
            $('.cancer_medical_question_374_380').hide();
            $('.cancer_medical_question_381').val('');
            $('.cancer_medical_question_374_381').hide();
            $('.cancer_medical_question_382').val('');
            $('.cancer_medical_question_374_382').hide();
            $('.cancer_medical_question_383').val('');
            $('.cancer_medical_question_374_383').hide();
        }
        else{

            $('.cancer_medical_question_373_374').removeClass('display_none_at_load_time').show();
        }
    }
});


$(document).on("click", "input[type='checkbox'].cancer_medical_question_499", function () {

    var show_question_arr = [];

    $( "input[type='checkbox'].cancer_medical_question_499" ).each(function( index, element ) {


        if($(element).is(':checked')){
            console.log($(element).val());
            if($(element).val() == 'Pills'){

                show_question_arr.push(500);
                $('.cancer_medical_question_499_500').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Patches'){

                show_question_arr.push(376);
                $('.cancer_medical_question_374_376').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Estrogen creams'){

                show_question_arr.push(377);
                $('.cancer_medical_question_374_377').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Other'){

                show_question_arr.push(501);
                $('.cancer_medical_question_499_501').removeClass('display_none_at_load_time').show();
                $('.cancer_medical_question_499_502').removeClass('display_none_at_load_time').show();
            }
        }

      });

    if(show_question_arr.includes(500) == false){

        $('.cancer_medical_question_500').val('');
        $('.cancer_medical_question_499_500').hide();
    }

    if(show_question_arr.includes(376) == false){
        $('.cancer_medical_question_376').val('');
        $('.cancer_medical_question_374_376').hide();
    }

    if(show_question_arr.includes(377) == false){
        $('.cancer_medical_question_377').val('');
        $('.cancer_medical_question_374_377').hide();
    }
    if(show_question_arr.includes(501) == false){
        $('.cancer_medical_question_501').val('');
        $('.cancer_medical_question_499_501').hide();
        $('.cancer_medical_question_502').val('');
        $('.cancer_medical_question_499_502').hide();
    }

});

$(document).ready(function () {

    var show_question_arr = [];

    $( "input[type='checkbox'].cancer_medical_question_499" ).each(function( index, element ) {


        if($(element).is(':checked')){
            console.log($(element).val());
            if($(element).val() == 'Pills'){

                show_question_arr.push(500);
                $('.cancer_medical_question_499_500').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Patches'){

                show_question_arr.push(376);
                $('.cancer_medical_question_374_376').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Estrogen creams'){

                show_question_arr.push(377);
                $('.cancer_medical_question_374_377').removeClass('display_none_at_load_time').show();
            }
            if($(element).val() == 'Other'){

                show_question_arr.push(501);
                $('.cancer_medical_question_499_501').removeClass('display_none_at_load_time').show();
                $('.cancer_medical_question_499_502').removeClass('display_none_at_load_time').show();
            }
        }

      });

    if(show_question_arr.includes(500) == false){

        $('.cancer_medical_question_500').val('');
        $('.cancer_medical_question_499_500').hide();
    }

    if(show_question_arr.includes(376) == false){
        $('.cancer_medical_question_376').val('');
        $('.cancer_medical_question_374_376').hide();
    }

    if(show_question_arr.includes(377) == false){
        $('.cancer_medical_question_377').val('');
        $('.cancer_medical_question_374_377').hide();
    }
    if(show_question_arr.includes(501) == false){
        $('.cancer_medical_question_501').val('');
        $('.cancer_medical_question_499_501').hide();
        $('.cancer_medical_question_502').val('');
        $('.cancer_medical_question_499_502').hide();
    }

});

$(document).on("click", "input[type='radio'].cancer_medical_question_498", function () {

    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.cancer_medical_question_499').prop("checked", false);
            $('.cancer_medical_question_498_499').hide();
            $('.cancer_medical_question_376').val('');
            $('.cancer_medical_question_374_376').hide();
            $('.cancer_medical_question_377').val('');
            $('.cancer_medical_question_374_377').hide();
            $('.cancer_medical_question_500').val('');
            $('.cancer_medical_question_499_500').hide();
            $('.cancer_medical_question_501').val('');
            $('.cancer_medical_question_499_501').hide();
            $('.cancer_medical_question_502').val('');
            $('.cancer_medical_question_499_502').hide();
        }
        else{

            $('.cancer_medical_question_498_499').removeClass('display_none_at_load_time').show();
        }
    }
});

$('body').on('focus',".cancer_medical_question_385", function(){
    var date = new Date();
    $(this).datepicker({
        maxDate: date
    });
});

//show cancer related child question for family members
/*$(document).on("click", "input[type='checkbox'].cancer_family_members_355", function () {

    var show_question_arr = [];

    $( "input[type='checkbox'].cancer_family_members_355" ).each(function( index, element ) {

        if($(element).is(':checked')){

            var name = $(this).attr('data-name');
            show_question_arr.push(name);
            $('.'+name+"_cancer_detail_section").removeClass('display_none_at_load_time').show();
        }
    });

    console.log(show_question_arr);

});*/


$(document).on("click", "input[type='checkbox'].family_members_cancer_type", function () {

    var flag = false;
    var name = $(this).attr('data-name');
    $( "input[type='checkbox']."+name+"_disease_detail" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

            flag = true;
        }
      });

    if(flag){

        $('.'+name+"_other_cancer").removeClass('display_none_at_load_time').show();
    }
    else{

        $('.'+name+"_other_cancer_textbox").val('');
        $('.'+name+"_other_cancer").hide();
    }
});

$(document).ready(function () {

    $( "input[type='checkbox'].family_members_cancer_type" ).each(function( index, element ) {

        var flag = false;
        var name = $(this).attr('data-name');

        $( "input[type='checkbox']."+name+"_disease_detail" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'Other'){

                flag = true;
            }
        });

        if(flag){

            $('.'+name+"_other_cancer").removeClass('display_none_at_load_time').show();
        }
        else{

            $('.'+name+"_other_cancer_textbox").val('');
            $('.'+name+"_other_cancer").hide();
        }

    });
});


$(document).on("click", "input[type='checkbox'].cancer_medical_question_355", function () {

        if ($(this).val() == 'No') {

            $('.family_members_cancer_type').prop("checked", false);
            $('.other_cancer_textbox').val('');
            $('.age_detail').val('');
            $('.cancer_type_detail_section').hide();

        }
});

// esophageal cancer js
$(document).on("click", "input[type='checkbox'].cancer_history_question_393", function () {

    var show_question_arr = [];
    $( "input[type='checkbox'].cancer_history_question_393" ).each(function( index, element ) {

        if($(element).is(':checked')){

            if($(element).val() == 'Other'){

                show_question_arr.push(395);
                $('.cancer_history_question_393_395').removeClass('display_none_at_load_time').show();
            }

            if($(element).val() == 'Trouble swallowing'){

                show_question_arr.push(394);
                $('.cancer_history_question_393_394').removeClass('display_none_at_load_time').show();
            }
        }
    });

    if(show_question_arr.includes(395) == false){
        $('.cancer_history_question_395').val('');
        $('.cancer_history_question_393_395').hide();
    }

    if(show_question_arr.includes(394) == false){
        $('.cancer_history_question_394').prop("checked", false);
        $('.cancer_history_question_393_394').hide();
    }


});

$(document).ready(function () {

    var show_question_arr = [];
    $( "input[type='checkbox'].cancer_history_question_393" ).each(function( index, element ) {

        if($(element).is(':checked')){

            if($(element).val() == 'Other'){

                show_question_arr.push(395);
                $('.cancer_history_question_393_395').removeClass('display_none_at_load_time').show();
            }

            if($(element).val() == 'Trouble swallowing'){

                show_question_arr.push(394);
                $('.cancer_history_question_393_394').removeClass('display_none_at_load_time').show();
            }
        }
    });

    if(show_question_arr.includes(395) == false){
        $('.cancer_history_question_395').val('');
        $('.cancer_history_question_393_395').hide();
    }

    if(show_question_arr.includes(394) == false){
        $('.cancer_history_question_394').prop("checked", false);
        $('.cancer_history_question_393_394').hide();
    }

});

$(document).on("click", "input[type='checkbox'].cancer_history_question_397", function () {
    //console.log('dfdsf');
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == "Don't know") {

            var id = $(this).attr('id');
            $(".cancer_history_question_397").prop("checked", false);
            $(".cancer_history_question_397#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_397').each(function(index, value){

                if($(this).val() == "Don't know"){

                    $(this).prop("checked", false);
                }
            })


        }
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_399", function () {
    //console.log('dfdsf');
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == "Don't know") {

            var id = $(this).attr('id');
            $(".cancer_history_question_399").prop("checked", false);
            $(".cancer_history_question_399#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_399').each(function(index, value){

                if($(this).val() == "Don't know"){

                    $(this).prop("checked", false);
                }
            })


        }
    }
});

$(document).on("click", "input[type='radio'].cancer_history_question_398", function () {

    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.cancer_history_question_399').prop("checked", false);
            $('.cancer_history_question_398_399').hide();

            $('.cancer_history_question_404').prop("checked", false);
            $('.cancer_history_question_398_404').hide();
            $('.cancer_history_question_432').prop("checked", false);
            $('.cancer_history_question_398_432').hide();

            $('.cancer_history_question_452').prop("checked", false);
            $('.cancer_history_question_398_452').hide();
            $('.cancer_history_question_448').prop("checked", false);
            $('.cancer_history_question_398_448').hide();
            $('.cancer_history_question_444').prop("checked", false);
            $('.cancer_history_question_398_444').hide();
            $('.cancer_history_question_439').prop("checked", false);
            $('.cancer_history_question_398_439').hide();
        }
        else{

            $('.cancer_history_question_398_399').removeClass('display_none_at_load_time').show();
            $('.cancer_history_question_398_404').removeClass('display_none_at_load_time').show();
            $('.cancer_history_question_398_432').removeClass('display_none_at_load_time').show();
            $('.cancer_history_question_398_452').removeClass('display_none_at_load_time').show();
            $('.cancer_history_question_398_448').removeClass('display_none_at_load_time').show();
            $('.cancer_history_question_398_444').removeClass('display_none_at_load_time').show();
            $('.cancer_history_question_398_439').removeClass('display_none_at_load_time').show();
        }
    }
});

//brain cancer js
$(document).on("click", "input[type='checkbox'].cancer_history_question_404", function () {
    //console.log('dfdsf');
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == "Dont know") {

            var id = $(this).attr('id');
            $(".cancer_history_question_404").prop("checked", false);
            $(".cancer_history_question_404#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_404').each(function(index, value){

                if($(this).val() == "Dont know"){

                    $(this).prop("checked", false);
                }
            })


        }
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_402", function () {
    //console.log('dfdsf');
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == "Dont know") {

            var id = $(this).attr('id');
            $(".cancer_history_question_402").prop("checked", false);
            $(".cancer_history_question_402#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_402').each(function(index, value){

                if($(this).val() == "Dont know"){

                    $(this).prop("checked", false);
                }
            })


        }
    }
});


$(document).on("click", "input[type='checkbox'].cancer_history_question_400", function () {

    var flag = false;

    $( "input[type='checkbox'].cancer_history_question_400" ).each(function( index, element ) {

        if($(element).is(':checked')){

            if($(element).val() == 'Other'){

                flag = true;
            }
        }
    });

    if(flag){

        $('.cancer_history_question_400_401').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_401').val('');
        $('.cancer_history_question_400_401').hide();
    }
});

$(document).ready(function () {

    var flag = false;

    $( "input[type='checkbox'].cancer_history_question_400" ).each(function( index, element ) {

        if($(element).is(':checked')){

            if($(element).val() == 'Other'){

                flag = true;
            }
        }
    });

    if(flag){

        $('.cancer_history_question_400_401').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_401').val('');
        $('.cancer_history_question_400_401').hide();
    }

});

//lung cancer js

$(document).on("click", "input[type='checkbox'].cancer_history_question_405", function () {

    var is_show_other = false;
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'None of these'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_history_question_405" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             is_show_other = true;
        }

      });

    if(is_show_other){

        $('.cancer_history_question_405_406').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_406').val('');
        $('.cancer_history_question_405_406').hide();
    }

    if(is_uncheck_all){

        $('.cancer_history_question_405').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);
         $('.cancer_history_question_406').val('');
        $('.cancer_history_question_405_406').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_405" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'None of these'){

               $(this).prop("checked", false);
            }
        });
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_history_question_405" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_history_question_405_406').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_406').val('');
        $('.cancer_history_question_405_406').hide();
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_407", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_407").prop("checked", false);
            $(".cancer_history_question_407#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_407').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })


        }
    }
});


//Stomach cancer js

$(document).on("click", "input[type='checkbox'].cancer_history_question_408", function () {

    var is_show_other = false;
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'None of these'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_history_question_408" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             is_show_other = true;
        }

      });

    if(is_show_other){

        $('.cancer_history_question_408_409').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_409').val('');
        $('.cancer_history_question_408_409').hide();
    }

    if(is_uncheck_all){

        $('.cancer_history_question_408').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);
        $('.cancer_history_question_409').val('');
        $('.cancer_history_question_408_409').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_408" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'None of these'){

               $(this).prop("checked", false);
            }
        });
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_history_question_408" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_history_question_408_409').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_409').val('');
        $('.cancer_history_question_408_409').hide();
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_410", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_410").prop("checked", false);
            $(".cancer_history_question_410#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_410').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })


        }
    }
});

//Kidney cancer js

$(document).on("click", "input[type='checkbox'].cancer_history_question_411", function () {

    var is_show_other = false;
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'None of these'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_history_question_411" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             is_show_other = true;
        }

      });

    if(is_show_other){

        $('.cancer_history_question_411_412').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_412').val('');
        $('.cancer_history_question_411_412').hide();
    }

    if(is_uncheck_all){

        $('.cancer_history_question_411').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);
        $('.cancer_history_question_412').val('');
        $('.cancer_history_question_411_412').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_411" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'None of these'){

               $(this).prop("checked", false);
            }
        });
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_history_question_411" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_history_question_411_412').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_412').val('');
        $('.cancer_history_question_411_412').hide();
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_413", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_413").prop("checked", false);
            $(".cancer_history_question_413#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_413').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })


        }
    }
});

//colon cancer js

$(document).on("click", "input[type='checkbox'].cancer_history_question_414", function () {

    var is_show_other = false;
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'None of these'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_history_question_414" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             is_show_other = true;
        }

      });

    if(is_show_other){

        $('.cancer_history_question_414_415').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_415').val('');
        $('.cancer_history_question_414_415').hide();
    }

    if(is_uncheck_all){

        $('.cancer_history_question_414').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);
        $('.cancer_history_question_415').val('');
        $('.cancer_history_question_414_415').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_414" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'None of these'){

               $(this).prop("checked", false);
            }
        });
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_history_question_414" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_history_question_414_415').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_415').val('');
        $('.cancer_history_question_414_415').hide();
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_416", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_416").prop("checked", false);
            $(".cancer_history_question_416#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_416').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })


        }
    }
});

//Cervical cancer js

$(document).on("click", "input[type='checkbox'].cancer_history_question_426", function () {

    var is_show_other = false;
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'None of these'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_history_question_426" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             is_show_other = true;
        }

      });

    if(is_show_other){

        $('.cancer_history_question_426_427').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_427').val('');
        $('.cancer_history_question_426_427').hide();
    }

    if(is_uncheck_all){

        $('.cancer_history_question_426').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);
        $('.cancer_history_question_427').val('');
        $('.cancer_history_question_426_427').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_426" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'None of these'){

               $(this).prop("checked", false);
            }
        });
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_history_question_426" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_history_question_426_427').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_427').val('');
        $('.cancer_history_question_426_427').hide();
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_428", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_428").prop("checked", false);
            $(".cancer_history_question_428#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_428').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })


        }
    }
});

//prostate cancer js

$(document).on("click", "input[type='checkbox'].cancer_history_question_417", function () {

    var is_show_other = false;
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'None of these'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_history_question_417" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             is_show_other = true;
        }

      });

    if(is_show_other){

        $('.cancer_history_question_417_418').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_418').val('');
        $('.cancer_history_question_417_418').hide();
    }

    if(is_uncheck_all){

        $('.cancer_history_question_417').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);
        $('.cancer_history_question_418').val('');
        $('.cancer_history_question_417_418').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_417" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'None of these'){

               $(this).prop("checked", false);
            }
        });
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_history_question_417" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_history_question_417_418').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_418').val('');
        $('.cancer_history_question_417_418').hide();
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_419", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_419").prop("checked", false);
            $(".cancer_history_question_419#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_419').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })


        }
    }
});

//uterine cancer js

$(document).on("click", "input[type='checkbox'].cancer_history_question_420", function () {

    var is_show_other = false;
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'None of these'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_history_question_420" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             is_show_other = true;
        }

      });

    if(is_show_other){

        $('.cancer_history_question_420_421').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_421').val('');
        $('.cancer_history_question_420_421').hide();
    }

    if(is_uncheck_all){

        $('.cancer_history_question_420').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);
        $('.cancer_history_question_421').val('');
        $('.cancer_history_question_420_421').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_420" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'None of these'){

               $(this).prop("checked", false);
            }
        });
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_history_question_420" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_history_question_420_421').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_421').val('');
        $('.cancer_history_question_420_421').hide();
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_422", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_422").prop("checked", false);
            $(".cancer_history_question_422#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_422').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })


        }
    }
});

//Ovarian cancer js

$(document).on("click", "input[type='checkbox'].cancer_history_question_429", function () {

    var is_show_other = false;
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'None of these'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_history_question_429" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             is_show_other = true;
        }

      });

    if(is_show_other){

        $('.cancer_history_question_429_430').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_430').val('');
        $('.cancer_history_question_429_430').hide();
    }

    if(is_uncheck_all){

        $('.cancer_history_question_429').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);
        $('.cancer_history_question_430').val('');
        $('.cancer_history_question_429_430').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_429" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'None of these'){

               $(this).prop("checked", false);
            }
        });
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_history_question_429" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_history_question_429_430').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_430').val('');
        $('.cancer_history_question_429_430').hide();
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_431", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_431").prop("checked", false);
            $(".cancer_history_question_431#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_431').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })
        }
    }
});

//Vulvar cancer js

$(document).on("click", "input[type='checkbox'].cancer_history_question_423", function () {

    var is_show_other = false;
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'None of these'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_history_question_423" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             is_show_other = true;
        }

      });

    if(is_show_other){

        $('.cancer_history_question_423_424').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_424').val('');
        $('.cancer_history_question_423_424').hide();
    }

    if(is_uncheck_all){

        $('.cancer_history_question_423').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);
        $('.cancer_history_question_424').val('');
        $('.cancer_history_question_423_424').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_423" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'None of these'){

               $(this).prop("checked", false);
            }
        });
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_history_question_423" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_history_question_423_424').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_424').val('');
        $('.cancer_history_question_423_424').hide();
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_425", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_425").prop("checked", false);
            $(".cancer_history_question_425#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_425').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })
        }
    }
});


//liver cancer js

$(document).on("click", "input[type='checkbox'].cancer_history_question_449", function () {

    var is_show_other = false;
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'None of these'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_history_question_449" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             is_show_other = true;
        }

      });

    if(is_show_other){

        $('.cancer_history_question_449_450').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_450').val('');
        $('.cancer_history_question_449_450').hide();
    }

    if(is_uncheck_all){

        $('.cancer_history_question_449').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);
        $('.cancer_history_question_450').val('');
        $('.cancer_history_question_449_450').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_449" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'None of these'){

               $(this).prop("checked", false);
            }
        });
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_history_question_449" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_history_question_449_450').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_450').val('');
        $('.cancer_history_question_449_450').hide();
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_451", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_451").prop("checked", false);
            $(".cancer_history_question_451#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_451').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })
        }
    }
});


$(document).on("click", "input[type='checkbox'].cancer_history_question_452", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_452").prop("checked", false);
            $(".cancer_history_question_452#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_452').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })
        }
    }
});


//thyroid cancer js

$(document).on("click", "input[type='checkbox'].cancer_history_question_453", function () {

    var is_show_other = false;
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'None of these'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_history_question_453" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             is_show_other = true;
        }

      });

    if(is_show_other){

        $('.cancer_history_question_453_454').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_454').val('');
        $('.cancer_history_question_453_454').hide();
    }

    if(is_uncheck_all){

        $('.cancer_history_question_453').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);
        $('.cancer_history_question_454').val('');
        $('.cancer_history_question_453_454').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_453" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'None of these'){

               $(this).prop("checked", false);
            }
        });
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_history_question_453" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_history_question_453_454').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_454').val('');
        $('.cancer_history_question_453_454').hide();
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_455", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_455").prop("checked", false);
            $(".cancer_history_question_455#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_455').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })
        }
    }
});

//Vaginal cancer js

$(document).on("click", "input[type='checkbox'].cancer_history_question_445", function () {

    var is_show_other = false;
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'None of these'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_history_question_445" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             is_show_other = true;
        }

      });

    if(is_show_other){

        $('.cancer_history_question_445_446').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_446').val('');
        $('.cancer_history_question_445_446').hide();
    }

    if(is_uncheck_all){

        $('.cancer_history_question_445').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);
        $('.cancer_history_question_446').val('');
        $('.cancer_history_question_445_446').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_445" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'None of these'){

               $(this).prop("checked", false);
            }
        });
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].cancer_history_question_445" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.cancer_history_question_445_446').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.cancer_history_question_446').val('');
        $('.cancer_history_question_445_446').hide();
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_447", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_447").prop("checked", false);
            $(".cancer_history_question_447#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_447').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })
        }
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_448", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_448").prop("checked", false);
            $(".cancer_history_question_448#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_448').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })
        }
    }
});


//leukemia js

$(document).on("click", "input[type='checkbox'].cancer_history_question_444", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_444").prop("checked", false);
            $(".cancer_history_question_444#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_444').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })
        }
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_443", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_443").prop("checked", false);
            $(".cancer_history_question_443#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_443').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })
        }
    }
});


$(document).on("click", "input[type='checkbox'].cancer_history_question_440", function () {

    var show_question_arr = [];
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'None of these'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_history_question_440" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

            show_question_arr.push(442);
            $('.cancer_history_question_440_442').removeClass('display_none_at_load_time').show();
        }

        if($(element).is(':checked') && $(element).val() == 'Abdominal pain'){

            show_question_arr.push(441);
            $('.cancer_history_question_440_441').removeClass('display_none_at_load_time').show();
        }

      });

    if(show_question_arr.includes(441) == false){

        $('.cancer_history_question_441').val('');
        $('.cancer_history_question_440_441').hide();
    }

    if(show_question_arr.includes(442) == false){

        $('.cancer_history_question_442').val('');
        $('.cancer_history_question_440_442').hide();
    }


    if(is_uncheck_all){

        $('.cancer_history_question_440').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);
        $('.cancer_history_question_441').val('');
        $('.cancer_history_question_442').val('');
        $('.cancer_history_question_440_441').hide();
        $('.cancer_history_question_440_442').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_440" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'None of these'){

               $(this).prop("checked", false);
            }
        });
    }
});

$(document).ready(function () {

    var show_question_arr = [];
    $( "input[type='checkbox'].cancer_history_question_440" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

            show_question_arr.push(442);
            $('.cancer_history_question_440_442').removeClass('display_none_at_load_time').show();
        }

        if($(element).is(':checked') && $(element).val() == 'Abdominal pain'){

            show_question_arr.push(441);
            $('.cancer_history_question_440_441').removeClass('display_none_at_load_time').show();
        }

    });

    if(show_question_arr.includes(441) == false){

        $('.cancer_history_question_441').val('');
        $('.cancer_history_question_440_441').hide();
    }

    if(show_question_arr.includes(442) == false){

        $('.cancer_history_question_442').val('');
        $('.cancer_history_question_440_442').hide();
    }
});

//pancreatic cancer js

$(document).on("click", "input[type='checkbox'].cancer_history_question_439", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Dont know") {

            var id = $(this).attr('id');
            $(".cancer_history_question_439").prop("checked", false);
            $(".cancer_history_question_439#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_439').each(function(index, value){

                if($(this).val() == "Dont know"){

                    $(this).prop("checked", false);
                }
            })
        }
    }
});

$(document).on("click", "input[type='checkbox'].cancer_history_question_438", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Not sure") {

            var id = $(this).attr('id');
            $(".cancer_history_question_438").prop("checked", false);
            $(".cancer_history_question_438#"+id).prop("checked", true);

        }else{

            $('.cancer_history_question_438').each(function(index, value){

                if($(this).val() == "Not sure"){

                    $(this).prop("checked", false);
                }
            })
        }
    }
});


$(document).on("click", "input[type='checkbox'].cancer_history_question_433", function () {

    var show_question_arr = [];
    var is_uncheck_all = false;
    var check_option_id = null;
    if($(this).val() == 'None of these'){
        is_uncheck_all = true;
        check_option_id = $(this).attr('id');
    }

    $( "input[type='checkbox'].cancer_history_question_433" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

            show_question_arr.push(437);
            $('.cancer_history_question_433_437').removeClass('display_none_at_load_time').show();
        }

        if($(element).is(':checked') && $(element).val() == 'Abdominal pain'){

            show_question_arr.push(434);
            $('.cancer_history_question_433_434').removeClass('display_none_at_load_time').show();
            $('.cancer_history_question_433_435').removeClass('display_none_at_load_time').show();
        }

        if($(element).is(':checked') && $(element).val() == 'Back pain'){

            show_question_arr.push(436);
            $('.cancer_history_question_433_436').removeClass('display_none_at_load_time').show();
        }

      });

    if(show_question_arr.includes(437) == false){

        $('.cancer_history_question_437').val('');
        $('.cancer_history_question_433_437').hide();
    }

    if(show_question_arr.includes(434) == false){

        $('.cancer_history_question_434').val('');
        $('.cancer_history_question_433_434').hide();
        $('.cancer_history_question_435').val('');
        $('.cancer_history_question_433_435').hide();
    }

    if(show_question_arr.includes(436) == false){

        $('.cancer_history_question_436').val('');
        $('.cancer_history_question_433_436').hide();
    }


    if(is_uncheck_all){

        $('.cancer_history_question_433').prop("checked", false);
        $('#'+check_option_id).prop("checked", true);
        $('.cancer_history_question_437').val('');
        $('.cancer_history_question_433_437').hide();
        $('.cancer_history_question_434').val('');
        $('.cancer_history_question_433_434').hide();
        $('.cancer_history_question_435').val('');
        $('.cancer_history_question_433_435').hide();
        $('.cancer_history_question_436').val('');
        $('.cancer_history_question_433_436').hide();
    }
    else{

        $( "input[type='checkbox'].cancer_history_question_433" ).each(function( index, element ) {

            if($(element).is(':checked') && $(element).val() == 'None of these'){

               $(this).prop("checked", false);
            }
        });
    }
});

$(document).ready(function () {

    var show_question_arr = [];
    $( "input[type='checkbox'].cancer_history_question_433" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

            show_question_arr.push(437);
            $('.cancer_history_question_433_437').removeClass('display_none_at_load_time').show();
        }

        if($(element).is(':checked') && $(element).val() == 'Abdominal pain'){

            show_question_arr.push(434);
            $('.cancer_history_question_433_434').removeClass('display_none_at_load_time').show();
            $('.cancer_history_question_433_435').removeClass('display_none_at_load_time').show();
        }

        if($(element).is(':checked') && $(element).val() == 'Back pain'){

            show_question_arr.push(436);
            $('.cancer_history_question_433_436').removeClass('display_none_at_load_time').show();
        }

      });

    if(show_question_arr.includes(437) == false){

        $('.cancer_history_question_437').val('');
        $('.cancer_history_question_433_437').hide();
    }

    if(show_question_arr.includes(434) == false){

        $('.cancer_history_question_434').val('');
        $('.cancer_history_question_433_434').hide();
        $('.cancer_history_question_435').val('');
        $('.cancer_history_question_433_435').hide();
    }

    if(show_question_arr.includes(436) == false){

        $('.cancer_history_question_436').val('');
        $('.cancer_history_question_433_436').hide();
    }
});

//pre post operation

$(document).on("click", "input[type='radio'].preop_postop_question459", function () {

    if($(this).is(':checked')) {
        if ($(this).val() == 'Other') {
            $('.preop_postop_question_459_460').removeClass('display_none_at_load_time').show();
        }
        else{
            $('.pre_op_post_op460').val('');
            $('.preop_postop_question_459_460').hide();
        }
    }
});


$(document).on("click", "input[type='radio'].preop_postop_question462", function () {

    if($(this).is(':checked')) {
        if ($(this).val() == 'Yes') {
            $('.preop_postop_question_462_463').removeClass('display_none_at_load_time').show();
        }
        else{
            $('.pre_op_post_op464').val('');
            $('.preop_postop_question463').prop("checked", false);
            $('.preop_postop_question_462_463').hide();
            $('.preop_postop_question_463_464').hide();
        }
    }
});

$(document).on("click", "input[type='radio'].preop_postop_question463", function () {

    if($(this).is(':checked')) {
        if ($(this).val() == 'Yes') {
            $('.preop_postop_question_463_464').removeClass('display_none_at_load_time').show();
        }
        else{
            $('.pre_op_post_op464').val('');
            $('.preop_postop_question_463_464').hide();
        }
    }
});

$(document).on("click", "input[type='checkbox'].preop_postop_question_467", function () {

    var flag = false;
    $( "input[type='checkbox'].preop_postop_question_467" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Vomiting'){
             flag = true;
        }
      });
    if(flag){
        $('.preop_postop_question_467_468').removeClass('display_none_at_load_time').show();
        $('.preop_postop_question_467_469').removeClass('display_none_at_load_time').show();
    }
    else{

        $('#question_468').val('');
        $('.preop_postop_question469').prop("checked", false);
        $('.preop_postop_question_467_468').hide();
        $('.preop_postop_question_467_469').hide();
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].preop_postop_question_467" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Vomiting'){

             flag = true;
        }
      });

      if(flag){
          $('.preop_postop_question_467_468').removeClass('display_none_at_load_time').show();
          $('.preop_postop_question_467_469').removeClass('display_none_at_load_time').show();
      }
      else{

        $('#question_468').val('');
        $('.preop_postop_question469').prop("checked", false);
        $('.preop_postop_question_467_468').hide();
        $('.preop_postop_question_467_469').hide();
      }
});

//cancer followup module general tab

$(document).on("click", "input[type='radio'].followup_general_question_471", function () {

    if($(this).is(':checked')) {
        if ($(this).val() == 'Yes') {
            $('.followup_general_question_471_472').removeClass('display_none_at_load_time').show();
        }
        else{
            $('.followup_general_question_472').prop("checked", false);
            $('.followup_general_question_471_472').hide();
        }
    }
});


$(document).on("click", "input[type='radio'].followup_general_question_473", function () {


    if($(this).is(':checked')) {
        if ($(this).val() == 'Yes') {
            $('.followup_general_question_474').removeClass('display_none_at_load_time').show();
        }
        else{
            $('.followup_general_question_474').prop("checked", false);
            $('.followup_general_question_474').hide();
            $('.followup_general_question_503').val();
            $('.followup_general_question_474_503').hide();
        }
    }
});

$(document).on("click", "input[type='checkbox'].followup_general_question_474", function () {

    var flag = false;
    $( "input[type='checkbox'].followup_general_question_474" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.followup_general_question_474_503').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.followup_general_question_503').val();
        $('.followup_general_question_474_503').hide();
    }
});

$(document).ready(function () {

    var flag = false;
    $( "input[type='checkbox'].followup_general_question_474" ).each(function( index, element ) {

        //alert($(element).val());

        if($(element).is(':checked') && $(element).val() == 'Other'){

             flag = true;
        }
      });

    if(flag){

        $('.followup_general_question_474_503').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.followup_general_question_503').val();
        $('.followup_general_question_474_503').hide();
    }
});

//cancer followup module medical history tab

$(document).on("click", "input[type='radio'].followup_medical_history_question_484", function () {

    if($(this).is(':checked')) {
        if ($(this).val() == 'Yes') {
            $('.followup_medical_history_question_484_485').removeClass('display_none_at_load_time').show();
        }
        else{
            $('.followup_medical_history_question_485').val('');
            $('.followup_medical_history_question_484_485').hide();
        }
    }
});


$(document).on("click", "input[type='radio'].followup_medical_history_question_478", function () {

    if($(this).is(':checked')) {
        if ($(this).val() == 'Yes') {
            $('.followup_medical_history_question_478_479').removeClass('display_none_at_load_time').show();
        }
        else{
            $('.followup_medical_history_question_479').prop('checked',false);

            $('.followup_medical_history_question_480').val('');
            $('.followup_medical_history_question_481').val('');
            $('.followup_medical_history_question_482').val('');
            $('.followup_medical_history_question_483').val('');
            $('.followup_medical_history_question_484').prop('checked',false);
            $('.followup_medical_history_question_485').val('');
            $('.followup_medical_history_question_484_485').hide();
            $('.hospital_stay_questions').hide();


            $('.followup_medical_history_question_486').val('');
            $('.followup_medical_history_question_487').val('');
            $('.followup_medical_history_question_488').val('');
            $('.followup_medical_history_question_489').prop('checked',false);
            $('.followup_medical_history_question_490').prop('checked',false);
            $('.er_room_visit_questions').hide();

            $('.followup_medical_history_question_478_479').hide();
        }
    }
});


$(document).on("click", "input[type='radio'].followup_medical_history_question_479", function () {

    var val = $(this).val().toLowerCase()
    if($(this).is(':checked')) {
        if (val == 'hospital stay') {

            $('.followup_medical_history_question_486').val('');
            $('.followup_medical_history_question_487').val('');
            $('.followup_medical_history_question_488').val('');
            $('.followup_medical_history_question_489').prop('checked',false);
            $('.followup_medical_history_question_490').prop('checked',false);
            $('.er_room_visit_questions').hide();

            $('.hospital_stay_questions').removeClass('display_none_at_load_time').show();
        }
        else if (val == 'emergency room visit only') {

            $('.followup_medical_history_question_480').val('');
            $('.followup_medical_history_question_481').val('');
            $('.followup_medical_history_question_482').val('');
            $('.followup_medical_history_question_483').val('');
            $('.followup_medical_history_question_484').prop('checked',false);
            $('.followup_medical_history_question_485').val('');
            $('.followup_medical_history_question_484_485').hide();
            $('.hospital_stay_questions').hide();

            $('.er_room_visit_questions').removeClass('display_none_at_load_time').show();
        }
        else{
            $('.followup_medical_history_question_480').val('');
            $('.followup_medical_history_question_481').val('');
            $('.followup_medical_history_question_482').val('');
            $('.followup_medical_history_question_483').val('');
            $('.followup_medical_history_question_484').prop('checked',false);
            $('.followup_medical_history_question_485').val('');
            $('.followup_medical_history_question_484_485').hide();
            $('.hospital_stay_questions').hide();


            $('.followup_medical_history_question_486').val('');
            $('.followup_medical_history_question_487').val('');
            $('.followup_medical_history_question_488').val('');
            $('.followup_medical_history_question_489').prop('checked',false);
            $('.followup_medical_history_question_490').prop('checked',false);
            $('.er_room_visit_questions').hide();
        }
    }
});


$('body').on('focus',".followup_medical_history_question_481", function(){
    var date = new Date();
    $(this).datepicker({
        maxDate: date
    });
});

$('body').on('focus',".followup_medical_history_question_482", function(){
    var date = new Date();
    $(this).datepicker({
        maxDate: date
    });
});

$('body').on('focus',".followup_medical_history_question_487", function(){
    var date = new Date();
    $(this).datepicker({
        maxDate: date
    });
});

//focused history tab 22 js

$(document).on("click", "input[type='checkbox'].focused_history_212", function () {

    var checked_arr = [];

  $( "input[type='checkbox'].focused_history_212" ).each(function( index, element ) {


    if($(element).is(':checked')){

        if($(element).val() == 'Asthma'){

            $('.health_condtion_asthma').removeClass('display_none_at_load_time').show();
            checked_arr.push('health_condtion_asthma');
        }

        if($(element).val() == 'Heart disease (coronary artery disease)'){

            $('.health_condtion_cad').removeClass('display_none_at_load_time').show();
            checked_arr.push('health_condtion_cad');
        }

        if($(element).val() == 'High blood pressure (hypertension)'){

            $('.health_condtion_hbp').removeClass('display_none_at_load_time').show();
            checked_arr.push('health_condtion_hbp');
        }

        if($(element).val() == 'Diabetes'){

            $('.health_condtion_diabetes').removeClass('display_none_at_load_time').show();
            checked_arr.push('health_condtion_diabetes');
        }
    }
  });


    if(checked_arr.indexOf('health_condtion_asthma') == -1)
    {
        //$('.covid_ques_145').prop('checked',false);
        $('.health_condtion_asthma').hide();
    }

    if(checked_arr.indexOf('health_condtion_cad') == -1)
    {
        //$('.covid_ques_146').prop('checked',false);
       $('.health_condtion_cad').hide();
    }

    if(checked_arr.indexOf('health_condtion_hbp') == -1)
    {
        //$('.covid_ques_147').prop('checked',false);
       $('.health_condtion_hbp').hide();
    }

    if(checked_arr.indexOf('health_condtion_diabetes') == -1)
    {
        //$('.covid_ques_147').prop('checked',false);
       $('.health_condtion_diabetes').hide();
    }

});

$(document).ready(function () {

    var checked_arr = [];

  $( "input[type='checkbox'].focused_history_212" ).each(function( index, element ) {


    if($(element).is(':checked')){

        if($(element).val() == 'Asthma'){

            $('.health_condtion_asthma').removeClass('display_none_at_load_time').show();
            checked_arr.push('health_condtion_asthma');
        }

        if($(element).val() == 'Heart disease (coronary artery disease)'){

            $('.health_condtion_cad').removeClass('display_none_at_load_time').show();
            checked_arr.push('health_condtion_cad');
        }

        if($(element).val() == 'High blood pressure (hypertension)'){

            $('.health_condtion_hbp').removeClass('display_none_at_load_time').show();
            checked_arr.push('health_condtion_hbp');
        }

        if($(element).val() == 'Diabetes'){

            $('.health_condtion_diabetes').removeClass('display_none_at_load_time').show();
            checked_arr.push('health_condtion_diabetes');
        }
    }
  });


    if(checked_arr.indexOf('health_condtion_asthma') == -1)
    {
        //$('.covid_ques_145').prop('checked',false);
        $('.health_condtion_asthma').hide();
    }

    if(checked_arr.indexOf('health_condtion_cad') == -1)
    {
        //$('.covid_ques_146').prop('checked',false);
       $('.health_condtion_cad').hide();
    }

    if(checked_arr.indexOf('health_condtion_hbp') == -1)
    {
        //$('.covid_ques_147').prop('checked',false);
       $('.health_condtion_hbp').hide();
    }

    if(checked_arr.indexOf('health_condtion_diabetes') == -1)
    {
        //$('.covid_ques_147').prop('checked',false);
       $('.health_condtion_diabetes').hide();
    }

});


$(document).on("click", "input[type='radio'].focused_history_219", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == 'No') {
            $('.focused_history_219_220').hide();
        }else{
            $('.focused_history_219_220').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='radio'].focused_history_221", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == 'No') {
            $('.focused_history_221_222').hide();
        }else{
            $('.focused_history_221_222').removeClass('display_none_at_load_time').show();
        }
    }
});

//tab 1 js
$(document).on("click", "input[type='radio'].check_recent_papsmear", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == 0) {
            $('.recent_papsmear_realted_fields').hide();

        }else{
            $('.recent_papsmear_realted_fields').show();

        }
    }
});


$(document).on("click", "input[type='radio'].was_regular_papsmear", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == 0) {
            $('.was_regular_papsmear_field').show();

        }else{
            $('.was_regular_papsmear_field input').val('');
            $('.was_regular_papsmear_field').hide();

        }
    }
});

//tab 2 js

$(document).on("click", "input[type='radio'].check_did_you_try_medication", function () {
    if($(this).is(':checked')) {
        // alert($(this).val());
        if ($(this).val() == 'No') {
            $('.question_13_14').val('');
            $('.question_13_14').hide();
        }else{
            $('.question_13_14').removeClass('display_none_at_load_time').show();


        }
    }
});


$(document).on("click", "input[type='radio'].detail_question_146", function () {
    if($(this).is(':checked')) {
        // alert($(this).val());
        if ($(this).val() == 'about the same') {
            $('.detail_question_146_147').val('');
            $('.detail_question_146_148').val('');

            $('.detail_question_146_147').hide();
            $('.detail_question_146_148').hide();
        }else if($(this).val() == 'better'){

            $('.detail_question_146_147').hide();
            $('.detail_question_146_148').removeClass('display_none_at_load_time').show();


        }
        else if($(this).val() == 'worse'){

            $('.detail_question_146_148').hide();
            $('.detail_question_146_147').removeClass('display_none_at_load_time').show();

        }
    }
});



$(document).on("click", "input[type='radio'].detail_question_122", function () {
    if($(this).is(':checked')) {
        // alert($(this).val());
        if ($(this).val() != 'morning') {

            $('.detail_question_122_123').hide();
        }else{

            $('.detail_question_122_123').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='radio'].detail_question_133", function () {
    if($(this).is(':checked')) {
        // alert($(this).val());
        if ($(this).val() != 'morning') {

            $('.detail_question_133_134').hide();
        }else{

            $('.detail_question_133_134').removeClass('display_none_at_load_time').show();


        }
    }
});


$(document).on("click", "input[type='radio'].detail_question_142", function () {
    if($(this).is(':checked')) {
        // alert($(this).val());
        if ($(this).val() != 'morning') {

            $('.detail_question_142_143').hide();
        }else{

            $('.detail_question_142_143').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='radio'].detail_question_182", function () {
    if($(this).is(':checked')) {
         
        if ($(this).val() != 'Yes') {

            $('.question_182_183').hide();
            $('.detail_question_182_184').hide();
            $('.detail_question_184_185').hide();
            $(".detail_question_184").prop("checked", false);
            $(".detail_question_185").prop("checked", false);
            $('#question_183').val('');
            
        }else{

            $('.question_182_183').removeClass('display_none_at_load_time').show();
            $('.detail_question_182_184').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='radio'].detail_question_184", function () {
    if($(this).is(':checked')) {
         
        if ($(this).val() != 'Yes') {            
            $('.detail_question_184_185').hide();
            $(".detail_question_185").prop("checked", false);
        }else{            
            $('.detail_question_184_185').removeClass('display_none_at_load_time').show();
        }
    }
});



$(document).on("click", "input[type='radio'].detail_question_117", function () {
    if($(this).is(':checked')) {
        // alert($(this).val());
        if ($(this).val() == 'No') {

            $('.detail_question_117_118').hide();
        }else{

            $('.detail_question_117_118').removeClass('display_none_at_load_time').show();


        }
    }
});



$(document).on("click", "input[type='radio'].detail_question_106", function () {
    if($(this).is(':checked')) {
        // alert($(this).val());
        if ($(this).val() != 'Both') {

            $('.detail_question_106_107').hide();
        }else{

            $('.detail_question_106_107').removeClass('display_none_at_load_time').show();


        }
    }
});


$(document).on("click", "input[type='radio'].detail_question_127", function () {
    if($(this).is(':checked')) {
        // alert($(this).val());
        if ($(this).val() != 'Both') {

            $('.detail_question_127_128').hide();
        }else{

            $('.detail_question_127_128').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='radio'].detail_question_135", function () {
    if($(this).is(':checked')) {
        // alert($(this).val());
        if ($(this).val() != 'Both') {

            $('.detail_question_135_136').hide();
        }else{

            $('.detail_question_135_136').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='radio'].detail_question_110", function () {
    if($(this).is(':checked')) {
        // alert($(this).val());
        if ($(this).val() != 'Suddenly') {

            $('.detail_question_110_111').hide();
            $('.detail_question_111_112').hide();
        }else{

            $('.detail_question_110_111').removeClass('display_none_at_load_time').show();


        }
    }
});




$(document).on("click", "input[type='radio'].take_exercise", function () {
    if($(this).is(':checked')) {
        // alert($(this).val());
        if ($(this).val() == 'No') {
            //$('.question_13_14').val('');
            $('.time_exercise').hide();
        }else{
            $('.time_exercise').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='radio'].question_73", function () {
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == 'No') {
            //$('.question_13_14').val('');
            $('.question_74').hide();
            $('.question_75').hide();
            // $('#radio_question2').attr('disabled',true);
            // $('#radio_question3').attr('disabled',true);
            // $('#radio_question4').attr('disabled',true);
        }else{

            // $('#radio_question2').attr('disabled',false);
         //    $('#radio_question3').attr('disabled',false);
         //    $('#radio_question4').attr('disabled',false);
            $('.question_74').removeClass('display_none_at_load_time').show();


        }
    }
});


$(document).on("click", "input[type='radio'].question_88", function () {
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == 'No') {
            //$('.question_13_14').val('');
            $('.question_89').hide();
            $('.question_90').hide();

        }else{

            $('.question_89').removeClass('display_none_at_load_time').show();
            $('.question_90').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='radio'].question_74", function () {
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == 'Liquids only') {

            $('.question_75').removeClass('display_none_at_load_time').show();

        }else{

            $('.question_75').hide();
        }
    }
});




$(document).on("click", "input[type='radio'].question_78", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == 'No') {
            //$('.question_13_14').val('');
            $('.question_79').hide();
            $('#question_79').attr('disabled',true);

        }else{

            $('#question_79').attr('disabled',false);
            $('.question_79').removeClass('display_none_at_load_time').show();


        }
    }
});


$(document).on("click", "input[type='radio'].stay_hospital", function () {
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == 'No') {
            $('.stay_hospital_que').hide();

        }else{
            $('.stay_hospital_que').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='radio'].travel_pain", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == 'No') {
            $('.travel_pain_from').hide();
        }else{
            $('.travel_pain_from').removeClass('display_none_at_load_time').show();


        }
    }
});


$(document).on("click", "input[type='radio'].nps", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == 'No') {
            $('.number_of_nps').hide();
        }else{
            $('.number_of_nps').removeClass('display_none_at_load_time').show();


        }
    }
});



$(document).on("click", "input[type='radio'].check_which_is_worse", function () {
    if($(this).is(':checked')) {
        if ($(this).val() != 'Both') {
            $('.question_16_17').val('');
            $('.question_16_17').hide();
        }else{
            $('.question_16_17').removeClass('display_none_at_load_time').show();

        }
    }
});


$(document).on("click", "input[type='radio'].which_joint_cls", function () {
    if($(this).is(':checked')) {
        if ($(this).val() != 'Joints') {
            $('.question_34_35').val('');
            $('.question_34_35').hide();
        }else{
            $('.question_34_35').removeClass('display_none_at_load_time').show();

        }
    }
});



$(document).on("click", "input[type='radio'].check_any_accident", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == 'No') {
            $('.question_26_27').val('');
            $('.question_26_27').hide();
        }else{
            $('.question_26_27').removeClass('display_none_at_load_time');
            $('.question_26_27').show();

        }
    }
});


$(document).on("change", "input[type='checkbox'].check_radiating_option", function () {

var rad_flag = false;
  $( "input[type='checkbox'].check_radiating_option" ).each(function( index, element ) {

    if($(element).is(':checked') && $(element).val() == 'Radiating'){

         rad_flag = true;
    }
  });


        if (!rad_flag) {
            $('.question_39_40').val('');
            $('.question_39_40').hide();
        }else{
            $('.question_39_40').removeClass('display_none_at_load_time');
            $('.question_39_40').show();

        }

});

$(document).on("change", "input[type='checkbox'].detail_question_111", function () {

var rad_flag = false;
  $( "input[type='checkbox'].detail_question_111" ).each(function( index, element ) {

    if($(element).is(':checked') && $(element).val() == 'fall'){

         rad_flag = true;
    }
  });

    if (!rad_flag) {
        $('.detail_question_111_112').hide();
    }else{
        $('.detail_question_111_112').removeClass('display_none_at_load_time');
        $('.detail_question_111_112').show();

    }

});



$(document).on("change", "input[type='checkbox'].question_93", function () {

var rad_flag = false;
  $( "input[type='checkbox'].question_93" ).each(function( index, element ) {

    //alert($(element).val());

    if($(element).is(':checked') && $(element).val() == 'Radiating'){

         rad_flag = true;
    }
  });


        if (!rad_flag) {
            $('.question_94').hide();
        }else{
            $('.question_94').removeClass('display_none_at_load_time').show();

        }

});

$(document).ready(function () {

var rad_flag = false;
  $( "input[type='checkbox'].question_93" ).each(function( index, element ) {

    if($(element).is(':checked') && $(element).val() == 'Radiating'){

         rad_flag = true;
    }
  });


        if (!rad_flag) {
            $('.question_94').hide();
        }else{

            $('.question_94').removeClass('display_none_at_load_time').show();
           // $('.question_94').show();

        }

});


$(document).on("click", "input[type='checkbox'].detail_question_95", function () {
    //console.log('dfdsf');
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == 'No') {

            var id = $(this).attr('id');
            //alert(".detail_question_95 #"+id);
            //alert("input[type='checkbox'].detail_question_95 #"+id);
            $(".detail_question_95").prop("checked", false);
            $(".detail_question_95#"+id).prop("checked", true);

        }else{


            $('.detail_question_95').each(function(index, value){

                if($(this).val() == 'No'){

                    $(this).prop("checked", false);
                }
            })


        }
    }
});

$(document).on("click", "input[type='checkbox'].detail_question_155", function () {
    //console.log('dfdsf');
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == 'All over') {

            var id = $(this).attr('id');
            $(".detail_question_155").prop("checked", false);
            $(".detail_question_155#"+id).prop("checked", true);

        }else{


            $('.detail_question_155').each(function(index, value){

                if($(this).val() == 'All over'){

                    $(this).prop("checked", false);
                }
            })


        }
    }
});

$(document).on("click", "input[type='checkbox'].detail_question_111", function () {

    //var class_name = $(this).data('class_name');
    if($(this).is(':checked') && $(this).val() == "I don't know"){

         $("input[type='checkbox'].detail_question_111").prop('checked', false);
         $(this).prop('checked',true);
    }
    else
    {
        $("input[type='checkbox'].detail_question_111").each(function(index, element){

            if($(element).is(':checked') && $(element).val() == "I don't know"){

                $(this).prop('checked',false);
            }
        });
        //$('.'+class_name).hide();
    }

});

//post checkup js
$(document).ready(function(){

var date = new Date();
$( "#post_checkup_question_15" ).datepicker({
  dateFormat: "yy-mm-dd",
  maxDate: date
  // "dd-mm-yy"
    // setDate: new Date('2014-12-18')
});

$( "#post_checkup_question_18" ).datepicker({
  dateFormat: "yy-mm-dd",
  maxDate: date
   // "dd-mm-yy"
    // setDate: new Date('2014-12-18')
});

$( "#procedure_detail_question26" ).datepicker({
  dateFormat: "yy-mm-dd",
  minDate: date
  // "dd-mm-yy"
    // setDate: new Date('2014-12-18')
});

$( "#pre_op_medications_question48,#pre_op_medications_question49,#pre_op_medications_question54" ).datepicker({
  dateFormat: "yy-mm-dd",
  maxDate: date
});

$( "#post_checkup_question_15" ).datepicker({
      dateFormat: "yy-mm-dd",
      maxDate: date
      // "dd-mm-yy"
        // setDate: new Date('2014-12-18')
    });

$('#disease_detail_question_42').datepicker({maxDate: date});
$('#disease_detail_question_36').datepicker({maxDate: date});
$('#disease_detail_question_38').datepicker({maxDate: date});
$('#disease_detail_question_40').datepicker({maxDate: date});

$( "#pre_op_medications_question48,#pre_op_medications_question49,#pre_op_medications_question54" ).datepicker({
  dateFormat: "yy-mm-dd",
  maxDate: date
});
});

$(document).on("click", "input[type='radio'].post_checkup_question_13", function () {
    //console.log('dfdsf');
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() != 'other') {

            $('.post_checkup_question_13_14').hide();
        }else{

            $('.post_checkup_question_13_14').removeClass('display_none_at_load_time').show();
        }
    }
});


$(document).on("click", "input[type='radio'].post_checkup_question_16", function () {
    //console.log('dfdsf');
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == 'No') {

            $('.post_checkup_question_16_17').hide();
            $('.post_checkup_question_16_17_18').hide();

        }else{

            $('.post_checkup_question_16_17').removeClass('display_none_at_load_time').show();

        }
    }
});


$(document).on("click", "input[type='radio'].post_checkup_question_17", function () {
    //console.log('dfdsf');
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == 'No') {

            //$('.post_checkup_question_16_17').hide();
            $('.post_checkup_question_16_17_18').hide();

        }else{

            $('.post_checkup_question_16_17_18').removeClass('display_none_at_load_time').show();

        }
    }
});

$(document).on("change", "input[type='checkbox'].post_checkup_question_21", function () {

    var rad_flag = false;
      $( "input[type='checkbox'].post_checkup_question_21" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'vomiting'){

             rad_flag = true;
        }
      });


    if (!rad_flag) {
        $('.post_checkup_question_21_22').hide();
        $('.post_checkup_question_21_23').hide();
    }else{
        $('.post_checkup_question_21_22').removeClass('display_none_at_load_time').show();
        $('.post_checkup_question_21_23').removeClass('display_none_at_load_time').show();

    }

});

$(document).on("click", ".medical_condition_name", function () {
    var medical_condition_val = $(this).children().val();
    var id = $(this).attr('data-id');


        if (medical_condition_val == 0) {

            $('.medical_condition_year_'+id).hide();

        }else{

            $('.medical_condition_year_'+id).removeClass('display_none_at_load_time').show();
        }

});

$(document).on("click", "input[type='radio'].procedure_detail_question_13", function () {
    //console.log('dfdsf');
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() != 'other') {

            $('.procedure_detail_question_13_14').hide();
        }else{

            $('.procedure_detail_question_13_14').removeClass('display_none_at_load_time').show();
        }
    }
});


$(document).on("click", "input[type='radio'].procedure_detail_question_25", function () {
    //console.log('dfdsf');
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() != 'Yes') {

            $('.procedure_detail_question_25_26').hide();
        }else{

            $('.procedure_detail_question_25_26').removeClass('display_none_at_load_time').show();
        }
    }
});


//pre_op_medications tab js

$(document).on("click", "input[type='radio'].pre_op_medications_question_27", function () {

    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.pre_op_medications_question_27_28').hide();
        }else{

            $('.pre_op_medications_question_27_28').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='radio'].pre_op_medications_question_32", function () {

    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.pre_op_medications_question_32_33').hide();
        }else{

            $('.pre_op_medications_question_32_33').removeClass('display_none_at_load_time').show();
        }
    }
});


$(document).on("change", "input[type='checkbox'].pre_op_medications_question_28", function () {

    var rad_flag = false;

      $( "input[type='checkbox'].pre_op_medications_question_28" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'Other'){

             rad_flag = true;
        }
      });


    if (!rad_flag) {
        $('.pre_op_medications_question_28_29').val('');
        $('.pre_op_medications_question_28_29').hide();
    }else{
        $('.pre_op_medications_question_28_29').removeClass('display_none_at_load_time').show();

    }

});


$(document).on("change", "input[type='checkbox'].pre_op_medications_question_33", function () {

    var rad_flag = false;
      $( "input[type='checkbox'].pre_op_medications_question_33" ).each(function( index, element ) {

        if($(element).is(':checked') && $(element).val() == 'other'){

             rad_flag = true;
        }
      });


    if (!rad_flag) {
        $('.pre_op_medications_question_33_34').val('');
        $('.pre_op_medications_question_33_34').hide();
    }else{
        $('.pre_op_medications_question_33_34').removeClass('display_none_at_load_time').show();

    }

});


$(document).on("click", "input[type='radio'].pre_op_medications_question_51", function () {

    if($(this).is(':checked')) {
            //alert($(this).val());
        if ($(this).val() == 'Yes') {

            $('.pre_op_medications_question_51_52').removeClass('display_none_at_load_time').show();

        }else{

            $('.pre_op_medications_question_51_52').hide();
        }
    }
});

$(document).on("click", "input[type='radio'].pre_op_medications_question_56", function () {

    if($(this).is(':checked')) {
            //alert($(this).val());
        if ($(this).val() == 'Yes') {

            $('.pre_op_medications_question_56_57').removeClass('display_none_at_load_time').show();

        }else{

            $('.pre_op_medications_question_56_57').hide();
        }
    }
});

$(document).on("click", "input[type='radio'].pre_op_medications_question_58", function () {

    if($(this).is(':checked')) {
            //alert($(this).val());
        if ($(this).val() == 'Yes') {

            $('.pre_op_medications_question_58_59').removeClass('display_none_at_load_time').show();

        }else{

            $('.pre_op_medications_question_58_59').hide();
        }
    }
});

$(document).on("click", ".alleries_conditions_name", function () {
    var medical_condition_val = $(this).children().val();
    var id = $(this).attr('data-id');


        if (medical_condition_val == 0) {

            $('.alleries_conditions_reaction'+id).hide();

        }else{

            $('.alleries_conditions_reaction'+id).removeClass('display_none_at_load_time').show();
        }

});

$(document).on("click", "input[type='radio'].procedure_detail_question_13", function () {
    //console.log('dfdsf');
    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() != 'other') {

            $('.procedure_detail_question_13_14').hide();
        }else{

            $('.procedure_detail_question_13_14').removeClass('display_none_at_load_time').show();
        }
    }
});


//disease_detail tab js

$(".detail_ques_cls button").unbind().click(function() {

        var tp = $('#multivitamin_textbox').val();
        // alert(tp);
        var tpm = $(this).attr('attr_val');

        if(tp && tp.toLowerCase().indexOf(tpm.toLowerCase()) == -1)


            $('#multivitamin_textbox').val(tp+", "+tpm);

        else if(!tp)
            $('#multivitamin_textbox').val($(this).attr('attr_val'));

        $(this).addClass('selected_chief_complaint');

    });

$(document).on("click", "input[type='radio'].disease_detail_question_35", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {
            $('.disease_detail_question_35_36').val('');
            $('.disease_detail_question_35_36').hide();
        }else{

            $('.disease_detail_question_35_36').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='radio'].disease_detail_question_37", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {
            $('.disease_detail_question_37_38').val('');
            $('.disease_detail_question_37_38').hide();
        }else{

            $('.disease_detail_question_37_38').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='radio'].disease_detail_question_39", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {
            $('.disease_detail_question_39_40').val('');
            $('.disease_detail_question_39_40').hide();
        }else{

            $('.disease_detail_question_39_40').removeClass('display_none_at_load_time').show();


        }
    }
});


$(document).on("click", "input[type='radio'].disease_detail_question_41", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {
            $('.disease_detail_question_41_42').removeClass('display_none_at_load_time').show();

        }else{

           $('.disease_detail_question_41_42').val('');
            $('.disease_detail_question_41_42').hide();
        }
    }
});

$(document).on("click", "input[type='radio'].disease_detail_question_43", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {
            $('.multivitamin_detail_section').removeClass('display_none_at_load_time').show();

        }else{

            $('.multivitamin_detail_section').addClass('display_none_at_load_time').hide();
        }
    }
});




$(document).on("click", ".baseline_sysmptom_name", function () {
    var baseline_sysmptom_val = $(this).children().val();
    var id = $(this).attr('data-id');


        if (baseline_sysmptom_val == 0) {

            $('.baseline_sysmptom_result_'+id).hide();

        }else{

            $('.baseline_sysmptom_result_'+id).removeClass('display_none_at_load_time').show();
        }

});

$(document).on("change", "input[type='radio'].currentlysmoking", function () {

    if($(this).is(':checked')) {
        //alert($(this).val());
        if ($(this).val() == 0) {
            $('.currentlysmokingdiv').addClass('elem_display_none') ;
            $('.currentlysmokingdiv input, .currentlysmokingdiv select').attr('disabled', 'disabled');
        }
        else{
            $('.currentlysmokingdiv').removeClass('elem_display_none') ;
            $('.currentlysmokingdiv input, .currentlysmokingdiv select').removeAttr('disabled', 'disabled');
        }
    }
});

$(document).on("change", "input[type='radio'].pastsmoking", function () {

    if($(this).is(':checked')) {
        // alert($(this).val());
        if ($(this).val() == 0) {
            $('.pastsmokingdiv').addClass('elem_display_none') ;
            $('.pastsmokingdiv input, .pastsmokingdiv select').attr('disabled', 'disabled');
        }else{
            $('.pastsmokingdiv').removeClass('elem_display_none') ;
            $('.pastsmokingdiv input, .pastsmokingdiv select').removeAttr('disabled', 'disabled');
        }
    }
});

$(document).on("change", "input[type='radio'].currentlydrinking", function () {

    if($(this).is(':checked')) {
        // alert($(this).val());
        if ($(this).val() == 0) {
            $('.currentlydrinkingdiv').addClass('elem_display_none') ;
            $('.currentlydrinkingdiv input, .currentlydrinkingdiv select').attr('disabled', 'disabled');
        }else{
            $('.currentlydrinkingdiv').removeClass('elem_display_none') ;
            $('.currentlydrinkingdiv input, .currentlydrinkingdiv select').removeAttr('disabled', 'disabled');
        }
    }
});

$(document).on("change", "input[type='radio'].pastdrinking", function () {

    if($(this).is(':checked')) {
        // alert($(this).val());
        if ($(this).val() == 0) {
            $('.pastdrinkingdiv').addClass('elem_display_none') ;
            $('.pastdrinkingdiv input, .pastdrinkingdiv select').attr('disabled', 'disabled');
        }else{
            $('.pastdrinkingdiv').removeClass('elem_display_none') ;
            $('.pastdrinkingdiv input, .pastdrinkingdiv select').removeAttr('disabled', 'disabled');
        }
    }
});

//followup js

$(document).on("click", "input[type='radio'].follow_up_question_132", function () {

    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.follow_up_question_132_133').hide();
        }else{

            $('.follow_up_question_132_133').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='radio'].follow_up_question_138", function () {

    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.follow_up_question_138_139').hide();
        }else{

            $('.follow_up_question_138_139').removeClass('display_none_at_load_time').show();
        }
    }
});


$(document).ready(function(){

    $("input[type='checkbox'].follow_up_question_140").each(function(index, element){

        if($(element).is(':checked')){

            var class_name = $(this).data('class_name');
            $('.'+class_name).removeClass('display_none_at_load_time');
        }
    })
});




$(document).on("click", "input[type='checkbox'].follow_up_question_140", function () {

    var class_name = $(this).data('class_name');
    if($(this).is(':checked')){

        $('.'+class_name).removeClass('display_none_at_load_time');
    }
    else
    {

        $('.'+class_name).hide();
    }

});

//covid js

$(document).on("click", "input[type='radio'].covid_ques_143", function () {
    if($(this).is(':checked'))
    {
        if ($(this).val() == 'No')
        {
            $('.covid_ques_144').prop('checked',false);
            $('.covid_ques_145').prop('checked',false);
            $('.covid_ques_146').prop('checked',false);
            $('.covid_ques_147').prop('checked',false);

            $('.covid_ques_143_144').hide();
            $('.covid_ques_144_145').hide();
            $('.covid_ques_144_146').hide();
            $('.covid_ques_144_147').hide();
        }
        else
        {
            $('.covid_ques_143_144').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='radio'].covid_ques_148", function () {
    if($(this).is(':checked'))
    {
        if ($(this).val() == 'No')
        {
            $('.covid_ques_150').prop('checked',false);
            $('.covid_ques_151').prop('checked',false);
            $('.covid_ques_152').prop('checked',false);
            $('.covid_ques_153').prop('checked',false);

            $('.covid_ques_148_149').hide();
            $('.covid_ques_149_150').hide();
            $('.covid_ques_149_151').hide();
            $('.covid_ques_149_152').hide();
        }
        else
        {
            $('.covid_ques_148_149').removeClass('display_none_at_load_time').show();
        }
    }
});


$(document).on("click", "input[type='checkbox'].covid_ques_144", function () {

    var checked_arr = [];

  $( "input[type='checkbox'].covid_ques_144" ).each(function( index, element ) {


    if($(element).is(':checked')){

        if($(element).val() == 'Washington'){

            $('.covid_ques_144_145').removeClass('display_none_at_load_time').show();
            checked_arr.push(145);
        }

        if($(element).val() == 'Massachusetts'){

            $('.covid_ques_144_146').removeClass('display_none_at_load_time').show();
            checked_arr.push(146);
        }

        if($(element).val() == 'New york'){

            $('.covid_ques_144_147').removeClass('display_none_at_load_time').show();
            checked_arr.push(147);
        }
    }
  });


    if(checked_arr.indexOf(145) == -1)
    {
        $('.covid_ques_145').prop('checked',false);
        $('.covid_ques_144_145').hide();
    }

    if(checked_arr.indexOf(146) == -1)
    {
        $('.covid_ques_146').prop('checked',false);
       $('.covid_ques_144_146').hide();
    }

    if(checked_arr.indexOf(147) == -1)
    {
        $('.covid_ques_147').prop('checked',false);
       $('.covid_ques_144_147').hide();
    }

});

$(document).ready(function () {

    var checked_arr = [];

  $( "input[type='checkbox'].covid_ques_144" ).each(function( index, element ) {


    if($(element).is(':checked')){

        if($(element).val() == 'Washington'){

            $('.covid_ques_144_145').removeClass('display_none_at_load_time').show();
            checked_arr.push(145);
        }

        if($(element).val() == 'Massachusetts'){

            $('.covid_ques_144_146').removeClass('display_none_at_load_time').show();
            checked_arr.push(146);
        }

        if($(element).val() == 'New york'){

            $('.covid_ques_144_147').removeClass('display_none_at_load_time').show();
            checked_arr.push(147);
        }
    }
  });


    if(checked_arr.indexOf(145) == -1)
    {
        $('.covid_ques_145').prop('checked',false);
       $('.covid_ques_144_145').hide();
    }

    if(checked_arr.indexOf(146) == -1)
    {
        $('.covid_ques_146').prop('checked',false);
       $('.covid_ques_144_146').hide();
    }

    if(checked_arr.indexOf(147) == -1)
    {
        $('.covid_ques_147').prop('checked',false);
       $('.covid_ques_144_147').hide();
    }

});


$(document).on("click", "input[type='checkbox'].covid_ques_149", function () {

    var checked_arr = [];

  $( "input[type='checkbox'].covid_ques_149" ).each(function( index, element ) {


    if($(element).is(':checked')){

        if($(element).val() == 'Washington'){

            $('.covid_ques_149_150').removeClass('display_none_at_load_time').show();
            checked_arr.push(150);
        }

        if($(element).val() == 'Massachusetts'){

            $('.covid_ques_149_151').removeClass('display_none_at_load_time').show();
            checked_arr.push(151);
        }

        if($(element).val() == 'New york'){

            $('.covid_ques_149_152').removeClass('display_none_at_load_time').show();
            checked_arr.push(152);
        }
    }
  });


    if(checked_arr.indexOf(150) == -1)
    {
        $('.covid_ques_150').prop('checked',false);
       $('.covid_ques_149_150').hide();
    }

    if(checked_arr.indexOf(151) == -1)
    {
        $('.covid_ques_151').prop('checked',false);
       $('.covid_ques_149_151').hide();
    }

    if(checked_arr.indexOf(152) == -1)
    {
        $('.covid_ques_152').prop('checked',false);
       $('.covid_ques_149_152').hide();
    }

});

$(document).ready(function () {

    var checked_arr = [];

  $( "input[type='checkbox'].covid_ques_149" ).each(function( index, element ) {


    if($(element).is(':checked')){

        if($(element).val() == 'Washington'){

            $('.covid_ques_149_150').removeClass('display_none_at_load_time').show();
            checked_arr.push(150);
        }

        if($(element).val() == 'Massachusetts'){

            $('.covid_ques_149_151').removeClass('display_none_at_load_time').show();
            checked_arr.push(151);
        }

        if($(element).val() == 'New york'){

            $('.covid_ques_149_152').removeClass('display_none_at_load_time').show();
            checked_arr.push(152);
        }
    }
  });


    if(checked_arr.indexOf(150) == -1)
    {
        $('.covid_ques_150').prop('checked',false);
       $('.covid_ques_149_150').hide();
    }

    if(checked_arr.indexOf(151) == -1)
    {
        $('.covid_ques_151').prop('checked',false);
       $('.covid_ques_149_151').hide();
    }

    if(checked_arr.indexOf(152) == -1)
    {
        $('.covid_ques_152').prop('checked',false);
       $('.covid_ques_149_152').hide();
    }

});

$(document).on("click", "input[type='radio'].covid_ques_201", function () {
    if($(this).is(':checked'))
    {
        if ($(this).val() == 'No')
        {
            $('.covid_ques_202').prop('checked',false);


            $('.covid_ques_201_202').hide();
            $('.covid_ques_202_203').hide();
        }
        else
        {
            $('.covid_ques_201_202').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='radio'].covid_ques_204", function () {
    if($(this).is(':checked'))
    {
        if ($(this).val() == 'No')
        {
            $('.covid_ques_205').prop('checked',false);


            $('.covid_ques_204_205').hide();
            $('.covid_ques_205_206').hide();
        }
        else
        {
            $('.covid_ques_204_205').removeClass('display_none_at_load_time').show();
        }
    }
});

$(document).on("click", "input[type='checkbox'].covid_ques_202", function () {

  $( "input[type='checkbox'].covid_ques_202" ).each(function( index, element ) {

    if($(element).is(':checked') && $(element).val() == 'Other'){

        $('.covid_ques_202_203').removeClass('display_none_at_load_time').show();
        return
    }
    else{

        $('.covid_ques_202_203').hide();
    }
  })
});



  $(document).on("click", "input[type='checkbox'].covid_ques_205", function () {

  $( "input[type='checkbox'].covid_ques_205" ).each(function( index, element ) {

    if($(element).is(':checked') && $(element).val() == 'Other'){

        $('.covid_ques_205_206').removeClass('display_none_at_load_time').show();
        return
    }
    else{

        $('.covid_ques_205_206').hide();
    }
  })
});

//oncology followup module js
$(document).on("click", "input[type='radio'].followup_medical_history_question_512", function () {
    if($(this).is(':checked'))
    {
        if ($(this).val() == 'No')
        {
            $('.followup_medical_history_question_512_513').removeClass('display_none_at_load_time').show();
            
        }
        else
        {
            $('.followup_medical_history_question_513').prop('checked',false);
            $('.followup_medical_history_question_512_513').hide();
        }
    }
});

$(document).on("click", "input[type='radio'].followup_medical_history_question_516", function () {

    if($(this).is(':checked')) {

        if ($(this).val() == 'Other') {
          $('.followup_medical_history_question_516_517').removeClass('display_none_at_load_time').show();
        }
        else{
            $('.followup_medical_history_question_517').val('');
            $('.followup_medical_history_question_516_517').hide();
        }
    }
});

$(document).on("click", "input[type='radio'].followup_medical_history_question_507", function () {

    if($(this).is(':checked')) {

        if ($(this).val() == 'No') {

            $('.followup_medical_history_question_508').val('');
            $('.followup_medical_history_question_509').val('');
            $('.followup_medical_history_question_510').val('');
            $('.followup_medical_history_question_511').prop("checked", false);
            $('.followup_medical_history_question_507_lmp_yes').hide();
            $('.followup_medical_history_question_511_514').removeClass('display_none_at_load_time').show();
        }
        else if ($(this).val() == 'Yes') {
            
            $('.followup_medical_history_question_514').prop("checked", false);
            $('.followup_medical_history_question_511_514').hide();
            $('.followup_medical_history_question_517').val('');
            $('.followup_medical_history_question_516_517').hide();
            $('.followup_medical_history_question_516').prop("checked", false);
            $('.followup_medical_history_question_514_515').hide();
            $('.followup_medical_history_question_507_lmp_yes').removeClass('display_none_at_load_time').show();
        }
        else{

            $('.followup_medical_history_question_508').val('');
            $('.followup_medical_history_question_509').val('');
            $('.followup_medical_history_question_510').val('');
            $('.followup_medical_history_question_511').prop("checked", false);
            $('.followup_medical_history_question_507_lmp_yes').hide();
            $('.followup_medical_history_question_514').prop("checked", false);
            $('.followup_medical_history_question_511_514').hide();
            $('.followup_medical_history_question_517').val('');
            $('.followup_medical_history_question_516_517').hide();
            $('.followup_medical_history_question_516').prop("checked", false);
            $('.followup_medical_history_question_514_515').hide();
        }
    }
});

$(document).on("click", "input[type='radio'].followup_medical_history_question_514", function () {

    if($(this).is(':checked')) {

        if ($(this).val() == 'Yes') {

            $('.cancer_medical_question_517').val('');
            $('.followup_medical_history_question_516_517').hide();
            $('.cancer_medical_question_516').prop("checked", false);
            $('.followup_medical_history_question_514_516').hide();

            $('.followup_medical_history_question_514_515').removeClass('display_none_at_load_time').show();
        }
        else if ($(this).val() == 'No') {

            $('.cancer_medical_question_515').val('');
            $('.followup_medical_history_question_514_515').hide();
            $('.followup_medical_history_question_514_516').removeClass('display_none_at_load_time').show();
        }
        else{
            $('.cancer_medical_question_517').val('');
            $('.followup_medical_history_question_516_517').hide();
            $('.cancer_medical_question_516').prop("checked", false);
            $('.followup_medical_history_question_514_516').hide();
            $('.cancer_medical_question_515').val('');
            $('.followup_medical_history_question_514_515').hide();
        }
    }
});

$('body').on('focus',".followup_medical_history_question_508", function(){
    var date = new Date();
    $(this).datepicker({
        maxDate: date
    });
});

$( document ).ready(function() {

  $('.cancer_family_members_362').on('click', function(){
          // e.preventDefault();
          var key = $(this).val();
          
          key=key.replace(" ","_");
          if($(this).prop("checked") == true){
              $('.diabetes_show_'+key).attr("style", "display: block !important");
          }
          else if($(this).prop("checked") == false){
              $('.diabetes_show_'+key).find('input[type="radio"]').prop("checked", false);
              $('.diabetes_show_'+key).attr("style", "display: none !important");
          }

      });

$("form").submit(function(){
  var form = $(this);
  var id = form.attr('id');
  $('<input>').attr({
    type: 'hidden',
    id: 'time',
    name: 'time',
    class: 'time',
    value: '0'
}).appendTo(form);
var timeinterval = $(".timeinterval").val();
$(".time").val(timeinterval);
});


var min = 0;
var second = 0;
var zeroPlaceholder = 0;
var counterId = setInterval(function() {
    countUp();
}, 1000);

function countUp() {
    second++;
    if (second == 59) {
        second = 0;
        min = min + 1;
    }
    if (second == 10) {
        zeroPlaceholder = '';
    } else
    if (second == 0) {
        zeroPlaceholder = 0;
    }
		$(".timeinterval").val(min + ':' + zeroPlaceholder + second)
}
});


// Show PMH Question
$(document).on("click", "input[type='checkbox'].cancer_medical_question_528", function () {
        if ($(this).val() == 'Yes') {

            // $('.cancer_medical_question_528').val('');
            // $('.followup_medical_history_question_516_517').hide();
            // $('.cancer_medical_question_528').prop("checked", false);
            // $('.cancer_medical_question_528_548').hide();

            $('.cancer_medical_question_528_548').removeClass('display_none_at_load_time').show();
        }
        else if ($(this).val() == 'No') {

            $('.cancer_medical_question_548').val('');
            $('.cancer_medical_question_548').prop("checked", false);
            $('.cancer_medical_question_528_548').hide();
            // $('.cancer_medical_question_528_548').removeClass('display_none_at_load_time').show();
        }
        else{
            $('.cancer_medical_question_528').val('');
            $('.cancer_medical_question_548').val('');
            $('.cancer_medical_question_528_548').hide();
            $('.cancer_medical_question_528').prop("checked", false);
            $('.cancer_medical_question_548').prop("checked", false);
            // $('.cancer_medical_question_515').val('');
            // $('.followup_medical_history_question_514_515').hide();
        }
});


//hospital/er info tab

$(document).on("click", "input[type='radio'].hospital_er_question_521", function () {

    if($(this).is(':checked') && $(this).val() == 'Yes') {

        $('.hospital_er_question_521_522').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.hospital_er_question_522').val('');
        $('.hospital_er_question_521_522').hide();
    }
});


$(document).on("click", "input[type='radio'].hospital_er_question_516", function () {

    if($(this).is(':checked') && $(this).val() == 'Emergency room visit only') {
        
       $('.er_info_questions').removeClass('display_none_at_load_time').show();


        $('.hospital_er_question_517').val('');
        $('.hospital_er_question_518').val('');
        $('.hospital_er_question_519').val('');
        $('.hospital_er_question_520').val('');
        $('.hospital_er_question_522').val('');
        $('.hospital_er_question_521_522').hide();
        $('.hospital_er_question_521').prop('checked',false);
        $('.hospital_info_questions').hide();
    }
    else if($(this).is(':checked') && $(this).val() == 'Hospital stay (inpatient)'){

        $('.hospital_er_question_523').val('');
        $('.hospital_er_question_524').val('');
        $('.hospital_er_question_525').val('');
        $('.hospital_er_question_526').prop('checked',false);
        $('.hospital_er_question_527').prop('checked',false);
        $('.er_info_questions').hide();

        // $('.hospital_er_question_522').val('');
        $('.hospital_er_question_521_522').hide();

        $('.hospital_info_questions').removeClass('display_none_at_load_time').show();
    }
    else{

        $('.hospital_er_question_523').val('');
        $('.hospital_er_question_524').val('');
        $('.hospital_er_question_525').val('');
        $('.hospital_er_question_526').prop('checked',false);
        $('.hospital_er_question_527').prop('checked',false);
        $('.er_info_questions').hide();


        $('.hospital_er_question_517').val('');
        $('.hospital_er_question_518').val('');
        $('.hospital_er_question_519').val('');
        $('.hospital_er_question_520').val('');
        $('.hospital_er_question_522').val('');
        $('.hospital_er_question_521_522').hide();
        $('.hospital_er_question_521').prop('checked',false);
        $('.hospital_info_questions').hide();
    }
});
$('body').on('focus',".hospital_er_question_518", function(){
    var date = new Date();
    $(this).datepicker({
        maxDate: date
    });
});
$('body').on('focus',".hospital_er_question_519", function(){
    var date = new Date();
    $(this).datepicker({
        maxDate: date
    });
});
$('body').on('focus',".hospital_er_question_524", function(){
    var date = new Date();
    $(this).datepicker({
        maxDate: date
    });
});

$('body').on('focus',".cancer_history_question_552", function(){
    var date = new Date();
    $(this).datepicker({
        maxDate: date
    });
});


$(document).ready(function(){
  $('.send_report').click(function(){  
  var newurl = $(this).attr('data-url');
  window.location.href = newurl;
});

});
$(document).ready(function(){
  $('#pay_later_btn').click(function(){  
  var newurl = $(this).attr('data-url');
  window.location.href = newurl;
});

});
$(document).ready(function(){
  $('#pay_now_btn').click(function(){  
  $('#payment_heading').text('Payment Information');
  $('#copayment_res').hide();
  $('#payment_form').show();
  $('#prev_pay_btn').hide();
  $('#submit_payment').show();
  // $('#pay_now_btn').attr( 'type','submit');
  

});

});

$("#post_payment_form").validate({

        showErrors: function(errorMap, errorList) {

            if(errorList.length>0){
                $("#post_payment_form div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
            }
        },

});
  
$(document).ready(function(){

    var insuranceType = $('.insuranceType').val();

    if(insuranceType == 'commercial'){

        $('.subscriber_name_div').css('display','block');
        $('.identification_number_div').css('display','block');
        $('.group_number_div').css('display','block');
        $('.insurance_comp_div').css('display','block');
        
    }else{      
        $('.subscriber_name_div').css('display','none');
        $('.identification_number_div').css('display','none');
        $('.group_number_div').css('display','none');
        $('.insurance_comp_div').css('display','none');
        $("#subscriberName").val('');
        $("#identificationNumber").val('');
        $("#groupNumber").val('');
        $("#insuranceCompany").val('');
    }

    $('.insuranceType').on('change',function(){

        var insuranceType = $(this).val();
        if(insuranceType == 'commercial'){
            $('.subscriber_name_div').css('display','block');
            $('.identification_number_div').css('display','block');
            $('.group_number_div').css('display','block');
            $('.insurance_comp_div').css('display','block');
        }else{
            $('.subscriber_name_div').css('display','none');
            $('.identification_number_div').css('display','none');
            $('.group_number_div').css('display','none');
            $('.insurance_comp_div').css('display','none');
            $("#subscriberName").val('');
            $("#identificationNumber").val('');
            $("#groupNumber").val('');
            $("#insuranceCompany").val('');
        }
    })
})
                    







