<div class="modal fade add-department add-new-department" id="addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="departModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="departModalLabel">{{__('teams.User.Create New Department')}}</h5>
            </div>
            <form action="{{ route('teams.department_save') }}" id="add_new_department" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="editdepartmentID" id="editdepartmentID" />
                    <div class="create__department">
                        <div class="form-group row">
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <div class="departmentName">
                                    <label>{{__('teams.User.Department Details')}}</label>
                                    <input type="text" class="form-control department_name-validation-error" aria-describedby="departmentName" placeholder="Name" name="department_name" id="department_name">
                                    <span class="invalid-feedback" role="alert">
                                    <strong id="department_name-validation-error-message"></strong>
                                    </span>
                                </div>
                                <div class="departDescribe">
                                    <textarea class="form-control" rows="3" placeholder="Short Department Description" name="department_description" id="department_description"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-12">
                                <div class="departmentName">
                                    <label>{{__('teams.User.Department Admin')}}</label>
                                    <div class="d-flex">
                                        <div class="team__member">
                                            <select class="form-control select2 all_users modal-select2 department-admin" id="modal-admin-users" data-user-type="admin">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="memeberaddingList modal-admin-display">

                                    </div>
                                </div>
                                <div class="modal-admin-input department_admin_input-validation-error"></div>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="department_admin_input-validation-error-message"></strong>
                                </span> 
                            </div>
                        </div>

                        <div class="form-group row">
                          
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="departmentName">
                                    <label>{{__('teams.User.Team Members')}}</label>
                                    <div class="d-flex">
                                        <div class="team__member form-group">
                                            <select class="form-control select2 all_users modal-select2" id="modal-all-users" data-user-type="all">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="memeberaddingList modal-all-display">

                                    </div>
                                </div>
                                <div class="modal-all-input department_all_input-validation-error"></div>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="department_all_input-validation-error-message"></strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('teams.User.Cancel')}}</button>
                        <button type="button" data-value="deptdetails" class="btn btn-primary FormsubmitBtn">{{__('teams.User.Confirm')}}</button>
                        <button hidden type="submit" class="btn btn-primary" id="deptsubmitbtn">{{__('teams.User.Confirm')}}</button>
                    </div>
                </div>
        </div>
    </div>
    </form>
</div>