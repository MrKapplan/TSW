class AssignationEditComponent extends Fronty.ModelComponent {
    constructor(pollsModel, gapsModel, assignationsModel, userModel, router) {
      super(Handlebars.templates.assignationedit, pollsModel);
  
      this.pollsModel = pollsModel; // posts
  
      this.userModel = userModel; // global
      this.addModel('user', userModel);
  
      this.gapsModel = gapsModel;
      this.addModel('gaps', gapsModel)
  
      this.assignationsModel = assignationsModel;
      this.addModel('assignations', assignationsModel)
  
      this.router = router;
  
      this.pollsService = new PollsService();
      this.gapsService = new GapsService();
      this.assignationsService = new AssignationsService();
  
  
      this.addEventListener('click', '#addAssignation', () => {
        // var newGaps = $('#gaps').val();
        // var linkPoll = $('#poll').val();
        
        // this.gapsService.addGaps(linkPoll, newGaps)
        //   .then(() => {
        //     this.router.goToPage('polls');
        //   })
        //   .fail((xhr, errorThrown, statusText) => {
        //     if (xhr.status == 400) {
        //       this.gapsModel.set(() => {
        //         this.gapsModel.errors = xhr.responseJSON;
        //       });
        //     } else {
        //       alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
        //     }
        //   });
      });
  
    }
  
  
  
//     afterRender() {
    
//       $.each(this.gapsModel.selectedGap, function(index, gap) {
//             var d = new Date(gap.date);
//             $('#gap-date-item-'.concat(gap.id)).html(d.toString().substr(0,3).toUpperCase().concat(',').concat(d.toString().substr(7,3)).concat(d.toString().substr(3,5))); 
//       }); 
  
//     }
  
  
//     onStart() {
//       var selectedLink = this.router.getRouteQueryParam('link');
//       this.loadPoll(selectedLink);
//       this.loadGapsPoll(selectedLink);
//       this.loadAssignationsPoll(selectedLink);
//     }
  
    
//     loadPoll(pollLink) {
//       if (pollLink != null) {
//         this.pollsService.findPoll(pollLink)
//           .then((poll) => {
//             this.pollsModel.setSelectedPoll(poll);
//           });
  
//       }
//     }
  
//     loadGapsPoll(pollLink) {
//       if (pollLink != null) {
//         this.gapsService.findGapsPoll(pollLink)
//           .then((gaps) => {
//             this.gapsModel.setSelectedGap(gaps);
//           });
  
//       }
//     }
  
//     loadAssignationsPoll(pollLink) {
//       if (pollLink != null) {
//         this.assignationsService.findAssignationsPoll(pollLink)
//           .then((assignations) => {
//             this.assignationsModel.setSelectedAssignation(assignations);
//           });
  
//       }
//     }
  
   }
  