<footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © ITC Store
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Powered By The TechTonic
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>


    <!-- JAVASCRIPT -->
    <script src="{{ asset ('/resources/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset ('/resources/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset ('/resources/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset ('/resources/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset ('/resources/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
   

    <!-- apexcharts -->
    <script src="{{ asset ('/resources/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset ('/resources/assets/libs/flatpickr/flatpickr.min.js') }}"><script>
    <script src="{{ asset ('/resources/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"><script>



    <!--Swiper slider js-->
    <script src="{{ asset ('/resources/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset ('/resources/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ asset ('/resources/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Sweet alert init js-->
    <script src="{{ asset ('/resources/assets/js/pages/sweetalerts.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset ('/resources/assets/js/app.js') }}"></script>

    
<script>
    $( document ).ready(function() {
        $(".view-order").click(function(){
            var order = $(this).data('order');
            $.ajax({
                url: "test.html",
                data: {id: order}
            }).done(function() {
                $( this ).addClass( "done" );
            });
        });
    });


    function change_date()
    {
    	
    	var dates = document.getElementById("datefilter").value;
    	//alert("date"+ document.getElementById("datefilter").value);
    	//var dates = "01-08-2023";
    	
    	var idx = dates.indexOf("to");
    	if(idx > -1)
    	{
    		
    		fromdate = dates.substring(0,idx);
    		var convertfromdate = fromdate.split("-").reverse().join("-");
    		toDate = dates.substring(idx+2);
    		var converttoDate = toDate.split("-").reverse().join("-");
    		
    		//alert(convertfromdate+ " "+converttoDate);
    		document.getElementById("sample_table1").innerHTML = "";
    		document.getElementById("sample_table1").innerHTML = "Please Wait...";
    		$.ajax({
			type: "POST",
			data: {
				from: convertfromdate, 
				to:converttoDate
			},
			url: "fetch_provider_order_summary.php",
			success: function(data){
			// console.log(data);
			 //alert(data);
			 document.getElementById("sample_table1").innerHTML = data;
			 },
			 error: function(xhr, status, error){
			 console.error(xhr);
			 }
		}) 
    	}
    }
    	
</script>
</body>

</html>