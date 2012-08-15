LocationX.grid.Categories = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		url: LocationX.config.connector_url,
		id: 'locationx-grid-categories',
		baseParams: {
            action: 'mgr/categories/getlist'
        },
        params: [],
        viewConfig: {
            forceFit: true,
            emptyText: _('locationx.error.noresults',{what: _('locationx.categories')})
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
			header: _('locationx.name'),
			dataIndex: 'name',
		    sortable: true,
			width: 1.2
		},{
			header: _('locationx.visible'),
			dataIndex: 'visible',
			sortable: true,
			width: .2,
            renderer: this.rendYesNo
		}],
        tbar: [{
            text: _('locationx.create', {what: _('locationx.category')}),
            handler: this.createCategory,
            scope: this
        }]
    });
    LocationX.grid.Categories.superclass.constructor.call(this,config);
};
Ext.extend(LocationX.grid.Categories,MODx.grid.Grid,{
    getMenu: function() {
        var m = [];
        m.push({
            text: _('locationx.update', {what: _('locationx.category')}),
            handler: this.updateCategory,
            scope: this
        },{
            text: _('locationx.duplicate', {what: _('locationx.category')}),
            handler: this.duplicateCategory,
            scope: this
        },'-',{
            text: _('locationx.remove', {what: _('locationx.category')}),
            handler: this.removeCategory,
            scope: this
        });
        return m;
    },

    createCategory: function() {
        var win = MODx.load({
            xtype: 'locationx-window-category',
            mode: 'create'
        });
        win.show();
    },

    updateCategory: function() {
        var record = this.menu.record;
        var win = MODx.load({
            xtype: 'locationx-window-category',
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
            xtype: 'locationx-window-category',
            mode: 'create',
            record: record
        });
        win.setValues(record);
        win.show();
    },

    removeCategory: function() {
        MODx.msg.confirm({
            title: _('locationx.remove',{what: _('locationx.category')}),
            text: _('locationx.remove.category.confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/categories/remove',
                id: this.menu.record.id
            },
            listeners: {
                success: {fn: function() {
                    this.refresh();
                    Ext.getCmp('locationx-grid-stores').refresh();
                },scope: this}
            }
        });
    }
});
Ext.reg('locationx-grid-categories',LocationX.grid.Categories);
