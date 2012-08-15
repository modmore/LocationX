
Ext.onReady(function() {
    Ext.QuickTips.init();
    MODx.load({ xtype: 'locationx-page-index', renderTo: 'locationx'});
});

/*
Index page configuration.
 */
LocationX.page.Index = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        cls: 'container',
        components: [{
            xtype: 'panel',
            html: '<h2>'+_('locationx')+'</h2>',
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
                title: _('locationx.stores'),
                items: [{
                    xtype: 'locationx-grid-stores',
                    border: false
                }]
            },{
                title: _('locationx.markers'),
                items: [{
                    xtype: 'locationx-grid-markers',
                    border: false
                }]
            },{
                title: _('locationx.categories'),
                items: [{
                    xtype: 'locationx-grid-categories',
                    border: false
                }]
            }]
        }]
    });
    LocationX.page.Index.superclass.constructor.call(this,config);
};
Ext.extend(LocationX.page.Index,MODx.Component);
Ext.reg('locationx-page-index',LocationX.page.Index);
