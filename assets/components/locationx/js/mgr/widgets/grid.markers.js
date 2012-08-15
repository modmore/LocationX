LocationX.grid.Markers = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		url: LocationX.config.connector_url,
		id: 'locationx-grid-markers',
		baseParams: {
            action: 'mgr/markers/getlist'
        },
        params: [],
        viewConfig: {
            forceFit: true,
            emptyText: _('locationx.error.noresults',{what: _('locationx.markers')})
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
			header: _('locationx.name'),
			dataIndex: 'name',
		    sortable: true,
			width: .3
		},{
			header: _('locationx.image'),
			dataIndex: 'image',
			sortable: true,
			width: .2,
            renderer: this.renderImage
		},{
			header: _('locationx.shadow'),
			dataIndex: 'shadow',
			sortable: true,
			width: .2,
            renderer: this.renderImage
		},{
			header: _('locationx.size'),
			dataIndex: 'size',
			sortable: true,
			width: .2
		},{
			header: _('locationx.origin'),
			dataIndex: 'origin',
			sortable: true,
			width: .2
		},{
			header: _('locationx.flat'),
			dataIndex: 'flat',
			sortable: true,
			width: .2,
            renderer: this.rendYesNo
		}],
        tbar: [{
            text: _('locationx.create', {what: _('locationx.marker')}),
            handler: this.createMarker,
            scope: this
        }]
    });
    LocationX.grid.Markers.superclass.constructor.call(this,config);
};
Ext.extend(LocationX.grid.Markers,MODx.grid.Grid,{
    getMenu: function() {
        var m = [];
        m.push({
            text: _('locationx.update', {what: _('locationx.marker')}),
            handler: this.updateMarker,
            scope: this
        },{
            text: _('locationx.duplicate', {what: _('locationx.marker')}),
            handler: this.duplicateMarker,
            scope: this
        },'-',{
            text: _('locationx.remove', {what: _('locationx.marker')}),
            handler: this.removeMarker,
            scope: this
        });
        return m;
    },

    createMarker: function() {
        var win = MODx.load({
            xtype: 'locationx-window-marker',
            mode: 'create'
        });
        win.show();
    },

    updateMarker: function() {
        var record = this.menu.record;
        var win = MODx.load({
            xtype: 'locationx-window-marker',
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
            xtype: 'locationx-window-marker',
            mode: 'create',
            record: record
        });
        win.setValues(record);
        win.show();
    },

    removeMarker: function() {
        MODx.msg.confirm({
            title: _('locationx.remove',{what: _('locationx.marker')}),
            text: _('locationx.remove.marker.confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/markers/remove',
                id: this.menu.record.id
            },
            listeners: {
                success: {fn: function() {
                    this.refresh();
                    Ext.getCmp('locationx-grid-stores').refresh();
                },scope: this}
            }
        });
    },

    renderImage: function(v) {
        if (v != '') return '<img src="' + v + '" width="30" height="30" />';
        return '';
    }
});
Ext.reg('locationx-grid-markers',LocationX.grid.Markers);
