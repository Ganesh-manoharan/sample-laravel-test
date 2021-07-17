<script>
    $(document).ready(function() {
        var baseUrl = "{{url('')}}";
        var awsurl="{{env('AWS_URL')}}";
        $('.user-type-add').on('click', function() {
            var text = $(this).text()
            var user_type = $(this).attr('data-value')
            $('#user-type-add').val(user_type)
            $('#user-type-add').text(text)
            $('input[name = "role_id"]').val(user_type)
        })

        $(document).on('change', '.new_item-add_to_user', function() {
            var type = $(this).attr('data-item-type')
            var optionSelected = $(this).find("option:selected");
            var id = $(this).find("option:selected").val()
            var user_id = $('#user_profile_id').attr('data-value')
            var image = optionSelected.attr('data-image')
            var text = optionSelected.text()
            $.ajax({
                type: "post",
                url: baseUrl + '/manager/teams/update_user_profile/' + type,
                data: {
                    user_id: user_id,
                    item_id: id,
                },
                success: function(data) {
                    if (!data.hasErrors) {
                        optionSelected.addClass('nodisplay')
                        $('.user-new-' + type + '-added').append('<div class="userrestricitem ' + type + '-user-' + data.data.id + '"><div class="d-flex"><div class="left__item"><p>' + text + '</p></div><div class="ml-auto right__item"><a href="' + baseUrl + '/manager/teams/delete/' + type + '/user/' + data.data.id + '" data-method="delete" data-type="' + type + '" data-id=' + id + ' data-text=' + text + ' data-image="' + image + '" data-delete-id="' + data.data.id + '" class="delete-from-user-profile"><em class="fas fa-times"></em></a></div></div></div>')
                        $('#select2-user-profile-' + type + '-container').find('img').remove();
                        $('#select2-user-profile-' + type + '-container').find('#text').text('Choose ' + type);
                    } else {
                        alert('Try again Later!')
                    }
                }
            })
        })

        $(document).on('change', '.modal-select2', function() {
            if (this.value) {
                var type = $(this).attr('data-user-type')
                var optionSelected = $(this).find("option:selected");
                var id = $(this).find("option:selected").val();
                var image = optionSelected.attr('data-image');
                var text = optionSelected.text();
                if (this.value == 0) {
                    $('.memeberaddingList.modal-' + type + '-display').empty()
                    $('#modal-' + type + '-users .nodisplay').removeClass('nodisplay')
                } else {

                    $('.modal-addnewuser-' + type + '-input').find("input[value='0']").remove();
                    $('.memeberaddingList.modal-' + type + '-display').find('.remove-selected-user[data-option-id="0"]').parents('.member-item').remove()
                    $('#modal-' + type + '-users').find('option[value="' + this.value + '"]').addClass('nodisplay')
                }
                $('.memeberaddingList.modal-' + type + '-display').append('<div class="member-item"><div class="d-flex"><div class="member-img"><img src="' + image + '" alt="userimg" style="width:30px"/></div><div class="member-name common-avoid-text-overflow">' + text + '</div><em class="fas fa-times memberClosedbtn remove-selected-user" data-option-id="' + id + '" data-type="' + type + '" style="cursor:pointer"></em><input type="hidden" name="department_'+type+'_input" value="' + id + '" /></div></div>')
                $('.modal-' + type + '-input').append('<input type="text" hidden value="' + id + '" id="department_' + type + '_input-' + id + '" name="department_'+type+'[]">')
                $('.modal-addnewuser-' + type + '-input').append('<input type="text" hidden value="' + id + '" id="department_' + type + '_input-' + id + '" name="department_addnewuser_' + type + '[]">')


                if (type == 'departments') {
                    var tmp = 'Department Restrictions';
                }
                if (type == 'clients') {
                    var tmp = 'Client Restrictions';
                }
                if (type == 'admin') {
                    var tmp = 'Select Department Admin';
                    $('#modal-all-users').find('option[value="' + this.value + '"]').addClass('nodisplay')
                }
                if (type == "all") {
                    $('#modal-admin-users').find('option[value="' + this.value + '"]').addClass('nodisplay')
                }

                $('#select2-modal-' + type + '-users-container').find('#text').text(tmp)
                $('#select2-modal-' + type + '-users-container').find('img').remove()
                optionSelected.removeAttr('selected')
            }
        })

        $(document).on('click', '.remove-selected-user', function() {
            var type = $(this).attr('data-type')
            var id = $(this).attr('data-option-id');
            $('#modal-' + type + '-users').find('option[value="' + id + '"]').removeClass('nodisplay')
            if (type == "all") {
                $('#modal-admin-users').find('option[value="' + id + '"]').removeClass('nodisplay')
            }
            if (type == 'admin') {
                var tmp = 'Select Department Admin';
                $('#modal-all-users').find('option[value="' + id + '"]').removeClass('nodisplay')
            }
            if($(this).hasClass('remove-server')){
                $('.modal-' + type + '-input').append('<input type="text" hidden value="' + $(this).attr('data-delete-id') + '" id="department_' + type + '_input-remove-' + $(this).attr('data-delete-id') + '" name="department_member_remove[]">')
            }
            $('#modal-' + type + '-users').find('option[value="' + id + '"]').removeAttr('selected')
            $('#department_' + type + '_input-' + id).remove()
            $(this).parents('.member-item').remove()
        })

        $('.modal-upload-file').on('click', function() {
           $('.upload-logo-input').click();
        })

        // $('.upload-logo').on('click', function() {
        //     var tmp = $(this).attr('data-for')
        //     $('#' + tmp).click()
        // })
        $(document).on('change', '.upload-logo-input', function(event) {
            $(".image-hover-eit").show();
            var imagebase64Map = "";
            var map = event.target.files[0];
            var reader = new FileReader();
            reader.onloadend = function() {
                imagebase64Map = reader.result;
                $('input[name="upload_icon"]').val(imagebase64Map);
            }
            reader.readAsDataURL(map);
            $('.imagehide').hide();
            $("#imagePreview").attr('hidden', false);
            $("#imagePreview").find('img').attr('src', URL.createObjectURL(event.target.files[0]));
        });
    })
</script>