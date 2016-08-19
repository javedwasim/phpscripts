<!-- header !-->
	
	<link rel="stylesheet" type="text/css" media="screen" href="ajax/css.css" />
	<script type="text/javascript" src="ajax/jquery-1.3.2.js"></script>
	<script type="text/javascript">
	
		function showLoader(){
			
			$('.search-background').fadeIn(200);
		}
		function hideLoader(){
			
			$('.search-background').fadeOut(200);
		};
		function pagination(page){
			showLoader();
			$("#daycontent").load("ajax/data.php?page="+page, hideLoader);
			
			return false;
		};
		
		$(document).ready(function(){
			
			showLoader();
			$("#daycontent").load("ajax/data.php?page=1", hideLoader);
			
		});
	</script>
	
	
<!-- End header !-->	
	
<!-- Body !-->


<!-- Pagination Block to display pages  and pagination links !-->
	<div >
		<div id="container-1">
			<div class="search-background">
				<label><img src="ajax/loader.gif" alt="" /></label>
			</div>
			<div id="daycontent">
				&nbsp;
			</div>
		</div>
	</div>
<!-- End pagination block!-->

<!-- End Body !-->
