<script>
    //task creation tab navigation start
    var submenus=["home","task","teams","clients","funds","taskdetail"];
    var ResponseURL = window.location.href;
    var baseUrl = "{{ url('')}}";
    var domain = ResponseURL.split('/');
    var keyword= domain[4];

    if(jQuery.inArray(keyword,submenus) !== -1)
    {
        if(keyword=="task")
        {
            var url=baseUrl+'/manager/'+keyword+"/home";
        }
        else
        {
        var url=baseUrl+'/manager/'+keyword;
        }
    }
    else
    {
        var url = window.location;
    }
    
    var nav = $('.leftside-navigation a[href="' + ResponseURL + '"]');
    nav.parent().addClass('menu-open');
    nav.parent().addClass('active-menu');
    nav.parent().removeClass('inactive-menu');
    var childspan = nav.parent().children().children();
    childspan.closest('.active-span').attr('hidden', false);
    childspan.closest('.general-span').attr('hidden', true);


    var currentTab = 0;
    showTab(currentTab);

    function showTab(n) {
        var x = document.getElementsByClassName("tab");

        x[n].style.display = "block";
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn-stepone").style.display = "none";
            if($('#submitBtn').length){
                document.getElementById("submitBtn").style.display = "inline";
            }
            if($('#issue-submitBtn').length){
            document.getElementById("issue-submitBtn").style.display = "inline";
            }
        } else {
            document.getElementById("nextBtn-stepone").style.display = "inline";
            if($('#submitBtn').length){
                document.getElementById("submitBtn").style.display = "none";
            }
            if($('#issue-submitBtn').length){
            document.getElementById("issue-submitBtn").style.display = "none";
            }
        }
        fixStepIndicator(n);
    }

    function nextPrevSlider(n) {
        var x = document.getElementsByClassName("tab");
        if (n == 1 && !validateForm()) return false;
        x[currentTab].style.display = "none";
        currentTab = currentTab + n;
        if (currentTab >= x.length) {
            document.getElementById("regForm").submit();
            return false;
        }
        showTab(currentTab);
        $('html, body').animate({
            scrollTop: $("#regForm").offset().top - 50
        }, 500);
    }

    function validateForm() {
        var x, y, i, valid = true;

        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid;
    }

    function fixStepIndicator(n) {
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        x[n].className += " active";
    }
    //task creation tab navigation stop
</script>