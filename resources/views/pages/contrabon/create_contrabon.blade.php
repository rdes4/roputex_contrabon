@inject('html', 'Spatie\Html\Html')

<div class="form_data">
    <div class="row">
        <div class="col-3">
            <label for="">Nomor Tanda Terima</label>
            <input type="text" name="" class="form-control nomor" id="">
        </div>
        <div class="col-3">
            <label for="">Tanggal Contrabon</label>
             <input type="text" name="" class="form-control tgl_contrabon date" id="" placeholder="dd-mm-yyyy">
        </div>
        <div class="col-2">
            <label for="">Tempo (hari)</label>
            <input type="text" name="" class="form-control tempo" id="" placeholder="...">
        </div>
        <div class="col-4">
            <label for="">Tanggal Jatuh Tempo</label>
            <div class="row">
                <div class="col-8">
                    <input type="text" name="" class="form-control tgl_jatuh_tempo" id="" placeholder="dd-mm-yyyy" readonly>
                </div>
                <div class="col-4 d-flex align-items-center">
                    <span class="badge badge-dark pointer" onclick="countTanggalJatuhTempo(this)"><i class="icon-shift-right"></i> Hitung Tempo</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-4">
            <label for="">Customer</label>
            {!! $html->select('customer', $arr_cust)->class('form-control customer option')->placeholder('Pilih customer...') !!}
        </div>
        <div class="col-4">
            <label for="">Sales</label>
            {!! $html->select('sales', $arr_sales)->class('form-control sales option')->placeholder('Pilih sales...') !!}
        </div>
        <div class="col-4">
            <label for="">Bank</label>
            {!! $html->select('bank',$arr_bank)->class('form-control bank option')->placeholder('Pilih bank...') !!}
        </div>
    </div>

    <hr>

    <div>
        <span class="badge badge-dark pointer" onclick="addListFaktur()"><i class="icon-plus"></i> Tambah Faktur</span>
    </div>

    <div class="row mt-2">
        <div class="col-12">
            <table class="table table-bordered table_faktur">
                <thead class="table-dark">
                    <tr>
                        <th width="4%">#</th>
                        <th width="4%">No</th>
                        <th>No. Faktur</th>
                        <th width="13%">Tgl. Faktur</th>
                        <th width="13%">SO</th>
                        <th width="19%">Jumlah</th>
                        <th width="19%">Diskon/Retur</th>
                        <th width="13%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <input type="text" class="form-control nomor_faktur">
                        </td>
                        <td>
                            <input type="text" class="form-control tgl_faktur date" placeholder="dd-mm-yyyy">
                        </td>
                        <td>
                            <input type="text" class="form-control sales_order">
                        </td>
                        <td>
                            <input type="text" step="any" class="form-control jumlah_faktur" onchange="countTotalFaktur(this)">
                        </td>
                        <td>
                            <input type="text" step="any" class="form-control jumlah_retur" onchange="countTotalFaktur(this)">
                        </td>
                        <td class="total_faktur text-end">

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-6">
            <button class="btn btn-sm btn-light btn-square px-2 btn-icon border" onclick="saveContrabon(this)"><i class="icon-save"></i> Simpan</button>
        </div>
        <div class="col-6">
            <h5>Total Tagihan : <span class="total_tagihan">0</span></h5>
        </div>
    </div>
</div>

