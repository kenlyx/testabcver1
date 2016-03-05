/**
 * 投票插件 for jQuery
 *
 * @author		zhoufan <happyeddie@gmail.com>
 * @website		http://www.raychou.com/demo/jquery-rater/
 * @version		1.0
 * @charset		UTF-8
 * @license		2009 raychou.com
 */

jQuery.fn.rater = function(tag,url, options , callback)
{
	// 默认设置
	var settings = {
		url			: url ,
		start		: 1,
		step		: 1 ,
		maxvalue	: 3 ,
		curvalue	: 0 ,
		//title		: null ,
		enabled		: true
	};
	
	if(options) { jQuery.extend(settings, options); };
	jQuery.extend(settings, {cancel: (settings.maxvalue > 1) ? true : false});
	
	var container = jQuery(this);
	jQuery.extend(container, { averageRating: settings.curvalue, url: settings.url });

	var starWidth	= 25;
	var raterWidth	= (settings.maxvalue - settings.start + settings.step)/settings.step * starWidth;
	var curvalueWidth	= (settings.curvalue - settings.start + settings.step)/settings.step * starWidth;
	
	var title	= '';
	if (typeof settings.title == 'object' && typeof settings.title[settings.curvalue] == 'string') {
		title	= settings.title[settings.curvalue];
	} else {
		title	= settings.curvalue+'/'+settings.maxvalue;
	}
	
	var ratingParent	= '<ul class="rating" style="width:'+raterWidth+'px" title="'+title+'">';
	container.html(ratingParent);
	
	var listItems	= '<li class="current" style="width:'+curvalueWidth+'px"></li>';
	
	if (settings.enabled){
		var k = 0;
		for (var i = settings.start;i <= settings.maxvalue;i = i + settings.step) {
			k++;
			if (typeof settings.title == 'object' && typeof settings.title[i] == 'string') {
				title	= settings.title[i];
			} else {
				//title	= i+'/'+settings.maxvalue;
				
				if(settings.maxvalue!=3)
				{
				title	= i;
				}
				else
				{
					if( i == 1)
					{ title = '小';}
					else if (i==2)
					{title = '中';}
					else
					{title = '大';}
				}
			}
			
			listItems	+= '<li class="star" style="width:'+(k * starWidth)+'px;z-index:'+((settings.maxvalue - i)  / settings.step + 1)+'" title="'+title+'"></li>';
			
		}
	}
	//alert(listItems);
	container.find('.rating').html(listItems);
	container.find('.rating').find('.star').hover(function() {
		container.find('.rating').find('.current').hide();
		this.className	= 'star_hover';
	} , function() {
		container.find('.rating').find('.current').show();
		this.className	= 'star';
	});
	
	container.find('.rating').find('.star').click(function() {
		// 从z-index属性中取得当前是第几颗star
		var value	= settings.maxvalue - $(this).css('z-index') + 1;
		//var value	= $(this).attr('title');
		container.find('.rating').find('.current').width((value - settings.start + settings.step)/settings.step * starWidth);
		//alert(tag);
		//以下研發頁面專用
		if (url&&tag=='stara1') {
			
			$.post(url , {valuea1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='stara2') {
			
			$.post(url , {valuea2:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='stara3') {
			
			$.post(url , {valuea3:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}if (url&&tag=='starb1') {
			
			$.post(url , {valueb1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='starb2') {
			
			$.post(url , {valueb2:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='starb3') {
			
			$.post(url , {valueb3:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}if (url&&tag=='starc1') {
			
			$.post(url , {valuec1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='starc2') {
			
			$.post(url , {valuec2:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='starc3') {
			
			$.post(url , {valuec3:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		//以上研發頁面專用
		//以下行銷頁面專用
		if (url&&tag=='mstarA1') {
			
			$.post(url , {mstarA1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='mstarA2') {
			
			$.post(url , {mstarA2:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='mstarB1') {
			
			$.post(url , {mstarB1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='mstarB2') {
			
			$.post(url , {mstarB2:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='mstarC1') {
			
			$.post(url , {mstarC1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='mstarC2') {
			
			$.post(url , {mstarC2:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		//以上行銷頁面專用
		
		//以下維修頁面專用
		if (url&&tag=='fstarA1') {
			
			$.post(url , {fstarA1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='fstarA2') {
			
			$.post(url , {fstarA2:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='fstarB1') {
			
			$.post(url , {fstarB1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='fstarB2') {
			
			$.post(url , {fstarB2:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='fstarC1') {
			
			$.post(url , {fstarC1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='fstarC2') {
			
			$.post(url , {fstarC2:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		//以上維修頁面專用
		
		//以下服務頁面專用
		if (url&&tag=='sstarA1') {
			
			$.post(url , {sstarA1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='sstarA2') {
			
			$.post(url , {sstarA2:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='sstarB1') {
			
			$.post(url , {sstarB1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='sstarB2') {
			
			$.post(url , {sstarB2:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='sstarC1') {
			
			$.post(url , {sstarC1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='sstarC2') {
			
			$.post(url , {sstarC2:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		//以上服務頁面專用
		
		//以下財務頁面專用
		if (url&&tag=='scmstar1') {
			
			$.post(url , {scmstar1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='scmstar2') {
			
			$.post(url , {scmstar2:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='scmstar3') {
			
			$.post(url , {scmstar3:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		
		//以上財務頁面專用
		
		//以下人資頁面專用
		if (url&&tag=='devstar1') {
			
			$.post(url , {devstar1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='marstar1') {
			
			$.post(url , {marstar1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='resstar1') {
			
			$.post(url , {resstar1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		if (url&&tag=='routinestar1') {
			
			$.post(url , {routinestar1:value} , function(response) {
				if (typeof callback == 'function') {
					callback(container , value , response);	
				}
			});
			return;
		}
		//以上人資頁面專用
		
		if (typeof callback == 'function') {
			callback(container , value);
			return ;
		}
		
	});
}