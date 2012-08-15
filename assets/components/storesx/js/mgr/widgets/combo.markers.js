StoresX.combo.Markers = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        tpl: new Ext.XTemplate('<tpl for="."><div class="x-combo-list-item"><img src="{image}" style="width: 20px; height: 20px; float: left; margin-right: 5px;"/> {name}</div></tpl>'),
        displayField: 'name',
        valueField: 'id',
        hiddenName: config.name,
        fields: ['id','name','image'],
        url: StoresX.config.connector_url,
        baseParams: {
            action: 'mgr/markers/getlist',
            combo: true
        },
        pageSize: 20
    });
    StoresX.combo.Markers.superclass.constructor.call(this,config);
};
Ext.extend(StoresX.combo.Markers,MODx.combo.ComboBox);
Ext.reg('storesx-combo-markers',StoresX.combo.Markers);
