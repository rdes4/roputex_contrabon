<div class="row">
    <div class="col-12">
        <button class="btn btn-sm btn-square px-2 border btn-icon btn-light" onclick="addBank()">
            <i class="icon-plus"></i> Tambah
        </button>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <table class="table table-bordered datatable_bank">
            <thead class="table-dark">
                <tr>
                    <th>_id</th>
                    <th>Bank</th>
                    <th>Nomor Rekening</th>
                    <th>Nama</th>
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
    var table = $('.datatable_bank').DataTable({
        columnDefs: [
             { width: "10%", targets: [4] },
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
            url: main_url + "/master-data/bank/ajax-data",
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
                "data": "bank",
                render: function (data, type, row) {
                    return data;
                }
            },
            {
                "data": "nomor_rekening",
                render: function (data, type, row) {
                    return data;
                }
            },
            {
                "data": "nama_pemilik",
                render: function (data, type, row) {
                    return data;
                }
            },
            {
                "data": "id",
                render: function (data, type, row) {
                    var text = `
                        <div class="d-flex" style="gap: 10px">
                            <button class="btn btn-sm btn-icon border px-2 btn-light txt-dark" type="button" onclick="editBank(this)" data-id_bank="${data}">
                                <i class="icon-pencil-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-icon border px-2 btn-light txt-danger" type="button" onclick="deleteBank(this)" data-id_bank="${data}">
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

function reloadbankTable(params) {
    $('.datatable_bank').DataTable().ajax.reload();
}

function addBank(params) {
    $("#modal_normal1").modal('show')
    $(".modal_normal1_title").html("Tambah Bank")
    $(".modal_normal1_body").html(`
        <div class="my-3 d-flex justify-content-center">
            <div class="spinner"></div>
        </div>
    `)
    $.post( main_url + "/master-data/bank/create",
    {
        _token: token,
    },
    function(data, status){
        $(".modal_normal1_body").html(data)
    })
}

function saveBank(ele) {
    var formData = $(ele).closest('.form_data')
    $.post( main_url + "/master-data/bank/save",
    {
        _token: token,
        bank : formData.find('.bank').val(),
        nomor_rekening : formData.find('.nomor_rekening').val(),
        nama_pemilik : formData.find('.nama_pemilik').val(),
    },
    function(data, status){
        if (data.success) {
            toast.show()
            $("#modal_normal1").modal('hide')
            reloadbankTable()
        }
    })
}

function editBank(ele) {
    $("#modal_normal1").modal('show')
    $(".modal_normal1_title").html("Edit bank")
    $(".modal_normal1_body").html(`
        <div class="my-3 d-flex justify-content-center">
            <div class="spinner"></div>
        </div>
    `)
    $.post( main_url + "/master-data/bank/edit",
    {
        _token: token,
        id_bank: $(ele).attr('data-id_bank')
    },
    function(data, status){
        $(".modal_normal1_body").html(data)
    })
}

function updateBank(ele) {
    var formData = $(ele).closest('.form_data')
    $.post( main_url + "/master-data/bank/update",
    {
        _token: token,
        id_bank : formData.find('.id_bank').val(),
        bank : formData.find('.bank').val(),
        nomor_rekening : formData.find('.nomor_rekening').val(),
        nama_pemilik : formData.find('.nama_pemilik').val(),
    },
    function(data, status){
        if (data.success) {
            toast.show()
            $("#modal_normal1").modal('hide')
            reloadbankTable()
        }
    })
}

function deleteBank(ele) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
           $.post( main_url + "/master-data/bank/delete",
            {
                _token: token,
                id_bank: $(ele).attr('data-id_bank')
            },
            function(data, status){
                if (data.success) {
                    toast.show()
                    reloadbankTable()
                }
            })
        }
    });



}
</script>
