StoresX.window.Store = function(config) {
    config = config || {};
    this.id = config.id = config.id || Ext.id();
    Ext.applyIf(config,{
        title: (config.mode && config.mode == 'create') ? _('storesx.create',{what: _('storesx.store')}) : _('storesx.update',{what: _('storesx.store')}),
        url: StoresX.config.connector_url,
        width: 750,
        baseParams: {
            action: (config.mode && config.mode == 'create') ? 'mgr/stores/create' : 'mgr/stores/update'
        },
        fields: [{
            xtype: 'hidden',
            name: 'id'
        },{
            layout: 'column',
            defaults: {
                border: false,
                layout: 'form'
            },
            items: [{
                columnWidth:.5,
                items: [{
                    xtype: 'fieldset',
                    title: _('storesx.general_set'),
                    items: [{
                        layout: 'column',
                        defaults: {
                            border: false,
                            layout: 'form'
                        },
                        items: [{
                            columnWidth:.8,
                            items: [{
                                xtype: 'textfield',
                                fieldLabel: _('storesx.name'),
                                name: 'name',
                                maxLength: 150,
                                allowBlank: false,
                                anchor: '100%'
                            }]
                        },{
                            columnWidth:.2,
                            items: [{
                                xtype: 'checkbox',
                                fieldLabel: '&nbsp;',
                                labelSeparator: '',
                                boxLabel: _('storesx.active'),
                                name: 'active'
                            }]
                        }]
                    },{
                        xtype: 'textfield',
                        fieldLabel: _('storesx.link'),
                        name: 'link',
                        maxLength: 150,
                        allowBlank: true,
                        anchor: '100%'
                    },{
                        xtype: 'storesx-combo-categories',
                        fieldLabel: _('storesx.category'),
                        name: 'category',
                        allowBlank: true,
                        anchor: '100%'
                    },{
                        xtype: 'numberfield',
                        fieldLabel: _('storesx.rank'),
                        name: 'rank',
                        minValue: 0,
                        maxValue: 9999999999,
                        allowBlank: false,
                        value: 0,
                        anchor: '100%'
                    }]
                }]
            },{
                columnWidth:.5,
                items: [{
                    xtype: 'fieldset',
                    title: _('storesx.contact_set'),
                    items: [{
                        xtype: 'textfield',
                        fieldLabel: _('storesx.contactperson'),
                        name: 'contactperson',
                        maxLength: 100,
                        allowBlank: true,
                        anchor: '100%'
                    },{
                        xtype: 'textfield',
                        fieldLabel: _('storesx.phone'),
                        name: 'phone',
                        maxLength: 25,
                        allowBlank: true,
                        anchor: '100%'
                    },{
                        xtype: 'textfield',
                        fieldLabel: _('storesx.fax'),
                        name: 'fax',
                        maxLength: 75,
                        allowBlank: true,
                        anchor: '100%'
                    },{
                        xtype: 'textfield',
                        fieldLabel: _('storesx.email'),
                        name: 'email',
                        maxLength: 75,
                        allowBlank: true,
                        anchor: '100%'
                    }]
                }]
            }]
        },{
            layout: 'column',
            defaults: {
                border: false,
                layout: 'form'
            },
            items: [{
                columnWidth:.5,
                items: [{
                    xtype: 'fieldset',
                    title: _('storesx.address_set'),
                    items: [{
                        xtype: 'textfield',
                        fieldLabel: _('storesx.address1'),
                        name: 'address1',
                        maxLength: 150,
                        allowBlank: true,
                        anchor: '100%'
                    },{
                        xtype: 'textfield',
                        fieldLabel: _('storesx.address2'),
                        name: 'address2',
                        maxLength: 150,
                        allowBlank: true,
                        anchor: '100%'
                    },{
                        xtype: 'textfield',
                        fieldLabel: _('storesx.city'),
                        name: 'city',
                        maxLength: 75,
                        allowBlank: true,
                        anchor: '100%'
                    },{
                        layout: 'column',
                        defaults: {
                            layout: 'form',
                            border: false
                        },
                        items: [{
                            columnWidth:.5,
                            items: [{
                                xtype: 'textfield',
                                fieldLabel: _('storesx.state'),
                                name: 'state',
                                maxLength: 75,
                                allowBlank: true,
                                anchor: '100%'
                            }]
                        },{
                            columnWidth:.5,
                            items: [{
                                xtype: 'textfield',
                                fieldLabel: _('storesx.zip'),
                                name: 'zip',
                                maxLength: 75,
                                allowBlank: true,
                                anchor: '100%'
                            }]
                        }]
                    },{
                        xtype: 'textfield',
                        fieldLabel: _('storesx.country'),
                        name: 'country',
                        maxLength: 50,
                        allowBlank: true,
                        anchor: '100%'
                    }]
                }]
            },{
                columnWidth:.5,
                items: [{
                    xtype: 'fieldset',
                    title: _('storesx.map_set'),
                    items: [{
                        layout: 'column',
                        defaults: {
                            border: false,
                            layout: 'form'
                        },
                        items: [{
                            columnWidth:.5,
                            items: [{
                                xtype: 'storesx-combo-markers',
                                fieldLabel: _('storesx.gmap_marker'),
                                name: 'gmap_marker',
                                allowBlank: false,
                                anchor: '100%',
                                value: 'default'
                            },{
                                xtype: 'textfield',
                                fieldLabel: _('storesx.latitude'),
                                name: 'latitude',
                                allowBlank: true,
                                anchor: '100%',
                                maxLength: '25',
                                listeners: {
                                    change: {fn: function() {
                                        Ext.getCmp(this.id).loadMap()
                                    }, scope: this}
                                }
                            }]
                        },{
                            columnWidth:.5,
                            items: [{
                                xtype: 'button',
                                text: _('storesx.get_latlong'),
                                handler: this.getLatLong,
                                scope: this,
                                style: 'margin: 16px 0 8px',
                                anchor: '100%'
                            },{
                                xtype: 'textfield',
                                fieldLabel: _('storesx.longitude'),
                                name: 'longitude',
                                allowBlank: true,
                                anchor: '100%',
                                maxLength: '25',
                                listeners: {
                                    change: {fn: function() {
                                        Ext.getCmp(this.id).loadMap()
                                    }, scope: this}
                                }
                            }]
                        }]
                    },{
                        xtype: 'panel',
                        id: this.id + '-map',
                        html: '<div style="width: 325px; background: grey; height: 170px;"></div>'
                    }]
                }]
            }]
        }],
        listeners: {
            success: function() {
                Ext.getCmp('storesx-grid-stores').refresh();
            }
        }
    });
    StoresX.window.Store.superclass.constructor.call(this,config);
    this.on('show',this.loadMap);
};
Ext.extend(StoresX.window.Store,MODx.Window,{
    loadMap: function() {
        var values = this.fp.getForm().getValues();
        var latitude = values.latitude;
        var longitude = values.longitude;
        var zoom = StoresX.config.cmp_zoom;
        if ((latitude == '') || (longitude == '')) {
            latitude = StoresX.config.cmp_default_lat;
            longitude = StoresX.config.cmp_default_long;
            zoom = StoresX.config.cmp_default_zoom;
        }

        var url = 'http://maps.googleapis.com/maps/api/staticmap?center=' +
            latitude + ',' + longitude +
            '&size=325x170&maptype=roadmap' +
            '&markers=' + latitude + ',' + longitude +
            '&sensor=false&zoom=' + zoom;

        var img = '<img src="'+url+'" width="325" height="170" />';

        var map = Ext.getCmp(this.id + '-map');
        map.update(img);
    },

    getLatLong: function() {
        var addressString = '';
        var values = this.fp.getForm().getValues();

        if (values['address1'] != '') addressString += ' ' + values['address1'];
        if (values['address2'] != '') addressString += ' ' + values['address2'];
        if (values['city'] != '') addressString += ' ' + values['city'];
        if (values['state'] != '') addressString += ' ' + values['state'];
        if (values['zip'] != '') addressString += ' ' + values['zip'];
        if (values['country'] != '') addressString += ' ' + values['country'];

        MODx.Ajax.request({
            url: StoresX.config.connector_url,
            params: {
                action: 'rest/geocode',
                address: addressString
            },
            listeners: {
                success: {fn: function(r) {
                    this.setLatLong(r.object.lat, r.object.lng);
                }, scope: this},
                failure: {fn: function(r) {
                    MODx.msg.alert(_('error'), r.message);
                }, scope: this}
            }
        });
    },

    setLatLong: function (lat, lng) {
        this.fp.getForm().setValues({latitude: lat, longitude: lng});
        this.loadMap();
    }
});
Ext.reg('storesx-window-store',StoresX.window.Store);
