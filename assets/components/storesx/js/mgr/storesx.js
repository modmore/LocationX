var StoresX = function(config) {
    config = config || {};
    StoresX.superclass.constructor.call(this,config);
};
Ext.extend(StoresX,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});
Ext.reg('storesx',StoresX);
StoresX = new StoresX();
