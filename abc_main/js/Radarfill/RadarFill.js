/*

This file is part of Ext JS 4

Copyright (c) 2011 Sencha Inc

Contact:  http://www.sencha.com/contact

Commercial Usage
Licensees holding valid commercial licenses may use this file in accordance with the Commercial Software License Agreement provided with the Software or, alternatively, in accordance with the terms contained in a written agreement between you and Sencha.

If you are unsure which license is appropriate for your use, please contact the sales department at http://www.sencha.com/contact.

*/
Ext.require('Ext.chart.*');
Ext.require(['Ext.Window', 'Ext.fx.target.Sprite', 'Ext.layout.container.Fit']);

Ext.onReady(function () {
    window.store1.loadData(generateData());
    var win = Ext.create('Ext.Window', {
		top:"1%",
        width: "96%",
        height: "94%",
        hidden: false,
        shadow: false,
        maximizable: false,
        style: 'overflow: hidden;',
        title: '人員效率評估',
        renderTo: Ext.getBody(),
        layout: 'fit',
        items: {
            id: 'chartCmp',
            xtype: 'chart',
            style: 'background:#fff',
            theme: 'Category2',
            insetPadding: 20,
            animate: true,
            store: store1,
            legend: {
                position: 'right'
            },
            axes: [{
                type: 'Radial',
                position: 'radial',
                label: {
                    display: true
                }
            }],
            series: [{
                showInLegend: false,
                type: 'radar',
                xField: 'name',
                yField: 'data1',
                style: {
                    opacity: 0.4
                }
            }]
        }
    });
});

