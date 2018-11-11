class GapsModel extends Fronty.Model {

    constructor() {
      super('GapsModel'); //call super
  
      // model attributes
      this.gaps = [];
    }
  
    setSelectedGap(gap) {
      this.set((self) => {
        self.selectedGap = gap;
        //console.log(self.selectedGap);
      });
      
    }
  
    setGaps(gaps) {
      this.set((self) => {
        self.gaps = gaps;
      });
    }
  }
  