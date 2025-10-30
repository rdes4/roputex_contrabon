@inject('html', 'Spatie\Html\Html')

<div class="form_data">

    <input type="hidden" class="id_contrabon" value="{{$contrabon->id}}">
    <div class="row">
        <div class="col-3">
            <label for="">Nomor Tanda Terima</label>
            <input type="text" name="" class="form-control nomor" id="" value="{{$contrabon->nomor}}">
        </div>
        <div class="col-3">
            <label for="">Tanggal Contrabon</label>
             <input type="text" name="" class="form-control tgl_contrabon date" id="" placeholder="yyyy-mm-dd" value="{{$contrabon->tgl_contrabon}}">
        </div>
        <div class="col-2">
            <label for="">Tempo (hari)</label>
            <input type="text" name="" class="form-control tempo" id="" value="{{$contrabon->tempo}}" placeholder="Masukkan tempo pembayaran">
        </div>
        <div class="col-4">
            <label for="">Tanggal Jatuh Tempo</label>
            <div class="row">
                <div class="col-8">
                    <input type="text" name="" class="form-control tgl_jatuh_tempo" id="" placeholder="dd-mm-yyyy" readonly value="{{ \Carbon\Carbon::parse($contrabon->tgl_jatuh_tempo)->format('d-m-Y') }}">
                </div>
                <div class="col-4 d-flex align-items-center">
                    <span class="badge badge-dark pointer" onclick="countTanggalJatuhTempoEdit(this)"><i class="icon-shift-right"></i> Hitung Tempo</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-4">
            <label for="">Customer</label>
            {!! $html->select('customer', $arr_cust, $contrabon->id_customer)->class('form-control customer option')->placeholder('Pilih customer...') !!}
        </div>
        <div class="col-4">
            <label for="">Sales</label>
            {!! $html->select('sales', $arr_sales, $contrabon->id_sales)->class('form-control sales option')->placeholder('Pilih sales...') !!}
        </div>
        <div class="col-4">
            <label for="">Bank</label>
            {!! $html->select('bank',$arr_bank, $contrabon->id_bank)->class('form-control bank option')->placeholder('Pilih bank...') !!}
        </div>
    </div>

    <hr>

    <div>
        <span class="badge badge-dark pointer" onclick="addListFakturEdit()"><i class="icon-plus"></i> Tambah Faktur</span>
    </div>

    <div class="row mt-2">
        <div class="col-12">
            <table class="table table-bordered table_faktur_edit">
                <thead class="table-dark">
                    <tr>
                        <th width="3%">#</th>
                        <th width="3%">No</th>
                        <th>No. Faktur</th>
                        <th width="17%">Tgl. Faktur</th>
                        <th width="13%">SO</th>
                        <th width="17%">Jumlah</th>
                        <th width="17%">Diskon/Retur</th>
                        <th width="13%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_tagihan = 0;
                    @endphp
                    @foreach ($contrabon_faktur as $value)
                        <tr class="old_faktur">
                            <td>
                                <input type="hidden" class="id_contrabon_faktur" value="{{$value->id}}" name="" id="">
                                <i class="icon-trash pointer txt-danger" onclick="deleteContrabonFaktur(this)"></i>
                            </td>
                            <td></td>
                            <td>
                                <input type="text" class="form-control nomor_faktur" value="{{$value->nomor_faktur}}">
                            </td>
                            <td>
                                <input type="text" class="form-control tgl_faktur date" value="{{$value->tgl_faktur}}">
                            </td>
                            <td>
                                <input type="text" class="form-control sales_order" value="{{$value->sales_order}}">
                            </td>
                            <td>
                                <input type="text" step="any" class="form-control jumlah_faktur" value="{{$value->jumlah_faktur}}" onchange="countTotalFakturEdit(this)">
                            </td>
                            <td>
                                <input type="text" step="any" class="form-control jumlah_retur" value="{{$value->jumlah_retur}}" onchange="countTotalFakturEdit(this)">
                            </td>
                            <td class="total_faktur text-end">
                                {{number_format($value->jumlah_faktur - $value->jumlah_retur, 2 )}}
                            </td>
                        </tr>
                        @php
                            $total_tagihan += $value->jumlah_faktur-$value->jumlah_retur;
                        @endphp
                    @endforeach

                </tbody>
                <tfoot>
                    <td colspan="7" class="text-end"> Total Tagihan</td>
                    <td class="text-end">
                        <span class="total_tagihan_edit ">{{number_format($total_tagihan, 2 )}}</span>
                    </td>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-6">
            <button class="btn btn-sm btn-light btn-square px-2 btn-icon border" onclick="updateContrabon(this)"><i class="icon-save"></i> Simpan</button>
        </div>
        <div class="col-6">

        </div>
    </div>
