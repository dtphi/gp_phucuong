/*/////////////HOW TO USE////////////////////
    Fix for IE
        IE7:  .ie7 cssname{...}
        IE8:  .ie8 cssname{...}
        IE9:  .ie9 cssname{...}
        IE10: .ie10 cssname{...}
        IE11: .ie11 cssname{...}
        IE:   .ie cssname{...}
    Fix for Safari: .safari cssname{...}
    Fix for Chrome: .chrome cssname{...}
    Fix for Firefox
        .firefox cssname{...}
        .gecko cssname{...}
///////////////////////////////////////////*/

export function detect_browser(u){
	var ua=u.toLowerCase(),
	isIE11 = !!navigator.userAgent.match(/Trident.*rv\:11\./),
	
	is=function(t){
		return ua.indexOf(t)>-1
	},
	
	g='gecko',
	w='webkit',
	s='safari',
	o='opera',
	
	arrClass=[
		(!(/opera|webtv/i.test(ua))&&/msie\s(\d)/.test(ua))?('ie ie'+(!(RegExp.$1 == 1)?RegExp.$1:10)):
		is('gecko/')?g+' firefox':
		is('opera')?o+(/version\/(\d+)/.test(ua)?' '+o+RegExp.$1:(/opera(\s|\/)(\d+)/.test(ua)?' '+o+RegExp.$2:'')):		
		is('chrome')?w+' chrome':
		is('applewebkit/')?w+' '+s+(/version\/(\d+)/.test(ua)?' '+s+RegExp.$1:''):
		is('mozilla/')?((isIE11==true)?('ie ie11'):g):''		
	], 
		
	c = arrClass.join(' ');
	document.documentElement.className += ' '+c;
	return c;
};
		
detect_browser(navigator.userAgent);