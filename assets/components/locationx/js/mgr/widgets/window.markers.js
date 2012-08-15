LocationX.window.Marker = function(config) {
    config = config || {};
    this.id = config.id = config.id || Ext.id();
    Ext.applyIf(config,{
        title: (config.mode && config.mode == 'create') ? _('locationx.create',{what: _('locationx.marker')}) : _('locationx.update',{what: _('locationx.marker')}),
        url: LocationX.config.connector_url,
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
            fieldLabel: _('locationx.name'),
            allowBlank: false,
            maxLength: 150,
            anchor: '100%'
        },{
            xtype: 'modx-combo-browser',
            name: 'image',
            fieldLabel: _('locationx.image'),
            allowBlank: false,
            maxLength: 150,
            anchor: '100%'
        },{
            xtype: 'modx-combo-browser',
            name: 'shadow',
            fieldLabel: _('locationx.shadow'),
            allowBlank: true,
            maxLength: 150,
            anchor: '100%'
        },{
            xtype: 'textfield',
            name: 'size',
            fieldLabel: _('locationx.size'),
            allowBlank: true,
            maxLength: 20,
            anchor: '100%'
        },{
            xtype: 'textfield',
            name: 'origin',
            fieldLabel: _('locationx.origin'),
            allowBlank: true,
            maxLength: 20,
            anchor: '100%'
        },{
            xtype: 'checkbox',
            name: 'flat',
            boxLabel: _('locationx.flat'),
            anchor: '100%'
        }],
        listeners: {
            success: function() {
                Ext.getCmp('locationx-grid-markers').refresh();
            }
        }
    });
    LocationX.window.Marker.superclass.constructor.call(this,config);
};
Ext.extend(LocationX.window.Marker,MODx.Window,{

});
Ext.reg('locationx-window-marker',LocationX.window.Marker);