</div>

<script>
    var toastEl = document.getElementById('toast-success');
    var toast = new bootstrap.Toast(toastEl);

    new AutoNumeric.multiple(`.jumlah_faktur`, {
        digitGroupSeparator: '.',     // pisah ribuan pakai titik
        decimalCharacter: ',',        // desimal pakai koma
        decimalPlaces: 2,             // tampilkan 2 angka di belakang koma
        currencySymbol: 'Rp. ',
        currencySymbolPlacement: 'p', // prefix "Rp "
        unformatOnSubmit: true        // kirim nilai tanpa format
    });
    new AutoNumeric.multiple(`.jumlah_retur`, {
        digitGroupSeparator: '.',     // pisah ribuan pakai titik
        decimalCharacter: ',',        // desimal pakai koma
        decimalPlaces: 2,             // tampilkan 2 angka di belakang koma
        currencySymbol: 'Rp. ',
        currencySymbolPlacement: 'p', // prefix "Rp "
        unformatOnSubmit: true        // kirim nilai tanpa format
    });

    var new_faktur_edit = 0
    flatpickr(".date", {
        dateFormat: "d-m-Y",
    });

    $('.option').selectize({
        theme: 'bootstrap5',
        maxItems: 1,
        create: false,
        placeholder: 'Silahkan pilih...'
    });

    function updateNumberingEdit() {
        $('.table_faktur_edit tbody tr').each(function(index) {
            // kolom kedua (index 1)
            $(this).find('td:eq(1)').text(index + 1);
        });
    }

    // panggil pertama kali
    updateNumberingEdit();

    function addListFakturEdit(params) {
        let jumlah = $('.table_faktur_edit tbody tr').length;
        console.log(jumlah);

        if (jumlah < 17) {
            $('.table_faktur_edit tbody').append(`
                <tr class="new_faktur_edit">
                    <td>
                        <i class="icon-close pointer txt-danger" onclick="removeListFakturEdit(this)"></i>
                    </td>
                    <td>

                    </td>
                    <td>
                        <input type="text" class="form-control nomor_faktur">
                    </td>
                    <td>
                        <input type="text" class="form-control tgl_faktur date_${new_faktur_edit}" placeholder="dd-mm-yyyy">
                    </td>
                    <td>
                        <input type="text" class="form-control sales_order">
                    </td>
                    <td>
                        <input type="text" step="any" class="form-control jumlah_faktur jumlah_faktur_${new_faktur_edit}" onchange="countTotalFakturEdit(this)">
                    </td>
                    <td>
                        <input type="text" step="any" class="form-control jumlah_retur jumlah_retur_${new_faktur_edit}" onchange="countTotalFakturEdit(this)">
                    </td>
                    <td class="total_faktur text-end">

                    </td>
                </tr>
            `)

            flatpickr(`.date_${new_faktur_edit}`, {
                dateFormat: "d-m-Y",
            });

            new AutoNumeric(`.jumlah_faktur_${new_faktur_edit}`, {
                digitGroupSeparator: '.',     // pisah ribuan pakai titik
                decimalCharacter: ',',        // desimal pakai koma
                decimalPlaces: 2,             // tampilkan 2 angka di belakang koma
                currencySymbol: 'Rp ',
                currencySymbolPlacement: 'p', // prefix "Rp "
                unformatOnSubmit: true        // kirim nilai tanpa format
            });

            new AutoNumeric(`.jumlah_retur_${new_faktur_edit}`, {
                digitGroupSeparator: '.',     // pisah ribuan pakai titik
                decimalCharacter: ',',        // desimal pakai koma
                decimalPlaces: 2,             // tampilkan 2 angka di belakang koma
                currencySymbol: 'Rp ',
                currencySymbolPlacement: 'p', // prefix "Rp "
                unformatOnSubmit: true        // kirim nilai tanpa format
            });

            updateNumberingEdit();

            new_faktur_edit++
        }else{
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

    function removeListFakturEdit(ele) {
        var table = $(ele).closest('.form_data').find('table')
        $(ele).closest('tr').remove()
        countTotaltagihanEdit(table)
        updateNumberingEdit();
    }

    function updateContrabon(ele) {
        var formData = $(ele).closest('.form_data')
        var arr_faktur = []
        var arr_new_faktur_edit = []

        var id_contrabon = formData.find('.id_contrabon').val()
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
            !tgl_contrabon ||
            !tgl_jatuh_tempo ||
            id_customer.length === 0 ||
            id_sales.length === 0 ||
            id_bank.length === 0
        ) {
            alert('Silahkan isi semua kolom yang diperlukan!');
            return;
        }

        var table = formData.find('.table_faktur_edit')
        table.find('tbody tr.old_faktur').each(function(index) {
            let row = $(this);
            let id_contrabon_faktur = row.find('.id_contrabon_faktur').val();
            let nomor_faktur = row.find('.nomor_faktur').val();
            let tgl_faktur = row.find('.tgl_faktur').val();
            let sales_order = row.find('.sales_order').val();

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
                id_contrabon_faktur,
                nomor_faktur,
                tgl_faktur,
                sales_order,
                jumlah_faktur,
                jumlah_retur,
            })
        });

        table.find('tbody tr.new_faktur_edit').each(function(index) {
            let row = $(this);

            let nomor_faktur = row.find('.nomor_faktur').val();
            let tgl_faktur = row.find('.tgl_faktur').val();
            let sales_order = row.find('.sales_order').val();

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

            arr_new_faktur_edit.push({
                nomor_faktur,
                tgl_faktur,
                sales_order,
                jumlah_faktur,
                jumlah_retur,
            })
        });

        $.post(main_url + "/contrabon/update",
        {
            _token: token,
            id_contrabon,
            nomor,
            tempo,
            tgl_contrabon,
            tgl_jatuh_tempo,
            id_customer,
            id_sales,
            id_bank,
            arr_faktur,
            arr_new_faktur_edit,
        },
        function(data, status){
            if (data.success) {
                toast.show()

            }
        })
    }

    function countTanggalJatuhTempoEdit(ele) {
        var formData = $(ele).closest('.form_data')
        var tr = formData.find('.table_faktur_edit tbody tr:first')

        let tempo = parseInt(formData.find('.tempo').val());
        let date = tr.find('.tgl_faktur').val();

        // pastikan input tidak kosong
        if (!date) {
            alert('Pilih tanggal di baris pertama pada list faktur dulu!');
            return;
        }

        // ubah ke objek Date
        const startDate = new Date(date);

        // tambahkan 70 hari
        const futureDate = new Date(startDate);
        futureDate.setDate(startDate.getDate() + tempo);

        // format hasil ke YYYY-MM-DD
        const formatted = futureDate.toISOString().split('T')[0];

        formData.find('.tgl_jatuh_tempo').val(formatted)
    }

    function countTotalFakturEdit(ele) {
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

        countTotaltagihanEdit(ele)
    }

    function deleteContrabonFaktur(ele) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data yang sudah dihapus tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(main_url + '/contrabon/delete-contrabon-faktur',
                {
                    _token: token,
                    id_contrabon_faktur: $(ele).closest('tr').find('.id_contrabon_faktur').val()
                },
                function(data, status){
                    toast.show()
                    countTotaltagihanEdit(ele)
                    $(ele).closest('tr').remove()
                    updateNumberingEdit();
                })
            }
        });
    }

    function countTotaltagihanEdit(ele) {
        var formData = $(ele).closest('.form_data')
        console.log(formData);

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
        formData.find('.total_tagihan_edit').html(total_tagihan_text)
    }

</script>
