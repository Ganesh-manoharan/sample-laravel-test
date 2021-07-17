export default class Custom {
    static initCommonPageJS() {

        if($('.pagination').length){
            $('.pagination').each(function(){
                var first = $(this).find('li').first().find('.page-link')
                var last = $(this).find('li').last().find('.page-link')
                first.empty(); last.empty()
                first.attr('style','width:100%');
                last.attr('style','width:100%');
                first.append('<em class="fas fa-angle-left"></em> Previous');
                last.append('Next <em class="fas fa-angle-right"></em>')
            })		
        }

        if ($('.splash').length) {
            $(".splash").delay(1500).fadeOut(2000);
        }

        if ($('.select2').length) {
            $('.select2').select2({
                placeholder: "Choose",
                allowClear: true
            });

        $('.select2').each(function(){
                var attr = $(this).attr('id');
                if (typeof attr !== 'undefined' && attr !== false)
                {
                    var ret = $(this).attr('id').replace('task_','').replace(/_/g, ' ');
            $(this).select2({
                                    placeholder: "Choose "+ret,
                                    templateResult: formatState,
                                    templateSelection: formatState
                        });
                  
                }
            });
         }
        if ($('.dropdown-menu').length) {
            $('.dropdown-menu li').on('click', function () {
                var getValue = $(this).text();
                $('.dropdown-select').text(getValue);
            });
        }

        if ($('#language').length) {
            $('#language').on('change', function () {
                var url = "/translate/"+ $(this).val();
                window.location.href=url;
               
            });
        }

        if($('input[name="date"]').length){
            var date_input=$('input[name="date"]');
            var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : ".task-duedate";
            var options={
                        format: 'M dd, yyyy',
                        container: container,
                        todayHighlight: true,
                        autoclose: true,
                    };
           date_input.datepicker(options);
    }

        if($('.datePicker').length)
        {
            $( ".datePicker" ).datepicker({
                format: 'M dd, yyyy',
                todayHighlight: true,
                autoclose: true,
                startDate: "now()",
            });
        }
        
        if($('.issuedatePicker').length)
        {
            $( ".issuedatePicker" ).datepicker({
                format: 'M dd, yyyy',
                todayHighlight: true,
                autoclose: true
            });
        }

/*Create Funds-30-03-21  */

       if($('input[name="initial_launch_date"]').length){
        var date_input1=$('input[name="initial_launch_date"]');
        var container1=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : ".task-duedate1";
        var options1={
                    format: 'M dd, yyyy',
                    container: container1,
                    todayHighlight: true,
                    autoclose: true
                };
       date_input1.datepicker(options1);
       }
        if($("#departments").length){
            $("#departments").select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        }

        if($("#departments1").length){
            $("#departments1").select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        }

        if($("#company").length){
            $("#company").select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        }

        if($("#fund_groups").length){
            $("#fund_groups").select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        }

        if($("#issues_type").length){
            $("#issues_type").select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        }
        
        if($("#clients_fund_groups").length){
            $("#clients_fund_groups").select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        }
        if($("#subfunds").length){
            $("#subfunds").select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        }
       
        if($("#allusrs").length){
            $("#allusrs").select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        }
        
        if($("#review_users").length){
            $("#review_users").select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        }

        if($("#regulatory_grouping").length){
            $("#regulatory_grouping").select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        }
        if($("#dependencies").length){
            $("#dependencies").select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        }

        if($(".reportsdrpdwn").length){
            $(".reportsdrpdwn").select2({
                dropdownParent: $('.addReportModal'),
                templateResult: formatState,
                templateSelection: formatState
            });
        }
        
        
        if($(".modal-select4").length){
            $(".modal-select4").select2({
                dropdownParent: $('.FundPopupModal'),
                templateResult: formatState,
                templateSelection: formatState
            });
        }

        
        // if($(".modal-select2").length){
        //     $('.modal-select2').select2({
        //         dropdownParent: $('.add-new-department'),
        //         templateResult: formatState,
        //         templateSelection: formatState
        //     });
        // }

        if($("#modal-admin-users").length){
            $('#modal-admin-users').select2({
                dropdownParent: $('#addDepartmentModal'),
                templateResult: formatState,
                templateSelection: formatState
            });
        }

        if($("#modal-all-users").length){
            $('#modal-all-users').select2({
                dropdownParent: $('#addDepartmentModal'),
                templateResult: formatState,
                templateSelection: formatState
            });
        }

        if($("#modal-clients-users").length){
            $('#modal-clients-users').select2({
                dropdownParent: $('#add_new_user'),
                templateResult: formatState,
                templateSelection: formatState
            });
        }

        if($(".modal-select3").length){
            $('.modal-select3').select2({
                dropdownParent: $('.commonmodal'),
                templateResult: formatState,
                templateSelection: formatState
            });
        }

        // if($("#clientpopup-departments").length){
        //     $("#clientpopup-departments").select2({
        //         templateResult: formatState,
        //         templateSelection: formatState
        //     });
        // }
       
        // if($("#clientpopup-fund_groups").length){
        //     $("#clientpopup-fund_groups").select2({
        //         templateResult: formatState,
        //         templateSelection: formatState
        //     });
        // }
        
        if($(".new_item-add_to_user").length){
            $('.new_item-add_to_user').select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        }

        
        function formatState (opt,container1) {
            if($(opt.element).hasClass('nodisplay') && $(opt.element).val() != 0){
                $(container1).addClass($(opt.element).attr("class"));
            }
            if (!opt.id) {
                return opt.text;
            } 
            var optimage = $(opt.element).attr('data-image'); 
            if(!optimage){
              return opt.text;
            } else {                    
                var $opt = $(
                  '<div class="fiels-item-text"><img src="' + optimage + '" alt="" class="select2-option-img"/> <p id="text">' + opt.text + '</p></div>'
                );
                return $opt;
            }

        }        
    }

    static addTaskType()
    {
        $('.questionary-add').click(function(){
            if($('.questionaireDetails').length)
            {
                $('.erroradd').remove();
                $(this).parent().append('<span class="erroradd delete-left-char">One Task cant have mutiple Questionaire Form</span>')
            }   
            else
            {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var type = "GET";
                    var ajaxurl = $('#baseUrl').val()+"/manager/task/questionary/formdetails";
                    console.log(ajaxurl);
                    $.ajax({
                        type: type,
                        url: ajaxurl,
                        dataType: 'json',
                        success: function (data) {
                        
                            var optionHtml='<div class="col-md-6 mt-4 questionaireDetails"><h5>Choose From Existing Form</h5><select class="questionnaire" name="questionnaire_form_id">';
                            for(var i=0;i<data.length;i++)
                            {
                                optionHtml+='<option value="'+data[i]['id']+'">'+data[i]['title']+'</option>';
                            }
                            optionHtml+='</select><h6>Or</h6><button class="btn search task-addnew-form" type="button" data-toggle="modal" data-target="#task-addnew-form"> ADD NEW</button>';
                                            optionHtml+='</div>';
                            $('.mis-field-append-new-field').append(optionHtml);
                            
                            $('.questionnaire').select2();
                        },
                        error: function (data) {
                            console.log('ERRRRR');
                            console.log(data);
                        }
                    });
            }
        });

        $('.storeQuestionarie').click(function(){
            setTimeout(function () { 
                if($('.closeQuestionary').length)
                {
                    $('.closeQuestionary').click();
                    $('.questionaireDetails').html('');
                    var questionaireDetails='<div class="row"><div class="col-md-8"><h3>Questionarie</h3><br>'+$('#questionnary-title').val()+'</div><div class="col-md-4"><span class="mis-field-close delete-left-char remove-mis-definition" style="float:right">Delete</span></div></div>';
                    $('.questionaireDetails').html(questionaireDetails);
                }
              }.bind(this), 4500);
            
        });
    }
    
}

