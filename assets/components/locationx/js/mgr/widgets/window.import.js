LocationX.window.Import = function(config) {
    config = config || {};
    this.id = config.id = config.id || Ext.id();
    config.register = config.register || 'mgr';
    config.topic = config.topic || '/locationx/import/' + this.id + '/';
    Ext.applyIf(config,{
        title: _('locationx.import'),
        url: LocationX.config.connector_url,
        width: 400,
        fileUpload: true,
        baseParams: {
            action: 'mgr/import',
            register: config.register,
            topic: config.topic
        },
        fields: [{
            xtype: 'hidden',
            name: 'id',
            value: this.id
        },{
            xtype: 'textfield',
            fieldLabel: _('locationx.xmlfile'),
            name: 'xmlfile',
            inputType: 'file'
        },{
            xtype: 'checkbox',
            boxLabel: _('locationx.overwrite_stores'),
            name: 'overwrite_stores'
        },{
            xtype: 'checkbox',
            boxLabel: _('locationx.auto_create_categories'),
            name: 'auto_create_categories',
            checked: true
        },{
            xtype: 'checkbox',
            boxLabel: _('locationx.import.get_latlong'),
            name: 'get_latlong',
            checked: false,
            disabled: true,
            description: _('locationx.import.get_latlong.disabled_quota')
        },{
            xtype: 'panel',
            height: 250,
            scrollable: true,
            autoScroll: true,
            hidden: true,
            id: config.id + '-body-container',
            items: [{
                xtype: 'panel',
                id: config.id + '-body',
                cls: 'x-form-text modx-console-text'
            }]
        }],
        buttons: [{
            text: _('locationx.import'),
            itemId: 'startBtn',
            handler: this.startImport,
            scope: this
        },{
            text: _('close'),
            itemId: 'okBtn',
            scope: this,
            handler: this.hideConsole
        }],
        listeners: {
            success: function() {
                this.fireEvent('complete');
                return false;
            },
            failure: function(r) {
                this.fireEvent('complete');
            }
        }
    });
    LocationX.window.Import.superclass.constructor.call(this,config);
    this.addEvents({
        'shutdown': true,
        'complete': true
    });
    this.on('complete',this.onComplete,this);
};
Ext.extend(LocationX.window.Import,MODx.Window,{
    running: false,
    startImport: function() {
        Ext.Msg.hide();
        this.fbar.getComponent('okBtn').setDisabled(true);
        this.fbar.getComponent('startBtn').setDisabled(true);
        var body = Ext.getCmp(this.id + '-body');
        body.el.dom.innerHTML = '';
        var bodyContainer = Ext.getCmp(this.id + '-body-container');
        bodyContainer.show();

        this.provider = new Ext.direct.PollingProvider({
            type:'polling'
            ,url: MODx.config.connectors_url+'system/index.php'
            ,interval: 500
            ,baseParams: {
                action: 'console'
                ,register: this.config.register || ''
                ,topic: this.config.topic || ''
                ,show_filename: this.config.show_filename || 0
                ,format: this.config.format || 'html_log'
            }
        });
        Ext.Direct.addProvider(this.provider);
        Ext.Direct.on('message', function(e,p) {
            var out = Ext.getCmp(this.id + '-body');
            if (out) {
                var progressRegex = /<span class="info">PROGRESS:(\d+)<\/span><br \/>/g;
                var progress = Ext.get(this.config.topic + '-progress');
                var match = progressRegex.exec(e.data);
                if (match != null) {
                    if (progress) progress.update(match[1]);
                    while ((match = progressRegex.exec(e.data)) != null) {
                        if (progress) progress.update(match[1]);

                    }
                }
                e.data = e.data.replace(progressRegex,"");
                out.el.insertHtml('beforeEnd',e.data);
                e.data = '';
                out.el.scroll('b', out.el.getHeight(), true);
            }
            if (e.complete) {
                this.fireEvent('complete');
            }
            delete e;
        },this);
        body.el.insertHtml('beforeEnd',_('locationx.import.initiated') + '<br />');

        this.submit(false);
    },

    onComplete: function() {
        this.provider.disconnect();
        this.fbar.getComponent('okBtn').setDisabled(false);
        this.fbar.getComponent('startBtn').setDisabled(false);
        var body = Ext.getCmp(this.id + '-body');
        body.el.insertHtml('beforeEnd',_('locationx.import.done') + '<br />');

        Ext.getCmp('locationx-grid-stores').refresh();
        Ext.getCmp('locationx-grid-categories').refresh();
    },

    download: function() {
        var c = this.getComponent('body').getEl().dom.innerHTML || '&nbsp;';
        MODx.Ajax.request({
            url: MODx.config.connectors_url+'system/index.php'
            ,params: {
                action: 'downloadOutput'
                ,data: c
            }
            ,listeners: {
                'success':{fn:function(r) {
                    location.href = MODx.config.connectors_url+'system/index.php?action=downloadOutput&HTTP_MODAUTH='+MODx.siteId+'&download='+r.message;
                },scope:this}
            }
        });
    },

    setRegister: function(register,topic) {
    	this.config.register = register;
        this.config.topic = topic;
    },

    hideConsole: function() {
        if (this.provider && this.provider.disconnect) {
            try {
                this.provider.disconnect();
            } catch (e) {}
        }
        this.fireEvent('shutdown');
        this.hide();
    },

    submit: function(close) {
        close = close === false ? false : true;
        var f = this.fp.getForm();
        if (f.isValid() && this.fireEvent('beforeSubmit',f.getValues())) {
            f.submit({
                scope: this
                ,failure: function(frm,a) {
                    if (this.fireEvent('failure',{f:frm,a:a})) {
                        MODx.form.Handler.errorExt(a.result,frm);
                    }
                }
                ,success: function(frm,a) {
                    if (this.config.success) {
                        Ext.callback(this.config.success,this.config.scope || this,[frm,a]);
                    }
                    this.fireEvent('success',{f:frm,a:a});
                    if (close) { this.hide(); }
                }
            });
        }
    }
});
Ext.reg('locationx-window-import',LocationX.window.Import);
