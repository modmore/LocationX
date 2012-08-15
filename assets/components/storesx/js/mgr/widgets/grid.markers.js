StoresX.grid.Markers = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		url: StoresX.config.connector_url,
		id: 'storesx-grid-markers',
		baseParams: {
            action: 'mgr/markers/getlist'
        },
        params: [],
        viewConfig: {
            forceFit: true,
            emptyText: _('storesx.error.noresults',{what: _('storesx.markers')})
        },
		fields: [
            {name: 'id', type: 'int'},
            {name: 'name', type: 'string'},
            {name: 'image', type: 'string'},
            {name: 'shadow', type: 'string'},
            {name: 'size', type: 'string'},
            {name: 'origin', type: 'string'},
            {name: 'flat', type: 'bool'}
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
			width: .3
		},{
			header: _('storesx.image'),
			dataIndex: 'image',
			sortable: true,
			width: .2,
            renderer: this.renderImage
		},{
			header: _('storesx.shadow'),
			dataIndex: 'shadow',
			sortable: true,
			width: .2,
            renderer: this.renderImage
		},{
			header: _('storesx.size'),
			dataIndex: 'size',
			sortable: true,
			width: .2
		},{
			header: _('storesx.origin'),
			dataIndex: 'origin',
			sortable: true,
			width: .2
		},{
			header: _('storesx.flat'),
			dataIndex: 'flat',
			sortable: true,
			width: .2,
            renderer: this.rendYesNo
		}],
        tbar: [{
            text: _('storesx.create', {what: _('storesx.marker')}),
            handler: this.createMarker,
            scope: this
        }]
    });
    StoresX.grid.Markers.superclass.constructor.call(this,config);
};
Ext.extend(StoresX.grid.Markers,MODx.grid.Grid,{
    getMenu: function() {
        var m = [];
        m.push({
            text: _('storesx.update', {what: _('storesx.marker')}),
            handler: this.updateMarker,
            scope: this
        },{
            text: _('storesx.duplicate', {what: _('storesx.marker')}),
            handler: this.duplicateMarker,
            scope: this
        },'-',{
            text: _('storesx.remove', {what: _('storesx.marker')}),
            handler: this.removeMarker,
            scope: this
        });
        return m;
    },

    createMarker: function() {
        var win = MODx.load({
            xtype: 'storesx-window-marker',
            mode: 'create'
        });
        win.show();
    },

    updateMarker: function() {
        var record = this.menu.record;
        var win = MODx.load({
            xtype: 'storesx-window-marker',
            mode: 'update',
            record: record
        });
        win.setValues(record);
        win.show();
    },

    duplicateMarker: function() {
        var record = this.menu.record;
        /* Unset the ID to prevent overwriting the other one */
        record['id'] = '';
        var win = MODx.load({
            xtype: 'storesx-window-marker',
            mode: 'create',
            record: record
        });
        win.setValues(record);
        win.show();
    },

    removeMarker: function() {
        MODx.msg.confirm({
            title: _('storesx.remove',{what: _('storesx.marker')}),
            text: _('storesx.remove.marker.confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/markers/remove',
                id: this.menu.record.id
            },
            listeners: {
                success: {fn: function() {
                    this.refresh();
                    Ext.getCmp('storesx-grid-stores').refresh();
                },scope: this}
            }
        });
    },

    renderImage: function(v) {
        if (v != '') return '<img src="' + v + '" width="30" height="30" />';
        return '';
    }
});
Ext.reg('storesx-grid-markers',StoresX.grid.Markers);
