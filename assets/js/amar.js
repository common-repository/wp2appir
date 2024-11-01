jQuery(document).ready(function(){	
	jQuery.ajax({ 
	       url: ajaxurl,
	               data: {
	                           action: "get_amar",
	                           "str" : "4"
               	        },
               	    success:function(data) {
               	    data = data.substring(0,data.length -1);
               	    var result = data.split('_');
               	    jQuery("#all_con").html(result[0]);
               	    jQuery("#yekam_all").html(result[1]);
               	    jQuery("#all_ip").html(result[2]);
               	    }
           	    });
});

function get_amar(id){
	if(id=="1") str="DAY";
	if(id=="2") str="WEEK";
	if(id=="3") str="MONTH";
	if(id=="4") str="4";
	jQuery.ajax({
	        url: ajaxurl,
	             data: {
	                    action: "get_amar",
	                    "str" : str
	                    },
	             success:function(data) {
	                    data = data.substring(0,data.length -1);
	                    var result = data.split('_');
	                    jQuery("#all_con").html(result[0]);
	                    jQuery("#yekam_all").html(result[1]);
	                    jQuery("#all_ip").html(result[2]);
	                }
	            }); 
}