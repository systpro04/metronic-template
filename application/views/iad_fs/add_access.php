<div class="page-container">
	<div class="page-content">
        <div class="container">		
           <div class="row margin-top-10">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs font-green-sharp"></i>
                                <span class="caption-subject font-green-sharp bold uppercase">iad access</span>
                            </div>
                            <div class="col-md-4">
                                <form class="search-form">
                                    <div class="input-group">
                                        <input type="search" for="search" name="search" id="search" class="form-control" placeholder="Search Employee">
                                        <!-- <span class="input-group-btn">
                                        <a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
                                        </span> -->
                                    </div>
                                </form>
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse">
                                </a>
                                <a href="javascript:;" class="reload">
                                </a>
                                <a href="" class="fullscreen" data-original-title="" title="">
								</a>
                                <a href="javascript:;" class="remove">
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered" id="iad_fs" width="100%">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-light">Employee ID</th>
                                            <th class="text-light">Name</th>
                                            <th class="text-light">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
</div>


<div class="modal fade draggable-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center" id="employeeName"></h3>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="det" class="table table-striped table-bordered" style="width:100%">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-light">MODULE</th>
                                <th class="text-light">COMPANY</th>
                                <th class="text-light">BUSINESS UNIT</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
    
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade draggable-modal" id="addAccess" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center" id="emp_name"></h3>
                <input type="hidden" class="modal-title text-center" id="emp_id">
            </div>
            <div class="modal-body">
                <form id="addAccessForm">
                    <div class="form-group">
                        <label for="modules">Select Modules:</label>
                        <select class="form-control" name="modules[]" multiple="multiple" id="modules"
                            style="width: 100%;"></select>
                    </div>

                    <div class="form-group">
                        <label for="company">Select Company:</label>
                        <select class="form-control" name="company[]" multiple="multiple" id="company"
                            style="width: 100%;"></select>
                    </div>

                    <div class="form-group">
                        <label for="business_unit">Business Unit Access</label>
                        <select class="form-control" name="business_unit[]" multiple="multiple" id="business_unit"
                            style="width: 100%;"></select>
                    </div>

                    <div class="modal-footer bg-whitesmoke">
                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade draggable-modal" id="editAccess" tabindex="-1" role="dialog" aria-labelledby="editAccessLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center" id="emp_name_edit"></h3>
                <input type="hidden" class="modal-title text-center" id="emp_id_edit">
            </div>
            <div class="modal-body">
                <form id="editAccessForm">
                    <div class="form-group">
                        <label for="modules">Select Modules:</label>
                        <select class="form-control" name="modules[]" multiple="multiple" id="modules_edit" style="width: 100%;"></select>
                    </div>

                    <div class="form-group">
                        <label for="company_edit">Select Company:</label>
                        <select class="form-control" name="company[]" multiple="multiple" id="company_edit" style="width: 100%;"></select>
                    </div>

                    <div class="form-group">
                        <label for="business_unit_edit">Business Unit Access:</label>
                        <select class="form-control" name="business_unit[]" multiple="multiple" id="business_unit_edit" style="width: 100%;"></select>
                    </div>

                    <div class="modal-footer bg-whitesmoke">
                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script>
    var table;
    $(document).ready(function () {
        table = $('#iad_fs').DataTable({
            'ajax': '<?php echo base_url('iad_fs/Iad_Ctrl/access_iad') ?>',
            'scrollCollapse': true,
            'scrollY': '40vh',
            'lengthMenu': [[10, 25, 50, 100, 10000], [10, 25, 50, 100, "Max"]],
            'pageLength': 10,
            "columnDefs": [
                { "className": "text-center", "targets": [0, 1, 2] }
            ],
        });
        
    });

    $("input[name='search']").autocomplete({
        source: function (request, response) {
            $.get("<?php echo base_url('iad_fs/Iad_Ctrl/search'); ?>", {
                query: request.term
            }, function (data) {
                data = JSON.parse(data);
                response(data);
            });
        },
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
        var listItem = $("<li>").append(
            $("<div>").css({
                "font-family": "Inter-Regular, sans-serif",
            }).html(`${item.emp_id} - ${item.name}`)
        );

        
        listItem.click(function() {
            var emp_id = item.emp_id; 
            add_employee_access(emp_id);
        });
        
        return listItem.appendTo(ul);
    }.bind($("input[name='search']"));
    $("div.ui-helper-hidden-accessible[role='status']").hide();
    $("div.ui-menu ui-widget ui-widget-content ui-autocomplete ui-front").hide();
    

    function add_employee_access(emp_id) {
        $.ajax({
            url: '<?php echo base_url('iad_fs/Iad_Ctrl/emp_data') ?>',
            type: 'post',
            data: { emp_id: emp_id },
            success: function (data) {
                var empData = JSON.parse(data);
                $('#emp_name').text(empData.name); 
                $('#emp_id').val(empData.emp_id); 
                $("div#addAccess").modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
                modules();
                businessUnits();
                company();
            },
        });
    }

    function modules(acc_modID) {
        $.ajax({
            url: '<?php echo base_url('iad_fs/Iad_Ctrl/getModules') ?>',
            dataType: 'json',
            success: function(data) {
                var modulesData = data.data.map(function(item) {
                    return { id: item.mod_id, text: item.mod_name };
                });

                $("#modules_edit, #modules").empty().select2({
                    placeholder: "Select modules...",
                    allowClear: true,
                    closeOnSelect: false,
                    // data: modulesData,
                });

                if (acc_modID) {
                    $('#modules_edit').val(acc_modID).trigger('change');
                }
            }
        });
    }

    function modules(acc_modID) {
        $.ajax({
            url: '<?php echo base_url('iad_fs/Iad_Ctrl/getModules') ?>',
            dataType: 'json',
            success: function(data) {
                var modulesData = data.data.map(function(item) {
                    return { id: item.mod_id, text: item.mod_name };
                });

                var $modules = $("#modules_edit, #modules").empty();
                $.each(modulesData, function(index, option) {
                    $modules.append($('<option>', { 
                        value: option.id,
                        text : option.text 
                    }));
                });

                $modules.select2({
                    placeholder: "Select modules...",
                    allowClear: true,
                    closeOnSelect: false
                });

                if (acc_modID) {
                    $modules.val(acc_modID).trigger('change');
                }
            }
        });
    }

    function businessUnits(acc_business_unit) {
        $.ajax({
            url: '<?php echo base_url('iad_fs/Iad_Ctrl/getBunit') ?>',
            dataType: 'json',
            success: function(data) {
                var businessUnitData = data.data.map(function(item) {
                    return { id: item.bcode, text: item.business_unit };
                });

                var $bunitselect = $("#business_unit_edit, #business_unit").empty();
                $.each(businessUnitData, function(index, option) {
                    $bunitselect.append($('<option>', { 
                        value: option.id,
                        text : option.text 
                    }));
                });

                $bunitselect.select2({
                    placeholder: "Select business units...",
                    allowClear: true,
                    closeOnSelect: false
                });

                if (acc_business_unit) {
                    $bunitselect.val(acc_business_unit).trigger('change');
                }
            }
        });
    }

    function company(acc_company) {
        $.ajax({
            url: '<?php echo base_url('iad_fs/Iad_Ctrl/getCompanies') ?>',
            dataType: 'json',
            success: function(data) {
                var companyData = data.data.map(function(item) {
                    return { id: item.company_code, text: item.acroname };
                });

                var $companySelect = $("#company_edit, #company").empty();
                $.each(companyData, function(index, option) {
                    $companySelect.append($('<option>', { 
                        value: option.id,
                        text : option.text 
                    }));
                });

                $companySelect.select2({
                    placeholder: "Select companies...",
                    allowClear: true,
                    closeOnSelect: false // This option is fine
                });

                if (acc_company) {
                    $companySelect.val(acc_company).trigger('change');
                }
            }
        });
    }


    function insert(empId, moduleIds, companyIds, businessUnitIds) {
    var format = companyIds.map(function(id) {
        return parseInt(id, 10);
    });

    var data = {
        emp_id: empId,
        acc_modID: moduleIds,
        acc_company: format.join(','),
        acc_business_unit: businessUnitIds.join(',')
    };

    $.ajax({
        url: '<?php echo base_url('iad_fs/Iad_Ctrl/insertAccess') ?>',
        type: 'post',
        dataType: 'json',
        data: data,
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Access data successfully inserted.',
                });
                table.ajax.reload(null, false);
            } else if (response.status === 'error' && response.message === 'No data inserted') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: 'No data inserted.',
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message,
                });
            }
        },
    });
}


    $("#addAccessForm").submit(function (event) {
        event.preventDefault();
        var empId = $('#emp_id').val(); 
        var moduleIds = $('#modules').val();
        var companyIds = $('#company').val();
        var businessUnitIds = $('#business_unit').val();
        insert(empId, moduleIds, companyIds, businessUnitIds);
        $('#addAccess').modal('hide');
    });

    function view_data(acc_employee) {
        $.ajax({
            url: '<?php echo base_url('iad_fs/Iad_Ctrl/view_data') ?>',
            type: 'post',
            data: { acc_employee: acc_employee },
            success: function (data) {
                var parsedData = $.parseJSON(data);
                $('#employeeName').text(parsedData.data.length > 0 ? parsedData.data[0][0] : '');
                if ($.fn.DataTable.isDataTable('#det')) {
                    $('#det').DataTable().destroy();
                }

                var dataTable = $('#det').DataTable({
                    data: parsedData.data.map(row => [row[1], row[2], row[3]]),
                    "columnDefs": [
                        { "className": "text-center", "targets": [0, 1, 2] }
                    ],
                    "ordering": false,
                    "lengthMenu": [[25, 50, 100, 10000], [25, 50, 100, "Max"]],
                    "pageLength": 25,
                });

                $("div#myModal").modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                $('#myModal').on('hidden.bs.modal', function (e) {
                    table.ajax.reload(null, false);
                });
            }
        });
    }

    function show_update_data(emp_id) {
        $.ajax({
            url: '<?php echo base_url('iad_fs/Iad_Ctrl/get_ebs_module') ?>',
            type: 'post',
            data: { emp_id: emp_id },
            success: function(data) {
                var emp_data = JSON.parse(data);

                $('#emp_name_edit').text(emp_data.name);
                $('#emp_id_edit').val(emp_data.emp_id);
                $("div#editAccess").modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
                modules(emp_data.acc_modID);
                businessUnits(emp_data.acc_business_unit);
                company(emp_data.acc_company);
            },
        });
    }

    function update(empId, moduleIds, companyIds, businessUnitIds) {
        var format = companyIds.map(function (id) {
            return parseInt(id, 10);
        });

        var data = {
            acc_employee: empId,
            acc_modID: moduleIds,
            acc_company: format.join(','),
            acc_business_unit: businessUnitIds.join(',')
        };

        $.ajax({
            url: '<?php echo base_url('iad_fs/Iad_Ctrl/updateAccess') ?>',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Access data successfully updated.',
                    });
                    table.ajax.reload(null, false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message,
                    });
                }
            },
        });
    }
    $("#editAccessForm").submit(function (event) {
        event.preventDefault();
        var empId = $('#emp_id_edit').val();
        var moduleIds = $('#modules_edit').val();
        var companyIds = $('#company_edit').val();
        var businessUnitIds = $('#business_unit_edit').val();
        update(empId, moduleIds, companyIds, businessUnitIds);
        $('#editAccess').modal('hide');
    });

</script>