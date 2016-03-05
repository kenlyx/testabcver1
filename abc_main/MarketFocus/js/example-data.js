Ext.require(['Ext.data.*']);

Ext.onReady(function() {
    com_data=new Array();
    window.generateData = function(n, floor){
        var data = [],
            p = (Math.random() *  11) + 1,
            i;
            $.ajax({
                url:"market_share.php",
                type:'GET',
                data: { type:'company_data'},
                error: function(xhr) {alert('Ajax request 發生錯誤');},
                success: function(str){ com_data=str.split(";");
                }
            });
            //floor = (!floor && floor !== 0)? 20 : floor;
            for (i = 0; i < n ; i++) {
                sub_data=com_data[i].split(",");
                //alert(com_data[i]);
                if(floor==1)
                    data.push({name: sub_data[0],data1: Math.max(sub_data[1], 1)});
                if(floor==2)
                    data.push({name: sub_data[0],data1: Math.max(sub_data[2], 1)});
            }
            return data;
    };


    window.store1 = Ext.create('Ext.data.JsonStore', {
        fields: ['name', 'data1', 'data2', 'data3', 'data4', 'data5', 'data6', 'data7', 'data8', 'data9'],
        data: generateData()
    });
    window.storeNegatives = Ext.create('Ext.data.JsonStore', {
        fields: ['name', 'data1', 'data2', 'data3', 'data4', 'data5', 'data6', 'data7', 'data9', 'data9'],
        data: generateDataNegative()
    });
//    window.store3 = Ext.create('Ext.data.JsonStore', {
//        fields: ['name', 'data1', 'data2', 'data3', 'data4', 'data5', 'data6', 'data7', 'data9', 'data9'],
//        data: generateData()
//    });
//    window.store4 = Ext.create('Ext.data.JsonStore', {
//        fields: ['name', 'data1', 'data2', 'data3', 'data4', 'data5', 'data6', 'data7', 'data9', 'data9'],
//        data: generateData()
//    });
//    window.store5 = Ext.create('Ext.data.JsonStore', {
//        fields: ['name', 'data1', 'data2', 'data3', 'data4', 'data5', 'data6', 'data7', 'data9', 'data9'],
//        data: generateData()
//    });


});