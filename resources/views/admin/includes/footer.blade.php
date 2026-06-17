        <!-- jQuery -->
        <script src="{{ asset('public/admin/assets/js/jquery-3.6.0.min.js') }}"></script>

        <!-- Bootstrap Core JS -->

        <script src="{{ asset('public/admin/assets/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Feather Icon JS -->

        <script src="{{ asset('public/admin/assets/js/feather.min.js') }}"></script>

        <!-- Slimscroll JS -->

        <script src="{{ asset('public/admin/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

        <!-- Select2 JS -->

        <script src="{{ asset('public/admin/assets/plugins/select2/js/select2.min.js') }}"></script>

        <!-- Datatables JS -->

        <script src="{{ asset('public/admin/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

        <script src="{{ asset('public/admin/assets/plugins/datatables/datatables.min.js') }}"></script>

        <!-- Chart JS -->
		<script src="{{ asset('public/admin/assets/plugins/apexchart/apexcharts.min.js')}}"></script>
		<script src="{{ asset('public/admin/assets/plugins/apexchart/chart-data.js')}}"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Custom JS -->

        <script src="{{ asset('public/admin/assets/js/script.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

        <script>
            window.Enums = {
                vcCharges: @json($vcChargesEnum)
            };
        </script>



        </body>

        </html>
