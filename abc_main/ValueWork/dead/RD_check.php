<?php

//若是先研發NB，disabled所有Tablet產品的inputs，隱藏產品Tablet的tfoot
	//A在判定為研發過時已隱藏tfoot
if($rd_rowA!=0 || $rd_rowB!=0){
	 if($year==$rdA['year'] && $month==$rdA['month']){ 			   
	?>	
				document.getElementById("tab2").style.opacity=0.5;
				document.getElementById("tabp_pnum_A").disabled=true;
				document.getElementById("tabc_pnum_A").disabled=true;
					
				document.getElementById("tabp_pnum_B").disabled=true;
				document.getElementById("tabc_pnum_B").disabled=true;
					
				document.getElementById("tabp_pnum_C").disabled=true;
				document.getElementById("tabc_pnum_C").disabled=true;
				$('.tfoot2').hide();     
	<?php
				$state="* 單月內只允許研發一項產品，本月已研發過<font color=#000>筆記型電腦</font> *";
	//若是本月研發B，disabled所有A產品的inputs，隱藏產品A的tfoot
	//B在判定為研發過時已隱藏tfoot
	}else if($year==$rdB['year'] && $month==$rdB['month']){
	?>	
				document.getElementById("tab1").style.opacity=0.5;
				document.getElementById("lapp_pnum_A").disabled=true;
				document.getElementById("lapc_pnum_A").disabled=true;
				document.getElementById("lapk_pnum_A").disabled=true;
					
				document.getElementById("lapp_pnum_B").disabled=true;
				document.getElementById("lapc_pnum_B").disabled=true;
				document.getElementById("lapk_pnum_B").disabled=true;
					
				document.getElementById("lapp_pnum_C").disabled=true;
				document.getElementById("lapc_pnum_C").disabled=true;
				document.getElementById("lapk_pnum_C").disabled=true;
				$('.tfoot1').hide();     
	<?php
				$state="* 單月內只允許研發一項產品，本月已研發過<font color=#000>平板電腦 </font>*";
	}
}//end if(有研發過)








$(document).ready(function(){
                $('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});


});//end ready(func)

?>