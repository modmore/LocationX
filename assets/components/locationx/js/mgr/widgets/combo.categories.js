LocationX.combo.Categories = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        tpl: new Ext.XTemplate('<tpl for="."><div class="x-combo-list-item">{name}</div></tpl>'),
        displayField: 'name',
        valueField: 'id',
        hiddenName: config.name,
        fields: ['id','name'],
        url: LocationX.config.connector_url,
        baseParams: {
            action: 'mgr/categories/getlist',
            combo: true,
            include_uncategorized: config.includeUncategorized || true
        },
        pageSize: 20
    });
    LocationX.combo.Categories.superclass.constructor.call(this,config);
};
Ext.extend(LocationX.combo.Categories,MODx.combo.ComboBox);
Ext.reg('locationx-combo-categories',LocationX.combo.Categories);
