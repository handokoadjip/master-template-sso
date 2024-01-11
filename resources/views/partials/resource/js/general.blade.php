<script>
    $(document).ready(function() {

        // --------------------------------------
        // OPTION CSRF
        // --------------------------------------
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // --------------------------------------
        // OPTION TOAST
        // --------------------------------------
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // --------------------------------------
        // ALERT SUCCESS
        // --------------------------------------
        @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: `{{ session('success') }}`
        });
        @endif
        // --------------------------------------
        // ALERT SUCCESS
        // --------------------------------------

        // --------------------------------------
        // ALERT WARNING
        // --------------------------------------
        @if(session('warning'))
        Toast.fire({
            icon: 'warning',
            title: `{{ session('warning') }}`
        });
        @endif
        // --------------------------------------
        // ALERT WARNING
        // --------------------------------------

        // --------------------------------------
        // ALERT FAILED
        // --------------------------------------
        @if(session('error'))
        Toast.fire({
            icon: 'error',
            title: `{{ session('error') }}`
        });
        @endif
        // --------------------------------------
        // ALERT SUCCESS
        // --------------------------------------

        $("body").on("click", (function(e) {
            // --------------------------------------
            // CONFIRM
            // --------------------------------------
            if ($(e.target).hasClass("confirm")) {
                e.preventDefault();
                const href = $(e.target).attr("href");
                Swal.fire({
                    title: "Apakah yakin?",
                    text: "Data akan berubah seperti yang sudah didefinisikan!",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya!"
                }).then(result => {
                    if (result.isConfirmed) {
                        $('body').waitMe({
                            effect: 'bounce',
                            text: '',
                            bg: "rgba(255, 255, 255, 0.7)",
                            color: "#000",
                            maxSize: '',
                            waitTime: -1,
                            textPos: 'vertical',
                            fontSize: '',
                            source: '',
                            onClose: function() {}
                        });
                        result.isConfirmed && (document.location.href = href)
                    }
                })
            };
            // --------------------------------------
            // CONFIRM
            // --------------------------------------

            // --------------------------------------
            // PRELOADER
            // --------------------------------------
            if ($(e.target).hasClass("waitme")) {
                $('body').waitMe({
                    effect: 'bounce',
                    text: '',
                    bg: "rgba(255, 255, 255, 0.7)",
                    color: "#000",
                    maxSize: '',
                    waitTime: -1,
                    textPos: 'vertical',
                    fontSize: '',
                    source: '',
                    onClose: function() {}
                });
            };
            // --------------------------------------
            // PRELOADER
            // --------------------------------------
        }));

        // --------------------------------------
        // DESTROY
        // --------------------------------------
        $(document).on('click', '.destroy', function() {
            url = $(this).attr('id');
            Swal.fire({
                title: 'Yakin ingin mengapus data ini?',
                text: "Data yang dihapus tidak dapat dikembalikan lagi!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus ini!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: `${url}`,
                        beforeSend: function() {
                            $('body').waitMe({
                                effect: 'bounce',
                                text: '',
                                bg: "rgba(255, 255, 255, 0.7)",
                                color: "#000",
                                maxSize: '',
                                waitTime: -1,
                                textPos: 'vertical',
                                fontSize: '',
                                source: '',
                                onClose: function() {}
                            });
                        },
                        success: function(data) {
                            console.log(data);
                            table.draw();
                            $('body').waitMe("hide");
                            Toast.fire({
                                icon: 'success',
                                title: 'Data berhasil dihapus!'
                            })
                        },
                        error: function() {
                            table.draw();
                            $('body').waitMe("hide");
                            Toast.fire({
                                icon: 'error',
                                title: 'Data gagal dihapus!'
                            })
                        },
                    })
                }
            })
        });

        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            url = $(this).attr('id');
            Swal.fire({
                title: 'Yakin ingin mengapus data ini?',
                text: "Data yang dihapus tidak dapat dikembalikan lagi!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus ini!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete').submit();
                }
            })
        });
        // --------------------------------------
        // DESTROY
        // --------------------------------------

        // --------------------------------------
        // SELECT2
        // --------------------------------------
        $('.select2').select2({
            theme: 'bootstrap-5'
        });
        // --------------------------------------
        // SELECT2
        // --------------------------------------

        // --------------------------------------
        // DROPIFY
        // --------------------------------------
        $('.dropify').dropify();
        // --------------------------------------
        // DROPIFY
        // --------------------------------------
    });
</script>