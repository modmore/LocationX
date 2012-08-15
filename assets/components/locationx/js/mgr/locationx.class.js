var LocationX = function(config) {
    config = config || {};
    LocationX.superclass.constructor.call(this,config);
};
Ext.extend(LocationX,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});
Ext.reg('locationx',LocationX);
LocationX = new LocationX();
