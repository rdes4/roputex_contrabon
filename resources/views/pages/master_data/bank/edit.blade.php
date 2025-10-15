<div class="form_data">
     <input type="hidden" class="form-control id_bank" name="" id="" value="{{$bank->id}}">

    <div class="row">
        <div class="col-3">
            <label for="">Bank</label>
            <input type="text" class="form-control bank" name="" id="" value="{{$bank->bank}}">
        </div>
        <div class="col-4">
            <label for="">Nomor Rekening</label>
            <input type="text" class="form-control nomor_rekening" name="" id="" value="{{$bank->nomor_rekening}}">
        </div>
        <div class="col-5">
            <label for="">Nama</label>
            <input type="text" class="form-control nama_pemilik" name="" id="" value="{{$bank->nama_pemilik}}">
        </div>
    </div>

    <button class="mt-3 btn btn-sm btn-square px-2 border btn-icon btn-light" onclick="updateBank(this)">
        <i class="icon-save"></i>
    </button>

</div>
