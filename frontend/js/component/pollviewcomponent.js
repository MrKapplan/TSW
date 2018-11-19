class PollViewComponent extends Fronty.ModelComponent {
  constructor(pollsModel, gapsModel, assignationsModel, userModel, router) {
    super(Handlebars.templates.pollview, pollsModel);

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


    this.addEventListener('click', '#addParticipation-button', (event) => {
      var pollLink = event.target.getAttribute('item');
      this.router.goToPage('add-assignation?link=' + pollLink);
    });

    this.addEventListener('click', '#modifyParticipation-button', (event) => {
      var pollLink = event.target.getAttribute('item');
      this.router.goToPage('modify-assignation?link=' + pollLink);
    });

  }



  afterRender() {
  
    $.each(this.gapsModel.selectedGap, function(index, gap) {
          var d = new Date(gap.date);
          $('#gap-date-item-'.concat(gap.id)).html(d.toString().substr(0,3).toUpperCase().concat(',').concat(d.toString().substr(7,3)).concat(d.toString().substr(3,5))); 
    }); 
  }



  loadPoll(pollLink) {
    if (pollLink != null) {
      this.pollsService.findPoll(pollLink)
        .then((poll) => {
          this.pollsModel.setSelectedPoll(poll);
        });

    }
  }

  loadGapsPoll(pollLink) {
    if (pollLink != null) {
      this.gapsService.findGapsPoll(pollLink)
        .then((gaps) => {
          
          this.gapsModel.setSelectedGap(gaps.map((gap) => new GapModel(gap.id, gap.date, gap.timeStart, gap.timeEnd, gap.poll_id)));
          console.log(gaps);
        });

    }
  }

  loadAssignationsPoll(pollLink) {
    if (pollLink != null) {
      this.assignationsService.findAssignationsPoll(pollLink)
        .then((assignations) => {
          this.assignationsModel.setSelectedAssignation(assignations);
        });

    }
  }


  onStart() {
    var selectedLink = this.router.getRouteQueryParam('link');
    this.loadPoll(selectedLink);
    this.loadGapsPoll(selectedLink);
    this.loadAssignationsPoll(selectedLink);
  }

    // Override
    createChildModelComponent(className, element, id, modelItem) {
      return new PollViewRowComponent(modelItem, this.assignationsModel, this.userModel, this.router, this);
    }
}


class PollViewRowComponent extends Fronty.ModelComponent {
  constructor(gapsModel, assignationsModel, userModel, router, pollViewComponent) {
    super(Handlebars.templates.pollviewrow, gapsModel);

    // this.pollsModel = pollsModel; // posts
    this.userModel = userModel; // global
    this.addModel('user', userModel);

    // this.gapsModel = gapsModel;
    // this.addModel('gaps', gapsModel)

    this.assignationsModel = assignationsModel;
    this.addModel('assignations', assignationsModel)

    this.router = router;

  }

}