<script>
    var new_faktur = 0;

    var toastEl = document.getElementById('toast-success');
    var toast = new bootstrap.Toast(toastEl); // delay = 3 detik

    flatpickr(".date", {
        dateFormat: "d-m-Y",
    });

    new AutoNumeric(`.jumlah_faktur`, {
        digitGroupSeparator: '.',     // pisah ribuan pakai titik
        decimalCharacter: ',',        // desimal pakai koma
        decimalPlaces: 2,             // tampilkan 2 angka di belakang koma
        currencySymbol: 'Rp. ',
        currencySymbolPlacement: 'p', // prefix "Rp "
        unformatOnSubmit: true        // kirim nilai tanpa format
    });
    new AutoNumeric(`.jumlah_retur`, {
        digitGroupSeparator: '.',     // pisah ribuan pakai titik
        decimalCharacter: ',',        // desimal pakai koma
        decimalPlaces: 2,             // tampilkan 2 angka di belakang koma
        currencySymbol: 'Rp. ',
        currencySymbolPlacement: 'p', // prefix "Rp "
        unformatOnSubmit: true        // kirim nilai tanpa format
    });

    $('.option').selectize({
        theme: 'bootstrap5',
        maxItems: 1,
        create: false,
        placeholder: 'Silahkan pilih...'
    });

    function updateNumbering() {
        $('.table_faktur tbody tr').each(function(index) {
            // kolom kedua (index 1)
            $(this).find('td:eq(1)').text(index + 1);
        });
    }

    // panggil pertama kali
    updateNumbering();

    function reloadContrabonTable(params) {
        $('.datatable_contrabond').DataTable().ajax.reload();
    }

    function addListFaktur(params) {
        let jumlah = $('.table_faktur tbody tr').length;
        console.log(jumlah);

        if (jumlah < 17) {
             $('.table_faktur tbody').append(`
                <tr>
                    <td>
                        <i class="icon-close pointer txt-danger" onclick="removeListFaktur(this)"></i>
                    </td>
                    <td>

                    </td>
                    <td>
                        <input type="text" class="form-control nomor_faktur">
                    </td>
                    <td>
                        <input type="text" class="form-control tgl_faktur date_${new_faktur}" placeholder="dd-mm-yyyy">
                    </td>
                    <td>
                        <input type="text" class="form-control sales_order">
                    </td>
                    <td>
                        <input type="text" step="any" class="form-control jumlah_faktur jumlah_faktur_${new_faktur}" onchange="countTotalFaktur(this)">
                    </td>
                    <td>
                        <input type="text" step="any" class="form-control jumlah_retur jumlah_retur_${new_faktur}" onchange="countTotalFaktur(this)">
                    </td>
                    <td class="total_faktur text-end">

                    </td>
                </tr>
            `)

            flatpickr(`.date_${new_faktur}`, {
                dateFormat: "d-m-Y",
            });

            new AutoNumeric(`.jumlah_faktur_${new_faktur}`, {
                digitGroupSeparator: '.',     // pisah ribuan pakai titik
                decimalCharacter: ',',        // desimal pakai koma
                decimalPlaces: 2,             // tampilkan 2 angka di belakang koma
                currencySymbol: 'Rp. ',
                currencySymbolPlacement: 'p', // prefix "Rp "
                unformatOnSubmit: true        // kirim nilai tanpa format
            });

            new AutoNumeric(`.jumlah_retur_${new_faktur}`, {
                digitGroupSeparator: '.',     // pisah ribuan pakai titik
                decimalCharacter: ',',        // desimal pakai koma
                decimalPlaces: 2,             // tampilkan 2 angka di belakang koma
                currencySymbol: 'Rp. ',
                currencySymbolPlacement: 'p', // prefix "Rp "
                unformatOnSubmit: true        // kirim nilai tanpa format
            });

            new_faktur++

            updateNumbering();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Batas Faktur Terpenuhi',
                html: `Jumlah faktur sudah mencapai <b>${jumlah}</b> (batas: 17).<br>
                        Silakan buat <b>kontrabon baru</b> untuk menambahkan faktur lagi.`,
                showCancelButton: true,
                cancelButtonText: 'Batal'
            })
        }


    }

    function removeListFaktur(ele) {
        $(ele).closest('tr').remove()
        updateNumbering();
    }

    function saveContrabon(ele) {
        var formData = $(ele).closest('.form_data')
        var arr_faktur = []

        var nomor = formData.find('.nomor').val()
        var tempo = formData.find('.tempo').val()
        var tgl_contrabon = formData.find('.tgl_contrabon').val()
        var tgl_jatuh_tempo = formData.find('.tgl_jatuh_tempo').val()
        var id_customer = formData.find('.customer')[0].selectize.getValue()
        var id_sales = formData.find('.sales')[0].selectize.getValue()
        var id_bank = formData.find('.bank')[0].selectize.getValue()

        if (
            !nomor ||
            !tempo ||
            !tgl_jatuh_tempo ||
            id_customer.length === 0 ||
            id_sales.length === 0 ||
            id_bank.length === 0
        ) {
            alert('Silahkan isi semua kolom yang diperlukan!');
            return;
        }

        var table = formData.find('.table_faktur')
        table.find('tbody tr').each(function(index) {
            let row = $(this);
            let nomor_faktur = row.find('.nomor_faktur').val();
            let tgl_faktur = row.find('.tgl_faktur').val();
            let sales_order = row.find('.sales_order').val();
            let jumlah_diskon = row.find('.jumlah_diskon').val();

            let check_faktur = row.find('.jumlah_faktur').val() || 0;
            let check_retur = row.find('.jumlah_retur').val() || 0;

            if (check_faktur != 0) {
                var get_faktur = row.find('.jumlah_faktur')[0]
                var get_faktur_element = AutoNumeric.getAutoNumericElement(get_faktur)
                var jumlah_faktur = get_faktur_element.getNumber();
            }else{
                var jumlah_fakur = 0
            }

            if (check_retur != 0) {
                var get_retur = row.find('.jumlah_retur')[0]
                var get_retur_element = AutoNumeric.getAutoNumericElement(get_retur)
                var jumlah_retur = get_retur_element.getNumber();
            }else{
                var jumlah_retur = 0
            }

            arr_faktur.push({
                nomor_faktur,
                tgl_faktur,
                sales_order,
                jumlah_faktur,
                jumlah_retur,
                jumlah_diskon,
            })
        });

        $.post(main_url + "/contrabon/save",
        {
            _token: token,
            nomor,
            tempo,
            tgl_contrabon,
            tgl_jatuh_tempo,
            id_customer,
            id_sales,
            id_bank,
            arr_faktur
        },
        function(data, status){
            if (data.success) {
                toast.show()
                formData.find('.nomor').val('')
                formData.find('.tempo').val('')
                formData.find('.tgl_contrabon').val('')
                formData.find('.tgl_jatuh_tempo').val('')
                formData.find('.customer')[0].selectize.clear()
                formData.find('.sales')[0].selectize.clear()
                formData.find('.bank')[0].selectize.clear()
                table.find('tbody').html(`
                    <tr>
                        <td></td>
                        <td>
                            <input type="text" class="form-control nomor_faktur">
                        </td>
                        <td>
                            <input type="date" class="form-control tgl_faktur">
                        </td>
                        <td>
                            <input type="text" class="form-control sales_order">
                        </td>
                        <td>
                            <input type="number" step="any" class="form-control jumlah_faktur" onchange="countTotalFaktur(this)">
                        </td>
                        <td>
                            <input type="number" step="any" class="form-control jumlah_diskon" onchange="countTotalFaktur(this)">
                        </td>
                        <td>
                            <input type="number" step="any" class="form-control jumlah_retur" onchange="countTotalFaktur(this)">
                        </td>
                        <td class="total_faktur text-end">

                        </td>
                    </tr>
                `)
            }
            if ($('body').find('.datatable_contrabon').length > 0) {

                reloadContrabonTable()
            }
        })
    }

    function countTanggalJatuhTempo(ele) {
        var formData = $(ele).closest('.form_data')
        var tr = formData.find('.table_faktur tbody tr:first')

        let tempo = parseInt(formData.find('.tempo').val());
        let check_date = tr.find('.tgl_faktur').val();

        // pastikan input tidak kosong
        if (!check_date) {
            alert('Pilih tanggal di baris pertama pada list faktur dulu!');
            return;
        }

        const [d, m, y] = check_date.split('-').map(Number); // pisahkan dd-mm-yyyy
        const date = new Date(y, m - 1, d);
        date.setDate(date.getDate() + tempo);

        const dd = String(date.getDate()).padStart(2, '0');
        const mm = String(date.getMonth() + 1).padStart(2, '0');
        const yyyy = date.getFullYear();
        const formatted =  `${dd}-${mm}-${yyyy}`

        formData.find('.tgl_jatuh_tempo').val(formatted)
    }

    function countTotalFaktur(ele) {
        var tr = $(ele).closest('tr')
        let check_faktur = tr.find('.jumlah_faktur').val() || 0;
        let check_retur = tr.find('.jumlah_retur').val() || 0;

        if (check_faktur != 0) {
            var get_faktur = tr.find('.jumlah_faktur')[0]
            var get_faktur_element = AutoNumeric.getAutoNumericElement(get_faktur)
            var jumlah_faktur = get_faktur_element.getNumber();
        }else{
            var jumlah_fakur = 0
        }

        if (check_retur != 0) {
            var get_retur = tr.find('.jumlah_retur')[0]
            var get_retur_element = AutoNumeric.getAutoNumericElement(get_retur)
            var jumlah_retur = get_retur_element.getNumber();
        }else{
            var jumlah_retur = 0
        }

        var total_faktur = jumlah_faktur - jumlah_retur
        var text_total_faktur = total_faktur.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
        tr.find('.total_faktur').text(text_total_faktur.replace(/\./g, '#').replace(/,/g, '.').replace(/#/g, ','))

        countTotaltagihan(ele)
    }

    function countTotaltagihan(ele) {
        var formData = $(ele).closest('.form_data')
        let total_faktur = 0;
        formData.find('.jumlah_faktur').each(function() {
            var get_faktur = $(this)[0]
            var get_faktur_element = AutoNumeric.getAutoNumericElement(get_faktur)
            var jumlah_faktur = get_faktur_element.getNumber();

            let val = parseFloat(jumlah_faktur) || 0;
            total_faktur += val;
        });

        let total_retur = 0;
        formData.find('.jumlah_retur').each(function() {
            var get_retur = $(this)[0]
            var get_retur_element = AutoNumeric.getAutoNumericElement(get_retur)
            var jumlah_retur = get_retur_element.getNumber();

            let val = parseFloat(jumlah_retur) || 0;
            total_retur += val;
        });

        var total_tagihan = total_faktur - total_retur
        var total_tagihan_text = total_tagihan.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
        formData.find('.total_tagihan').html(total_tagihan_text)
    }
</script>
