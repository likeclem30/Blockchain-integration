$(document).ready(function() {



    $(document).on('change', '#lontxtmsisdnagloan', function() {
        var lonwphoneagloan_id = $(this).val();
        if (lonwphoneagloan_id != "") {
            $.ajax({
                url: "c_agloan.php",
                type: 'POST',
                data: { lonwphoneagloan_id: lonwphoneagloan_id },
                success: function(response) {
                    //var resp = $.trim(response);
                    if (response != '') {
                        $("#lontxtaddressagloan").removeAttr('disabled', 'disabled').html(response);

                    } else {
                        $("#lontxtaddressagloan").attr('disabled', 'disabled').html("<option value=''>----- Select ---</option>");
                    }
                }
            });
        } else {
            $("#lontxtaddressagloan").attr('disabled', 'disabled').html("<option value=''>----- Select ------</option>");
        }
    });



    $(document).on('change', '#bentxtmsisdnagloan', function() {
        var benwphoneagloan_id = $(this).val();
        if (benwphoneagloan_id != "") {
            $.ajax({
                url: "c_agloan.php",
                type: 'POST',
                data: { benwphoneagloan_id: benwphoneagloan_id },
                success: function(response) {
                    //var resp = $.trim(response);
                    if (response != '') {
                        $("#bentxtaddressagloan").removeAttr('disabled', 'disabled').html(response);

                    } else {
                        $("#bentxtaddressagloan").attr('disabled', 'disabled').html("<option value=''>----- Select ---</option>");
                    }
                }
            });
        } else {
            $("#bentxtaddressagloan").attr('disabled', 'disabled').html("<option value=''>----- Select ------</option>");
        }
    });





    money();
    decimal();
    var value = {
        method: "getdata"
    };

    var t_type = $("#divid").val();

    $('#table_agloan').DataTable({
        "paging": true,
        "lengthChange": false,
        "oSearch": { 'sSearch': t_type },
        "searching": true,
        "ordering": true,
        "info": false,
        "responsive": true,
        "autoWidth": false,
        "pageLength": 3,
        "dom": '<"top"f>rtip',
        "ajax": {
            "url": "c_agloan.php",
            "type": "POST",
            "data": value,
        },
        "columns": [
            { "data": "urutan" },
            { "data": "id_agloan" },
            { "data": "agloan_name" },
            { "data": "transaction_type" },
            { "data": "lonmsisdn" },
            { "data": "benemsisdn" },
            { "data": "term" },
            { "data": "principal" },
            { "data": "principal_limit" },
            { "data": "irate" },
            { "data": "date_created" },
            { "data": "button" },
        ]
    });
    $("#table_agloan_filter").addClass("pull-right");
});

$(document).on("click", "#btnaddagloan", function() {
    $(".contentharga").remove();
    $("#modalmasteragloan").modal('show');
    newagloan();
});

