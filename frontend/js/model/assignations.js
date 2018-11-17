class AssignationsModel extends Fronty.Model {

    constructor() {
      super('AssignationsModel'); //call super
  
      // model attributes
      this.assignations = [];
    }
  
    setSelectedAssignation(assignation) {
      this.set((self) => {
        self.selectedAssignation = assignation['assignationsDB'];
        self.selectedParticipants = assignation['participants'];
        self.selectedIsParticipant = assignation['isParticipant'];
        // console.log( self.selectedAssignation);
        // console.log( self.selectedParticipants);
        // console.log( self.selectedIsParticipant);
      });
    }
  
    setAssignations(assignations) {
      this.set((self) => {
        self.assignations = assignations;
      });
    }
  }
  