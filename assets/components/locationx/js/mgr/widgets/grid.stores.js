LocationX.grid.Stores = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		url: LocationX.config.connector_url,
		id: 'locationx-grid-stores',
		baseParams: {
            action: 'mgr/stores/getlist'
        },
        params: [],
        viewConfig: {
            forceFit: true,
            emptyText: _('locationx.error.noresults',{what: _('locationx.stores')})
        },
		fields: [
            {name: 'id', type: 'int'},
            {name: 'name', type: 'string'},
            {name: 'link', type: 'string'},
            {name: 'category', type: 'int'},
            {name: 'category_name', type: 'string'},
            {name: 'address1', type: 'string'},
            {name: 'address2', type: 'string'},
            {name: 'contactperson', type: 'string'},
            {name: 'phone', type: 'string'},
            {name: 'fax', type: 'string'},
            {name: 'email', type: 'string'},
            {name: 'city', type: 'string'},
            {name: 'state', type: 'string'},
            {name: 'zip', type: 'string'},
            {name: 'country', type: 'string'},
            {name: 'latitude', type: 'string'},
            {name: 'longitude', type: 'string'},
            {name: 'gmap_marker', type: 'int'},
            {name: 'gmap_marker_name', type: 'string'},
            {name: 'active', type: 'boolean'},
            {name: 'rank', type: 'int'},
            {name: 'createdon', type: 'date'},
            {name: 'updatedon', type: 'date'}
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
			width: .3
		},{
			header: _('locationx.link'),
			dataIndex: 'link',
			sortable: true,
			width: .2
		},{
			header: _('locationx.address1'),
			dataIndex: 'address1',
			sortable: true,
			width: .2,
            hidden: true
		},{
			header: _('locationx.address2'),
			dataIndex: 'address2',
			sortable: true,
			width: .2,
            hidden: true
		},{
			header: _('locationx.city'),
			dataIndex: 'city',
			sortable: true,
			width: .2
		},{
			header: _('locationx.state'),
			dataIndex: 'state',
			sortable: true,
			width: .15
		},{
			header: _('locationx.country'),
			dataIndex: 'country',
			sortable: true,
			width: .2
		},{
			header: _('locationx.category'),
			dataIndex: 'category_name',
		    sortable: true,
			width: .2
		},{
			header: _('locationx.active'),
			dataIndex: 'active',
		    sortable: true,
			width: .1,
            renderer: this.rendYesNo
		},{
			header: _('locationx.rank'),
			dataIndex: 'rank',
		    sortable: true,
			width: .1,
            hidden: true
		}],
        tbar: [{
            text: _('locationx.create', {what: _('locationx.store')}),
            handler: this.createStore,
            scope: this
        },'-',{
            text: _('locationx.import'),
            handler: this.importStores,
            scope: this
        },'->',{
            xtype: 'textfield',
            id: 'locationx-grid-stores-filter-query',
            emptyText: _('locationx.query'),
            listeners: {
                change: {fn: function(field, value) {
                    this.getStore().baseParams['query'] = value;
                    this.getBottomToolbar().changePage(1);
                }, scope: this},
                render: { fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER,
                        fn: function() {
                            this.fireEvent('change',this);
                            // lose & gain focus again so clicking outside field doesn't refresh grid again.
                            this.blur();
                            this.focus();
                            return true;
                        },
                        scope: cmp
                    });
                },scope: this}
            }
        },'-',{
            xtype: 'locationx-combo-categories',
            id: 'locationx-grid-stores-filter-categories',
            includeUncategorized: false,
            emptyText: _('locationx.filter',{what: _('locationx.category')}),
            listeners: {
                select: {fn: function(combo, record) {
                    this.getStore().baseParams['category'] = record.id;
                    this.getBottomToolbar().changePage(1);
                }, scope: this}
            }
        },'-',{
            text: _('locationx.clear_filter'),
            handler: function() {
                Ext.getCmp('locationx-grid-stores-filter-categories').setValue();
                Ext.getCmp('locationx-grid-stores-filter-query').setValue();
                this.getStore().baseParams['category'] = 0;
                this.getStore().baseParams['query'] = '';
                this.getBottomToolbar().changePage(1);
            },
            scope: this
        }]
    });
    LocationX.grid.Stores.superclass.constructor.call(this,config);
};
Ext.extend(LocationX.grid.Stores,MODx.grid.Grid,{
    getMenu: function() {
        var r = this.getSelectionModel().getSelected();
        var d = r.data;

        var m = [];
        if (!d.active) {
            m.push({
                text: _('locationx.activate', {what: _('locationx.store')}),
                handler: this.activateStore,
                scope: this
            });
        } else {
            m.push({
                text: _('locationx.deactivate', {what: _('locationx.store')}),
                handler: this.deactivateStore,
                scope: this
            });
        }
        m.push('-',{
            text: _('locationx.update', {what: _('locationx.store')}),
            handler: this.updateStore,
            scope: this
        },{
            text: _('locationx.duplicate', {what: _('locationx.store')}),
            handler: this.duplicateStore,
            scope: this
        },'-',{
            text: _('locationx.remove', {what: _('locationx.store')}),
            handler: this.removeStore,
            scope: this
        });
        return m;
    },

    createStore: function() {
        var win = MODx.load({
            xtype: 'locationx-window-store',
            mode: 'create'
        });
        win.show();
    },

    importStores: function() {
        var win = MODx.load({
            xtype: 'locationx-window-import'
        });
        win.show();
    },

    updateStore: function() {
        var record = this.menu.record;
        var win = MODx.load({
            xtype: 'locationx-window-store',
            mode: 'update',
            record: record
        });
        win.setValues(record);
        win.show();
    },

    duplicateStore: function() {
        var record = this.menu.record;
        /* Unset the ID to prevent overwriting the other one */
        record['id'] = '';
        var win = MODx.load({
            xtype: 'locationx-window-store',
            mode: 'create',
            record: record
        });
        win.setValues(record);
        win.show();
    },

    removeStore: function() {
        MODx.msg.confirm({
            title: _('locationx.remove',{what: _('locationx.store')}),
            text: _('locationx.remove.store.confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/stores/remove',
                id: this.menu.record.id
            },
            listeners: {
                success: {fn:this.refresh,scope: this}
            }
        });
    },

    activateStore: function() {
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/stores/activate',
                id: this.menu.record.id
            },
            listeners: {
                success: {fn:this.refresh,scope: this}
            }
        });
    },

    deactivateStore: function() {
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/stores/deactivate',
                id: this.menu.record.id
            },
            listeners: {
                success: {fn:this.refresh,scope: this}
            }
        });
    }
});
Ext.reg('locationx-grid-stores',LocationX.grid.Stores);
