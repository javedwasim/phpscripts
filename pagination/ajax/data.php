<?php
	require_once("../scripts/functions.php");
	$functs = new Functs();
	$total_rows = $functs->RowPaginationTotalSubCategoriePage($subcat=0); // Number of rows in the table database

	$total = $total_rows['total']; 

	$per_page = 8;  // Number of rows per page ( 8 rows will be displayed per page in this case)

	$pages = ceil($total/$per_page);

	if(isset($_GET['page'])){
		$page1 = intval($_GET['page']);
		if($page1>$pages){
			$page1 = $pages;
		}
	}else{
		$page1 = 1;
	}

	$start = ($page1-1)*8;


	$rsd = $functs->RowSubCategoriePaginationAjaxQuery($start,$per_page);
	if(empty($rsd)){
		
		echo ' No Rows to display ! ';
	}
	else{
		
		while ($row = mysql_fetch_assoc($rsd)){ 
		
			$seotilite=$functs->TitleFiled($row['post_title']);
		?>
			<div >
				<article>
				<!--
					<figure>
						<img src="<?=$url;?>/images/<?=$cat;?>/thumb/<?= $row['img_cols'];?>" alt="<?=$seotilite;?>">
					</figure>
				-->	
					<div>
						<span>
								<?= $row['post_title'];?>
						</span>
						<p><?= $row['post_title'];?></p>
						<a href="page-row-detail.php?id=<?=$row['id_cols'];?>" title="<?=$seotilite;?>">Read More</a>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</article>
				<div class="clear"></div>
			</div>
						
		<?php 					
		}
		?>
						
		<div id="paging_button" style="text-align:center;">
		<?php
			echo '<ul>';
			$pag=$functs->pagination($page1, $pages);
			echo $pag;
			echo '</ul>';
		?>                        
		</div>
			<?php			

	}
?>
 

<script type="text/javascript">
$(document).ready(function(){
	
	var Timer  = '';
	var selecter = 0;
	var Main =0;
	
	bring(selecter);
	
});

function bring ( selecter )
{	
	$('div.shopp:eq(' + selecter + ')').stop().animate({
		opacity  : '1.0',
		height: '60px'
		
	},300,function(){
		
		if(selecter < 6)
		{
			clearTimeout(Timer); 
		}
	});
	
	selecter++;
	var Func = function(){ bring(selecter); };
	Timer = setTimeout(Func, 20);
}

</script>