function newagloan() {
    $("#txtidagloan").val("*New");
    $("#txtagloanname").val("");
    $("#txttctyagloan").val("");
    $("#lontxtmsisdnagloan").val("");
    $("#lontxtaddressagloan").val("");
    $("#txtpassagloan").val("");
    $("#txtprinagloan").val(0);
    $("#txtlprinagloan").val(0);
    $("#txttermagloan").val(0);
    $("#txtmoratagloan").val(0);
    $("#txtexpagloan").val("");
    $("#txtirateagloan").val(0);
    $("#txtlpenagloan").val(0);
    $("#txtapayagloan").val("");
    $("#txtpaydayagloan").val("");
    $("#txtdescagloan").val("");
    $("#bentxtmsisdnagloan").val("");
    $("#bentxtaddressagloan").val("");
    $("#inputcrud").val("N");
    set_focus("#txtagloanname");
}
$(document).on("click", ".btneditagloan", function() {
    var id_agloan = $(this).attr("id_agloan");
    var value = {
        id_agloan: id_agloan,
        method: "get_detail_agloan"
    };
    $.ajax({
        url: "c_agloan.php",
        type: "POST",
        data: value,
        success: function(data, textStatus, jqXHR) {
            var hasil = jQuery.parseJSON(data);
            data = hasil.data;
            $("#agloaninputcrud").val("E");
            $("#txtidagloan").val(data.id_agloan);
            $("#txtagloanname").val(data.agloan_name);
            $("#txttctyagloan").val(data.transaction_type);
            $("#txtpassagloan").val(data.passagloan);

            $("#txtprinagloan").val(addCommas(data.principal));
            $("#txtlprinagloan").val(addCommas(data.principal_limit));
            $("#txttermagloan").val(data.term);
            $("#txtmoratagloan").val(addCommas(data.moratorium));
            $("#txtexpagloan").val(data.expenses);
            $("#txtirateagloan").val(data.irate);
            $("#txtlpenagloan").val(data.late_pen);
            $("#txtapayagloan").val(data.autopay);
            $("#txtpaydayagloan").val(data.payday);
            $("#txtdescagloan").val(data.description);
            $("#lontxtmsisdnagloan").val(data.lonmsisdnagloan);
            $("#lontxtaddressagloan").val(data.lonaddressagloan);
            $("#bentxtmsisdnagloan").val(data.benmsisdnagloan);
            $("#bentxtaddressagloan").val(data.benaddressagloan);


            $("#modalmasteragloan").modal('show');
            set_focus("#txtagloanname");
        },
        error: function(jqXHR, textStatus, errorThrown) {}
    });
});
$(document).on("click", "#btnsaveagloan", function() {

    var id_agloan = $("#txtidagloan").val();
    var agloan_name = $("#txtagloanname").val();
    var transaction_type = $("#txttctyagloan").val();
    var principal = cleanString($("#txtprinagloan").val());
    var principal_limit = cleanString($("#txtlprinagloan").val());
    var expenses = $("#txtexpagloan").val();
    var term = $("#txttermagloan").val();

    var moratorium = cleanString($("#txtmoratagloan").val());
    var irate = $("#txtirateagloan").val();
    var late_pen = cleanString($("#txtlpenagloan").val());
    var autopay = cleanString($("#txtapayagloan").val());
    var payday = cleanString($("#txtpaydayagloan").val());
    var description = $("#txtdescagloan").val();
    var lonmsisdnagloan = $("#lontxtmsisdnagloan").val();
    var lonaddressagloan = $("#lontxtaddressagloan").val();
    var benmsisdnagloan = $("#bentxtmsisdnagloan").val();
    var benaddressagloan = $("#bentxtaddressagloan").val();
    var passagloan = $("#txtpassagloan").val();
    var crud = $("#inputcrud").val();
    if (crud == 'E') {
        if (id_agloan == '' || id_agloan == null) {
            $.notify({
                message: "Loan  Id invalid"
            }, {
                type: 'warning',
                delay: 4000,
            });
            $("#txtidagloan").focus();
            return;
        }
    }
    if (agloan_name == '' || agloan_name == null) {
        $.notify({
            message: "Please fill out the Loan s Title"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtagloanname").focus();
        return;
    }
    if (transaction_type == '' || transaction_type == null) {
        $.notify({
            message: "Please fill out Transaction type"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txttctyagloan").focus();
        return;
    }
    if (principal == '' || principal == null) {
        $.notify({
            message: "Please fill out the Loan Principal"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtprinagloan").focus();
        return;
    }

    if (principal_limit == '' || principal_limit == null) {
        $.notify({
            message: "Please fill out the Loan Principal Limit"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtlprinagloan").focus();
        return;
    }

    if ((expenses == '' || expenses == null)&&(transaction_type =='addagloan')){
        $.notify({
            message: "Please fill out the Expenses"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtexpagloan").focus();
        return;
    }

    if (term == '' || term == null) {
        $.notify({
            message: "Please fill out the loan term"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txttermagloan").focus();
        return;
    }

    if (moratorium == '' || moratorium == null) {
        $.notify({
            message: "Please fill out the Loan moratorium"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtmoratagloan").focus();
        return;
    }

    if (irate == '' || irate == null) {
        $.notify({
            message: "Please fill out the Loan Interest Rate"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtirateagloan").focus();
        return;
    }

    if (late_pen == '' || late_pen == null) {
        $.notify({
            message: "Please fill out the Loan Late Penalty"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtlpenagloan").focus();
        return;
    }

    if (autopay == '' || autopay == null) {
        $.notify({
            message: "Please fill out the Loan Auto Pay Status"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtapayagloan").focus();
        return;
    }

    if (payday == '' || payday == null) {
        $.notify({
            message: "Please fill out the Loan  Pay day Status"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtpaydayagloan").focus();
        return;
    }

    if (description == '' || description == null) {
        $.notify({
            message: "Please fill out the Loan Description"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtdescagloan").focus();
        return;
    }

    if (lonmsisdnagloan == '' || lonmsisdnagloan == null) {
        $.notify({
            message: "Please fill out the Loaner MSISDN"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#lontxtmsisdnagloan").focus();
        return;
    }
    if (lonaddressagloan == '' || lonaddressagloan == null) {
        $.notify({
            message: "Please fill out the loaner Address"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#lontxtaddressagloan").focus();
        return;
    }

    if (passagloan == '' || passagloan == null) {
        $.notify({
            message: "Please fill out the loaner Password"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtpassagloan").focus();
        return;
    }

    if (benmsisdnagloan == '' || benmsisdnagloan == null) {
        $.notify({
            message: "Please fill out the Beneficiary MSISDN"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#bentxtmsisdnagloan").focus();
        return;
    }
    if (benaddressagloan == '' || benaddressagloan == null) {
        $.notify({
            message: "Please fill out the Beneficiary Address"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#bentxtaddressagloan").focus();
        return;
    }




    var value = {

        id_agloan: id_agloan,
        agloan_name: agloan_name,
        transaction_type: transaction_type,
        principal: principal,
        principal_limit: principal_limit,
        expenses: expenses,
        moratorium: moratorium,
        irate: irate,
        late_pen: late_pen,
        autopay: autopay,
        payday: payday,
        description: description,
        lonmsisdnagloan: lonmsisdnagloan,
        lonaddressagloan: lonaddressagloan,
        benmsisdnagloan: benmsisdnagloan,
        benaddressagloan: benaddressagloan,
        passagloan: passagloan,
        term: term,
        crud: crud,
        method: "save_agloan"
    };
    $(this).prop('disabled', true);
    proccess_waiting("#infoprosesagloan");
    $.ajax({
        url: "c_agloan.php",
        type: "POST",
        data: value,
        success: function(data, textStatus, jqXHR) {
            $("#btnsaveagloan").prop('disabled', false);
            $("#infoprosesagloan").html("");
            var data = jQuery.parseJSON(data);
            if (data.ceksat == 0) {
                $.notify(data.error);
            } else {
                if (data.crud == 'N') {
                    if (data.result == 1) {
                        $.notify('Save Loan  successfuly');
                        var table = $('#table_agloan').DataTable();
                        table.ajax.reload(null, false);
                        newagloan();
                    } else {
                        $.notify({
                            message: "Error save Loan , error :" + data.error
                        }, {
                            type: 'danger',
                            delay: 4000,
                        });
                        set_focus("#txtidagloan");
                    }
                } else if (data.crud == 'E') {
                    if (data.result == 1) {
                        $.notify('Update Loan  successfuly');
                        var table = $('#table_agloan').DataTable();
                        table.ajax.reload(null, false);
                        $("#modalmasteragloan").modal("hide");
                    } else {
                        $.notify({
                            message: "Error update Loan , error :" + data.error
                        }, {
                            type: 'danger',
                            delay: 4000,
                        });
                        set_focus("#txtidagloan");
                    }
                } else {
                    $.notify({
                        message: "Invalid Loan "
                    }, {
                        type: 'danger',
                        delay: 4000,
                    });
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $("#btnsaveagloan").prop('disabled', false);
        }
    });
});
$(document).on("click", ".btndeleteagloan", function() {
    var id_agloan = $(this).attr("id_agloan");
    swal({
            title: "Delete",
            text: "Delete Loan  with id : " + id_agloan + " ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Delete",
            closeOnConfirm: true
        },
        function() {
            var value = {
                id_agloan: id_agloan,
                method: "delete_agloan"
            };
            $.ajax({
                url: "c_agloan.php",
                type: "POST",
                data: value,
                success: function(data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {
                        $.notify('Delete Loan  successfuly');
                        var table = $('#table_agloan').DataTable();
                        table.ajax.reload(null, false);
                    } else {
                        $.notify({
                            message: "Error delete Loan , error :" + data.error
                        }, {
                            type: 'eror',
                            delay: 4000,
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });
        });
});