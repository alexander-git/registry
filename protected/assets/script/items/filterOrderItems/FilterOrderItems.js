var FilterOrderItems = function(id) {
    
    var Sel = new FilterOrderItemsSelectors(id);

    this.getValues = function() {
        var result = [];
        result['processed'] = $(Sel.PROCESSED_FULL_SELECTOR).val();
        result['state'] = $(Sel.STATE_FULL_SELECTOR).val();
        return result;
    };

};
