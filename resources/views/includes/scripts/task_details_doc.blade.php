<script>
    $(document).ready(function() {
        $('.prev-show-doc').html("<span class='nodocumentavailable'>None</span>");
        var baseUrl = "{{ url('')}}";
        var task_id = $('#taskid').val();
        if ($('.mis-enter-value')) {
            $.ajax({
                type: "get",
                url: baseUrl + '/manager/task/mis_results',
                data: {
                    task_id: task_id
                },
                success: function(data) {
                    console.log(data)
                    if (data.length > 0) {
                        $.each(data, function(index, item) {
                            var mis = $('#mis-field-' + item.task_mis_field_id)
                            var type = mis.attr('data-mis-type')
                            if (type == 'dropdown') {
                                mis.find('option').removeAttr('selected');
                                mis.find('option').attr('disabled', true)
                                mis.find('option[value=' + item.option_id + ']').prop('selected', 'selected')
                                mis.find('option[value=' + item.option_id + ']').prop('disabled', false)
                            } else {
                                mis.val(item.value)
                                mis.attr('readonly', true)
                            }
                        })
                    }
                }
            })
        }

        $.ajax({
            type: "GET",
            url: baseUrl + '/manager/task_documents/' + task_id,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                var width = "col-md-6";
                var hidden = true;
                var close = ""
                var mode = ""
                if ($("#mode").length) {
                    if ($("#mode").val() == "edit") {
                        width = "col-md-4";
                        hidden = false;
                        close = '<img src="{{env("DOMAIN_URL")}}/img/Close.svg" class="selected-page-remove-from-modal"></img>'
                        mode = 'data-mode="edit"'
                    }
                }
                $.each(data.docs, function(index, item) {
                    console.log(item)
                    var document_content = document.createElement('div')
                    document_content.id = 'parentWindow-selected-content-html-' + index
                    document.body.appendChild(document_content);
                    $('#parentWindow-selected-content-html-' + index).attr('hidden', true)
                    $('#parentWindow-selected-content-html-' + index).attr('data-document-id', index)
                    $('#parentWindow-selected-content-html-' + index).addClass('get-selected-document')

                    $('#parentWindow-selected-content-html-' + index).append('<div class="row"><div class="col-md-2 selection-section">Pages :</div><div class="col-md-10 row selected-page-content" id="selected-page-list"></div></div><div class="row"><div class="col-md-2 selection-section">Text : </div><div class="col-md-10 row selected-text-content" id="selected-text-list"></div></div>')
                    $.each(item, function(i, tmp) {
                        console.log(tmp)
                        if (i == 0) {
                            var new_thumbnail = document.createElement('div')
                            new_thumbnail.id = 'document-thumbnail'
                            new_thumbnail.setAttribute('hidden', true)
                            new_thumbnail.setAttribute('data-selection-type', tmp.document_added_as)
                            document.body.appendChild(new_thumbnail);
                            var canvas = document.createElement('canvas')
                            var ctx = canvas.getContext("2d");
                            var image = new Image();
                            image.onload = function() {
                                ctx.drawImage(image, 0, 0);
                            };
                            image.src = tmp.thumbnail;
                            canvas.width = 150
                            canvas.height = 150
                            console.log(canvas)
                            new_thumbnail.appendChild(canvas)
                            thumbnail_append(index);
                        }
                        var task_document = '';
                        
                        if (tmp.selected_type == 'page') {
                            $('#parentWindow-selected-content-html-' + index).find('#selected-page-list').append('<div class="col-md-2 d-flex selected-document-input" data-selected-type="page"><input class="selected-page-on-popup" id="selected-page-' + tmp.document_specific_page + '" data-doc-id="' + index + '" value="' + tmp.document_specific_page + '" readonly="">' + close + '</div>')
                        }
                        if (tmp.selected_type == 'text') {
                            var tmp_count = 0
                            $('#parentWindow-selected-content-html-' + index).find('#selected-text-list').append('<div class="d-flex selected-document-input" data-selected-type="text"><div class="selected-text-wrapper"><textarea class="selected-text-on-popup" id="selected-textarea-' + tmp_count + '" data-doc-id="' + index + '" data-selected-page="' + tmp.document_specific_page + '" disabled="" cols="100" data-quads=' + tmp.text_quads + ' >' + tmp.text + '</textarea></div>' + close + '<em class="fa fa-eye selected-text-on-popup" data-doc-id="' + index + '" data-selected-page="' + tmp.document_specific_page + '" data-quads=' + tmp.text_quads + '></em></div>')
                        }
                        $('textarea.selected-text-on-popup').each(function() {
                            var txt = $(this).val();
                            var cols = $(this).attr('cols');
                            var arraytxt = txt.split('\n');
                            var rows = arraytxt.length;
                            for (i = 0; i < arraytxt.length; i++)
                                rows += parseInt(arraytxt[i].length / cols);
                            $(this).attr('rows', rows);
                        })
                    });
                    $('.prev-show-doc').empty();
                    $.ajax({
                        url: baseUrl + '/manager/add_document/',
                        type: "GET",
                        data: {
                            title: data.doc_detail[index][0].document_name,
                            name: data.doc_detail[index][0].document_name,
                            id: index,
                            width: width
                        },
                        success: function(doc) {
                            console.log(doc)
                            $('.prev-show-doc').append('' + doc + '')
                            thumbnail_append(index)
                            $('.selected-doc-clear').attr('hidden', hidden)
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            }
        });
    })


    function thumbnail_append(id) {
        var thumbnail = $('#document-thumbnail')
        thumbnail.find('canvas').attr('style', 'width: 66px;height: 80px;background-color: white;border: 1px solid;')
        var selection_type = thumbnail.attr('data-selection-type')
        $('#document-selection-type-' + id).text(selection_type)
        $(document).find('#document-thumbnail-' + id).append(thumbnail)
        $('#document-thumbnail-' + id).find('#document-thumbnail').attr('id', 'document-thumbnail-canvas' + id)
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
        $('#document-thumbnail-canvas' + id).attr('hidden', false)
    }
</script>