<div class="row">
    <div class="col-12">
        <button class="btn-sm mb-3 btn-square btn-light border px-2 btn-icon" onclick="reloadContrabonTable()"><i class="fa fa-refresh"></i> Refresh</button>

        <table class="table table-bordered datatable_contrabond">
            <thead class="table-dark">
                <tr>
                    <th>_id</th>
                    <th>No Tanda Terima</th>
                    <th>Customer</th>
                    <th>Sales</th>
                    <th>Bank</th>
                    <th>Tanggal Jatuh Tempo</th>
                    <th>Faktur</th>
                    <th>Total Tagihan</th>
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
    var table = $('.datatable_contrabond').DataTable({
        columnDefs: [
            { width: "8%", targets: [6] },
            { width: "10%", targets: [8] },
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
            url: main_url + "/contrabon/ajax-data",
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
                "data": "nomor",
                render: function (data, type, row) {
                    return data;
                }
            },
            {
                "data": "id_customer",
                render: function (data, type, row) {
                    return data;
                }
            },
            {
                "data": "id_sales",
                render: function (data, type, row) {
                    return data;
                }
            },
            {
                "data": "id_bank",
                render: function (data, type, row) {
                    return data;
                }
            },
            {
                "data": "tgl_jatuh_tempo",
                render: function (data, type, row) {
                    return data;
                }
            },
            {
                "data": "total_faktur",
                render: function (data, type, row) {
                    return data + " Faktur";
                }
            },
            {
                "data": "total_tagihan",
                render: function (data, type, row) {
                    return `<p class="m-0 text-end">${data}</p>`;
                }
            },
            {
                "data": "id",
                render: function (data, type, row) {
                    var text = `
                        <div class="d-flex" style="gap: 10px">
                            <button class="btn btn-sm btn-icon border px-2 btn-light txt-dark" type="button" onclick="editContrabon(this)" data-id_contrabon="${data}">
                                <i class="icon-pencil-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-icon border px-2 btn-light txt-dark" type="button" onclick="printContrabon(this)" data-id_contrabon="${data}">
                                <i class="icon-printer"></i>
                            </button>
                            <button class="btn btn-sm btn-icon border px-2 btn-light txt-danger" type="button" onclick="deleteContrabon(this)" data-id_contrabon="${data}">
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

function reloadContrabonTable(params) {
    $('.datatable_contrabond').DataTable().ajax.reload();
}

function editContrabon(ele) {
    $("#modal_xl").modal('show')
    $(".modal_xl_title").html("Detail Contrabon")
    $(".modal_xl_body").html(`
        <div class="my-3 d-flex justify-content-center">
            <div class="spinner"></div>
        </div>
    `)
    $.post(main_url + '/contrabon/edit',
    {
        _token: token,
        id_contrabon: $(ele).attr('data-id_contrabon')
    },
    function(data, status){
        $(".modal_xl_body").html(data)
    })
}

function deleteContrabon(ele) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Data yang sudah dihapus tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(main_url + '/contrabon/delete',
            {
                _token: token,
                id_contrabon: $(ele).attr('data-id_contrabon')
            },
            function(data, status){
                toast.show()
                reloadContrabonTable()
            })
        }
    });
}

function printContrabon(ele) {
    $("#modal_normal1").modal('show')
    $(".modal_normal1_title").html("Pilih Kertas")
    $(".modal_normal1_body").html(`
        <div class="my-3 d-flex justify-content-center">
            <div class="spinner"></div>
        </div>
    `)
    $.post(main_url + '/contrabon/print-selection',
    {
        _token: token,
        id_contrabon: $(ele).attr('data-id_contrabon')
    },
    function(data, status){
        $(".modal_normal1_body").html(data)
    })
    // window.open(main_url + `/contrabon/print?id_contrabon=${$(ele).attr('data-id_contrabon')}`, '_blank');

}
</script>
