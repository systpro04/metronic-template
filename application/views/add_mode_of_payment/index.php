<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<div class="page-container">
	<div class="page-content">
        <div class="container">		
           <div class="row margin-top-10">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs font-green-sharp"></i>
                                <span class="caption-subject font-green-sharp bold uppercase"> Mode of payment</span>
                            </div>
                            <div class="col-md-3">
                                <select id="b_unit" class="form-control" aria-label="Choose Business Unit" style="height: 100%"></select>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addMop"><i class="fa fa-plus"></i> ADD</button>
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
                                <table class="table table-hover table-striped table-bordered" id="mop" width="100%">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-light">Mop Code</th>
                                            <th class="text-light">Mop Name</th>
                                            <th class="text-light">Department</th>
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
<div class="modal fade draggable-modal" id="addMop" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form id="addMopForm">
                    <div class="form-group">
                        <label for="modules">Payment Code</label>
                        <input type="text" name="mop_code" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="modules">Payment Name</label>
                        <input type="text" name="mop_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="company">Company</label>
                        <select name="company" class="form-control" id="company"></select>
                    </div>
                    <div class="form-group">
                        <label for="bcode">Business Unit</label>
                        <select name="bcode" class="form-control" id="bcode"></select>
                    </div>
                    <div class="form-group">
                        <label for="dcode">Department</label>
                        <select name="dcode" class="form-control" id="department"></select>
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

<script>
    $(document).ready(function () {
        var table = $('#mop').DataTable({
            'scrollCollapse': true,
            'scrollY': '50vh',
            'lengthMenu': [[10, 25, 50, 100, 10000], [10, 25, 50, 100, "Max"]],
            'pageLength': 10,
            'ajax': {
                url: '<?php echo base_url('Mop_Ctrl/view_mop_access') ?>',
                type: 'POST',
                
                data: function (d) {
                    d.business_unit = $('#b_unit').val();
                }
            },
            "columnDefs": [
                { "className": "text-center", "targets": [0, 1, 2] }
            ],
            "ordering": false,
        });

        function fetchBusinessUnits() {
            $.ajax({
                url: '<?php echo base_url('Mop_Ctrl/get_business_units') ?>',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#b_unit').empty();
                    $('#b_unit').append('<option selected disabled>All</option>');
                    $.each(data, function(index, unit) {
                        $('#b_unit').append('<option value="' + unit.bcode + '">' + unit.business_unit + '</option>');
                    });
                },
            });
        }

        fetchBusinessUnits();

        $('#b_unit').change(function () {
            table.ajax.reload(false, null);
        });

        var initialCompanyCode;
        function toggleDropdowns(disabled) {
            $('#bcode, #department').prop('disabled', disabled);
        }
        $.ajax({
            url: '<?php echo base_url("Mop_Ctrl/get_departments"); ?>',
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                $('#company').html(response.companyOptions);
                $('#bcode').html(response.bcodeOptions);
                $('#department').html(response.departmentOptions);
            }
        });

        $('#company').change(function () {
            var company = $(this).val();

            initialCompanyCode = company;
            if (!company) {
                toggleDropdowns(true);
                return;
            }
            toggleDropdowns(false);
            $.ajax({
                url: '<?php echo base_url("Mop_Ctrl/get_departments"); ?>',
                type: 'POST',
                data: { bunit_code: company },
                dataType: 'json',
                success: function (response) {
                    $('#bcode').html(response.bcodeOptions);
                    $('#department').html('');
                    $('#company').val(company);
                }
            });
        }).change();

        $('#bcode').change(function () {
            var selectedBcode = $(this).val();
            if (!initialCompanyCode) {
                $('#department').html('');
                return;
            }
            $.ajax({
                url: '<?php echo base_url("Mop_Ctrl/get_departments"); ?>',
                type: 'POST',
                data: { bunit_code: initialCompanyCode, bcode: selectedBcode },
                dataType: 'json',
                success: function (response) {
                    $('#department').html(response.departmentOptions);
                }
            });
        });

        $('#addMopForm').submit(function (event) {
            event.preventDefault();
            var emptyFields = $(this).find("input[type=text]").filter(function () {
                return this.value === "";
            });

            if (emptyFields.length > 0 || $('#company').val() === '' || $('#bcode').val() === '' || $('#department').val() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Please fill all input fields!',
                });
                $("#addMop").modal('hide');
                return false;
            }
            

            var formData = $(this).serialize();

            $.ajax({
                url: '<?php echo base_url("Mop_Ctrl/save_mop_data"); ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Successfully Added.',
                        });
                        fetchBusinessUnits();
                        $("#addMop").modal('hide');
                        table.ajax.reload(false, null);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to Add!',
                        });
                    }
                },
            });
        });

    });
</script>
