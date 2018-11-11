class AssignationsModel extends Fronty.Model {

    constructor() {
      super('AssignationsModel'); //call super
  
      // model attributes
      this.assignations = [];
    }
  
    setSelectedAssignation(assignation) {
      this.set((self) => {
        self.selectedAssignation = assignation;
      });
    }
  
    setAssignations(assignations) {
      this.set((self) => {
        self.assignations = assignations;
      });
    }
  }
  