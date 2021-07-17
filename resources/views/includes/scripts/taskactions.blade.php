<script>
    $(document).ready(function() {
        
        var baseUrl = "{{ url('')}}";
        $(document).on('click', 'body', function() {
            if ($('.search-result-content').length) {
                if (!$("#keywords").is(":focus")) {
                    $('.search-result-content').hide()
                }
            }
        })

        if ($('.collapse-section')) {
            $('.collapse-section').on('click', function() {
                if ($(this).hasClass('collapsed')) {
                    $('.teams-main-content-scroll').attr('hidden', false)
                } else {
                    $('.teams-main-content-scroll').attr('hidden', true)
                }
            })
        }

        $(document).on('focus', '#keywords', function() {
            if ($('.search-result-content ul li').length) {
                $('.search-result-content').show()
            }
        })

        $(document).on('click', '.select2-close', function(e) {
            $(this).parent().remove();
            var value = $(this).attr('data-value')
            var select = $(this).attr('data-select-type')
            $('#' + select).find('option[value=' + value + ']').removeClass('nodisplay')
            var classDetails = $(this).attr('data-values');
            $('.' + classDetails).remove();
            $('#' + select).val('').trigger('change')
            if ($(this).hasClass('remove-child')) {
                $('[data-fund-id="' + value + '"]').remove();
            }
            if ($(this).hasClass('trigger-delete-click')) {
                $('[data-client-id="' + value + '"]').each(function() {
                    var span = $(this).find('span')
                    setTimeout(function() {
                        span.click()
                    }, 500)
                })
            }
            if ($(this).hasClass('remove-department-user')) {
                $('[data-department-id="' + value + '"]').remove();
            }
            if ($(this).hasClass('remove-more-parent')) {
                $('.firstParent-' + classDetails + '[data-value="' + value + '"]').remove()
            }
        });

        // $('#task_assignees').change(function() {
        //     if (this.value) {
        //         if (this.value == 0) {
        //             $('.assignees-input').empty()
        //             $('.assignees-display ul').empty()
        //             $('#task_assignees .nodisplay').removeClass('nodisplay')
        //         } else {
        //             $('.assignees-input').find("input[value='0']").remove()
        //             $('.assignees-display ul').find("li[data-value='0']").remove()
        //         }
        //         var optionSelected = $(this).find("option:selected");
        //         var image = $(this).find("option:selected").attr('data-image')
        //         var department_id = optionSelected.attr('data-department-id')
        //         $(".assignees-display ul").append("<li data-department-id=" + department_id + " data-value='" + this.value + "'><img src=" + image + " alt=''>" + optionSelected.text() + "<span data-values='allusersform_" + this.value + "' data-value='" + optionSelected.val() + "' data-select-type='task_assignees' class='close select2-close'><em class='fas fa-times'></em></span></li>");
        //         // $(".assignees-input").append("<input data-department-id=" + department_id + " class='allusersform_" + this.value + "' name='users[]' type='hidden' value='" + this.value + "'>");
        //         // optionSelected.addClass('nodisplay')
        //     }
        // });

        $('#clients_fund_groups').change(function() {
            var optionSelected = $(this).find("option:selected");
            optionSelected.addClass('nodisplay');
            var clientid = $("#client_id").val();
            var datastring = 'fundgroupsid=' + this.value + '&clientid=' + clientid;

            $.ajax({
                type: "POST",
                data: datastring,
                url: baseUrl + '/manager/clients/addfundgroupsassignedvalue',
                success: function(data) {

                    var phtml = '<ul><li data-value="' + data[0]['id'] + '" class="Fund-item">' + data[0]["fund_group_name"] + '<span data-values=fundgroupsform_' + data[0]["id"] + ' data-value="' + data[0]['id'] + '" data-text="' + data[0]['fund_group_name'] + '"  data-image="' + baseUrl + "/" + data[0]['avatar'] + '" data-select-type="clients_fund_groups" class="close  clients-fundgroups-close remove-child"><em class="fas fa-times"></em></span></li>';
                    for (var k = 0; k < data[0]["getsubfundslist"].length; k++) {
                        phtml += '<li data-value=' + data[0]['getsubfundslist'][k]['id'] + ' class="depart-item">' + data[0]['getsubfundslist'][k]['sub_fund_name'] + '<span data-values="sub_fund_groups_' + data[0]['getsubfundslist'][k]['id'] + ' data-value=' + data[0]['getsubfundslist'][k]['sub_fund_name'] + ' data-select-type="sub_fund_groups" class="close select2-close remove-child"></span></li>';
                    }
                    phtml += '</ul>';
                    $('.fund_groups1').append(phtml);
                }
            });
        });

        $('#subfunds').change(function() {
            if (this.value) {
                if (this.value == 0) {
                    $('.subfunds_list').empty()
                    $('.subfunds ul').empty()
                    $('#subfunds .nodisplay').removeClass('nodisplay')
                } else {
                    $('.subfunds_list').find("input[value='0']").remove()
                    $('.subfunds ul').find("li[data-value='0']").remove()
                }
                var optionSelected = $(this).find("option:selected");
                var image = $(this).find("option:selected").attr('data-image');
                var deptid = $(this).find("option:selected").attr('data-fund-id');
                $(".subfunds ul").append("<li data-fund-id='" + deptid + "' data-value='" + this.value + "'>" + optionSelected.text() + "<span data-values='subfundsform_" + this.value + "' data-value='" + optionSelected.val() + "' data-select-type='subfunds' class='close select2-close '><em class='fas fa-times'></em><input type='hidden' name='subfunds' value='"+this.value+"' /></span></li>");
                $(".subfunds_list").append("<input class='subfundsform_" + this.value + "' data-fund-id='" + deptid + "' name='subfunds[]' type='hidden' value='" + this.value + "'>");
                optionSelected.addClass('nodisplay')
            }
        });

        $('#document').change(function() {
            if (this.value) {
                if (this.value == 0) {
                    $('.document_list').empty()
                    $('.listDocument ul').empty()
                    $('#listDocument .nodisplay').removeClass('nodisplay')
                } else {
                    $('.document_list').find("input[value='0']").remove()
                    $('.listDocument ul').find("li[data-value='0']").remove()
                }
                var optionSelected = $(this).find("option:selected");
                var deptid = $(this).find("option:selected").attr('data-department-id');
                $(".listDocument ul").append("<li data-fund-id='" + deptid + "' data-value='" + this.value + "'><div class='trim-drpdnval'>" + optionSelected.text() + "</div><span data-values='documentform_" + this.value + "' data-value='" + optionSelected.val() + "' data-select-type='document' class='close select2-close '><em class='fas fa-times'></em><input type='hidden' name='report_documents' value='"+this.value+"' /></span></li>");
                $(".document_list").append("<input class='documentform_" + this.value + "' data-fund-id='" + deptid + "' name='document[]' type='hidden' value='" + this.value + "'>");
                optionSelected.addClass('nodisplay')
            }
        });

        $('#dependencies').change(function() {
            var img = ''
            var optionSelected = $(this).find("option:selected");
            if (this.value) {
                if (this.value == 0) {
                    img = '<img src="' + optionSelected.attr("data-image") + '" alt="">'
                    $('.dependencies_list').empty()
                    $('.dependencies ul').empty()
                    $('#dependencies .nodisplay').removeClass('nodisplay')
                } else {
                    $('.dependencies_list').find("input[value='0']").remove()
                    $('.dependencies ul').find("li[data-value='0']").remove()
                }
                $(".dependencies ul").append("<li data-value='" + this.value + "'>" + img + " " + optionSelected.text() + "<span data-values='dependenciesform_" + this.value + "' data-value='" + optionSelected.val() + "' data-select-type='dependencies' class='close select2-close'><em class='fas fa-times'></em></span></li>");
                $(".dependencies_list").append("<input class='dependenciesform_" + this.value + "' name='dependencies[]' type='hidden' value='" + this.value + "'>");
                optionSelected.addClass('nodisplay')
            }
        });

        $('#risk_departments').change(function() {
            var optionSelected = $(this).find("option:selected");
            if (this.value) {
                if (this.value == 0) {
                    $('.departments-input-risk').empty()
                    $('.departments-display-risk ul').empty()
                    $('#risk_departments .nodisplay').removeClass('nodisplay')
                } else {
                    $('.departments-input-risk').find("input[value='0']").remove()
                    $('.departments-display-risk ul').find("li[data-value='0']").remove()
                }
                $(".departments-display-risk ul").append("<li data-value='" + this.value + "'>"+ optionSelected.text() + "<span data-values='dependenciesform_" + this.value + "' data-value='" + optionSelected.val() + "' data-select-type='departments' class='close select2-close'><em class='fas fa-times'></em><input type='hidden' name='departments' value='"+this.value+"' /></span></li>");
                $(".departments-input-risk").append("<input class='dependenciesform_" + this.value + "' name='risk_departments[]' type='hidden' value='" + this.value + "'>");
                optionSelected.addClass('nodisplay')
            }
        });


        // $('#task_reviewers').change(function() {
        //     if (this.value) {
        //         if (this.value == 0) {
        //             $('.reviewers-input').empty()
        //             $('.reviewers-display ul').empty()
        //             $('#task_reviewers .nodisplay').removeClass('nodisplay')
        //         } else {
        //             $('.reviewers-input').find("input[value='0']").remove()
        //             $('.reviewers-display ul').find("li[data-value='0']").remove()
        //         }
        //         var optionSelected = $(this).find("option:selected");
        //         var image = $(this).find("option:selected").attr('data-image')
        //         var department_id = optionSelected.attr('data-department-id')
        //         $(".reviewers-display ul").append("<li data-department-id=" + department_id + " data-value='" + this.value + "'><img src=" + image + " alt=''>" + optionSelected.text() + "<span data-values='reviewusrform_" + this.value + "' class='close select2-close' data-value='" + optionSelected.val() + "' data-select-type='task_reviewers'><em class='fas fa-times'></em></span></li>");
        //         // $(".reviewers-input").append("<input data-department-id=" + department_id + " class='reviewusrform_" + this.value + "' name='review_users[]' type='hidden' value='" + this.value + "'>");
        //         // optionSelected.addClass('nodisplay')
        //     }
        // });

        $(document).on('click', '.custom-control-input', function() {
            var check = $(this).val();
            if (check == 1 || check == 2) {
                $('#comments').attr('hidden', false)
            } else {
                $('#comments').find('textarea').val(null)
                $('#comments').attr('hidden', true)
            }
        });

        $('#modal-trigger-confirmation-text').on('click', function() {
            setTimeout(function() {
                if($('input[name="formType"]').val()=='task')
                {
                    window.location.href = "{{route('task.form',['type'=>base64_encode('task')])}}"
                }
                else if($('input[name="formType"]').val()=='risk')
                {
                    window.location.href = "{{route('task.form',['type'=>base64_encode('risk')])}}"
                }
                else if($('input[name="formType"]').val()=='issue')
                {
                    window.location.href = "{{route('task.form',['type'=>base64_encode('issue')])}}"
                }
                    //window.location.href = "{{route('task')}}"
            }, 2000)
        })

        $('input[data-value="task-due-date"]').on('click', function() {
            $('.datepicker-days .prev').empty();
            $('.datepicker-days .prev').append('<img src="{{ env("APP_URL")}}/img/app/date-prev-arrow.png" alt="prev">');
            $('.datepicker-days .next').empty();
            $('.datepicker-days .next').append('<img src="{{env("APP_URL")}}/img/app/date-next-arrow.png" alt="next">');
        });

        $('input[data-value="task-due-date1"]').on('click', function() {
            $('.datepicker-days .prev').empty();
            $('.datepicker-days .prev').append('<img src="{{ env("APP_URL")}}/img/app/date-prev-arrow.png" alt="prev">');
            $('.datepicker-days .next').empty();
            $('.datepicker-days .next').append('<img src="{{env("APP_URL")}}/img/app/date-next-arrow.png" alt="next">');
        });

        $('input[name="frequency"]').val(1)

        $('.task-frequency a').on('click', function() {
            $('#selected-frequency').text($(this).text())
            $('input[name = "frequency"]').val($(this).attr('data-value'))
            $('#selected-frequency').attr('style', 'color:#495057 !important')
            $('.task-frequency a').removeClass('selected-frequency-in-list')
            $(this).addClass('selected-frequency-in-list')
            if ($('[name="document_type"]').length > 0) {
                $('[name="document_type"]').val($(this).attr('data-value'))
            }
        });

        /* departments and funds */
        $('.view-choose-departments a').on('click', function() {
            alert("testing-choosedepartments");
            debugger;
            $('#selected-departments').text($(this).text());
            $('input[name = "view-departments"]').val($(this).attr('data-value'))
            $('#selected-departments').attr('style', 'color:#495057 !important')
            $(this).addClass("nodisplay");
            $("#client_deptassignedto").removeAttr("disabled");
        });

        $('.view-choose-fundgroups a').on('click', function() {
            alert("fundgroups");
            debugger;
            $('#selected-fund-groups').text($(this).text())
            $('input[name="view-fundgroups"]').val($(this).attr('data-value'))
            $('#selected-fund-groups').attr('style', 'color:#495057 !important')
            $(this).addClass("nodisplay");
            $("#client_fundgroupsassignedto").removeAttr("disabled");
        });

        $(document).on('click', '.doc-image-select', function() {
            $('.selected-page input').val($(this).attr('data-value'))
            $('.selected-page').attr('hidden', false)
        })

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $('.swalDefaultError').click(function() {
            Toast.fire({
                icon: 'error',
                title: 'Please fill the required fields!'
            })
        });

        $(document).on('click', '.mis-field-close', function() {
            if ($(this).hasClass('remove-mis-definition')) {
                $(this).parents('.mis-definition').remove()
            }
            $(this).parent().remove();
        })

        $('#departments1').change(function() {
            if (this.value) {
                var clientid = $("#client_id").val();
                var datastring = 'departments=' + this.value + '&clientid=' + clientid;
                var optionSelected = $(this).find("option:selected");
                optionSelected.addClass('nodisplay');
                $.ajax({
                    type: "POST",
                    data: datastring,
                    url: baseUrl + '/manager/clients/adddepartmentassignedvalue',
                    success: function(data) {
                        //alert(data.length);
                        debugger;
                        if (data.length > 1) {
                            $(".department_list").append("<option value='0' data-image='" + baseUrl + "/img/fundgroup/AllFundGroups.png'>All Departments</option>");
                        }

                        $(".view-dept ul").append("<li data-value='" + data['id'] + "'>" + data['name'] + "<span data-values='departmentform_" + data['id'] + "' data-value='" + data['id'] + "' data-text='" + data['name'] + "' data-image='" + baseUrl + "/" + data['dep_icon'] + "'  data-select-type='departments1' class='close clients-dept-close remove-child'><em class='fas fa-times'></em></span></li>");
                        if (data != null) {
                            $(".department_list").append("<input class='departmentsform_" + data['id'] + "' name='departments[]' type='hidden' value='" + data['id'] + "'>");
                        }

                    }
                });
            }
        });


        $(document).on('click', '.mis-field-add', function(e) {
            var baseUrl = "{{ url('')}}";
            var content = $(this).attr('data-append-content')
            var type = $(this).attr('data-field-type')
            var mis = $(this)
            $.ajax({
                type: 'get',
                url: baseUrl + '/manager/task/mis-field/' + type,
                success: function(data) {
                    if (type != 'dropdown-option') {
                        $('.mis-field-append-' + content).append('' + data + '')
                    }
                    $('img.mis-field-add').attr('src', "{{env('DOMAIN_URL')}}/img/app/plus-into-red-add-icon.png")
                    if (type == 'dropdown') {
                        var ttl = mis.attr('data-count');
                        var new_ttl = Number(ttl) + Number(1)
                        mis.attr('data-count', new_ttl)
                        console.log(new_ttl)
                        var drop = $('.mis-field-append-' + content).find('.mis-definition:last')
                        console.log(drop)
                        drop.find('img.mis-field-add').attr('data-list-no', new_ttl)
                        drop.attr('data-list-no', new_ttl)
                        drop.find('input[type="radio"]').attr('name', 'temp_name_' + new_ttl)
                    }
                    if (type == 'dropdown-option') {
                        var list_no = mis.attr('data-list-no')
                        console.log(list_no)
                        $('.mis-definition[data-list-no="' + list_no + '"]').find('.mis-field-append-' + content).append('' + data + '')
                        $('.mis-definition[data-list-no="' + list_no + '"]').find('input[type="radio"]').last().attr('name', 'temp_name_' + list_no)
                    }
                }
            });
        })

        $(document).on('click', '.selected-doc-clear', function() {
            var id = $(this).attr('data-id');
            $('#selected-doc-' + id).remove()
            $(this).parent().remove()
            $('#parentWindow-selected-content-html-' + id).remove()
        })

        $(document).on('click', '.selected-page-remove-from-modal', function() {
            $(this).parent().remove()
        })

        $(document).on('click', '.clients-dept-close', function(e) {
            var baseUrl = "{{ url('')}}";
            $(this).parent().remove();
            var id = $(this).attr('data-value');
            var image = $(this).attr('data-image');
            var text = $(this).attr('data-text');
            $.ajax({
                type: "GET",
                url: baseUrl + '/manager/clients/deletedepartmentassignedvalue/' + id,
                success: function(data) {
                    if (!data.hasErrors) {
                        $("#departments1").append('<option value="' + id + '" data-image=' + image + '>' + text + '</option>')
                    }
                }
            });
        });

        $(document).on('click', '.clients-fundgroups-close', function(e) {
            var baseUrl = "{{ url('')}}";
            var value = $(this).attr('data-value')
            var select = $(this).attr('data-select-type')
            var id = $(this).attr('data-value');
            var image = $(this).attr('data-image');
            var text = $(this).attr('data-text');
            $(this).parent().parent().remove();
            $.ajax({
                type: "GET",
                url: baseUrl + '/manager/clients/deletefundgroupsassignedvalue/' + id,
                success: function(data) {
                    $("#clients_fund_groups").append('<option value="' + id + '" data-image=' + image + '>' + text + '</option>')
                }
            });
        });

        $('input[name="document_file"]').change(function(e) {
            $('.document-upload-preview').empty()
            var map = e.target.files[0];
            var type = map.name.split('.').pop()
            var img = 'pdf-document.svg'
            if (type == 'doc') {
                img = 'document-check.svg'
            }
            $('.document-upload-preview').append('<div class="prev-upload-doc d-flex"><div class="img-docu-item"><img src="/img/' + img + '" alt="PDF document" class="img-fluid mr-4"></div><div class="dodument-name"><p>' + map.name + '</p></div><div class="ml-auto"><span class="close-document"><em class="fas fa-times"></em></span></div></div>')
        })

        $('#reopen-task, #delete-task').click(function(e){
            $('#reopen-description').attr('hidden',true)
            var id=$(this).attr('id');
            var txt = id.split('-')[0];
            if(id == "reopen-task"){
                $('#reopen-description').attr('hidden',false)
            }
            $('#task-action-msg').text(txt)
            $('.task-action-btn').attr('href',$(this).attr('data-href'));
        })

    });
</script>