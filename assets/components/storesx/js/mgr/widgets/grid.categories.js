StoresX.grid.Categories = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		url: StoresX.config.connector_url,
		id: 'storesx-grid-categories',
		baseParams: {
            action: 'mgr/categories/getlist'
        },
        params: [],
        viewConfig: {
            forceFit: true,
            emptyText: _('storesx.error.noresults',{what: _('storesx.categories')})
        },
		fields: [
            {name: 'id', type: 'int'},
            {name: 'name', type: 'string'},
            {name: 'visible', type: 'bool'}
        ],
        paging: true,
		remoteSort: true,
		columns: [{
			header: _('id'),
			dataIndex: 'id',
			sortable: true,
			width: .075
		},{
			header: _('storesx.name'),
			dataIndex: 'name',
		    sortable: true,
			width: 1.2
		},{
			header: _('storesx.visible'),
			dataIndex: 'visible',
			sortable: true,
			width: .2,
            renderer: this.rendYesNo
		}],
        tbar: [{
            text: _('storesx.create', {what: _('storesx.category')}),
            handler: this.createCategory,
            scope: this
        }]
    });
    StoresX.grid.Categories.superclass.constructor.call(this,config);
};
Ext.extend(StoresX.grid.Categories,MODx.grid.Grid,{
    getMenu: function() {
        var m = [];
        m.push({
            text: _('storesx.update', {what: _('storesx.category')}),
            handler: this.updateCategory,
            scope: this
        },{
            text: _('storesx.duplicate', {what: _('storesx.category')}),
            handler: this.duplicateCategory,
            scope: this
        },'-',{
            text: _('storesx.remove', {what: _('storesx.category')}),
            handler: this.removeCategory,
            scope: this
        });
        return m;
    },

    createCategory: function() {
        var win = MODx.load({
            xtype: 'storesx-window-category',
            mode: 'create'
        });
        win.show();
    },

    updateCategory: function() {
        var record = this.menu.record;
        var win = MODx.load({
            xtype: 'storesx-window-category',
            mode: 'update',
            record: record
        });
        win.setValues(record);
        win.show();
    },

    duplicateCategory: function() {
        var record = this.menu.record;
        /* Unset the ID to prevent overwriting the other one */
        record['id'] = '';
        var win = MODx.load({
            xtype: 'storesx-window-category',
            mode: 'create',
            record: record
        });
        win.setValues(record);
        win.show();
    },

    removeCategory: function() {
        MODx.msg.confirm({
            title: _('storesx.remove',{what: _('storesx.category')}),
            text: _('storesx.remove.category.confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/categories/remove',
                id: this.menu.record.id
            },
            listeners: {
                success: {fn: function() {
                    this.refresh();
                    Ext.getCmp('storesx-grid-stores').refresh();
                },scope: this}
            }
        });
    }
});
Ext.reg('storesx-grid-categories',StoresX.grid.Categories);
