StoresX.window.Category = function(config) {
    config = config || {};
    this.id = config.id = config.id || Ext.id();
    Ext.applyIf(config,{
        title: (config.mode && config.mode == 'create') ? _('storesx.create',{what: _('storesx.category')}) : _('storesx.update',{what: _('storesx.category')}),
        url: StoresX.config.connector_url,
        width: 400,
        baseParams: {
            action: (config.mode && config.mode == 'create') ? 'mgr/categories/create' : 'mgr/categories/update'
        },
        fields: [{
            xtype: 'hidden',
            name: 'id'
        },{
            xtype: 'textfield',
            name: 'name',
            fieldLabel: _('storesx.name'),
            allowBlank: false,
            maxLength: 150,
            anchor: '100%'
        },{
            xtype: 'checkbox',
            name: 'visible',
            boxLabel: _('storesx.visible'),
            anchor: '100%'
        }],
        listeners: {
            success: function() {
                Ext.getCmp('storesx-grid-categories').refresh();
                Ext.getCmp('storesx-grid-stores').refresh();
            }
        }
    });
    StoresX.window.Category.superclass.constructor.call(this,config);
};
Ext.extend(StoresX.window.Category,MODx.Window);
Ext.reg('storesx-window-category',StoresX.window.Category);
