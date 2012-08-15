StoresX.combo.Categories = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        tpl: new Ext.XTemplate('<tpl for="."><div class="x-combo-list-item">{name}</div></tpl>'),
        displayField: 'name',
        valueField: 'id',
        hiddenName: config.name,
        fields: ['id','name'],
        url: StoresX.config.connector_url,
        baseParams: {
            action: 'mgr/categories/getlist',
            combo: true,
            include_uncategorized: config.includeUncategorized || true
        },
        pageSize: 20
    });
    StoresX.combo.Categories.superclass.constructor.call(this,config);
};
Ext.extend(StoresX.combo.Categories,MODx.combo.ComboBox);
Ext.reg('storesx-combo-categories',StoresX.combo.Categories);
