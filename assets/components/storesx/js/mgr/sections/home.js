
Ext.onReady(function() {
    Ext.QuickTips.init();
    MODx.load({ xtype: 'storesx-page-index', renderTo: 'storesx'});
});

/*
Index page configuration.
 */
StoresX.page.Index = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        cls: 'container',
        components: [{
            xtype: 'panel',
            html: '<h2>'+_('storesx')+'</h2>',
            border: false,
            cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs',
            width: '98%',
            bodyStyle: 'padding: 10px 10px 10px 10px;',
            border: true,
            defaults: {
                border: false,
                autoHeight: true,
                bodyStyle: 'padding: 5px 8px 5px 5px;'
            },
            items: [{
                title: _('storesx.stores'),
                items: [{
                    xtype: 'storesx-grid-stores',
                    border: false
                }]
            },{
                title: _('storesx.markers'),
                items: [{
                    xtype: 'storesx-grid-markers',
                    border: false
                }]
            },{
                title: _('storesx.categories'),
                items: [{
                    xtype: 'storesx-grid-categories',
                    border: false
                }]
            }]
        }]
    });
    StoresX.page.Index.superclass.constructor.call(this,config);
};
Ext.extend(StoresX.page.Index,MODx.Component);
Ext.reg('storesx-page-index',StoresX.page.Index);
