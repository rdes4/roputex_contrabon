<div class="row">
    <div class="col-12">
        <button class="btn btn-sm btn-square px-2 border btn-icon btn-light" onclick="addSales()">
            <i class="icon-plus"></i> Tambah
        </button>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <table class="table table-bordered datatable_sales">
            <thead class="table-dark">
                <tr>
                    <th>_id</th>
                    <th>Sales</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
var toastEl = document.getElementById('toast-success');
var toast = new bootstrap.Toast(toastEl); // delay = 3 detik

$(document).ready(function (params) {
    var table = $('.datatable_sales').DataTable({
        columnDefs: [
             { width: "10%", targets: [2] },
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            },
        ],
        scrollX: true,
        ordering: false,
        processing: true,
        serverSide: true,
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_ Per Halaman',
            paginate: {
                'first': 'First',
                'last': 'Last',
                'next': '&rarr;',
                'previous': '&larr;'
            }
        },
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: main_url + "/master-data/sales/ajax-data",
            type: 'post',
            dataType: 'json',
            data: {
                '_token': token,
            }
        },
        columns: [
            {
                "data": "id",
                render: function (data, type, row) {
                    return data
                }
            },
            {
                "data": "nama",
                render: function (data, type, row) {
                    var text = `${row.sales_code} - ${data}`
                    return text;
                }
            },
            {
                "data": "id",
                render: function (data, type, row) {
                    var text = `
                        <div class="d-flex" style="gap: 10px">
                            <button class="btn btn-sm btn-icon border px-2 btn-light txt-dark" type="button" onclick="editSales(this)" data-id_sales="${data}">
                                <i class="icon-pencil-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-icon border px-2 btn-light txt-danger" type="button" onclick="deleteSales(this)" data-id_sales="${data}">
                                <i class="icon-trash"></i>
                            </button>
                        </div>
                    `
                    return text;
                }
            },
        ]
    });
})

function reloadsalesTable(params) {
    $('.datatable_sales').DataTable().ajax.reload();
}

function addSales(params) {
    $("#modal_normal1").modal('show')
    $(".modal_normal1_title").html("Tambah sales")
    $(".modal_normal1_body").html(`
        <div class="my-3 d-flex justify-content-center">
            <div class="spinner"></div>
        </div>
    `)
    $.post( main_url + "/master-data/sales/create",
    {
        _token: token,
    },
    function(data, status){
        $(".modal_normal1_body").html(data)
    })
}

function saveSales(ele) {
    var formData = $(ele).closest('.form_data')
    $.post( main_url + "/master-data/sales/save",
    {
        _token: token,
        nama : formData.find('.nama').val()
    },
    function(data, status){
        if (data.success) {
            toast.show()
            $("#modal_normal1").modal('hide')
            reloadsalesTable()
        }
    })
}

function editSales(ele) {
    $("#modal_normal1").modal('show')
    $(".modal_normal1_title").html("Edit sales")
    $(".modal_normal1_body").html(`
        <div class="my-3 d-flex justify-content-center">
            <div class="spinner"></div>
        </div>
    `)
    $.post( main_url + "/master-data/sales/edit",
    {
        _token: token,
        id_sales: $(ele).attr('data-id_sales')
    },
    function(data, status){
        $(".modal_normal1_body").html(data)
    })
}

function updateSales(ele) {
    var formData = $(ele).closest('.form_data')
    $.post( main_url + "/master-data/sales/update",
    {
        _token: token,
        id_sales : formData.find('.id_sales').val(),
        nama : formData.find('.nama').val()
    },
    function(data, status){
        if (data.success) {
            toast.show()
            $("#modal_normal1").modal('hide')
            reloadsalesTable()
        }
    })
}

function deleteSales(ele) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
           $.post( main_url + "/master-data/sales/delete",
            {
                _token: token,
                id_sales: $(ele).attr('data-id_sales')
            },
            function(data, status){
                if (data.success) {
                    toast.show()
                    reloadsalesTable()
                }
            })
        }
    });



}
</script>
