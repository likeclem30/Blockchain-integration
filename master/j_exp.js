$(document).ready(function() {


    money();
    decimal();
    var value = {
        method: "getdata"
    };
    $('#table_exp').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": false,
        "responsive": true,
        "autoWidth": false,
        "pageLength": 3,
        "dom": '<"top"f>rtip',
        "ajax": {
            "url": "c_exp.php",
            "type": "POST",
            "data": value,
        },
        "columns": [
            { "data": "urutan" },
            { "data": "id_exp" },
            { "data": "exp_name" },
            { "data": "price" },
            { "data": "wprice" },
            { "data": "terms" },
            { "data": "transaction_id" },
            { "data": "button" },
        ]
    });
    $("#table_exp_filter").addClass("pull-right");

});

$(document).on("click", "#btnaddexp", function() {
    $(".contentharga").remove();
    $("#modalmasterexp").modal('show');
    newexp();
});

function newexp() {
    $("#txtidexp").val("*New");
    $("#txtexpname").val("");
    $("#txtexpindexloc").val("");
    $("#txtexpunit").val();
    $("#txtexpterms").val(0);
    $("#txtexpprice").val(0);
    $("#txtexpwprice").val(0);
    $("#inputcrud").val("N");
    set_focus("#txtexpname");
}
$(document).on("click", ".btneditexp", function() {
    var id_exp = $(this).attr("id_exp");
    var value = {
        id_exp: id_exp,
        method: "get_detail_exp"
    };
    $.ajax({
        url: "c_exp.php",
        type: "POST",
        data: value,
        success: function(data, textStatus, jqXHR) {
            var hasil = jQuery.parseJSON(data);
            data = hasil.data;
            $("#inputcrud").val("E");
            $("#txtidexp").val(data.id_exp);
            $("#txtexpname").val($.trim(data.exp_name));
            $("#txtexpindexloc").val($.trim(data.loci));
            $("#txtexpunit").val($.trim(data.unit));

            $("#txtexpterms").val(data.terms);
            $("#txtexpprice").val(addCommas(data.price));
            $("#txtexpwprice").val(addCommas(data.wprice));

            $("#modalmasterexp").modal('show');
            set_focus("#txtname");
        },
        error: function(jqXHR, textStatus, errorThrown) {}
    });
});
$(document).on("click", "#btnsaveexp", function() {
    var id_exp = $("#txtidexp").val();
    var exp_name = $("#txtexpname").val();
    var loci = $("#txtexpindexloc").val();
    var unit = $("#txtexpunit").val();

    var terms = cleanString($("#txtexpterms").val());
    var price = cleanString($("#txtexpprice").val());
    var wprice = cleanString($("#txtexpwprice").val());

    var crud = $("#inputcrud").val();
    if (crud == 'E') {
        if (id_exp == '' || id_exp == null) {
            $.notify({
                message: "exp Id invalid"
            }, {
                type: 'warning',
                delay: 4000,
            });
            $("#txtidexp").focus();
            return;
        }
    }
    if (exp_name == '' || exp_name == null) {
        $.notify({
            message: "Please fill out the exp name"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtexpname").focus();
        return;
    }
    if (loci == '' || loci == null) {
        $.notify({
            message: "Please fill out location index"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtexpindexloc").focus();
        return;
    }


    if (unit == '' || unit == null) {
        $.notify({
            message: "Please fill out exp unit of Measurement"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtexpunit").focus();
        return;
    }



    if (terms == '' || terms == null) {
        $.notify({
            message: "Please fill out exp terms"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtexpterms").focus();
        return;
    }

    if (price == '' || price == null) {
        $.notify({
            message: "Please fill out exp Ware house price"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtprice").focus();
        return;
    }

    if (wprice == '' || wprice == null) {
        $.notify({
            message: "Please fill out exp Farm price"
        }, {
            type: 'warning',
            delay: 4000,
        });
        $("#txtexpwprice").focus();
        return;
    }

    var value = {
        id_exp: id_exp,
        exp_name: exp_name,
        loci: loci,
        unit: unit,
        terms: terms,
        price: price,
        wprice: wprice,

        crud: crud,
        method: "save_exp"
    };
    $(this).prop('disabled', true);
    proccess_waiting("#infoprosesexp");
    $.ajax({
        url: "c_exp.php",
        type: "POST",
        data: value,
        success: function(data, textStatus, jqXHR) {
            $("#btnsaveexp").prop('disabled', false);
            $("#infoprosesexp").html("");
            var data = jQuery.parseJSON(data);
            if (data.ceksat == 0) {
                $.notify(data.error);
            } else {
                if (data.crud == 'N') {
                    if (data.result == 1) {
                        $.notify('Save exp successfuly');
                        var table = $('#table_exp').DataTable();
                        table.ajax.reload(null, false);
                        newexp();
                    } else {
                        $.notify({
                            message: "Error save exp, error :" + data.error
                        }, {
                            type: 'danger',
                            delay: 8000,
                        });
                        set_focus("#txtidexp");
                    }
                } else if (data.crud == 'E') {
                    if (data.result == 1) {
                        $.notify('Update exp successfuly');
                        var table = $('#table_exp').DataTable();
                        table.ajax.reload(null, false);
                        $("#modalmasterexp").modal("hide");
                    } else {
                        $.notify({
                            message: "Error update exp, error :" + data.error
                        }, {
                            type: 'danger',
                            delay: 8000,
                        });
                        set_focus("#txtidexp");
                    }
                } else {
                    $.notify({
                        message: "Invalid request"
                    }, {
                        type: 'danger',
                        delay: 8000,
                    });
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $("#btnsaveexp").prop('disabled', false);
        }
    });
});
$(document).on("click", ".btndeleteexp", function() {
    var id_exp = $(this).attr("id_exp");
    swal({
            title: "Delete",
            text: "Delete expenses with id : " + id_exp + " ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Delete",
            closeOnConfirm: true
        },
        function() {
            var value = {
                id_exp: id_exp,
                method: "delete_exp"
            };
            $.ajax({
                url: "c_exp.php",
                type: "POST",
                data: value,
                success: function(data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {
                        $.notify('Delete exp successfuly');
                        var table = $('#table_exp').DataTable();
                        table.ajax.reload(null, false);
                    } else {
                        $.notify({
                            message: "Error delete exp, error :" + data.error
                        }, {
                            type: 'eror',
                            delay: 8000,
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });
        });
});