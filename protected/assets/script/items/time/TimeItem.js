var TimeItem = function(timeTextView, time, state) {
      
    this.timeTextView = timeTextView;
    this.time = time;
    
    if (state === undefined) {
        this.state = TimeItemState.FREE; 
    } else {
        this.state = state; 
    } 
};
