/*

This file is part of Ext JS 4

Copyright (c) 2011 Sencha Inc

Contact:  http://www.sencha.com/contact

Commercial Usage
Licensees holding valid commercial licenses may use this file in accordance with the Commercial Software License Agreement provided with the Software or, alternatively, in accordance with the terms contained in a written agreement between you and Sencha.

If you are unsure which license is appropriate for your use, please contact the sales department at http://www.sencha.com/contact.

*/
Ext.require(['Ext.data.*']);

Ext.onReady(function() {

    window.generateData = function(){
		window.QQ = [];
                window.word=[];
                var ajax0=$.ajax({
			url:'GET_ee.php',
			type: 'GET',
            async:false,
			datatype: 'html',
			data: 'get',
			success: function(str){
                            if(str!='::')
                                window.word=str.split(':');
			}
		});
//                var der=$.when(ajax0);
//                der.done(initial);
        window.QQ.push(
                                {name: '財務',data1: parseInt(window.word[0],10)},
                                {name: '資源運籌',data1: parseInt(window.word[1],10)},
                                {name: '行銷與業務',data1: parseInt(window.word[2],10)},
                                {name: '行政',data1: parseInt(window.word[3],10)},
                                {name: '研發',data1: parseInt(window.word[4],10)}
                            );
                                return window.QQ;
    }
//    function initial(){
//            window.QQ.push(
//                                {name: '財務',data1: parseInt(window.word[0],10)},
//                                {name: '行銷',data1: parseInt(window.word[1],10)},
//                                {name: '資源運籌',data1: parseInt(window.word[2],10)},
//                                {name: '人力資源',data1: parseInt(window.word[3],10)},
//                                {name: '研發',data1: parseInt(window.word[4],10)}
//                            );
//                                alert(window.QQ[0].data1);
//    }
    window.store1 = Ext.create('Ext.data.JsonStore', {
        fields: ['name', 'data1'],
        data: generateData()
    });
});

