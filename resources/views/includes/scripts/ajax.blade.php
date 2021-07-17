<script>
    $(document).ready(function() {

        if ($('#task_clients').length) {
            retriveClientDetails();
        }
        if ($('#task_departments').length) {
            retriveDepartmentDetails();
        }
        if ($('#task_risk_category').length) {
            retriveRiskCategoryDetails();
        }

        if ($('#task_associate_activity').length) {
            retriveAssociateActivity();
        }

        var baseUrl = "{{ url('')}}";
        var awsurl = "{{env('AWS_URL')}}";
        $(".financial_impact_value").hide();
        $(".financial_impact_resolution").hide();
        $("#task_financial_impact_resolution").hide();
        $("#task_financial_impact_value").hide();
        $('#task_clients').change(function() {
            //alert("task_clients");debugger;
            $('#task_dependencies').empty()
            $('.dependencies-display ul').empty()
            $('#task_dependencies').append('<option value="" disabled> {{__("task_creation.Taskcreation_stepone.Choose Dependency")}}</option>')
            $('#task_fund_groups').empty();
            $('#task_fund_groups').append("<option value='' disabled>{{__('task_creation.Taskcreation_stepone.Choose Fund Group')}}</option>");
            $('.fund_groups-display ul').empty();
            $('#task_departments').empty()
            $('.departments-display ul').empty()
            $('#task_departments').append("<option value=''  disabled>{{__('task_creation.Taskcreation_stepone.Departments')}}</option>");
            var OptionValue = $(this).val();
            $(".clients-display ul").empty();
            $('#task_clients option').each(function() {
                if ($(this).is(':selected')) {
                    var url = $(this).attr('data-image');
                    var domain = url.split('/');
                    var keyword = domain[3];
                    if (keyword != "null" && keyword != "") {
                        $(".clients-display ul").append("<li><img src=" + $(this).attr('data-image') + " alt=''>" + $(this).text() + "</li>");
                    } else {
                        $(".clients-display ul").append("<li><img src='" + baseUrl + "/img/user-avatar.png'>" + $(this).text() + "</li>");
                    }
                }
            });

            var values = $(this).val();
            if (values) {
                $.ajax({
                    url: baseUrl + '/manager/fundgroupby_company',
                    type: "GET",
                    data: {
                        'clients': values
                    },
                    success: function(data) {
                        if (data.length > 1) {
                            $('#task_fund_groups').append("<option value='0' data-client-id='0' data-image='" + baseUrl + "/img/select-all.png'>{{__('task_creation.Taskcreation_stepone.All Funds')}}</option>");
                        }
                        for (var i = 0; i < data.length; i++) {
                            var nodisplay = ''
                            if ($('.fundgroupsform_' + data[i].id).length > 0) {
                                nodisplay = 'nodisplay'
                            }
                            $('#task_fund_groups').append("<option data-client-id=" + data[i].company_id + " class='" + nodisplay + "' data-image='{{env('AWS_URL')}}/" + data[i].avatar + "' value='" + data[i].id + "'>" + data[i].fund_group_name + "</option>");
                        }

                        if($('#mode').length && ($('#mode').val()=='edit' || $('#mode').val()=='parent'))
                        {
                            var value = $('#task_fund_groups').attr('data-selectedID');
                            // Set selected 

                            $('#task_fund_groups').val(value).select2().trigger('change');
                        }

                    },
                    error: function(error) {
                        console.log(data);
                    }
                });
                $('#task_departments').html();
                $.ajax({
                    url: baseUrl + '/manager/departments_by_clients',
                    type: "GET",
                    data: {
                        'clients': values
                    },
                    success: function(data) {
                        if (data.length > 1) {
                            $('#task_departments').append("<option value='0' data-client-id='0' data-image='" + baseUrl + "/img/select-all.png'>{{__('task_creation.Taskcreation_stepone.All Departments')}}</option>");
                        }
                        for (var i = 0; i < data.length; i++) {
                            $('#task_departments').append("<option data-image='{{env('AWS_URL')}}/" + data[i].dep_icon + "' value='" + data[i].id + "'>" + data[i].name + "</option>");
                        }
                        if($('#mode').length && ($('#mode').val()=='edit' || $('#mode').val()=='parent'))
                        {
                            var value = $('#task_departments').attr('data-selectedID');
                            // Set selected 

                            $('#task_departments').val(value).select2().trigger('change');
                        }
                    },
                    error: function(error) {
                        console.log(data);
                    }
                });
                if ($('#task_dependencies').length) {
                    $.ajax({
                        url: baseUrl + '/manager/dependency_company',
                        type: "GET",
                        data: {
                            'clients': values
                        },
                        success: function(data1) {
                          
                            $('#task_dependencies').empty();

                            if (data1.length > 1) {
                                $('#task_dependencies').append("<option value='0' data-image='" + baseUrl + "/img/select-all.png'>{{__('task_creation.Taskcreation_stepone.All Dependencies')}}</option>");
                            }
                            for (var i = 0; i < data1.length; i++) {
                                if (data1[i].task_name != null && data1[i].task_name != '') {
                                    $('#task_dependencies').append("<option value='" + data1[i].id + "'>" + data1[i].task_name + "</option>");

                                }
                            }

                            if($('#mode').length && ($('#mode').val()=='edit' || $('#mode').val()=='parent'))
                    {
                        var value = $('#task_dependencies').attr('data-selectedID');
                        $('#task_dependencies').val(value.split(",")).select2().trigger('change');
                    }
                        },
                        error: function(error) {
                            console.log(data1);
                        }
                    });
                }
                if ($('#task_risk_register_impact').length) {
                    $.ajax({
                        url: baseUrl + '/manager/dependency_company/risk',
                        type: "GET",
                        success: function(data1) {
                            console.log(data1)
                            $('#task_risk_register_impact').empty();

                            if (data1.length > 1) {
                                //$('#task_risk_register_impact').append("<option value='0' data-image='" + baseUrl + "/img/select-all.png'>{{__('task_creation.Taskcreation_stepone.All Dependencies')}}</option>");
                            }
                            for (var i = 0; i < data1.length; i++) {
                                if (data1[i].task_name != null && data1[i].task_name != '') {
                                    $('#task_risk_register_impact').append("<option value='" + data1[i].id + "'>" + data1[i].task_name + "</option>");

                                }
                            }
                        },
                        error: function(error) {
                            console.log(data1);
                        }
                    });
                }
            }
        });

        $('#task_risk_category').change(function() {
            $('#task_risk_subcategory').empty();
            var baseUrl = "{{ url('')}}";
            var values = $(this).val();
            $.ajax({
                url: baseUrl + '/manager/retriveTaskFormDetails/riskSubCategory',
                type: "GET",
                data: {
                    "category_id": values
                },
                success: function(data) {
                    if (data.length > 1) {
                        $('#task_risk_subcategory').append("<option value='0' disabled>Select Sub-category</option>");
                    }
                    for (var i = 0; i < data.length; i++) {
                        var nodisplay = ''
                        if ($('[data-values=subfundsform_' + data[i].id + ']').length > 0) {
                            nodisplay = 'nodisplay'
                        }
                        $('#task_risk_subcategory').append('<option class="' + nodisplay + '" value="' + data[i].id + '">' + data[i].title + '</option>');
                    }

                    if($('#mode').length && ($('#mode').val()=='edit' || $('#mode').val()=='parent'))
                    {
                        var value = $('#task_risk_subcategory').attr('data-selectedID');
                        // Set selected 

                        $('#task_risk_subcategory').val(value).select2().trigger('change');
                    }
                },
                error: function(error) {
                    console.log(data);
                }
            });
        });

        $('#task_fund_groups').change(function() {
            $('#task_sub_fund_groups').empty();
            $('#task_sub_fund_groups').append("<option value='' disabled>{{__('task_creation.Taskcreation_stepone.Choose Sub Fund')}}</option>");
            $('.sub_fund_groups-display ul').empty();

            $(".fund_groups-display ul").empty();
            $('#task_fund_groups option').each(function() {
                if ($(this).is(':selected')) {
                    $(".fund_groups-display ul").append("<li>" + $(this).text() + "</li>");
                }
            });
            var values = $(this).val();
            if (values.length == 1 && values[0] == 0) {
                $('#task_fund_groups option').each(function(i) {
                    values[i] = $(this).val()
                })
                values.shift()
            }
            console.log(values);
            console.log('###');
            if (values.length) {
                $.ajax({
                    url: baseUrl + '/manager/subfundby_company/',
                    type: "GET",
                    data: {
                        "fundgroups": values,
                    },
                    success: function(data) {
                        if (data.length > 1) {
                            $('#task_sub_fund_groups').append("<option value='0' data-image='" + baseUrl + "/img/select-all.png'>{{__('task_creation.Taskcreation_stepone.All Sub Funds')}}</option>");
                        }
                        for (var i = 0; i < data.length; i++) {
                            var nodisplay = ''
                            if ($('[data-values=subfundsform_' + data[i].id + ']').length > 0) {
                                nodisplay = 'nodisplay'
                            }
                            $('#task_sub_fund_groups').append('<option data-fund-id="' + data[i].fund_group_id + '" class="' + nodisplay + '" data-image=' + baseUrl + '/' + data[i].sub_fund_avatar + ' value="' + data[i].id + '">' + data[i].sub_fund_name + '</option>');
                        }

                            if($('#mode').length && ($('#mode').val()=='edit' || $('#mode').val()=='parent'))
                        {
                            var value = $('#task_sub_fund_groups').attr('data-selectedID');
                            // Set selected 

                            $('#task_sub_fund_groups').val(value).select2().trigger('change');
                        }

                    },
                    error: function(error) {
                        console.log('Error on Retrive');
                    }
                });
            }
        });

        $('#task_sub_fund_groups').change(function() {
            $(".sub_fund_groups-display ul").empty();
            $('#task_sub_fund_groups option').each(function() {
                if ($(this).is(':selected')) {
                    $(".sub_fund_groups-display ul").append("<li>" + $(this).text() + "</li>");
                }
            });
        });

        $('.responsible_party').change(function(){
            if($(this).attr('data-optionText')=='external')
            {
                $('#task_responsible_party_comments').show();
            }
            else
            {
                $('#task_responsible_party_comments').hide().val('');
                $('.responsible_party_internal').remove();
                $('.issue_responsible_party').append('<div class="form-group responsible_party_internal"><label for="Dependiencies">Departments</label><span>'+$('#task_departments option:selected').text()+'</span></div>')
            }
        });

        $('#task_assignees').change(function() {
            $(".assignees-display ul").empty()
            $('#task_assignees option').each(function() {
                if ($(this).is(':selected')) {
                    $(".assignees-display ul").append("<li><img src=" + $(this).attr('data-image') + " alt=''>" + $(this).text() + "</li>");
                }
            });
            var values = $(this).val()
            // values.each(function(i,v){
            //     $('#task_reviewers').find('option[value="'+v+'"]').addClass('nodisplay')
            // })
            $('#task_reviewers option').removeClass('nodisplay');
            $.each(values, function() {
                $('#task_reviewers').find('option[value="' + this + '"]').addClass('nodisplay')
            })

        });

        $('#task_reviewers').change(function() {
            $(".reviewers-display ul").empty()
            $('#task_reviewers option').each(function() {
                if ($(this).is(':selected')) {
                    $(".reviewers-display ul").append("<li><img src=" + $(this).attr('data-image') + " alt=''>" + $(this).text() + "</li>");
                }
            });
            var values = $(this).val()
            $('#task_assignees option').removeClass('nodisplay');
            $.each(values, function() {
                $('#task_assignees').find('option[value="' + this + '"]').addClass('nodisplay')
            })
        });

        $('#departments').change(function() {
            $('#allusrs,#review_users').empty();
            $('#allusrs').append("<option value='' disabled>{{__('task_creation.Taskcreation_stepone.Choose Users')}}</option>");
            $('#review_users').append("<option value='' disabled>{{__('task_creation.Taskcreation_stepone.Choose Review Users')}}</option>");
            var optionSelected = $(this).find("option:selected");
            var values = []
            if ($("input[name='departments[]']").length == 0) {
                $('.allusrs ul, .reviewusr ul, .dept ul, .assignees-input, .reviewers-input').empty();
            }
            if (this.value || $("input[name='departments[]']").length > 0) {
                if (this.value) {
                    $(".departments-input").append("<input class='departments_input-" + this.value + "' name='departments[]' type='hidden' value='" + this.value + "'>");
                    if (this.value == 0) {
                        $('.departments-input input').not(".departments_input-" + this.value).remove()
                        $('.departments-display ul').empty()
                        $('#departments .nodisplay').removeClass('nodisplay')
                    } else {
                        $('.departments-input').find("input[value='0']").remove()
                        $('.departments-display ul').find("li[data-value='0']").remove()
                        optionSelected.addClass('nodisplay')
                        var exist_departments = $("input[name='departments[]']")
                            .map(function() {
                                return $(this).val();
                            }).get();
                        $.each(exist_departments, function() {
                            $('.allusrs li[data-department-id=' + this + ']').addClass('wait-complete')
                            $('.reviewusr li[data-department-id=' + this + ']').addClass('wait-complete')
                            $('.assignees-input input[data-department-id=' + this + ']').addClass('wait-complete')
                            $('.reviewers-input input[data-department-id=' + this + ']').addClass('wait-complete')
                        })
                        $('.allusrs li').each(function() {
                            if (!$(this).hasClass('wait-complete')) {
                                $(this).remove()
                            }
                            $(this).removeClass('wait-complete')
                        })
                        $('.assignees-input input').each(function() {
                            if (!$(this).hasClass('wait-complete')) {
                                $(this).remove()
                            }
                            $(this).removeClass('wait-complete')
                        })
                        $('.reviewusr li').each(function() {
                            if (!$(this).hasClass('wait-complete')) {
                                $(this).remove()
                            }
                            $(this).removeClass('wait-complete')
                        })
                        $('.reviewers-input input').each(function() {
                            if (!$(this).hasClass('wait-complete')) {
                                $(this).remove()
                            }
                            $(this).removeClass('wait-complete')
                        })
                    }
                    $(".departments-display ul").append("<li data-value=" + this.value + ">" + optionSelected.text() + "<span class='close select2-close remove-department-user' data-values='departments_input-" + this.value + "' data-value='" + optionSelected.val() + "' data-select-type='departments'><em class='fas fa-times'></em><input type='hidden' name='report_departments' value='"+ this.value+"' /></span></li>");
                }
                if (this.value != 0 || !this.value) {
                    values = $("input[name='departments[]']")
                        .map(function() {
                            return $(this).val();
                        }).get();
                }
                console.log(values)
                var add_deps = $("#departments option")
                    .map(function() {
                        return $(this).attr('value');
                    }).get();
                console.log(add_deps)
                $.ajax({
                    url: baseUrl + '/manager/usersby_department',
                    type: "GET",
                    data: {
                        "departments[]": values,
                        'add_deps[]': add_deps
                    },
                    success: function(data) {
                        console.log(data)
                        if (data.length > 1) {
                            $('#allusrs').append("<option value='0' data-image='" + baseUrl + "/img/user-avatar.png'>{{__('task_creation.Taskcreation_stepone.All Users')}}</option>");
                            $('#review_users').append("<option value='0' data-image='" + baseUrl + "/img/user-avatar.png'>{{__('task_creation.Taskcreation_stepone.All Users')}}</option>");
                        }
                        for (var i = 0; i < data.length; i++) {
                            var user_nodisplay = ''
                            var review_nodisplay = ''
                            if ($('[data-values=allusersform_' + data[i].company_user_id + ']').length > 0) {
                                user_nodisplay = 'nodisplay'
                            }
                            if ($('[data-values=reviewusrform_' + data[i].company_user_id + ']').length > 0) {
                                review_nodisplay = 'nodisplay'
                            }
                            $('#allusrs').append("<option data-department-id=" + data[i].department_id + " class='" + user_nodisplay + "' data-image='" + baseUrl + '/' + data[i].avatar + "' value='" + data[i].id + "'>" + data[i].name + "</option>");
                            $('#review_users').append("<option data-department-id=" + data[i].department_id + " class='" + review_nodisplay + "' data-image='" + baseUrl + '/' + data[i].avatar + "' value='" + data[i].id + "'>" + data[i].name + "</option>");
                        }
                    },
                    error: function(error) {
                        console.log(data);
                    }
                });
            }
        });

        $('#task_departments').change(function() {
            $('#task_assignees,#task_reviewers').empty();
            $('#task_assignees').append("<option value='' disabled>{{__('task_creation.Taskcreation_stepone.Choose Users')}}</option>");
            $('#task_reviewers').append("<option value='' disabled>{{__('task_creation.Taskcreation_stepone.Choose Review Users')}}</option>");

            $(".departments-display ul").empty();
            $('#task_departments option').each(function() {
                if ($(this).is(':selected')) {
                    $(".departments-display ul").append("<li>" + $(this).text() + "</li>")
                }
            });
            var values = $(this).val();
            if (values.length == 1 && values[0] == 0) {
                $('#task_departments option').each(function(i) {
                    values[i] = $(this).val()
                })
                values.shift()
            }
            console.log(values)
            $.ajax({
                url: baseUrl + '/manager/usersby_department',
                type: "GET",
                data: {
                    "departments[]": values,
                },
                success: function(data) {
                    console.log(data)
                    // if (data.length > 1) {
                    //     $('#task_assignees').append("<option value='0' data-image='" + baseUrl + "/img/user-avatar.png'>{{__('task_creation.Taskcreation_stepone.All Users')}}</option>");
                    //     $('#task_reviewers').append("<option value='0' data-image='" + baseUrl + "/img/user-avatar.png'>{{__('task_creation.Taskcreation_stepone.All Users')}}</option>");
                    // }
                    for (var i = 0; i < data.length; i++) {
                        var user_nodisplay = ''
                        var review_nodisplay = ''
                        if ($('[data-values=allusersform_' + data[i].company_user_id + ']').length > 0) {
                            user_nodisplay = 'nodisplay'
                        }
                        if ($('[data-values=reviewusrform_' + data[i].company_user_id + ']').length > 0) {
                            review_nodisplay = 'nodisplay'
                        }

                        $('#task_assignees').append("<option data-department-id=" + data[i].department_id + " class='" + user_nodisplay + "' data-image='" + baseUrl + '/' + data[i].avatar + "' value='" + data[i].company_user_id + "'>" + data[i].name + "</option>");


                        $('#task_reviewers').append("<option data-department-id=" + data[i].department_id + " class='" + review_nodisplay + "' data-image='" + baseUrl + '/' + data[i].avatar + "' value='" + data[i].company_user_id + "'>" + data[i].name + "</option>");

                    }

                        if($('#mode').length && ($('#mode').val()=='edit' || $('#mode').val()=='parent'))
        {
                        var value = $('#task_assignees').attr('data-selectedID');
                        if (value) {
                            var value_in_array = value.split(',');
                            $('#task_assignees').val(value_in_array).select2().trigger('change');
                        }
                    }
                    if($('#mode').length && ($('#mode').val()=='edit' || $('#mode').val()=='parent'))
                    {
                        var value = $('#task_reviewers').attr('data-selectedID');
                        if (value) {
                            var value_in_array = value.split(',');
                            $('#task_reviewers').val(value_in_array).select2().trigger('change');
                        }
                    }
                },
                error: function(error) {
                    console.log(data);
                }
            });
        });

        $('.task-filter-by-department').on('click', function() {
            var id = $(this).attr('data-id');
            var department = $(this).find('span').text()
            window.location.href = "{{route('task')}}" + "/" + id + "/" + department + '?type=' + "{{base64_encode(strtolower('task'))}}"
        })

        $('#btn_search').click(function() {
            $('.table-report').show();
            $('.doc-list').empty();
            $('.search-count').empty()
            var ids = $('#keywords').attr('suggest-ids')
            $.ajax({
                url: baseUrl + '/manager/fetch_documentsby_type/' + ids,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    for (var i = 0; i < data.response.numFound; i++) {
                        $('.doc-list').append("<tr><td class='display-pdf-modal' data-doc-id=" + data.response.docs[i].id + " data-toggle='modal' data-target='#exampleModalCenter'>" + data.response.docs[i].description + "</td><td>p." + data.response.docs[i].attr_xmptpg_npages + "</td><td >Ref Number: " + data.response.docs[i].id + "</td> <td>Date: 01/28/2021</td></tr>");
                    }
                },
                error: function(error) {
                    console.log(data);
                }
            });
        });

        var delay = (function() {
            var timer = 0;
            return function(callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })()

        // Search Documents - Auto Suggestions List 
        $('#keywords').keyup(function() {
            hideLoader();
            $('.search-result-content .no-data-found').attr('hidden', true);
            if ($(this).val().length > 0) {
                delay(function() {
                    $('.search-result-body').attr('style', 'display:block');
                    $.ajax({
                        url: baseUrl + '/manager/task/suggest/' + $('#keywords').val() + '?doc_type=' + $('#document_type').val(),
                        type: "GET",
                        dataType: 'json',
                        beforeSend: function() {
                            showLoader();
                        },
                        success: function(data) {
			            
                            if (data.numFound > 0) {
                                hideLoader();
                                $('.search-result-content').show()
                                $('.search-btn').attr('hidden', true)
                                var exist_li = $('.doc-search-append li').length
                                var exist_suggest = $('.doc-search-append li')
                                var limit = 4;
                                if (data.numFound <= limit) {
                                    limit = data.numFound
                                    $('.show-more-suggest').attr('hidden', true);
                                } else {
                                    $('.show-more-suggest').attr('hidden', false);
                                }
                                for (var i = 0; i < limit; i++) {
                                    var suggest = '';
                                    var string
                                    if (data.suggestions[i].cat == 'Title') {
                                        string = data.suggestions[i].term
                                    } else {
                                        suggest = data.suggestions[i].term.split(/<b>(.+)/);
                                        string = "<b>" + getWords(suggest[1])
                                    }
                                    var data_populate = data.suggestions[i].payload.split('___split___');
                                    var img = ''
                                    if (data.suggestions[i].cat == 'Text') {
                                        img = '/img/document_text.png'
                                    } else {
                                        img = '/img/document_title.png'
                                    }
                                    var tmp = '<span class="col-md-1"><img src="' + baseUrl + img + '"></span><span class="suggest-text col-md-9 text-left">' + string + '</span><span class="col-md-2 text-left float-right">in ' + data.suggestions[i].cat + '</span>'
                                    if (i < exist_li && i < limit) {
                                        $(exist_suggest[i]).empty()
                                        $(exist_suggest[i]).append(tmp)
                                        $(exist_suggest[i]).attr('data-id', data_populate[0])
                                        $(exist_suggest[i]).attr('data-cat', data.suggestions[i].cat)
                                        $(exist_suggest[i]).addClass('select-suggest')
                                    } else {
                                        $('.doc-search-append').append('<li class="row m-0 select-suggest" data-toggle="modal" data-target="#exampleModalCenter" data-id=' + data_populate[0] + ' data-cat=' + data.suggestions[i].cat + '>' + tmp + '</li>');
                                    }
                                }
                                if (exist_li > limit) {
                                    var count = limit - 1
                                    $('.doc-search-append li:gt(' + count + ')').remove();
                                }
                            } else {
                                hideLoader();
                                $('.search-result-content .no-data-found').attr('hidden', false);
                                $('.doc-search-append li').remove();
                                $('.show-more-suggest').attr('hidden', true);
                            }
                            hideLoader();
                           
                        },
                        error: function(error) {
                            hideLoader();
                            console.log(data);
                        }
                    });
                }, 500)
            } else {
                $('.doc-search-append').empty();
                $('.search-result-body').attr('style', 'display:none');
                $('.show-more-suggest').attr('hidden', true);
            }
        });
        // Search Documents - Auto Suggestions List 

        $('.show-more-suggest').on('click', function() {
            $('.modal-suggest-list').empty()
            $('.modal-suggest-list tr').remove()
            $('.doc-search-append').empty();
            $('.search-result-body').attr('style', 'display:none');
            $('.show-more-suggest').attr('hidden', true);
            var keyword = $('#keywords').val()
            $('.modal-search-docs').val(keyword);
            suggetion_list_on_modal(keyword, 0, 10, 1)
        })

        $('.modal-search-docs').on('keyup', function() {
            var keyword = $(this).val()
            if (keyword.length > 0) {
                delay(function() {
                    suggetion_list_on_modal(keyword, 0, 10, 1)
                }, 500)
            } else {
                $('.modal-suggest-list tr').remove();
                $('.suggest-start').text(0)
                $('.suggest-end').text(0)
                $('.suggest-total').text(0)
                $('.suggest-report-pagination').attr('hidden', true)
                $('.suggest-report-pagination ul').empty()
                hideLoader();
            }

        })

        $(document).on('click', '.suggest-page-click', function() {
            var page = $(this).attr('data-page')
            var keyword = $('.modal-search-docs').val();
            var start = page * 10 - 10;
            var end = start + 10;
            suggetion_list_on_modal(keyword, start, end, page)
        })

        function suggetion_list_on_modal(keyword, start, end, page) {
            $.ajax({
                url: baseUrl + '/suggest/' + keyword + '?doc_type=' + $('#document_type').val(),
                type: "GET",
                dataType: 'json',
                beforeSend: function() {
                    showLoader();
                },
                success: function(data) {
                    if (data.numFound > 0) {
                        if (end > data.numFound) {
                            end = data.numFound
                        }
                        var exist_suggest = $('.modal-suggest-list tr[data-target="#exampleModalCenter"]')
                        var count_avl = end - start
                        var exist_tmp_sug = Number(exist_suggest.length) + Number(start)
                        var pages = Math.ceil(data.numFound / 10);
                        var next = Number(page) + Number(1);
                        var previous = Number(page) - 1;
                        $('.suggest-page-next').attr('data-page', next)
                        $('.suggest-page-previous').attr('data-page', previous)
                        if (next > pages) {
                            $('.suggest-page-next').attr('disabled', true)
                        } else {
                            $('.suggest-page-next').attr('disabled', false)
                        }
                        if (previous == 0) {
                            $('.suggest-page-previous').attr('disabled', true)
                        } else {
                            $('.suggest-page-previous').attr('disabled', false)
                        }
                        var tmp_list = 0
                        for (var i = start; i < end; i++) {
                            var suggest = '';
                            var string
                            if (data.suggestions[i].cat == 'Title') {
                                string = data.suggestions[i].term
                            } else {
                                suggest = data.suggestions[i].term.split(/<b>(.+)/);
                                string = "<b>" + getWords(suggest[1])
                            }
                            var data_populate = data.suggestions[i].payload.split('___split___');
                            var img = ''
                            if (data.suggestions[i].cat == 'Text') {
                                img = '/img/document_text.png'
                            } else {
                                img = '/img/document_title.png'
                            }
                            var tmp = '<td><img src=' + baseUrl + img + ' class="modal-suggest-img">' + string + '</td><td class="modal-suggest-"' + data.suggestions[i].cat + '">in ' + data.suggestions[i].cat + '</td><td>' + data_populate[1] + '</td><td>Ref.' + data_populate[0] + '</td><td>' + data_populate[2] + '</td>'
                            if (i < exist_tmp_sug) {
                                $(exist_suggest[i - start]).empty()
                                $(exist_suggest[i - start]).append(tmp)
                                $(exist_suggest[i - start]).attr('data-id', data_populate[0])
                                $(exist_suggest[i - start]).attr('data-cat', data.suggestions[i].cat)
                                $(exist_suggest[i - start]).addClass('select-suggest')
                            } else {
                                $('.modal-suggest-list').append('<tr class="select-suggest" data-toggle="modal" data-target="#exampleModalCenter" data-id="' + data_populate[0] + '">' + tmp + '<tr>');
                            }
                        }
                        if (exist_suggest.length > count_avl) {
                            var count = count_avl - 1
                            $('.modal-suggest-list tr[data-target="#exampleModalCenter"]:gt(' + count + ')').remove();
                        }
                        var exist_page = $('.suggest-report-pagination ul li')
                        if (pages > 1) {
                            $('.suggest-report-pagination').attr('hidden', false)
                            for (var i = 1; i <= pages; i++) {
                                if (i <= exist_page.length) {
                                    $(exist_page[i - 1]).attr('data-page', i)
                                    $(exist_page[i - 1]).text(i)
                                } else {
                                    $('.suggest-report-pagination ul').append('<li class="suggest-page-click" data-page="' + i + '">' + i + '</li>')
                                }
                            }
                            if (exist_page.length > pages) {
                                var count = pages - 1
                                $('.suggest-report-pagination ul li:gt(' + count + ')').remove();
                            }
                            $('.suggest-page-click').removeClass('suggest-page-clicked')
                            $('.suggest-page-click[data-page="' + page + '"]').addClass('suggest-page-clicked')
                        } else {
                            $('.suggest-report-pagination').attr('hidden', true)
                            $('.suggest-report-pagination ul').empty()
                        }
                        $('.suggest-start').text(start + 1)
                        $('.suggest-end').text(end)
                        $('.suggest-total').text(data.numFound)
                        hideLoader();
                    } else {
                        $('.modal-suggest-list tr').remove();
                        $('.suggest-start').text(0)
                        $('.suggest-end').text(0)
                        $('.suggest-total').text(0)
                        $('.suggest-report-pagination').attr('hidden', true)
                        $('.suggest-report-pagination ul').empty()
                        hideLoader();
                    }
                },
                error: function(error) {
                    console.log(data);
                }
            });
        }

        $(document).on('click', '.document-confirm-excel', function() {
            $('.document-page-select').click()
            $(this).removeClass('document-confirm-excel')
        })

        $(document).on('click', '.select-suggest', function(e) {
            $('.document-confirm').attr('disabled', true)
            var id = $(this).attr('data-id')
            $('#iframe-wrapper').empty()
            $('.doc-search-append li').remove()
            $('.search-result-content').hide()
            $('#selected-page-list').empty()
            $('#selected-text-list').empty()
            $.ajax({
                url: baseUrl + '/manager/fetch_documentsby_type',
                type: "GET",
                dataType: "JSON",
                data: {
                    doc_id: id
                },
                success: function(data) {
                    //alert(data);debugger;
                    $('.view-card-sec').empty();
                    var doc = data.doc_path.split('/')
                    var doc_ext = doc[1].split('.').pop()
                    $('#doc-name-modal').text(data.doc_title)
                    $('#doc-type-modal').text(data.doc_type)
                    $('.document-page-select').attr('data-doc-title', data.doc_title)
                    $('.document-page-select').attr('data-doc-name', doc[2])
                    $('.document-page-select').attr('data-doc-id', data.id)
                    var exist = $('#parentWindow-selected-content-html-' + data.id).length
                    if (exist > 0) {
                        $('.delete-item').empty()
                        $('.delete-item').append($('#parentWindow-selected-content-html-' + data.id).html())
                    }

                   
                  
                    if(data["version_history"].length>0 || data["version_history"]!='')
                    {
                        $('.view-card-sec').append('<ul><a  target="_blank" doc-href="'+data["doc_path"]+'" class="selectdocument" style="cursor:pointer;"><li class="view-list-item"><p>'+data["doc_update_date"]+'</p><span>'+data["nameofuser"]+'</span></li></a></ul>');
                    for(var i = 0; i <=data["version_history"]["created_at"].length; i++)
                        {
                            if(data["version_history"]["created_at"][i])
                            {
                            $('.view-card-sec').append('<ul><a  target="_blank" doc-href="'+data["version_history"]["docpath"][i]+'" style="cursor:pointer;" class="selectdocument"><li class="view-list-item"><p>'+data["version_history"]["created_at"][i]+'</p><span>'+data["version_history"]["nameofuser"][i]+'</span></li></a></ul>');
                            }
                        }
                    }

                    
                    // $.each(data['version_history']['name'], function( key, value ) {
                    //     alert(value);
                    //     $('.version_history_data').append('<div class="prev-upload-doc d-flex"><div class="img-docu-item"></div><div class="dodument-name"><p><a  target="_blank" href="#">'+value+'</a></p></div><div class="ml-auto"><span class="close-document"></span></div></div>');
                    //     });

                    $.ajax({
                        url: baseUrl + '/manager/doc_viewer',
                        type: "GET",
                        data: {
                            doc_path: data.doc_path,
                            doc_ext: doc_ext
                        },
                        success: function(data) {
                            //console.log(data)
                            $('#iframe-wrapper').append(data)
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })
                }
            });
        })

        $(document).on('click','.selectdocument',function(){
            //alert("tetsing");debugger;
            var docpath=$(this).attr('doc-href');
           // alert(docpath);
            var doc = docpath.split('/')
            var doc_ext = doc[1].split('.').pop()
            $('#iframe-wrapper').empty();
            $.ajax({
                        url: baseUrl + '/manager/doc_viewer',
                        type: "GET",
                        data: {
                            doc_path: docpath,
                            doc_ext: doc_ext
                        },
                        success: function(data) {
                            //alert(data);debugger;
                            $('#iframe-wrapper').append(data)
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })
            

        });

        $(document).on('click', '.document-page-select', function() {
            var title = $(this).attr('data-doc-title')
            var name = $(this).attr('data-doc-name')
            var id = $(this).attr('data-doc-id')
            var exist = $('.viewdoc-id-' + id).length
            var contents = $('.delete-item').html()
            var new_thumbnail = document.createElement('div')
            new_thumbnail.id = 'document-thumbnail'
            document.body.appendChild(new_thumbnail);
            if ($('#parentWindow-selected-content-html-' + id).length == 0) {
                var document_content = document.createElement('div')
                document_content.id = 'parentWindow-selected-content-html-' + id
                document.body.appendChild(document_content);
                $('#parentWindow-selected-content-html-' + id).attr('hidden', true)
                $('#parentWindow-selected-content-html-' + id).attr('data-document-id', id)
                $('#parentWindow-selected-content-html-' + id).addClass('get-selected-document')
            }
            $('#parentWindow-selected-content-html-' + id).empty()
            $('#parentWindow-selected-content-html-' + id).append(contents)
            if (exist == 0) {
                $.ajax({
                    url: baseUrl + '/manager/add_document/',
                    type: "GET",
                    data: {
                        title: title,
                        name: name,
                        id: id,
                        width: 'col-md-4'
                    },
                    success: function(data) {
                        $('.prev-show-doc').append('' + data + '')
                        $('.selected-docs-id').append('<input id="selected-doc-' + id + '" name="documents[]" value="' + id + '" hidden />')
                        $('.document-viewer-close').click()
                        thumbnail_append(id)
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            } else {
                $('.document-viewer-close').click()
                setTimeout(function() {
                    thumbnail_append(id)
                }, 1000);
            }
        })

        function thumbnail_append(id) {
            var thumbnail = $('#document-thumbnail')
            thumbnail.find('canvas').attr('style', 'width: 66px;height: 80px;background-color: white;border: 1px solid;')
            var selection_type = thumbnail.attr('data-selection-type')
            $('#document-selection-type-' + id).text(selection_type)
            $('#document-thumbnail-' + id).html(thumbnail)
            $('#document-thumbnail-' + id).find('#document-thumbnail').attr('id', 'document-thumbnail-done')
            var selection_string = ''
            if (selection_type == 'Selection') {
                $('#selection-content-' + id).attr('hidden', false)
                var contents = $('#parentWindow-selected-content-html-' + id)
                var page_count = contents.find('#selected-page-list input').length
                var text_count = contents.find('#selected-text-list textarea').length
                contents.find('#selected-page-list input').each(function() {
                    selection_string += 'p.' + $(this).val() + ', '
                })
                if (text_count > 0 && page_count > 0) {
                    selection_string += 'and Text'
                }
                if (text_count > 0 && page_count == 0) {
                    selection_string += 'Text'
                }
                $('#document-selection-content-string-' + id).text(selection_string)
            }
        }

        function showLoader() {
            $("#overlay").fadeIn(300);
        }

        function hideLoader() {
            $("#overlay").fadeOut(300);
        }

        function getWords(str) {
            return str.split(/\s+/).slice(0, 5).join(" ");
        }

        function getDateFormat(date) {
            var todayTime = new Date(date);
            var month = todayTime.getMonth() + 1;
            var day = todayTime.getDate();
            var year = todayTime.getFullYear();
            month = month >= 10 ? month : "0" + month.toString();
            day = day >= 10 ? day : "0" + day.toString();
            return month + "/" + day + "/" + year;
        }

        function timeNow() {
            var d = new Date(),
                h = (d.getHours() < 10 ? '0' : '') + d.getHours(),
                m = (d.getMinutes() < 10 ? '0' : '') + d.getMinutes();
            return h + ':' + m;
        }

        function mis_fields() {
            var mis = {}
            $('.mis-definition').each(function(i) {
                var item = {}
                if ($(this).attr('data-task_mis')) {
                    item['task_mis'] = $(this).attr('data-task_mis')
                }
                item['field_type'] = $(this).attr('data-parent-field-type');
                item['field_id'] = $(this).attr('data-parent-field-id')
                item['label_title'] = $(this).find('.mis-label-title').val();
                item['description'] = $(this).find('.mis-field-description').val();
                if ($(this).find('.mis-field-min-value').length > 0) {
                    item['min_value'] = $(this).find('.mis-field-min-value').val()
                    if ($(this).find('.mis-field-min-value').attr('data-mis_content')) {
                        item['mis_content'] = $(this).find('.mis-field-min-value').attr('data-mis_content')
                    }
                }
                if ($(this).find('.mis-dropdown-option-list').length > 0) {
                    item['options'] = {}
                    $(this).find('.mis-dropdown-option-list').each(function(j) {
                        var options = {}
                        if ($(this).attr('data-mis_content')) {
                            options['mis_content'] = $(this).attr('data-mis_content')
                        }
                        options['name'] = $(this).find('.dropdown-option-value').val()
                        options['required'] = $(this).find('.dropdown-option-required').is(':checked') ? 'on' : 'off'
                        item['options'][j] = options
                    })
                }
                mis[i] = item;
            });
            return mis
        }

        function selected_documents() {
            var docs = {}
            $('.get-selected-document').each(function(i) {
                var mode = null
                if ($('#mode').length) {
                    mode = $('#mode').val()
                }
                var item = {}
                var id = $(this).attr('data-document-id')
                item['mode'] = mode
                item['document_id'] = id;
                item['thumbnail'] = $('#canvas-base64-image-' + id).val()
                var selected = $(this).find('.selected-document-input')

                if (selected.length > 0) {
                    item['selection_type'] = 'Selection'
                } else {
                    item['selection_type'] = 'All'
                }
                item['selected'] = {}
                selected.each(function(j) {
                    var selected_content = {}
                    var type = $(this).attr('data-selected-type')
                    selected_content['type'] = type
                    selected_content[type] = $(this).find('.selected-' + type + '-on-popup').val()
                    if (type == 'text') {
                        selected_content['page'] = $(this).find('.selected-' + type + '-on-popup').attr('data-selected-page')
                        selected_content['quads'] = $(this).find('.selected-' + type + '-on-popup').attr('data-quads')
                    }
                    item['selected'][j] = selected_content
                })
                docs[i] = item;
            });
            console.log(docs)
            return docs
        }

        $(document).on('click', '#submitBtn', function() {
            docThumbnailToReviewModal();
            var form = $("#regForm");
            $('.is-invalid').removeClass('is-invalid')
            var data = {
                mis: mis_fields(),
                docs: selected_documents()
            }
            var isvalid = true;
            $('#regForm').find("input:visible, select:visible, textarea:visible").each(function() {
                var attr = $(this).attr('required');
                // For some browsers, `attr` is undefined; for others,
                // `attr` is false.  Check for both.
                if ((typeof attr !== 'undefined' && attr !== false) && (!$(this).val() || $(this).val().length == 0)) {
                    isvalid = false;
                    console.log($(this).attr('id'));
                    $('.' + $(this).attr('id') + '-validation-error').addClass('is-invalid');
                    var ret = $(this).attr('id').replace('task_', '').replace(/_/g, ' ');
                    $('#' + $(this).attr('id') + '-error-message').text('The ' + ret + ' is Requried');
                    $(this).parent().find('.invalid-feedback').show();
                    $(this).addClass('invalid');
                }
            });
            console.log(isvalid);
            if (isvalid) {
                $.ajax({
                    type: "POST",
                    url: baseUrl + '/manager/addTask-validation',
                    data: form.serialize() + '&' + $.param(data), // serializes the form's elements.
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(data) {
                        //console.log(data)
                        hideLoader()
                        if (data['hasErrors'] == 0) {
                            console.log('yes');
                            var taskName = $("#task_task_name").val();

                            var clientName = '';
                            $('#task_clients option').each(function() {
                                if ($(this).is(':selected')) {
                                    clientName += $(this).text() + '<br>';
                                }
                            });
                            var department = '';
                            $('#task_departments option').each(function() {
                                if ($(this).is(':selected')) {
                                    department += $(this).text() + '<br>';
                                }
                            });
                            var deadLineDate = $('#task_due_date').val();
                            var frequency = '';
                            $('#task_frequency option').each(function() {
                                if ($(this).is(':selected')) {
                                    frequency += $(this).text() + '<br>';
                                }
                            });
                            var date = new Date();
                            var fundgroupdetails = [];
                            var fundgroups = '';
                            $('#task_fund_groups option').each(function() {
                                if ($(this).is(':selected')) {
                                    fundgroups += $(this).text() + '<br>';
                                }
                            });
                            $('#modal_fundgroup').html(fundgroups);
                            var createdDate = getDateFormat(date) + '  ' + timeNow();
                            var deadLine = getDateFormat(deadLineDate) + '  ' + timeNow();
                            $("#modal_taskname").html(taskName);
                            $("#assigned_to").html(department);
                            $("#created_date").text(createdDate);
                            $("#modal_clientname").html(clientName);
                            $("#modal_deadline").text(deadLine);
                            $("#modal_frequency").html(frequency);
                            $(".taskDetailView ul li").empty()
                            $('.allusrs img').each(function() {
                                $(".taskDetailView ul").append('<li><img src="' + $(this).attr('src') + '" alt="assign-img" style="width:40px"></li>')
                            })
                            $('button[data-target="#taskDetail"]').click()
                        } else {
                            $.each(data.data, function(index, value) {
                                $('.' + index + '-validation-error').addClass('is-invalid')
                                $('#' + index + '-validation-error-message').text(value)
                                $('.swalDefaultError').click()
                            })
                        }
                    }
                });
            }
        });

        function docThumbnailToReviewModal() {
            $('.review-doc-section').empty()
            var cols = document.querySelectorAll('.viewdoc-section');
            [].forEach.call(cols, (e) => {
                var filename = e.querySelector('.document-filename').getAttribute('data-filename')
                var canvas = e.querySelector('canvas')
                var src = canvas.toDataURL()
                e.querySelector('.canvas-base64-image').value = src
                var newImage = document.createElement('img');
                newImage.src = src;
                newImage.width = '66';
                newImage.height = "80";
                newImage.style.border = '1px solid #ccc';
                $('.review-doc-section').append('<div style="display: grid;width: 66px;" class="ml-4">' + newImage.outerHTML + '<span style="font-size: 9px;padding:5px">' + filename + '</span></div>');
            })
        }

        $(document).on('click', '.create-issue', function() {
            window.location.href = $(this).attr('data-href');
        });
        $(document).on('click', '#issue-submitBtn', function(e) {
            var isvalid = true;
            $('#regForm').find("input:visible, select:visible, textarea:visible").each(function() {
                var attr = $(this).attr('required');
                // For some browsers, `attr` is undefined; for others,
                // `attr` is false.  Check for both.
                if ((typeof attr !== 'undefined' && attr !== false) && (!$(this).val() || $(this).val().length == 0)) {
                    isvalid = false;
                    console.log('****');
                    console.log($(this).attr('id'));
                    $('.' + $(this).attr('id') + '-validation-error').addClass('is-invalid');
                    var ret = $(this).attr('id').replace('task_', '').replace(/_/g, ' ');
                    $('#' + $(this).attr('id') + '-error-message').text('The ' + ret + ' is Requried');
                    $(this).parent().find('.invalid-feedback').show();
                    $(this).addClass('invalid');
                }
            });
            if (!isvalid) {
                e.preventDefault();
            }

        });
        $(document).on('click', '#nextBtn-stepone', function() {
            // $('#nextBtn').click();
            var isvalid = true;
            $('#regForm').find("input:visible, select:visible, textarea:visible").each(function() {
                var attr = $(this).attr('required');
                // For some browsers, `attr` is undefined; for others,
                // `attr` is false.  Check for both.
                if ((typeof attr !== 'undefined' && attr !== false) && (!$(this).val() || $(this).val().length == 0)) {
                    isvalid = false;
                    console.log($(this).attr('id'));
                    $('.' + $(this).attr('id') + '-validation-error').addClass('is-invalid');
                    var ret = $(this).attr('id').replace('task_', '').replace(/_/g, ' ');
                    $('#' + $(this).attr('id') + '-error-message').text('The ' + ret + ' is Requried');
                    $(this).parent().find('.invalid-feedback').show();
                    $(this).addClass('invalid');
                }
            });
            if (isvalid) {
                $('#nextBtn').click();
            }
            /*  var form = $("#regForm");
             $('.is-invalid').removeClass('is-invalid')
             $.ajax({
                 type: "POST",
                 url: baseUrl + '/manager/addTask-stepone-validation',
                 data: form.serialize(), // serializes the form's elements.
                 success: function(data) {
                     if (data['hasErrors'] == 0) {
                         $('#nextBtn').click()
                     } else {
                         $.each(data.data, function(index, value) {
                             $('.' + index + '-validation-error').addClass('is-invalid')
                             $('#' + index + '-validation-error-message').text(value)
                             $('.swalDefaultError').click()
                         })
                     }
                 }
             }); */

        });

        $(document).on('click', '#company_admin', function() {
            var datavalue = $(this).attr('data-value');
            var form = $("#adminform");
            $('.is-invalid').removeClass('is-invalid')
            $.ajax({
                type: "POST",
                url: baseUrl + '/addcompany_validation',
                data: form.serialize() + "&variable=" + datavalue, // serializes the form's elements.
                beforeSend: function() {
                    showLoader();
                },
                success: function(data) {
                    console.log(data); // show response from the php script.
                    hideLoader();
                    if (data['hasErrors'] == 0) {
                        //alert(datavalue);
                        if (datavalue == "companydetails") {
                            $('#companydetailsbtn').click();
                        } else if (datavalue == "companyadmins") {
                            $('#companyadminbtn').click();
                        } else if (datavalue == "companydepartments") {
                            $('#companydepartmentbtn').click();
                        }
                    } else {
                        $.each(data.data, function(index, value) {
                            $('.' + index + '-validation-error').addClass('is-invalid')
                            $('#' + index + '-validation-error-message').text(value)
                            $('.swalDefaultError').click()
                        })
                    }
                }
            });

        });

        /*Fund Validations*/
        $(document).on('click', '.FormsubmitBtn', function() {
            // alert("formsubmitbtn");debugger;
            var datavalue = $(this).attr('data-value');
            if (datavalue == "funddetails") {
                var form = $("#fundform");
            } else if (datavalue == "subfunddetails") {
                var form = $("#subfundform");
            } else if (datavalue == "clientdetails") {
                var form = $("#clientform");
            } else if (datavalue == "documentdetails") {
                var form = $("#document-upload-apache");
            }
            else if(datavalue =="userdetails"){
                var form = $("#add-new-user-form");  
            }
            else if(datavalue=="deptdetails"){
                var form = $("#add_new_department");  
            }
            else if(datavalue=="reportdetails")
            {
                var form = $("#create_reports");
            }
            $('.is-invalid').removeClass('is-invalid')
            $.ajax({
                type: "POST",
                url: baseUrl + '/manager/form_validation',
                data: form.serialize() + "&variable=" + datavalue, // serializes the form's elements.
                beforeSend: function() {
                    showLoader();
                },
                success: function(data) {
                    //alert(data);debugger;
                    console.log(data); // show response from the php script.
                    hideLoader();
                    if (data['hasErrors'] == 0) {
                        if (datavalue == "funddetails") {
                            $("#fundsubmitBtn").click();
                        } else if (datavalue == "subfunddetails") {
                            $("#subfundsubmitBtn").click();
                        } else if (datavalue == "clientdetails") {
                            $("#clientsubmitBtn").click();
                        } else if (datavalue == "documentdetails") {
                            $("#document-save").click();
                        }else if(datavalue=="userdetails"){
                            $("#add-new-user-confirm").click(); 
                        }
                        else if(datavalue=="deptdetails"){
                            $("#deptsubmitbtn").click(); 
                        }
                        else if(datavalue=="reportdetails"){
                            $("#reportsubmitbtn").click(); 
                        }
                    } else {

                        $.each(data.data, function(index, value) {
                            $('.' + index + '-validation-error').addClass('is-invalid')
                            $('#' + index + '-validation-error-message').text(value)
                            $('.swalDefaultError').click()
                        })

                    }
                }
            });

        });

        $('document').ready(function() {
            $("#regForm").submit(function(e) {
                e.preventDefault(); // avoid to execute the actual submit of the form.
                $('.is-invalid').removeClass('is-invalid')
                var form = $("#regForm");
                var url = form.attr('action');
                var data = {
                    mis: mis_fields(),
                    docs: selected_documents()
                }
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize() + '&' + $.param(data), // serializes the form's elements.
                    success: function(data) {
                        if (!data['hasErrors']) {
                            $('#taskDetail button[type="button"]').click()
                            $('#modal-trigger-confirmation-text').click()
                        } else {
                            $.each(data.data, function(index, value) {
                                $('#taskDetail button[type="button"]').click()
                                $('.' + index + '-validation-error').addClass('is-invalid')
                                $('#' + index + '-validation-error-message').text(value)
                            })
                        }
                    }
                });
            });
        });

        // Awaiting Approval Page Start 
        $('#completebtn').click(function() {
            $('#detailsComplete').hide();
        });
        $('#awaiting-approval-confmbtn').click(function() {
            $('#awaitingApprovalPopup').hide();
        });

        $('input:radio[name=flexRadioDefault]').change(function() {
            // $("#awaitingmodal_taskname").empty();
            // $("#awaitingmodal_taskid").empty();
            // $("#awaitingmodal_clientname").empty();
            // $("#awaitingmodal_mis ul").empty();
            // $("#awaitingmodal_status").empty();
            // $("#awaitingmodal_status").empty();
            // $("#awaitingmodal_assigned_to").empty();
            // $("#awaitingmodal_deadline").empty();
            // $('#awaitingmodal_documents').empty();
            // $('.popupassignedto').empty();
            $('.awaiting-model-append').empty()

            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: baseUrl + '/manager/task/fetchthetaskdetails/' + id,
                success: function(data) {
                    $('.awaiting-model-append').append(data);
                    // var message = JSON.parse(data);
                    // $("#awaitingmodal_taskname").text(message["task_name"]);
                    // $("#awaitingmodal_taskid").text(message["id"]);
                    // $("#taskid").val(message["id"]);
                    // $("#awaitingmodal_clientname").text(message["clients"][0]["client_name"]);
                    // $("#awaitingmodal_assigned_to").text(message["departments"][0]["name"]);
                    // $("#awaitingmodal_deadline").text(getDateFormat(message["due_date"]));
                    // var imgpath = "<img src='" + baseUrl + '/img/tick.svg' + "'>";

                    // var date1 = message["due_date"];
                    // var date2 = message["completed_date_by_assignee"];
                    // var due_date = date1.split(' ')[0];
                    // var completed_date = date2.split(' ')[0];

                    // var countdays = new Date(Date.parse(due_date) - Date.parse(completed_date)) / (1000 * 3600 * 24);

                    // var deadline_priority = message["deadline"];

                    // if (countdays > deadline_priority) {
                    //     var status_button = '<input id="statisfactory" value="Satisfactory" class="statisfactory"/>';
                    //     $("#awaitingmodal_status").html(status_button);
                    // } else if (countdays <= deadline_priority) {
                    //     var status_button = '<input  id="critical" value="Critical" class="statisfactory critical"/>';
                    //     $("#awaitingmodal_status").html(status_button);

                    // }

                    // for (var i = 0; i < message["attachdocumentation"].length; ++i) {
                    //     //var filename = message["attachdocumentation"][i]["file_path"].replace("uploads/", "");
                    //     $('#awaitingmodal_documents').append("<li><img src='" + baseUrl + '/img/doc-list.svg' + "'>" + "\n" + message["attachdocumentation"][i] + "<li>");
                    // }

                    // for (var j = 0; j < message["assignees"].length; ++j) {
                    //     $('.popupassignedto').append("<li><img src='" + baseUrl + "/" + message["assignees"][j]["avatar"] + "'></li>");
                    // }
                    // var kk = 1;
                    // for (var k = 0; k < message["mis_fields"].length; k++) {
                    //     $("#awaitingmodal_mis ul").append("<li>" + message["mis_fields"][k]["label_title"] + "</li>");
                    //     kk++;
                    // }
                }
            });

        });
        // Awaiting Approval Page End

        // Task Details Page Start
        $("input[name='file[]']").change(function() {
            var filename=$(this).get(0).files[0].name;
            var type = filename.split('.').pop();
            var allowed_extensions = new Array("pdf","doc","dot","docx","xls","xlsx","ppt","pot","pps","ppa","pptx","ppsx","gif","jpg","jpeg","png");
            var file_extension = filename.split('.').pop();

            var valid=false;
            for(var i = 0; i <= allowed_extensions.length; i++)
            {
                if(allowed_extensions[i]==file_extension)
                {
                    valid=true;
                    $(".uploaddocformats").hide();
                    $("#taskuploaddoc_status").hide();
                    var names = [];
                    for (var i = 0; i < $(this).get(0).files.length; ++i) {
                        $('.fileupload ul').append("<li class='attached-file-list-page'><img src='" + baseUrl + '/img/document.svg' + "'><span class='docfile-attach'>" + $(this).get(0).files[i].name + "</span><span class='close select2-close'><em class='fas fa-times fileupload'></em></span></li>");
                    }
                    return true;
                }
            }
            if(valid==false){
                $(".uploaddocformats").hide();
                $("#taskuploaddoc_status").css("display","block");
                $("#taskuploaddoc_status").html("Please upload valid documents!");
                return false;
            }

           
        });
        $('input[name="completion"]').on('click', function() {
            $('.completion-check-validation').attr('style', 'display:none');
            $('input[name="completion"]').removeClass('is-invalid')
        })
        $('.mis-enter-value').on('focus', function() {
            $(this).removeClass('is-invalid')
        })
        $(document).on('click', '#check-mis-validation', function() {
            var mis_fileds = []
            $('.mis-enter-value').each(function(i) {
                var id = $(this).attr('data-mis-id')
                var value = $(this).val()
                mis_fileds[i] = {
                    mis_id: id,
                    value: value
                }
                if ($(this).attr('data-mis-type') == 'dropdown') {
                    value = $(this).find('option:selected').text()
                }
                $('#mis-value-' + id).text(value)
                if (!$(this).val()) {
                    $(this).addClass('is-invalid')
                }
            })
            if ($('input[name="completion"]:checked').length == 0) {
                $('input[name="completion"]').addClass('is-invalid')
                $('.completion-check-validation').attr('style', 'display:block');
            }
            if ($('.addition-documentation-value').attr('data-condition') == 1 && $('.attached-file-list-page').length == 0) {
                $('.attach_drop').addClass('is-invalid')
                $('.attach-doc-validation').attr('style', 'display:block !important')
            }
            if ($('.is-invalid').length == 0) {
                var er = false
                var eM = ''
                if (mis_fileds.length > 0) {
                    $.ajax({
                        method: "get",
                        url: baseUrl + "/mis_validation",
                        data: {
                            mis_fileds: mis_fileds,
                        },
                        success: function(data) {
                            if (!data.misSatisfy) {
                                if ($('[name="completion"]:checked').val() == 0) {
                                    er = true
                                }
                                eM = 'MIS values does not meet the required values! Task satisfactory changed to Challenge.'
                                $('[name="completion"]').each(function() {
                                    if ($(this).val() == 0) {
                                        $(this).attr('checked', false)
                                    } else {
                                        $(this).attr('checked', 'checked')
                                    }
                                })
                            }
                        }
                    })
                }
                $.ajax({
                    method: "get",
                    url: baseUrl + '/task_dependency_check',
                    data: {
                        task_id: $('input[name="taskid"]').val()
                    },
                    success: function(data) {
                        if (data.hasDependency) {
                            er = true
                            eM = eM + "\nPlease complete the dependency tasks!"
                        }
                        if (er) {
                            $('button[data-target="#errorpopup"]').click()
                            $('#error_message').text(eM)
                        } else {
                            $('#completeTask').click()
                        }
                    }
                })

            } else {
                //document.querySelector('.is-invalid').scrollIntoView({ behavior: 'smooth', block: 'start'})
                $('html, body').animate({
                    scrollTop: $(".is-invalid").offset().top - 50
                }, 500);
            }
        })

        $(document).on('click', "#completeTask", function() {
            $('#fileattached ul').empty()
            var val = $(".completion:checked").val();
            $("#outcome").empty();
            if (val == 0) {
                var status = "Satisfactory";
                $("#outcome").append(status);
            } else if (val == 1) {
                var status = "With Challenge";
                $("#outcome").append(status);
            }
            $('.attached-file-list-page').each(function() {
                var clone = $(this).clone()
                clone.find('.select2-close').remove()
                clone.find('.docfile-attach').addClass('ml-2')
                $('#fileattached ul').append(clone)
            })
        });
        $('#attachDrop,.document-upload').on('click', function() {
            $('.attach_drop').removeClass('is-invalid')
            $('.attach-doc-validation').removeAttr('style')
            $('#attach_file').click()
        })

        $('document').ready(function() {
            $("#taskForm").submit(function(e) {
                e.preventDefault(); // avoid to execute the actual submit of the form.
                var form = $("#taskForm");
                var url = form.attr('action');
                var data = JSON.stringify(mis_field_results())
                var formData = new FormData($(this)[0]);
                formData.append('mis', data)
                $('#task-complete-cancel').click()
                $.ajax({
                    type: "POST",
                    url: url,
                    //data: form.serialize() + '&' + $.param(data), // serializes the form's elements.
                    data: formData, // serializes the form's elements.
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log(data)
                        if (!data['hasErrors']) {
                            $('button[data-target="#comfirmepopup"]').click()
                            window.location.href = "{{route('task',['type'=>base64_encode(strtolower('task'))])}}"
                        }
                    }
                });
            });

            $(".issuesave_btn").click(function() {
                var taskid = $("#taskid").val();
                var issues_types = '';
                $('.displaylist_issues_types li').each(function(i) {
                    issues_types = $(this).attr('data-value'); // This is your rel value
                });
                var issue_type_id = issues_types;
                var issue_description = $("#issue_description").val();
                var datastring = 'taskid=' + taskid + '&issue_type_id=' + issue_type_id + '&issue_description=' + issue_description;

                $.ajax({
                    type: "POST",
                    url: baseUrl + '/manager/task/store_issues_details',
                    data: datastring,
                    cache: false,
                    success: function(data) {
                        // alert(data);
                    }
                });


            });

        });

        function mis_field_results() {
            var mis_result = {};
            $('.mis-enter-value').each(function(i) {
                var data = {}
                var id = $(this).attr('data-mis-id')
                var value = $(this).val()
                var type = $(this).attr('data-mis-type')
                data['type'] = type
                data['mis_id'] = id
                data['value'] = value
                mis_result[i] = data
            })
            console.log(mis_result)
            return mis_result;
        }

        $(document).on('click', '.task-detail-popup', function() {
            var type = $(this).attr('data-type');
            var url = baseUrl + '/manager/task/task-detail/' + type + '-popup'
            $.ajax({
                method: "get",
                url: url,
                data: {
                    task_id: $('input[name="taskid"]').val(),
                    page: 1,
                    count: 10,
                },
                beforeSend: function() {
                    showLoader();
                },
                success: function(data) {
                    console.log(data)
                    if (type == 'client') {
                        $('.task_detail-clientPopup-append').empty()
                        $('.task_detail-fundGroup-append').empty()
                        $('.task_detail-subFund-append').empty()

                        var clients = data.clients
                        var funds = data.funds
                        var subfunds = data.subfunds
                        for (var i = 0; i < clients.length; i++) {
                            $('.task_detail-clientPopup-append').append('<div class="clientPopup d-inline-flex"><img class="inline-image-content" src="{{ env("AWS_URL")}}/' + clients[i].client_logo + '" alt="client-logo" /><p>' + clients[i].client_name + ' </p></div>')
                        }
                        for (var i = 0; i < funds.length; i++) {
                            $('.task_detail-fundGroup-append').append('<div class="fundGroup d-inline-flex"><p>' + funds[i].fund_group_name + '</p></div>')
                        }
                        for (var i = 0; i < subfunds.length; i++) {
                            $('.task_detail-subFund-append').append('<div class="subFund d-inline-flex"><p>' + subfunds[i].sub_fund_name + '</p></div>')
                            if (i == subfunds.length - 1) {
                                remove_span_close();
                            }
                        }
                    }

                    if (type == 'assigned') {
                        $('.task_detail-departments-append').empty()
                        $('.task_detail-assignees-append').empty()
                        $('.task_detail-reviewers-append').empty()

                        var departments = data.departments
                        var assignees = data.assignees
                        var reviewers = data.reviewers
                        for (var i = 0; i < departments.length; i++) {
                            $('.task_detail-departments-append').append('<li class="asweio-instyle">' + departments[i].name + '</li>')
                        }
                        for (var i = 0; i < assignees.length; i++) {
                            $('.task_detail-assignees-append').append('<li class="asweio-instyle"><img class="inline-image-content" src="{{ env("AWS_URL")}}/' + assignees[i].avatar + '" alt="assignedUser" /> ' + assignees[i].name + '</li>')
                        }
                        for (var i = 0; i < reviewers.length; i++) {
                            $('.task_detail-reviewers-append').append('<li class="asweio-instyle"><img class="inline-image-content" src="{{ env("AWS_URL")}}/' + reviewers[i].avatar + '" alt="review_users" /> ' + reviewers[i].name + '</li>')
                            if (i == reviewers.length - 1) {
                                remove_span_close();
                            }
                        }
                    }
                    hideLoader();
                }
            })
        })

        function remove_span_close() {
            var cmp = $('#completion-status-value').val();
            if (cmp != 0) {
                $('span.close').remove()
            }
        }

        $('.teams-child-content-scroll').on('scroll', chk_scroll)

        function chk_scroll(e) {
            var elem = $(e.currentTarget);
            if (elem[0].scrollHeight - elem.scrollTop().toFixed() == elem.outerHeight()) {
                console.log("bottom");
            }
        }
        // Task Details Page End

        // Teams Scripts Start
        $(document).on('click', '.pagination .page-item', function(e) {
            var chc = $('.top-navitem').text()
            if($('.search-module-append').length == 0 || chc == "Risk Dashboard"){
                return;
            }
            var url = $(this).find('a').attr('href')
            var win_url = window.location.href
            if (url.includes('?')) {
                e.preventDefault()
                $('.search-module-append').empty();
                $('.pagination-module-append').empty();
                $.ajax({
                    type: "GET",
                    url: url,
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(data) {
                        $('.search-module-append').append(data['data']);
                        $('.pagination-module-append').append(data['pagination']);
                        hideLoader()
                        // $('.data-append').empty()
                        // $('.pagination-content').empty()
                        // $('.pagination-content').append(response.pagination)
                        // $(document).ready(function() {
                        //     $('.pagination').each(function() {
                        //         var first = $(this).find('li').first().find('.page-link')
                        //         var last = $(this).find('li').last().find('.page-link')
                        //         first.empty();
                        //         last.empty()
                        //         first.attr('style', 'width:100%');
                        //         last.attr('style', 'width:100%');
                        //         first.append('<em class="fas fa-angle-left"></em> Previous');
                        //         last.append('Next <em class="fas fa-angle-right"></em>')
                        //     })
                        // });
                        // var data = response.data.data
                        // $('.data-append').append('<div id="collapseExample2" class="collapse show"><div class="card-body"><ul class="depart-itemtable"></ul></div></div>')
                        // $(document).ready(function() {
                        //     for (var i = 0; i < data.length; i++) {
                        //         $('.depart-itemtable').append('<li><div class="d-flex align-items-center"><div class="col-md-1"><img src="{{ env("AWS_URL")}}/' + data[i].department_manager.avatar + ' " alt=""></div><div class="col-md-3 cursor-pointer ' + response.click_on_list + '" data-id="' + data[i].id + '"><p class="dep_title">{{__("home_manager.Department.Title")}}</p><span>' + data[i].name + '</span></div><div class="col-md-2"><p>{{__("home_manager.Department.Dep Manager")}}</p><span>' + data[i].department_manager.name + '</span></div><div class="col-md-3"><div class="d-flex"><div class="cricle"><span class="success">' + data[i].info.active + '</span><span>{{__("home_manager.Department.On Track")}}</span></div><div class="cricle"><span class="warning">' + data[i]['info']['urgent'] + '</span><span>{{__("home_manager.Department.Urgent")}}</span></div><div class="cricle"><span class="danger">' + data[i]['info']['overdue'] + '</span><span>{{__("home_manager.Department.Overdue")}}</span></div></div></div><div class="col-md-3 status-bar"><p>{{__("home_manager.Task.Total Tasks")}}: ' + data[i]['info']['total'] + '</p><div class="progress"><div class="progress-bar progress-bar-green text-primary" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: ' + data[i].per + '%">' + data[i]['per'] + '%</div></div></div></div></li>')
                        //     }
                        // })
                    }
                })

                // else {
                //     page_url = url.replace("user_search", "all_users");
                //     $(this).find('a').attr('href', page_url)
                // }
            }

        })
        // $('#search-on-teams').on('keyup', function() {
        //     var url = $(this).attr('data-url');
        //     var keyword = $(this).val();
        //     if ($('.sortby-key.active').length) {
        //         var sortBy_element = $('.sortby-key.active');
        //         var sortBy = sortBy_element.attr('data-sortBy')
        //         var sortOrder = sortBy_element.attr('data-sort-order')
        //         keyword += '&sortBy=' + sortBy + '&sortOrder=' + sortOrder
        //     }
        //     if ($(this).attr('data-add-parameter')) {
        //         keyword += '&' + $(this).attr('data-parameter-name') + '=' + $(this).attr('data-add-parameter')
        //     }
        //     var search_table = $(this).attr('data-search-column')
        //     console.log(search_table)
        //     delay(function() {
        //         $.ajax({
        //             type: "GET",
        //             url: url + '?search=' + keyword,
        //             success: function(response) {
        //                 $('.data-append').empty()
        //                 $('.pagination-content').empty()
        //                 $('.awaiting-approval').empty()
        //                 var data = response.data.data
        //                 $('.data-append').append('<div id="collapseExample2" class="collapse show"><div class="card-body"><ul class="depart-itemtable"></ul></div></div>')

        //                 $(document).ready(function() {
        //                     if (search_table == 'teams_search') {
        //                         for (var i = 0; i < data.length; i++) {
        //                             $('.depart-itemtable').append('<li><div class="d-flex align-items-center"><div class="col-md-1"><img src="{{ env("AWS_URL")}}/' + data[i].department_manager.avatar + ' " alt=""></div><div class="col-md-3 cursor-pointer ' + response.click_on_list + '" data-id="' + data[i].id + '"><p class="dep_title">{{__("home_manager.Department.Title")}}</p><span>' + data[i].name + '</span></div><div class="col-md-2"><p>{{__("home_manager.Department.Dep Manager")}}</p><span>' + data[i].department_manager.name + '</span></div><div class="col-md-3"><div class="d-flex"><div class="cricle"><span class="success">' + data[i].info.active + '</span><span>{{__("home_manager.Department.On Track")}}</span></div><div class="cricle"><span class="warning">' + data[i]['info']['urgent'] + '</span><span>{{__("home_manager.Department.Urgent")}}</span></div><div class="cricle"><span class="danger">' + data[i]['info']['overdue'] + '</span><span>{{__("home_manager.Department.Overdue")}}</span></div></div></div><div class="col-md-3 status-bar"><p>{{__("home_manager.Task.Total Tasks")}}: ' + data[i]['info']['total'] + '</p><div class="progress"><div class="progress-bar progress-bar-green text-primary" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: ' + data[i].per + '%">' + data[i]['per'] + '%</div></div></div></div></li>')
        //                         }
        //                     }
        //                     if (search_table == 'fund_search') {
        //                         $('.fundgroup').empty();
        //                         for (var i = 0; i < data.length; i++) {
        //                             if (data[i].fund_group_name.length > 0) {
        //                                 var fundgroupname = data[i].fund_group_name;
        //                             } else {
        //                                 var fundgroupname = "";
        //                             }
        //                             if (data[i].entity_type != null) {
        //                                 var entity_type = data[i].entity_type;

        //                             } else {
        //                                 var entity_type = "";
        //                             }
        //                             $('.fundgroup').append('<li><div class="d-flex align-items-center"><div class="frm-clients funds"> <p>Fund Entity</p><span>' + fundgroupname + '</span></div><div class="frm-clients-subfunds funds"><p>Entity Type</p> <span>' + entity_type + '</span></div><div class="frm-clients-subfunds funds"><p>Sub-Funds</p><span>' + data[i].getsubfundslist.length + '</span></div><div class="action_item"><div class="view_item"> <p><a href="' + baseUrl + '/manager/funds/viewfunddetails/' + data[i].id + '"><img src="{{ asset("/img/view-icon.svg") }}" alt="view"/></a></p><span>View</span></div> <div class="delete_item"><p><a href="#" data-toggle="modal" data-target=".deleteclientModal"><img src="{{ asset("/img/delete__icon.svg") }}" alt="delete"/></a></p><span>Delete</span></div></li><div class="modal fade deleteclientModal" id="deleteclientModal" tabindex="-1" role="dialog" aria-labelledby="deleteclientModal" aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"> <form method="GET" action="' + baseUrl + '/manager/funds/deletethesinglefundrecord/' + data[i].id + '" class="modal-approveall"> {{ csrf_field() }} <div class="modal-content"> <div class="modal-body"><h3>{{__("clients.view_details.Do you want to delete the record")}}?</h3><div class="bottom__btn"><button type="button" class="btn btn-secondary" data-dismiss="modal">{{__("awaiting_approval.Popupmodal.CANCEL")}}</button><button type="submit" id="delete-clients-confmbtn" class="btn btn-primary pdfmodal-save">{{__("awaiting_approval.Popupmodal.CONFIRM")}}</button></div> </div> </div> </form></div> </div>');

        //                         }
        //                     }
        //                     if (search_table == 'client_search') {
        //                         for (var i = 0; i < data.length; i++) {
        //                             var ass = '<p class="assignto_deptvalue">All Departments</p><div><span class="home-and-more">Total ' + response.total_departments + '</span></div>'
        //                             var t = Number(data[i]['company_departments'].length) - Number(1)

        //                             $('.awaiting-approval').append('<li><div class="d-flex align-items-center"><div class="frm-clients-logo"><p class="semi-bold"><img class="client-img" src="{{ env("AWS_URL")}}/' + data[i].company_logo + '" ></p></div><div class="frm-clients"><p>{{__("clients.view_details.Client Name")}}</p> <span>' + data[i].client_name + '</span></div><div class="frm-clients-subfunds"><p>{{__("clients.view_details.Fund Groups")}}</p><span>' + data[i].company_fundgroups_count.length + '</span></div> <div class="frm-clients-subfunds"><p>{{__("clients.view_details.Sub-Funds")}}</p>  <span>' + data[i].company_sub_funds_count.length + '</span></div> <div class="action_item">  <div class="view_item"> <p><a href="' + baseUrl + '/manager/clients/viewclientdetails/' + data[i].id + '"><img src="{{ asset("/img/view-icon.svg") }}" alt="view"/></a></p>  <span>{{__("clients.view_details.View")}}</span>  </div> <div class="delete_item">  <p><a href="#" data-toggle="modal" data-target=".deleteclientModal"><img src="{{ asset("/img/delete__icon.svg") }}" alt="delete" /></a></p><span>{{__("clients.view_details.Delete")}}</span></div></div></div></li> <div class="modal fade deleteclientModal" id="deleteclientModal" tabindex="-1" role="dialog" aria-labelledby="deleteclientModal" aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"> <form method="GET" action="' + baseUrl + '/manager/clients/deletethesingleclientrecord/' + data[i].id + '" class="modal-approveall"> {{ csrf_field() }} <div class="modal-content"> <div class="modal-body"><h3>{{__("clients.view_details.Do you want to delete the record")}}?</h3><div class="bottom__btn"><button type="button" class="btn btn-secondary" data-dismiss="modal">{{__("awaiting_approval.Popupmodal.CANCEL")}}</button><button type="submit" id="delete-clients-confmbtn" class="btn btn-primary pdfmodal-save">{{__("awaiting_approval.Popupmodal.CONFIRM")}}</button></div> </div> </div> </form></div> </div>')
        //                         }
        //                     }
        //                 })

        //                 $('.data-append').append(response.data)
        //                 $('.pagination-content').append(response.pagination)
        //                 $('.extra-pagination').empty()
        //                 $('.extra-pagination').append(response.pagination)
        //                 $(document).ready(function() {
        //                     $('.pagination').each(function() {
        //                         var first = $(this).find('li').first().find('.page-link')
        //                         var last = $(this).find('li').last().find('.page-link')
        //                         first.empty();
        //                         last.empty()
        //                         first.attr('style', 'width:100%');
        //                         last.attr('style', 'width:100%');
        //                         first.append('<em class="fas fa-angle-left"></em> Previous');
        //                         last.append('Next <em class="fas fa-angle-right"></em>')
        //                     })
        //                 });
        //             }
        //         })
        //     }, 500)
        // })

        

        $(document).on('click', '.department-detail-page', function() {
            var id = $(this).attr('data-id');
            window.location.href = baseUrl + '/manager/teams/department_details/' + id
        })


        $(document).on('click', '.admin_addnewuser', function() {


            var name = $('input[name="user_name"]').val();
            var email = $('input[name="user_email"]').val();

            if (email || $("input[name='username[]']").length > 0) {
                if (email) {
                    $(".users_list").append("<input class='departments_list-" + name + "  username-validation-error' name='company_admin_username[]' type='hidden' value='" + name + "'>");
                    $(".users_list").append("<input class='departments_list-" + email + "' name='company_admin_email[]' type='hidden' value='" + email + "'>");
                    if (email == 0) {
                        $('.displayuserprofile ul').empty()
                    }
                    $(".displayuserprofile").append("<div class='prev_fields form-group select2-close'> <div class='d-flex align-items-center'> <p>" + name + "</p> <button type='button' class='prev-close btn'><input type='hidden' name='account_admin_user' value='"+ name + "' /><em class='fas fa-times'></em></button></div></div>");
                }

            }
            $("#user_name").val("");
            $("#user_email").val("");

        })

        $(document).on('click', '.addnewdepartments', function() {

            var departments = $('input[name="admin_deparments"]').val();
            if (departments || $("input[name='departments1[]']").length > 0) {
                if (departments) {
                    $(".departments_list").append("<input class='departments_list-" + departments + "' name='departments[]' type='hidden' value='" + departments + "'>");
                    if (departments == 0) {
                        $('.newaddeddepartments').empty()
                    }
                    $(".newaddeddepartments").append("<div class='col-lg-4 col-md-4 col-sm-6'><div class='form-group prev_department select2-close'><div class='d-flex align-items-center'> <p>" + departments + "</p> <button type='button' class='prev-close btn'><input type='hidden' name='company_departments' value='"+ departments + "' /><em class='fas fa-times'></em></button></div></div></div>");
                }
            }
            $("#admin_deparments").va("");
        });
        $(document).on('click', '.get-data-for-adding', function() {
            var datatype = $(this).attr('data-type');
            $(".image-hover-eit").hide();
            $('#modal-departments-users').empty();
            $('#modal-clients-users').empty();
            // $("#addDepartmentModal").css("display", "block");
            // $("#add_new_user").css("display", "block");
            // if (datatype == "user") {
            //     $("#addDepartmentModal").css("display", "none");
            //     $("#add_new_user").css("display", "none");
            // }
            var for_data = $('.underline-active').attr('data-type')
            if (for_data == undefined || for_data.length == 0) {
                for_data = $(this).attr('data-type');
            }
            var url = baseUrl + '/manager/teams/' + for_data + '/add'
            if (for_data != 'department') {
                $('#modal-all-departments').empty()
                $('#modal-all-clients').empty()
                $('.modal-addnewuser-departments-input').empty()
                $('.modal-departments-display').empty()
                $('.modal-clients-display').empty()
                $('.modal-addnewuser-clients-input').empty()
            } else {
                $('#modal-all-users').empty()
                $('#modal-admin-users').empty()
                $('.modal-all-input').empty()
                $('.modal-admin-input').empty()
                $('.modal-all-display').empty()
                $('.modal-admin-display').empty()
            }
            var user_all = 0;
            var user_admin = 0
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    if (for_data != 'department') {
                        $('#modal-departments-users').append("<option value='' selected='selected' disabled>Department Restrictions</option>");
                        $('#modal-clients-users').append("<option value='' selected='selected' disabled>Client Restrictions</option>");
                        for (var i = 0; i < data.departments.length; i++) {
                            if (user_all == 0) {
                                $('#modal-departments-users').append("<option value='0' data-image='" + baseUrl + "/img/select-all.png'>All Departments</option>");
                                user_all = 1
                            }
                            $('#modal-departments-users').append("<option data-image='" + awsurl + '/' + data.departments[i].dep_icon + "' value='" + data.departments[i].id + "'>" + data.departments[i].name + "</option>");
                        }
                        for (var i = 0; i < data.clients.length; i++) {
                            if (user_admin == 0) {
                                $('#modal-clients-users').append("<option value='0' data-image='" + baseUrl + "/img/select-all.png'>All Clients</option>");
                                user_admin = 1
                            }
                            if (data.clients[i].client_logo) {
                                $('#modal-clients-users').append("<option data-image='" + awsurl + '/' + data.clients[i].client_logo + "' value='" + data.clients[i].id + "'>" + data.clients[i].client_name + "</option>");
                            } else {
                                $('#modal-clients-users').append("<option data-image='" + baseUrl + "/img/user-avatar.png' value='" + data.clients[i].id + "'>" + data.clients[i].client_name + "</option>");
                            }
                        }
                    } else {
                        $('#modal-all-users').append("<option value='' selected='selected' disabled>Select Team Members</option>");
                        $('#modal-admin-users').append("<option value='' selected='selected' disabled>Select Department Admin</option>");
                        for (var i = 0; i < data.length; i++) {
                            // if (user_all == 0) {
                            //     $('#modal-all-users').append("<option value='0' data-image='" + baseUrl + "/img/select-all.png'>All Users</option>");
                            //     user_all = 1
                            // }
                            var nodisplay = 'nodisplay';
                            if ($('[data-option-id = ' + data[i].company_user_id + ']').length == 0) {
                                nodisplay = ''
                            }

                            $('#modal-all-users').append("<option class='" + nodisplay + "' data-image='" + awsurl + '/' + data[i].avatar + "' value='" + data[i].company_user_id + "'>" + data[i].name + "</option>");

                            $('#modal-admin-users').append("<option class='" + nodisplay + "' data-image='" + awsurl + '/' + data[i].avatar + "' value='" + data[i].company_user_id + "'>" + data[i].name + "</option>");


                        }
                    }
                }
            });
        })


        $("#add-new-user-form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('.is-invalid').removeClass('is-invalid')
            var form = $("#add-new-user-form");
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(data) {
                    $('button[data-dismiss="modal"]').click()
                    $('button[data-target="#addUserConfirmationMSG"]').click();
                }
            });
        });
        $('.user-added-confirm-close').on('click', function() {
            window.location.reload(true)
        })

        $(document).on('click', '.delete-from-user-profile', function(e) {
            e.preventDefault();
            var type = $(this).attr('data-type')
            var url = $(this).attr('href');
            var method = $(this).attr('data-method')
            var text = $(this).attr('data-text')
            var id = $(this).attr('data-id');
            var image = $(this).attr('data-image')
            var delete_id = $(this).attr('data-delete-id')
            $.ajax({
                type: method,
                url: url,
                success: function(data) {
                    console.log(data)
                    if (!data.hasErrors) {
                        if ($('#user-profile-' + type).find('option[value="' + id + '"]').length > 0) {
                            $('#user-profile-' + type).find('option[value="' + id + '"]').removeClass('nodisplay')
                        } else {
                            $('#user-profile-' + type).append('<option value="' + id + '" data-image=' + image + '>' + text + '</option>')
                        }
                        $('.' + type + '-user-' + delete_id).remove()
                    }
                }
            })
        })
        // Teams Scripts End

        // Clients Scripts // 

        $('#clientpopup-departments').change(function() {

            var optionSelected = $(this).find("option:selected");
            var image = $(this).find("option:selected").attr('data-image');
            var values = []

            if (this.value || $("input[name='departments1[]']").length > 0) {
                if (this.value) {
                    $(".departments_list").append("<input class='departments_list-" + this.value + "' name='departments1[]' type='hidden' value='" + this.value + "'>");
                    if (this.value == 0) {
                        $('.departments_list input').not(".departments_list-" + this.value).remove()
                        $('.dept ul').empty()
                        $('#clientpopup-departments .nodisplay').removeClass('nodisplay')
                    } else {
                        $('.departments_list').find("input[value='0']").remove()
                        $('.dept ul').find("li[data-value='0']").remove()
                        optionSelected.addClass('nodisplay')
                    }
                    $(".dept ul").append("<li data-value=" + this.value + ">" + optionSelected.text() + "<span class='close select2-close remove-client-department-user' data-values='departments_list-" + this.value + "' data-value='" + optionSelected.val() + "' data-select-type='clientpopup-departments'><em class='fas fa-times'></em></span><input type='hidden' name='clients_departments' value=" + this.value + " /></li>");
                }
                if (this.value != 0 || !this.value) {
                    values = $("input[name='departments1[]']")
                        .map(function() {
                            return $(this).val();
                        }).get();
                }
                console.log(values)
                var add_deps = $("#departments1 option")
                    .map(function() {
                        return $(this).attr('value');
                    }).get();
                console.log(add_deps)
                $.ajax({
                    url: baseUrl + '/manager/usersby_department',
                    type: "GET",
                    data: {
                        "departments[]": values,
                        'add_deps[]': add_deps
                    },
                    success: function(data) {},
                    error: function(error) {
                        console.log(data);
                    }
                });
            }
        });
        $('#clientpopup-fund_groups').change(function() {

            var optionSelected = $(this).find("option:selected");
            var image = $(this).find("option:selected").attr('data-image');
            var values = []
            var editreportid = $("#editReportID").val();
            if (editreportid == "") {
                if ($("input[name='fund_groups[]']").length == 0) {
                    $('.subfunds ul').empty()
                    $('.sub_fund_groups-input').empty()
                    $('.subfunds_list').empty()
                }
            }
            if ($(".displaylist").children().length == 0) {
                $('.subfunds ul').empty()
                $('.sub_fund_groups-input').empty()
                $('.subfunds_list').empty()
            }
            if (this.value || $("input[name='fund_groups[]']").length > 0) {
                if (this.value) {
                    $(".fund_groups-input").append("<input class='fundgroupsform_" + this.value + "' name='fund_groups[]' type='hidden' value='" + this.value + "'>");
                    $(".fund_groups_list").append("<input class='fundgroupsform_" + this.value + "' name='fund_groups[]' type='hidden' value='" + this.value + "'>");
                    if (this.value == 0) {
                        $('.fund_groups-input input').not(".fundgroupsform_" + this.value).remove()
                        $('.fund_groups-display ul').empty()
                        $('#task_fund_groups .nodisplay').removeClass('nodisplay')
                        $('.fund_groups_list input').not(".fundgroupsform_" + this.value).remove()
                        $('.fund_groups ul').empty()
                        $('#fund_groups .nodisplay').removeClass('nodisplay')
                    } else {
                        $('.fund_groups_list').find("input[value='0']").remove()
                        $('.fund_groups-input').find("input[value='0']").remove()
                        $('.fund_groups-display ul').find("li[data-value='0']").remove()
                        $('.fund_groups ul').find("li[data-value='0']").remove()
                        optionSelected.addClass('nodisplay')
                        var exist_funds = $("input[name='fund_groups[]']")
                            .map(function() {
                                return $(this).val();
                            }).get();
                        exist_sub = ''
                        $.each(exist_funds, function() {
                            $('.subfunds li[data-fund-id=' + this + ']').addClass('wait-complete')
                            $('.sub_fund_groups-display li[data-fund-id=' + this + ']').addClass('wait-complete')
                            $('.sub_fund_groups-input input[data-fund-id=' + this + ']').addClass('wait-complete')
                            $('.subfunds_list input[data-fund-id=' + this + ']').addClass('wait-complete')
                        })
                        if (editreportid == "") {
                            $('.subfunds li').each(function() {
                                if (!$(this).hasClass('wait-complete')) {
                                    $(this).remove()
                                }
                                $(this).removeClass('wait-complete')
                            })
                            $('.subfunds_list input').each(function() {
                                if (!$(this).hasClass('wait-complete')) {
                                    $(this).remove()
                                }
                                $(this).removeClass('wait-complete')
                            })
                            $('.sub_fund_groups-display li').each(function() {
                                if (!$(this).hasClass('wait-complete')) {
                                    $(this).remove()
                                }
                                $(this).removeClass('wait-complete')
                            })
                            $('.sub_fund_groups-input input').each(function() {
                                if (!$(this).hasClass('wait-complete')) {
                                    $(this).remove()
                                }
                                $(this).removeClass('wait-complete')
                            })
                            $('.subfunds_list input').each(function() {
                                if (!$(this).hasClass('wait-complete')) {
                                    $(this).remove()
                                }
                                $(this).removeClass('wait-complete')
                            })
                        }
                    }
                    $(".fund_groups-display ul").append("<li data-client-id=" + optionSelected.attr('data-client-id') + " data-value='" + this.value + "'>" + optionSelected.text() + "<span data-values='fundgroupsform_" + this.value + "' data-value='" + optionSelected.val() + "' data-select-type='clientpopup-fund_groups' class='close select2-close remove-child'><em class='fas fa-times'></em></span></li>");
                    $(".fund_groups ul").append("<li data-client-id=" + optionSelected.attr('data-client-id') + " data-value='" + this.value + "'>" + optionSelected.text() + "<span data-values='fundgroupsform_" + this.value + "' data-value='" + optionSelected.val() + "' data-select-type='clientpopup-fund_groups' class='close select2-close remove-child'><em class='fas fa-times'></em></span><input type='hidden' name='clients_fundgroups' value=" + this.value + " /></li>");
                }
                if (this.value != 0 || !this.value) {
                    var values = $("input[name='fund_groups[]']")
                        .map(function() {
                            return $(this).val();
                        }).get();
                }
                var add_funds = $("#task_fund_groups option")
                    .map(function() {
                        return $(this).attr('value');
                    }).get();
                if (add_funds == "") {
                    var add_funds = $("#fund_groups option")
                        .map(function() {
                            return $(this).attr('value');
                        }).get();

                }
                console.log(add_funds)
                $.ajax({
                    url: baseUrl + '/manager/subfundby_company/',
                    type: "GET",
                    data: {
                        "fundgroups[]": values,
                        'add_funds[]': add_funds
                    },
                    success: function(data) {
                        $('#task_sub_fund_groups').empty();
                        if (data.length > 1) {
                            $('#task_sub_fund_groups').append("<option value='0' data-image='" + baseUrl + "/img/select-all.png'>{{__('task_creation.Taskcreation_stepone.All Sub Funds')}}</option>");
                            $('#subfunds').append("<option value='0' data-image='" + baseUrl + "/img/select-all.png'>{{__('task_creation.Taskcreation_stepone.All Sub Funds')}}</option>");
                        }
                        for (var i = 0; i < data.length; i++) {
                            var nodisplay = ''
                            if ($('[data-values=subfundsform_' + data[i].id + ']').length > 0) {
                                nodisplay = 'nodisplay'
                            }
                            $('#task_sub_fund_groups').append('<option data-fund-id="' + data[i].fund_group_id + '" class="' + nodisplay + '" value="' + data[i].id + '">' + data[i].sub_fund_name + '</option>');
                            $('#subfunds').append('<option data-fund-id="' + data[i].fund_group_id + '" class="' + nodisplay + '" value="' + data[i].id + '">' + data[i].sub_fund_name + '</option>');
                        }
                    },
                    error: function(error) {
                        console.log(data);
                    }
                });
            }
        });

        $("#risk_category").change(function() {
            // alert("risk_category");debugger;
            var values = $(this).val();
            $.ajax({
                url: baseUrl + '/manager/reports/fetchsubcategory',
                type: "GET",
                data: {
                    "riskcategoryid": values,
                },
                success: function(data) {
                    //alert(data);debugger;
                    if (data.length > 1) {
                        $('#subcategory').append("<option value='0' data-client-id='0'>All SubFunds</option>");
                    }
                    for (var i = 0; i < data.length; i++) {
                        $('#subcategory').append("<option value='" + data[i].id + "'>" + data[i].title + "</option>");
                    }
                },
                error: function(error) {
                    console.log(data);
                }
            });
        });

        $("#task_risk_category").change(function() {
            var values = $(this).val();
            $.ajax({
                url: baseUrl + '/manager/reports/fetchsubcategory',
                type: "GET",
                data: {
                    "riskcategoryid": values,
                },
                success: function(data) {
                    if (data.length > 1) {
                        $('#task_risk_subcategory').append("<option value='0' data-client-id='0'>All SubFunds</option>");
                    }
                    for (var i = 0; i < data.length; i++) {
                        $('#task_risk_subcategory').append("<option value='" + data[i].id + "'>" + data[i].title + "</option>");
                    }
                },
                error: function(error) {
                    console.log(data);
                }
            });
        });

        $('#clients').change(function() {
            var values = $(this).val();
            $('#departments').empty();
            $.ajax({
                url: baseUrl + '/manager/departments_by_clients',
                type: "GET",
                data: {
                    "report_clients": values,
                },
                success: function(data) {
                    //alert(data);debugger;

                    $('#departments').append("<option value='' selected disabled>Choose Departments</option>");

                    for (var i = 0; i < data.length; i++) {
                        $('#departments').append("<option  value='" + data[i].id + "'>" + data[i].name + "</option>");
                    }
                },
                error: function(error) {
                    console.log(data);
                }
            });

        });

        $('.clients-modal-upload-file').on('click', function() {
            $('.client-upload-logo-input').click()
        })
        $('.company-modal-upload-file').on('click', function() {
            $('.client-upload-logo-input').click()
        })

        $('.user-modal-upload-file').on('click', function() {
            $('.client-upload-logo-input').click()
        })

        // $('.department-modal-upload-file').on('click', function() {
        //     alert("department-modal-upload-file");debugger;
        //     $('.department-upload-logo-input').click()
        // })
        $('.depart__editBtn').click(function() {
            $('#imagehide').hide();
            var formtype = $(this).attr('data-type');
            if (formtype == "clients") {
                var id = $(this).attr('data-value');
                $('.dept  ul').empty();
                $('.dep-list ul').empty();
                $('.fund_groups-display ul').empty();
                $('#departModalLabel').html("Edit Client");

                $.ajax({
                    type: "GET",
                    url: baseUrl + '/manager/clients/fetchclientdetails/' + id,
                    success: function(data) {
                        $("#editclientID").val(data["id"]);
                        $("#clientName").val(data["client_name"]);
                        $("#shortDescriptions").val(data["description"]);
                        $("#clientEmail").val(data["email"]);
                        $("#regulated_status").val(data["regulated_status"]);
                        $("#deadline_priority").val(data["deadline_priority"]);

                        if (data["client_logo"] != null) {
                            var url = $("#aws_url").val();
                            $("#imagePreview").attr('hidden', false);
                            $("#imagePreview").find('img').attr('src', url + "/" + data["client_logo"]);
                            $('#hideupload').hide();
                        }
                        if (data["fund_groups"].length > 0) {
                            for (var k = 0; k < data["fund_groups"].length; k++) {
                                $(".fund_groups-display ul").append("<li data-value='" + data["fund_groups"][k]["id"] + "'>" + data["fund_groups"][k]["fund_group_name"] + "<span data-values='departmentform_" + data["fund_groups"][k]["id"] + "' data-value='" + data["fund_groups"][k]["fund_group_name"] + "' data-select-type='fund_groups' class='close select2-close  remove-child'><em class='fas fa-times'></em></span></li>");
                                $(".dep-list ul").append("<li data-value='" + data["fund_groups"][k]["id"] + "'>" + data["fund_groups"][k]["fund_group_name"] + "<span data-values='departmentform_" + data["fund_groups"][k]["id"] + "' data-value='" + data["fund_groups"][k]["fund_group_name"] + "' data-select-type='fund_groups' class='close select2-close  remove-child'><em class='fas fa-times'></em></span><input type='hidden' name='clients_fundgroups' value=" + data["fund_groups"][k]["id"] + " /></li>");
                            }
                        }

                        if (data["departments"].length > 0) {
                            for (var m = 0; m < data["departments"].length; m++) {
                                $(".dept ul").append("<li data-value='" + data["departments"][m]["id"] + "'>" + data["departments"][m]["name"] + "<span data-values='departmentform_" + data["departments"][m]["id"] + "' data-value='" + data["departments"][m]["name"] + "' data-select-type='departments' class='close select2-close remove-child'><em class='fas fa-times'></em></span><input type='hidden' name='clients_departments' value='" + data["departments"][m]["id"] + "' /></li>");
                            }
                        }

                        if (data["clientkeycontact"].length > 0) {
                            var sa = 0;
                            for (var l = 1; l <= 2; l++) {
                                $("#keyclientID" + l).val(data["clientkeycontact"][sa]["id"]);
                                $("#keycontact" + l + "_clientName").val(data["clientkeycontact"][sa]["name"]);
                                $("#keycontact" + l + "_clientEmail").val(data["clientkeycontact"][sa]["email"]);
                                $("#keycontact" + l + "_clientphonenumber").val(data["clientkeycontact"][sa]["phone_number"]);
                                sa++;
                            }

                        }



                    }
                });
            }
            if (formtype == "department") {
                var id = $(this).attr('data-value');
                $('#departModalLabel').html("Edit Department");
                var type = $(this).attr('data-user-type')

                $.ajax({
                    type: "GET",
                    url: baseUrl + '/manager/teams/fetchdepartmentdetails/' + id,
                    success: function(data) {
                        console.log(data)
                        $("#editdepartmentID").val(data["department_detail"]["id"]);
                        $("#department_name").val(data["department_detail"]["name"]);
                        $("#department_description").val(data["department_detail"]["description"]);

                        if (data["department_detail"]["dep_icon"] != "") {
                            var url = $("#aws_url").val();
                            $("#imagePreview").attr('hidden', false);
                            $("#imagePreview").find('img').attr('src', url + "/" +
                                data["department_detail"]["dep_icon"]);
                        }
                        $.each(data.department_members, function(i, v) {
                            if (v.is_manager == 0) {
                                $('.memeberaddingList.modal-all-display').append('<div class="member-item"><div class="d-flex"><div class="member-img"><img src="' + baseUrl + "/" + v.avatar + '" alt="userimg"/></div><div class="member-name">' + v.name + '</div><em class="fas fa-times memberClosedbtn remove-selected-user remove-server" data-option-id="' + v.company_user_id + '" data-delete-id="' + v.department_member_id + '" data-type="all" style="cursor:pointer"></em><input type="hidden" name="department_all_input" value="' + v.company_user_id + '" /></div></div>')
                            }
                            if (v.is_manager == 1) {
                                $('.memeberaddingList.modal-admin-display').append('<div class="member-item"><div class="d-flex"><div class="member-img"><img src="' + baseUrl + "/" + v.avatar + '" alt="userimg" /></div><div class="member-name">' + v.name + '</div><em class="fas fa-times memberClosedbtn remove-selected-user remove-server" data-option-id="' + v.company_user_id + '" data-delete-id="' + v.department_member_id + '" data-type="admin" style="cursor:pointer"></em><input type="hidden" name="department_admin_input" value="' + v.company_user_id + '" /></div></div></div>')
                            }
                        })
                    }
                });
            }

        });

        $(document).on('change', '.client-upload-logo-input', function(event) {

            var imagebase64Map = "";
            var map = event.target.files[0];
            var reader = new FileReader();
            reader.onloadend = function() {
                imagebase64Map = reader.result;
                $('input[name="upload_icon"]').val(imagebase64Map);
            }
            var allowed_extensions = new Array("jpg", "jpeg", "JPG", "JPEG", "png", "PNG", "GIF", "gif", "bmp", "BMP");
            var file_extension = map.name.split('.').pop();
            var valid = false;
            for (var i = 0; i <= allowed_extensions.length; i++) {
                if (allowed_extensions[i] == file_extension) {
                    valid = true;
                    $(".fileformats").hide();
                    $(".companyimage_status").hide();
                    reader.readAsDataURL(map);
                    $("#imagePreview").attr('hidden', false);
                    $("#imagePreview").find('img').attr('src', URL.createObjectURL(event.target.files[0]));
                    $('#hideupload').hide();
                    return true;
                }
            }

            if (valid == false) {
                $(".fileformats").hide();
                $(".companyimage_status").html("Please upload valid image file!");
                return false;
            }
          
        });

     

        // Clients script END
        $(".client-addnew-btn").click(function() {
            $('#clientform')[0].reset();
            $('.dept ul').empty();
            $('.fund_groups-display ul').empty();
            $('.imagePreview-icon').removeAttr('src');
            $('#clientpopup-departments .nodisplay').removeClass('nodisplay');
            $('#clientpopup-fund_groups .nodisplay').removeClass('nodisplay');
            $(".departments_list").find("input[name='departments1[]']").remove();
            $(".fund_groups-input").find("input[name='fund_groups[]']").remove();
            $('#clientpopup-departments').val('').trigger('change');
            $('#clientpopup-fund_groups').val('').trigger('change');
        });

        //clients
        $(".user-addnew-btn").click(function() {
            $('#fundform')[0].reset();
            $(".imagePreview-icon").removeAttr("src");
        });

        $('.user-modal-upload-file').on('click', function() {
            $('.user-upload-logo-input').click()
        })

        $(document).on('change', '.user-upload-logo-input', function(event) {
            var imagebase64Map = "";
            var map = event.target.files[0];
            var reader = new FileReader();
            reader.onloadend = function() {
                imagebase64Map = reader.result;
                $('input[name="upload_icon"]').val(imagebase64Map);
            }
            var allowed_extensions = new Array("jpg", "jpeg", "JPG", "JPEG", "png", "PNG", "GIF", "gif", "bmp", "BMP");
            var file_extension = map.name.split('.').pop();
            var valid = false;
            for (var i = 0; i <= allowed_extensions.length; i++) {
                if (allowed_extensions[i] == file_extension) {
                    valid = true;
                    $(".fileformats").hide();
                    $(".companyimage_status").hide();
                    reader.readAsDataURL(map);
                    $('#imagehide').hide();
                    $("#user_imagePreview").attr('hidden', false);
                    $("#user_imagePreview").find('img').attr('src', URL.createObjectURL(event.target.files[0]));
                    return true;
                }
            }
            if (valid == false) {
                $(".fileformats").hide();
                $(".companyimage_status").html("Please upload valid image file!");
                return false;
            }
        });

        $(".deleterecords").click(function() {
            var formAction = $(this).attr("data-target-action");
            $('.modal').find('form').attr('action', formAction);
        });

    });

    function retriveClientDetails() {
        var baseUrl = "{{ url('')}}";
        var awsurl = "{{ env('AWS_URL') }}";
        console.log(awsurl);
        console.log('****');
        $.ajax({
            url: baseUrl + '/manager/retriveTaskFormDetails/client',
            type: "GET",
            success: function(data) {
                if (data.length > 1) {
                    $('#task_clients').html("<option value='0' data-client-id='0' data-image='" + baseUrl + "/img/select-all.png'>{{__('task_creation.Taskcreation_stepone.All Clients')}}</option>");
                }
                console.log('*****');
                console.log(data);
                for (var i = 0; i < data.length; i++) {
                    console.log(awsurl);
                    $('#task_clients').append("<option data-client-id=" + data[i].id + " data-image='" + awsurl + "/" + data[i].client_logo + "' value='" + data[i].id + "'>" + data[i].client_name + "</option>");
                }
            },
            error: function(error) {
                console.log(data);
            }
        });
    }

    function retriveDepartmentDetails() {
        var baseUrl = "{{ url('')}}";
        var awsurl = "{{ env('AWS_URL') }}";
        console.log(awsurl);
        console.log('****');
        $.ajax({
            url: baseUrl + '/manager/retriveTaskFormDetails/departments',
            type: "GET",
            success: function(data) {
                // if (data.length > 1) {
                //     $('#task_departments').html("<option value='0' data-client-id='0'>{{__('task_creation.Taskcreation_stepone.All Departments')}}</option>");
                // }
                console.log('*****');
                console.log(data);
                for (var i = 0; i < data.length; i++) {
                    console.log(awsurl);
                    $('#task_departments').append("<option data-department-id=" + data[i].id + " value='" + data[i].id + "'>" + data[i].name + "</option>");
                }
            },
            error: function(error) {
                console.log(data);
            }
        });
    }

    function retriveRiskCategoryDetails() {
        var baseUrl = "{{ url('')}}";
        var awsurl = "{{ env('AWS_URL') }}";
        $.ajax({
            url: baseUrl + '/manager/retriveTaskFormDetails/riskCategory',
            type: "GET",
            success: function(data) {
                if (data.length > 1) {
                    $('#task_risk_category').html("<option value=''>Select Category</option>");
                }
                for (var i = 0; i < data.length; i++) {

                    $('#task_risk_category').append("<option data-client-id=" + data[i].id + " value='" + data[i].id + "'>" + data[i].title + "</option>");
                }
            },
            error: function(error) {
                console.log(data);
            }
        });

    }

    $(document).ready(function() {
        var baseUrl = "{{ url('')}}";

        if($('#mode').length && ($('#mode').val()=='edit' || $('#mode').val()=='parent'))
        {
            setTimeout(function() {
                $('.select2').each(function() {
                    var value = $(this).attr('data-selectedID');
                    if (value) {
                        var value_in_array = value.split(',');
                        $(this).val(value_in_array).select2().trigger('change');
                    }
                });
                if($('.responsible_party:checked').attr("data-optionText"))
                {
                $('.responsible_party').val($('.responsible_party:checked').attr("data-optionText")).trigger('change');
                }
            }, 3000);
        }

        $('.filter').hide();

        $("#report_type").change(function() {

            var reportType = $(this).val();
            if (reportType == 1 || reportType == 4) {
                $('.filter').hide();
                $('.auditfilter').show();
            } else if (reportType == 2) {
                $('.filter').hide();
                $('.riskfilter').show();
            } else if (reportType == 3) {
                $('.filter').hide();
                $('.issuefilter').show();
            }

        });

        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        $.ajax({
            url: baseUrl + '/fetchtags',
            type: "GET",
            data: {
                "id": 1,
            },
            success: function(data) {
                var myarray = [];
                var ids = [];
                for (var k = 0; k < data.length; k++) {

                    myarray.push(data[k]["name"]);
                }

                $('input[name="tags"]').amsifySuggestags({
                    suggestions: myarray
                });

                         $('input[name="task_tags"]').amsifySuggestags({
                               suggestions: myarray
                             });
                        $('input[name="ftp_tags"]').amsifySuggestags({
                               suggestions: myarray
                             });
                        
                        $('.tags').amsifySuggestags({
                            suggestions: myarray
                        });

            },
            error: function(error) {
                console.log(data);
            }
        });

        // alert("fetchtasktags");debugger;
        // $.ajax({
        //     url: baseUrl + '/manager/fetchtasktags',
        //     type: "GET",
        //     data: {
        //         "id": 1,
        //     },
        //     success: function(data) {
        //         alert(data);debugger;
        //         var myarray = [];
        //         var ids=[];
        //         for (var k = 0; k < data.length; k++) {
        //          myarray.push(data[k]["task_tag_name"]);
        //         }
        //         $('input[name="task_tags"]').amsifySuggestags({
        //                 suggestions: myarray
        //             });
        //     },
        //     error: function(error) {
        //         console.log(data);
        //     }
        // });        
    });

    $("#task_financial_impact").change(function() {

        $(".financial_impact_value").hide();
        $(".financial_impact_resolution").hide();
        $("#task_financial_impact_resolution").hide();
        $("#task_financial_impact_value").hide();
        $("#task_financial_impact_resolution").attr('disabled', 'disabled');
        $("#task_financial_impact_value").attr('disabled', 'disabled');
        var id = $(this).val();
        if (id == 1) {
            $(".financial_impact_value").show();
            $(".financial_impact_resolution").show();
            $("#task_financial_impact_resolution").show();
            $("#task_financial_impact_value").show();
            $("#task_financial_impact_resolution").removeAttr('disabled');
            $("#task_financial_impact_value").removeAttr('disabled');
        } else {
            $(".financial_impact_value").hide();
            $(".financial_impact_resolution").hide();
            $("#task_financial_impact_resolution").hide();
            $("#task_financial_impact_value").hide();
            $("#task_financial_impact_resolution").attr('disabled', 'disabled');
            $("#task_financial_impact_value").attr('disabled', 'disabled');
        }
    });

    function retriveAssociateActivity() {
        var baseUrl = "{{ url('')}}";
        $.ajax({
            url: baseUrl + '/manager/dependency_company',
            type: "GET",
            success: function(data1) {
                $('#task_associate_activity').empty();
                $('#task_associate_activity').append("<option value=''></option>");
                for (var i = 0; i < data1.length; i++) {
                    $('#task_associate_activity').append("<option value='" + data1[i].id + "'>" + data1[i].task_name + "</option>");
                }
            },
            error: function(error) {
                console.log('Error in retriving');
            }
        });
    }
    $(document).ready(function() {
        $('#task_associate_activity').change(function() {
            $(".associate_activity-display ul").empty();
            var activityHtml = '';
            $('#task_associate_activity option').each(function() {
                if ($(this).is(':selected')) {
                    var taskLink = "{{route('task')}}" + "/taskdetail/" + $(this).val();
                    activityHtml += '<li><span><em class="fas fa-times memberClosedbtn remove-selected-user remove-server" data-option-id="' + $(this).val() + '" data-type="admin" style="cursor:pointer"></em></span><div class="activities"><span class="title">' + $(this).text() + '</span><span class="action"><a href="' + taskLink + '" type="button" class="btn risk-view-edit-btn">View</a></span></div></li>';
                }
            });
            $(".associate_activity-display ul").append(activityHtml);

        });
        document.getElementById('task_attachments_text').addEventListener('change', handleFileSelect, false);

    });
    function handleFileSelect(evt) {
  var f = evt.target.files[0]; // FileList object
  var file_extension = f.name.split('.').pop();
  console.log(file_extension);
  var reader = new FileReader();
  // Closure to capture the file information.
  reader.onload = (function(theFile) {
    return function(e) {
      var binaryData = e.target.result;
      //Converting Binary Data to base 64
      var base64String = window.btoa(binaryData);
      base64String=base64String+'Nexus'+file_extension;
      //showing file converted to base64
      $('.file_formFieldValue').val(base64String);
    };
  })(f);
  // Read in the image file as a data URL.
  reader.readAsBinaryString(f);
}
</script>
