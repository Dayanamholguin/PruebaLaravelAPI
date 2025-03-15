<script>
    window.addEventListener('alert', function(messageAlert) {
        let data = messageAlert.detail.detail;
        Swal.fire(
            data.title ?? 'Error',
            data.message ?? 'No se recibió mensaje',
            data.icon ?? 'warning'
        );
    });
</script>
