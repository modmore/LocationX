StoresX.window.Marker = function(config) {
    config = config || {};
    this.id = config.id = config.id || Ext.id();
    Ext.applyIf(config,{
        title: (config.mode && config.mode == 'create') ? _('storesx.create',{what: _('storesx.marker')}) : _('storesx.update',{what: _('storesx.marker')}),
        url: StoresX.config.connector_url,
        width: 400,
        baseParams: {
            action: (config.mode && config.mode == 'create') ? 'mgr/markers/create' : 'mgr/markers/update'
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
            xtype: 'modx-combo-browser',
            name: 'image',
            fieldLabel: _('storesx.image'),
            allowBlank: false,
            maxLength: 150,
            anchor: '100%'
        },{
            xtype: 'modx-combo-browser',
            name: 'shadow',
            fieldLabel: _('storesx.shadow'),
            allowBlank: true,
            maxLength: 150,
            anchor: '100%'
        },{
            xtype: 'textfield',
            name: 'size',
            fieldLabel: _('storesx.size'),
            allowBlank: true,
            maxLength: 20,
            anchor: '100%'
        },{
            xtype: 'textfield',
            name: 'origin',
            fieldLabel: _('storesx.origin'),
            allowBlank: true,
            maxLength: 20,
            anchor: '100%'
        },{
            xtype: 'checkbox',
            name: 'flat',
            boxLabel: _('storesx.flat'),
            anchor: '100%'
        }],
        listeners: {
            success: function() {
                Ext.getCmp('storesx-grid-markers').refresh();
            }
        }
    });
    StoresX.window.Marker.superclass.constructor.call(this,config);
};
Ext.extend(StoresX.window.Marker,MODx.Window,{

});
Ext.reg('storesx-window-marker',StoresX.window.Marker);
