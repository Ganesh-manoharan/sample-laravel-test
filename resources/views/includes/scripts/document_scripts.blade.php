<script>
    $(document).ready(function() {
        var baseUrl = "{{ url('')}}";

        $('input[name="document_file"]').change(function(e) {
            $('.document-upload-preview').empty()
            var map = e.target.files[0];
            ulpoadDocument(map.name)
        })

        $('#drag-drop-file').on(
            'dragover',
            function(e) {
                e.preventDefault();
                e.stopPropagation();
            }
        )
        $('#drag-drop-file').on(
            'dragenter',
            function(e) {
                e.preventDefault();
                e.stopPropagation();
            }
        )
        $('#drag-drop-file').on(
            'drop',
            function(e) {
                if (e.originalEvent.dataTransfer) {
                    if (e.originalEvent.dataTransfer.files.length) {
                        e.preventDefault();
                        e.stopPropagation();
                        /*UPLOAD FILES HERE*/
                        upload(e.originalEvent.dataTransfer.files);
                    }
                }
            }
        );

        function upload(data) {
            var input = document.getElementById('attach_file');
            input.files = data
            ulpoadDocument(data[0].name)
        }

        function ulpoadDocument(name) {
            var type = name.split('.').pop()
            var img = 'pdf-document.svg'
            if (type == 'doc') {
                img = 'document-check.svg'
            }
            var allowed_extensions = new Array("pdf","PDF");
            var file_extension = name.split('.').pop();
            var valid=false;
            for(var i = 0; i <= allowed_extensions.length; i++)
            {
                if(allowed_extensions[i]==file_extension)
                {
                    valid=true;	
                    $(".docformats").hide();
                    $("#documentimage_status").hide();
                    $('.document-upload-preview').append('<div class="prev-upload-doc d-flex"><div class="img-docu-item"><img src="/img/' + img + '" alt="PDF document" class="img-fluid mr-4"></div><div class="dodument-name"><p>' + name + '</p></div><div class="ml-auto"><span class="close-document"><em class="fas fa-times"></em></span></div></div>')
                    return true;
                }
            }
            if(valid==false){
                $(".docformats").hide();
                $("#documentimage_status").css("display","block");
               $("#documentimage_status").html("Please upload only pdf documents!");
                return false;
            }
            
            
           
        }

        $(document).on('click', '#document-rename,#document-reupdate', function() {
            var name = $(this).attr('data-value');
            var id = $(this).attr('data-id')
            $('.document-update-submit').attr('data-id', id)
            $('input[name="document_rename"]').val(name)
        })

        $(document).on('click', '.document-update-submit', function() {
            var update = $(this).attr('data-update')
            var id = $(this).attr('data-id')
            var document_name = '';
            var formData = new FormData()
            formData.append('document_id', id);
            if (update == 'document-rename') {
                document_name = $('input[name="document_rename"]').val()
                formData.append('document_rename', document_name);
            }
            
            if (update == 'document-update'){
                formData.append('document_file', $('#attach_file')[0].files[0]);
            }
            var url = "{{route('document_save')}}"
            $('button[data-dismiss="modal"]').click()
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    showLoader();
                },
                success: function(data) {
                    console.log(data)
                    if (!data.hasErrors) {
                        if (update == 'document-rename') {
                            $('#document-name-' + id).text(document_name)
                        }
                        hideLoader();
                        $('button[data-target="#confrimationUpdate"]').click();
                    }
                    var href = "{{route('document_index')}}";
                     window.location.href = href;
                    
                    //location.reload(true);
                   
                },
                error: function(error) {
                    console.log(data);
                }
            });
        })

        $(document).on('click', '.document-view', function() {
            var id = $(this).attr('data-id')
            var document_name = $(this).attr('data-name');
            var type = $(this).attr('data-document-type');
            var rev = $(this).attr('data-reviewer');
            var date = $(this).attr('data-modified-date');
            var doc_path = $(this).attr('data-path')
            $('#document-view-name').text(document_name)
            $('#document-view-type').text(type)
            $('#document-view-date').text(date)
            $('#document-view-reviewer').text(rev)
            $('#document-update-name').text(document_name)
            $('#document-update-date').text(date)
            $('#document-update-reviewer').text(rev)
            $('#iframe-wrapper').empty()
            $.ajax({
                url: baseUrl + '/manager/doc_viewer',
                type: "GET",
                data: {
                    doc_path: doc_path, 
                    document_view : 'view'
                },
                success: function(data) {
                    console.log(data)
                    $('#iframe-wrapper').append(data)
                },
                error: function(error) {
                    console.log(error);
                }
            })
        })

        /*upload document */
        $(document).on('click', '.document-view', function() {
            //alert("document-view");debugger;
            var id = $(this).attr('data-id')
            var document_name = $(this).attr('data-name');
            var type = $(this).attr('data-document-type');
            var rev = $(this).attr('data-reviewer');
            var date = $(this).attr('data-modified-date');
            var doc_path = $(this).attr('data-path')
            $('#document-view-name').text(document_name)
            $('#document-view-type').text(type)
            $('#document-view-date').text(date)
            $('#document-view-reviewer').text(rev)
            $('#document-update-name').text(document_name)
            $('#document-update-date').text(date)
            $('#document-update-reviewer').text(rev)
            $('#iframe-wrapper').empty()
            $.ajax({
                url: baseUrl + '/manager/doc_viewer',
                type: "GET",
                data: {
                    doc_path: doc_path, 
                    doc_id:id,
                    document_view : 'view'
                },
                success: function(data) {
                    //alert(data);debugger;
                   // console.log(data)
                    for(var i = 0; i <= data.length; i++)
                        {
                            if(data[i]["text"]!=null)
                            {
                            
                            $('.fetchtask').append('<div class="list-of-doc-item"><div class="doc-upload-box"><div class="d-flex align-items-center"><div class="left-logo"><span>T</span></div><div class="doc-upload-content"><h6>'+data[i]["text"]+'</h6><span>Task ID '+data[i]["task_id"]+'</span></div></div><div class="view-doc-item"><a  target="_blank" href="'+href+'/manager/task/taskdetail/'+data[i]["task_id"]+'" class="btn view-doc-btn">View</a></div></div></div>');
                            
                           }
                            
                        }
                    $('#iframe-wrapper').append(data)
                },
                error: function(error) {
                    console.log(error);
                }
            })
        })

         /*upload document */
         $(document).on('click', '.list-tasks', function() {
            //alert("list-tasks");debugger;
            var id = $(this).attr('data-id')
            var document_name = $(this).attr('data-name');
            var type = $(this).attr('data-document-type');
            var rev = $(this).attr('data-reviewer');
            var date = $(this).attr('data-modified-date');
            var doc_path = $(this).attr('data-path');
            /*documents uploaded */
            var type = doc_path.split('.').pop();
            var img = 'pdf-document.svg'
            if (type == 'doc') {
                img = 'document-check.svg'
            }
            var allowed_extensions = new Array("pdf","PDF");
            var file_extension = doc_path.split('.').pop();
            // var removePath = 'documents/'+date('m')+'/';
            // var removedpath_file=doc_path.split(removePath).pop();
            $('.document-upload-preview').empty();
            var valid=false;
            for(var i = 0; i <= allowed_extensions.length; i++)
            {
                if(allowed_extensions[i]==file_extension)
                {
                    valid=true;
                    $(".docformats").hide();
                    $("#documentimage_status").hide();
                    $('.document-upload-preview').append('<div class="prev-upload-doc d-flex"><div class="img-docu-item"><img src="/img/' + img + '" alt="PDF document" class="img-fluid mr-4"></div><div class="dodument-name"><p>' + doc_path + '</p></div><div class="ml-auto"><span class="close-document"><em class="fas fa-times"></em></span></div></div>')
                }
            }
            if(valid==false){
                $(".docformats").hide();
               $("#documentimage_status").html("Please upload valid documents(pdf)!");
                return false;
            }

            var href=$(this).attr('data-href');
            $('#document-view-name').text(document_name);
            $('#document-view-type').text(type);
            $('#document-view-date').text(date);
            $('#document-view-reviewer').text(rev);
            $('#document-update-name').text(document_name);
            $('#document-update-date').text(date);
            $('#document-update-reviewer').text(rev);
            $('#iframe-wrapper').empty();
            $.ajax({
                url: baseUrl + '/manager/list_tasks',
                type: "GET",
                data: {
                    doc_path: doc_path, 
                    doc_id:id,
                    document_view : 'view'
                },
                success: function(data) {
                    //alert(data);debugger;
                    //alert(href);
                    //console.log(data)
                    $('.fetchtask').empty();
                    for(var i = 0; i <= data.length; i++)
                        {
                            if(data[i]["text"]!=null)
                            {
                            $('.fetchtask').append('<div class="doc-upload-box"><div class="d-flex align-items-center"><div class="left-logo"><span>T</span></div><div class="doc-upload-content"><h6>'+data[i]["text"]+'</h6><span>Task ID '+data[i]["task_id"]+'</span></div></div><div class="view-doc-item"><a  target="_blank" href="'+href+'/manager/task/taskdetail/'+data[i]["task_id"]+'" class="btn view-doc-btn">View</a></div></div>');
                           }
                            
                        }
                    $('#iframe-wrapper').append(data);
                   // var href = "{{route('document_index')}}";
                   // window.location.href = href;
                },
                error: function(error) {
                    console.log(error);
                }
            })
        })

        $("#document-upload-apache").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('.is-invalid').removeClass('is-invalid')
            var form = $("#document-upload-apache");
            var url = form.attr('action');
            var formData = new FormData($(this)[0]);
            formData.append('document_file', $('#attach_file')[0].files);
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    showLoader();
                },
                success: function(data) {
                    if (!data.hasErrors) {
                        $('button[data-target="#confrimationDocument"]').click();
                        var href = "{{route('document_index')}}"
                        if ($('#ftp-document-upload').length > 0) {
                            href = "{{route('ftp_documents_index')}}"
                        }
                        setTimeout(function() {
                            window.location.href = href
                        }, 500);
                    }
                    else{
                        $.each(data.data, function(index, value) {
                            $('.' + index + '-validation-error').addClass('is-invalid')
                            $('#' + index + '-validation-error-message').text(value)
                            $('.swalDefaultError').click()
                            hideLoader();
                            $(".docformats").hide();
                        })
                    }
                }
            });
        });

        function showLoader() {
            $("#overlay").fadeIn(300);
        }

        function hideLoader() {
            $("#overlay").fadeOut(300);
        }
    })
</script>