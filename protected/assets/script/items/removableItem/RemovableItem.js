var RemovableItem = (function() {
    
    // Т.к объект RemovableItem создаётся сразу и на момент его 
    // создания(т.е. по сути включения файла RemovableItem.js  
    // в страницу), должны быть доступный селекторы.
    // Чтобы не иметь проблем с порядком подключения файлов определим
    // RemovableItemSelectors здесь, а не в отдельном файле. 
    var RemovableItemSelectors = function() {
        this.REMOVABLE_ITEM_SELECTOR = '.removableItem';
        this.INFO_SELECTOR = '.removableItem__info';
        this.REMOVE_SELECTOR = '.removableItem__remove';
    };
    
    var Sel = new RemovableItemSelectors();
    
    function prepareRemovableItems() {
        $(Sel.REMOVE_SELECTOR).live('click', function() {
            // Удаляем весь блок.
            $(this).closest(Sel.REMOVABLE_ITEM_SELECTOR).remove();
        });
    }
  
    return {
        'prepareRemovableItems' : prepareRemovableItems
    };
	
})();