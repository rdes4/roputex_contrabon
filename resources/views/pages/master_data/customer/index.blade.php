<div class="row">
    <div class="col-12">
        <button class="btn btn-sm btn-square px-2 border btn-icon btn-light" onclick="addCustomer()">
            <i class="icon-plus"></i> Tambah
        </button>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <table class="table table-bordered datatable_customer">
            <thead class="table-dark">
                <tr>
                    <th>_id</th>
                    <th>Customer</th>
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
    var table = $('.datatable_customer').DataTable({
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
            url: main_url + "/master-data/customer/ajax-data",
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
                    var text = `${row.customer_code} - ${data}`
                    return text;
                }
            },
            {
                "data": "id",
                render: function (data, type, row) {
                    var text = `
                        <div class="d-flex" style="gap: 10px">
                            <button class="btn btn-sm btn-icon border px-2 btn-light txt-dark" type="button" onclick="editCustomer(this)" data-id_customer="${data}">
                                <i class="icon-pencil-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-icon border px-2 btn-light txt-danger" type="button" onclick="deleteCustomer(this)" data-id_customer="${data}">
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

function reloadCustomerTable(params) {
    $('.datatable_customer').DataTable().ajax.reload();
}

function addCustomer(params) {
    $("#modal_normal1").modal('show')
    $(".modal_normal1_title").html("Tambah Customer")
    $(".modal_normal1_body").html(`
        <div class="my-3 d-flex justify-content-center">
            <div class="spinner"></div>
        </div>
    `)
    $.post( main_url + "/master-data/customer/create",
    {
        _token: token,
    },
    function(data, status){
        $(".modal_normal1_body").html(data)
    })
}

function saveCustomer(ele) {
    var formData = $(ele).closest('.form_data')
    $.post( main_url + "/master-data/customer/save",
    {
        _token: token,
        nama : formData.find('.nama').val()
    },
    function(data, status){
        if (data.success) {
            toast.show()
            $("#modal_normal1").modal('hide')
            reloadCustomerTable()
        }
    })
}

function editCustomer(ele) {
    $("#modal_normal1").modal('show')
    $(".modal_normal1_title").html("Edit Customer")
    $(".modal_normal1_body").html(`
        <div class="my-3 d-flex justify-content-center">
            <div class="spinner"></div>
        </div>
    `)
    $.post( main_url + "/master-data/customer/edit",
    {
        _token: token,
        id_customer: $(ele).attr('data-id_customer')
    },
    function(data, status){
        $(".modal_normal1_body").html(data)
    })
}

function updateCustomer(ele) {
    var formData = $(ele).closest('.form_data')
    $.post( main_url + "/master-data/customer/update",
    {
        _token: token,
        id_customer : formData.find('.id_customer').val(),
        nama : formData.find('.nama').val()
    },
    function(data, status){
        if (data.success) {
            toast.show()
            $("#modal_normal1").modal('hide')
            reloadCustomerTable()
        }
    })
}

function deleteCustomer(ele) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
           $.post( main_url + "/master-data/customer/delete",
            {
                _token: token,
                id_customer: $(ele).attr('data-id_customer')
            },
            function(data, status){
                if (data.success) {
                    toast.show()
                    reloadCustomerTable()
                }
            })
        }
    });



}
</script>
