$(function(){var e=$("#cd_container").children(".cd_album"),s=e.length,h=$("#cd_navigation"),k=h.children(".cd_prev").hide(),l=h.children(".cd_next").hide(),f=e.eq(0),m=$("#cd_background"),n=m.children(".cd_loading"),p=$("#jp-audio"),q=$.browser.msie&&9>$.browser.version.substr(0,1);(function(){var h=function(){return $.Deferred(function(a){var b=[];e.each(function(a){a=$(this).data("bgimg");var c=a.replace("images","thumbs");b.push(a);b.push(c)});for(var d=b.length,g=0,c=0;c<d;++c)$("<img/>").load(function(){++g;
g===d&&a.resolve()}).attr("src",b[c])}).promise()},u=function(){e.find("h1:first").bind("click",function(){var a=$(this);if(a.data("opened"))return!1;var b=a.parent();t(b);a.data("opened",!0);return!1});l.bind("click",function(){r(1);return!1});k.bind("click",function(){r(0);return!1})},r=function(a){if(f.is(":animated"))return!1;var b={opacity:0};q||(b.rotate=a?"360deg":"-360deg",f.stop().animate(b,1E3,function(){$(this).transform({rotate:"0deg"}).css("opacity",1).hide()}));b=a?f.next():f.prev();
0===b.length&&(b=a?e.eq(0):e.eq(s-1));b.fadeIn(1E3,function(){f=$(this)});q&&f.fadeOut(1E3)},t=function(a){var b=a.find(".cd_back"),d=a.find(".cd_content"),g=a.find(".cd_content_inner"),c=a.find("h1:first"),e=a.find("div.cd_playlist > ul");f=a;c.stop().animate({left:-(c.width()+50)+"px"},400);a.removeClass("cd_album_"+(a.index()+1));d.show();g.jScrollPane({verticalDragMinHeight:40,verticalDragMaxHeight:40});k.hide();l.hide();g=a.data("bgimg");v(g);var h=w(e);b.show().unbind("click").bind("click",
function(g){c.stop().animate({left:"10px"},400);b.hide();p.hide();a.addClass("cd_album_"+(a.index()+1));d.hide();k.show();l.show();x();h.playlistDestroy();c.data("opened",!1);return!1})},v=function(a){a=$('<img src="'+a+'" alt="Background" class="cd_bgimage" style="display:none;"/>');m.prepend(a);a.fadeIn(700)},x=function(){m.find("img").fadeOut(700,function(){$(this).remove()})},w=function(a){var b=[];a.children("li").each(function(a){var c=$(this);a=c.html();var d=c.data("mp3"),c=c.data("oga");
b.push({name:a,mp3:d,oga:c})});p.show();var d=new Playlist(b,{ready:function(){d.displayPlaylist();d.playlistInit(!0)},ended:function(){d.playlistNext()},play:function(){$(this).jPlayer("pauseOthers")},swfPath:"js/jPlayer",supplied:"mp3, oga",solution:"html, flash"});return d};return{init:function(){n.show();$.when(h()).done(function(){n.hide();k.show();l.show();f.show();u()})}}})().init()});