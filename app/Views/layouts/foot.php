<!-- bootstrap -->
<script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>

<!-- JQuery -->
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js'); ?>"></script>

<!-- Sweet Alert 2 -->
<script src="<?= base_url('assets/js/sweetalert2.min.js'); ?>"></script>

<!-- Data Tables -->
<script src="<?= base_url('assets/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/js/dataTables.bootstrap5.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/datatables.js'); ?>"></script>

<!-- index -->
<script src="<?= base_url('assets/js/index.js'); ?>"></script>



<script>
    $('#logout').on('click', () => {
        const data = {
            title: 'Logout',
            text: 'Apakah kamu ingin keluar dari aplikasi?',
            buttonText: 'Ya, logout!',
            url: '<?= base_url('auth/logout') ?>',
            redirectTo: '<?= base_url('auth/login') ?>',
            method: "DELETE"
        }
        confirmSwalHandler(data);
    })
</script>
<?= $this->renderSection('scripts'); ?>
</body>

</html>