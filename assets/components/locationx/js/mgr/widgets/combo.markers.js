LocationX.combo.Markers = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        tpl: new Ext.XTemplate('<tpl for="."><div class="x-combo-list-item"><img src="{image}" style="width: 20px; height: 20px; float: left; margin-right: 5px;"/> {name}</div></tpl>'),
        displayField: 'name',
        valueField: 'id',
        hiddenName: config.name,
        fields: ['id','name','image'],
        url: LocationX.config.connector_url,
        baseParams: {
            action: 'mgr/markers/getlist',
            combo: true
        },
        pageSize: 20
    });
    LocationX.combo.Markers.superclass.constructor.call(this,config);
};
Ext.extend(LocationX.combo.Markers,MODx.combo.ComboBox);
Ext.reg('locationx-combo-markers',LocationX.combo.Markers);
