
Ext.onReady(function() {
    Ext.QuickTips.init();
    MODx.load({ xtype: 'storesx-page-index'});
});

/*
Index page configuration.
 */
StoresX.page.Index = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        renderTo: 'storesx',
        components: [{
            xtype: 'storesx-panel-header'
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
                title: _('storesx.estates'),
                items: [{
                    xtype: 'storesx-grid-estates',
                    border: false
                }]
            },{
                title: _('storesx.listings'),
                items: [{
                    xtype: 'storesx-grid-listings',
                    border: false
                }]
            }]
        }]
    });
    StoresX.page.Index.superclass.constructor.call(this,config);
};
Ext.extend(StoresX.page.Index,MODx.Component);
Ext.reg('storesx-page-index',StoresX.page.Index);

/*
Index page header configuration.
 */
StoresX.panel.Header = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2>'+_('storesx')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        }]
    });
    StoresX.panel.Header.superclass.constructor.call(this,config);
};
Ext.extend(StoresX.panel.Header,MODx.Panel);
Ext.reg('storesx-panel-header',StoresX.panel.Header);
