$(function() {
	// jquery-ui draggable
	$(".draggable").draggable();

	// gnuboard pops draggable
	$(".hd_pops").draggable();

	//var ip_mask = /\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/;
	var ip_mask = /^(1|2)?\d?\d([.](1|2)?\d?\d){3}$/;
	$("#current_connect .crt_name, .tbl_wrap tbody td.td_category").each(function(index){
		var ip = $(this).text();
		if (ip_mask.test(ip)) {
			$(this).html("<a href='https://db-ip.com/" + ip + "' target='_blank'>" + ip + "</a>");
			//$(this).html("<a href='http://en.utrace.de/?query=" + ip + "' target='_blank'>" + ip + "</a>");
		}
	});

	//https://www.newmediacampaigns.com/blog/lazyytjs-a-jquery-plugin-to-lazy-load-youtube-videos
	$('.js-lazyYT').lazyYT();
});

// https://appelsiini.net/projects/lazyload/
$("img.lazy").lazyload({
	threshold : 300
	, effect : "fadeIn"
});
