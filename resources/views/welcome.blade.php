@extends('layout.main')

@section('content')
<div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs border border-tab mb-0 list_tab bg-white" id="border-tab" role="tablist">

        </ul>

        <div class="tab-content mt-3 list_tab_content" id="border-tabContent">

        </div>
    </div>
</div>


@endsection

@section('script')
<script src="{{asset('control/main.js')}}"></script>
@endsection
