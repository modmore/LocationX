LocationX.window.Category = function(config) {
    config = config || {};
    this.id = config.id = config.id || Ext.id();
    Ext.applyIf(config,{
        title: (config.mode && config.mode == 'create') ? _('locationx.create',{what: _('locationx.category')}) : _('locationx.update',{what: _('locationx.category')}),
        url: LocationX.config.connector_url,
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
            fieldLabel: _('locationx.name'),
            allowBlank: false,
            maxLength: 150,
            anchor: '100%'
        },{
            xtype: 'checkbox',
            name: 'visible',
            boxLabel: _('locationx.visible'),
            anchor: '100%'
        }],
        listeners: {
            success: function() {
                Ext.getCmp('locationx-grid-categories').refresh();
                Ext.getCmp('locationx-grid-stores').refresh();
            }
        }
    });
    LocationX.window.Category.superclass.constructor.call(this,config);
};
Ext.extend(LocationX.window.Category,MODx.Window);
Ext.reg('locationx-window-category',LocationX.window.Category);
