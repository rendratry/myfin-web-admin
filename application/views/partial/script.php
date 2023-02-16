<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url('assets/admin/') ?>vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url('assets/admin/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="<?php echo base_url('assets/admin/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="<?php echo base_url('assets/admin/') ?>js/sb-admin-2.min.js"></script>
	<script>
        $('.btn-ubah-adm').on('click', function (e) {
			e.preventDefault();
			let id_adminstaff_query = $(this).data('id');
			$('#ubahModal').modal('show');
			$.getJSON(`admin/getAjax/${id_adminstaff_query}`, function(data, status, xhr) {
                const {email_adminstaff,role,nama_adminstaff,id_adminstaff} = data;
                $('#ubahModal #id_adminstaff').val(id_adminstaff);
                $('#ubahModal #email_adminstaff').val(email_adminstaff);
                $('#ubahModal #role').val(role);
                $('#ubahModal #nama_adminstaff').val(nama_adminstaff);
            })
		})
        $('.btn-ubah-nas').on('click', function (e) {
			e.preventDefault();
			let id_user_query = $(this).data('id');
			$('#ubahModal').modal('show');
			$.getJSON(`nasabah/getAjax/${id_user_query}`, function(data, status, xhr) {
                const {email,nik,nama_lengkap,id_user} = data;
                $('#ubahModal #id_user').val(id_user);
                $('#ubahModal #email').val(email);
                $('#ubahModal #nik').val(nik);
                $('#ubahModal #nama_lengkap').val(nama_lengkap);
            })
		})
    
    </script>
    <script src="<?php echo base_url('assets/admin/') ?>vendor/datatables/jquery.dataTables.min.css"></script>
    <script src="<?php echo base_url('assets/admin/') ?>vendor/datatables/dataTables.bootstrap4.min.css"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>