<script>
    var delay = (function() {
        var timer = 0;
        return function(callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })()
    var url = window.location.href
    console.log(url)
    $(document).ready(function() {
        $('.search-module').on('keyup', function() {
            console.log(url)
            data = {
                search : $(this).val()
            }
            if (!$(this).val()) {
                window.location.href = url
            }
            
            delay(function() {
                filter_module(url, data)
            }, 500)
        })

        $('.sortby-key').on('click', function() {
            // alert("sortby-key");debugger;
            $(".sortby_title").html($(this).text());
            // var datatype = $(this).attr("data-type");

            // if (datatype == "user") {
            //     var url = baseUrl + '/manager/teams/user_search';
            // } else if (datatype == "company") {
            //     var url = baseUrl + '/admin_home';
            // }
            //var keyword = $('#search-on-teams').val();
            $(this).addClass('active');
            $('.sortby-key').not($(this)).removeClass('active');
            var sortBy = $(this).attr('data-sortBy')
            var sortOrder = $(this).attr('data-sort-order')
            //   keyword += '&sortBy=' + sortBy + '&sortOrder=' + sortOrder

            // if ($(this).attr('data-add-parameter')) {
            //     keyword += '&' + $(this).attr('data-parameter-name') + '=' + $(this).attr('data-add-parameter')
            // }
            data = {
                sortBy: sortBy,
                sortOrder: sortOrder
            }
            delay(function() {
                filter_module(url, data)
            }, 500)

        })

        function filter_module(url, data) {
            $('.search-module-append').empty()
            $('.pagination-module-append').empty()
            $.ajax({
                url: url,
                type: "GET",
                data: data,
                beforeSend: function() {
                    showLoader();
                },
                success: function(data) {
                    $('.search-module-append').append(data['data']);
                    $('.pagination-module-append').append(data['pagination']);
                    hideLoader()
                },
                error: function(error) {
                    console.log(data);
                }
            });
            url = window.location.href
        }

        function showLoader() {
            $("#overlay").fadeIn(300);
        }

        function hideLoader() {
            $("#overlay").fadeOut(300);
        }
    })
</script>