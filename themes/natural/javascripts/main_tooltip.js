/*
 * Tooltip script 
 * powered by jQuery (http://www.jquery.com)
 * 
 * written by Alen Grakalic (http://cssglobe.com)
 * 
 * for more info visit http://cssglobe.com/post/1695/easiest-tooltip-and-image-preview-using-jquery
 *
 */
 


this.tooltip = function(){	
	/* CONFIG */		
		xOffset = -12;
		yOffset = 20;		
		// these 2 variable determine popup's distance from the cursor
		// you might want to adjust to get the right result		
	/* END CONFIG */		
	jQuery("a.tooltip").hover(function(e){											  
		this.t = this.title;
		this.l = this.href;
		this.title = "";									  
		jQuery("body").append("<p id='tooltip'>"+ this.t +"<br /><span class='tooltip_link'>("+ this.l +")</span></p>");
		jQuery("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("medium");		
    },
	function(){
		this.title = this.t;
		this.href = this.l;		
		jQuery("#tooltip").remove();
    });	
	jQuery("a.tooltip").mousemove(function(e){
		jQuery("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});			
};



// starting the script on page load
jQuery(document).ready(function(){
	tooltip();
});