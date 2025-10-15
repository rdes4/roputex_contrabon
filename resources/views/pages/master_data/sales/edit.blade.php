<div class="form_data">
     <input type="hidden" class="form-control id_sales" name="" id="" value="{{$sales->id}}">

    <div class="row">
        <div class="col-12">
            <label for="">Nama Sales</label>
            <input type="text" class="form-control nama" name="" id="" value="{{$sales->nama}}">
        </div>
    </div>

    <button class="mt-3 btn btn-sm btn-square px-2 border btn-icon btn-light" onclick="updateSales(this)">
        <i class="icon-save"></i>
    </button>

</div>
