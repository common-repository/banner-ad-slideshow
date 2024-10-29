
jQuery(document).ready(function($) {
	var mygallery=new fadeSlideShow({
	wrapperid: "fadeshow1", 
	dimensions: ['100%', 480], 
	imagearray: php_var.var1,
	displaymode: {type:'auto', pause:2500, cycles:0, wraparound:false, randomize:false},
	persist: false, 
	fadeduration: 500, 
	descreveal: "always",
	togglerid: "fadeshow1toggler"
});
});
