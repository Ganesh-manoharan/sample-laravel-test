<div class="splash">
    <div class="hold-transition login-page login-spalsh-section fade-in">
        <div class="login-box ">
            <div class="logo">
                <img src="{{ asset('img/NEXUS-gov-assurance.png') }}" alt="main-logo" class="img-fluid"/>
            </div>
                 <!-- /.login-logo -->
            <div class="card">
                  <div class="card-body login-card-body">
                        <h4>WELCOME {{ decryptKMSvalues(Auth::user()->name) }}</h4>
                        <span class="profile-img"><img src="{{ asset(Auth()->user()->avatar) }}" alt="" class="img-fluid" style="width:100px;height:100px;" /></span>
                  </div>
                   <!-- /.login-card-body -->
            </div>
        </div>
    </div>
</div>