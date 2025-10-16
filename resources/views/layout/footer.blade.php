<!-- latest jquery-->
    <script src="{{asset('mofi/assets/js/jquery.min.js')}}"></script>
    <!-- Bootstrap js-->
    <script src="{{asset('mofi/assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <!-- feather icon js-->
    {{-- <script src="{{asset('mofi/assets/js/icons/feather-icon/feather.min.js')}}"></script> --}}
    {{-- <script src="{{asset('mofi/assets/js/icons/feather-icon/feather-icon.js')}}"></script> --}}
    <!-- scrollbar js-->
    <script src="{{asset('mofi/assets/js/scrollbar/simplebar.js')}}"></script>
    <script src="{{asset('mofi/assets/js/scrollbar/custom.js')}}"></script>
    <!-- Sidebar jquery-->
    <script src="{{asset('mofi/assets/js/config.js')}}"></script>

    <!-- Plugins JS start-->

    <script src="{{asset('mofi/assets/js/sidebar-menu.js')}}"></script>
    {{-- <script src="{{asset('mofi/assets/js/sidebar-pin.js')}}"></script> --}}
    <script src="{{asset('mofi/assets/js/slick/slick.min.js')}}"></script>
    <script src="{{asset('mofi/assets/js/slick/slick.js')}}"></script>
    <script src="{{asset('mofi/assets/js/header-slick.js')}}"></script>
    <!-- calendar js-->
    <script src="{{asset('mofi/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('mofi/assets/js/datatable/datatables/datatable.custom.js')}}"></script>
    <script src="{{asset('mofi/assets/js/select2/tagify.js')}}"></script>
    <script src="{{asset('mofi/assets/js/select2/tagify.polyfills.min.js')}}"></script>
    <script src="{{asset('mofi/assets/js/height-equal.js')}}"></script>
    <script src="{{asset('mofi/assets/js/popover-custom.js')}}"></script>
    <script src="{{asset('mofi/assets/js/tooltip-init.js')}}"></script>
    <script src="{{asset('mofi/assets/js/modalpage/validation-modal.js')}}"></script>
    <script src="{{asset('mofi/assets/js/flat-pickr/flatpickr.js')}}"></script>
    <script src="{{asset('mofi/assets/js/sweet-alert/sweetalert.min.js')}}"></script>
    <script src="{{asset('mofi/assets/js/timeline/custom-timeline.js')}}"></script>
    {{-- <script src="{{asset('mofi/assets/js/editors/quill.js')}}"></script> --}}
    <!-- Plugins JS Ends-->

    <!-- Theme js-->
    <script src="{{asset('mofi/assets/js/script.js')}}"></script>
    <script src="{{asset('mofi/assets/js/script1.js')}}"></script>

    {{-- CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.10.9/autoNumeric.min.js" integrity="sha512-cVa6IRDb7tSr/KZqJkq/FgnWMwBaRfi49qe3CVW4DhYMU30vHAXsIgbWu17w/OuVa0jyGly6/kJvcIzr8vFrDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- Plugin used-->
<script>
    var token = "{{ csrf_token() }}";
    var main_url = window.location.origin;

    function salamWaktu() {
        const jam = new Date().getHours();
        let salam = "";

        if (jam >= 4 && jam < 11) {
            salam = "Selamat Pagi ☀️";
        } else if (jam >= 11 && jam < 15) {
            salam = "Selamat Siang 🌤️";
        } else if (jam >= 15 && jam < 18) {
            salam = "Selamat Sore 🌇";
        } else {
            salam = "Selamat Malam 🌙";
        }

        $('.greeting_text').html(salam)
    }

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
    });
    salamWaktu();

    function getFileFromMaleser(link, from) {
        const $statusEl = $('#fileContainer');

        $.post(main_url + '/get-file-from-maleser',
        {
            _token: token,
            link,from
        },
        function(data, status){
            if (data.success) {
                window.open(data.url, '_blank', 'noopener,noreferrer');  // _blank = new tab
            }
        })
    }
</script>
