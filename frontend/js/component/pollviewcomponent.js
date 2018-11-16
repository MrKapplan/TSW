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

    // this.addEventListener('click', '#savecommentbutton', () => {
    //   var selectedId = this.router.getRouteQueryParam('id');
    //   this.postsService.createComment(selectedId, {
    //       content: $('#commentcontent').val()
    //     })
    //     .then(() => {
    //       $('#commentcontent').val('');
    //       this.loadPost(selectedId);
    //     })
    //     .fail((xhr, errorThrown, statusText) => {
    //       if (xhr.status == 400) {
    //         this.postsModel.set(() => {
    //           this.postsModel.commentErrors = xhr.responseJSON;
    //         });
    //       } else {
    //         alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
    //       }
    //     });
    // });
  }

  onStart() {
    var selectedLink = this.router.getRouteQueryParam('link');
    this.loadPoll(selectedLink);
    this.loadGapsPoll(selectedLink);
    this.loadAssignationsPoll(selectedLink);


  }

  loadPoll(pollLink) {
    if (pollLink != null) {
      this.pollsService.findPoll(pollLink)
        .then((poll) => {
          this.pollsModel.setSelectedPoll(poll);
          //console.log(poll);
        });

    }
  }

  loadGapsPoll(pollLink) {
    if (pollLink != null) {
      this.gapsService.findGapsPoll(pollLink)
        .then((gaps) => {
          this.gapsModel.setSelectedGap(gaps);
          //console.log(gaps);
         // console.log(gaps.length);

        });

    }
  }

  loadAssignationsPoll(pollLink) {
    if (pollLink != null) {
      this.assignationsService.findAssignationsPoll(pollLink)
        .then((assignations) => {
          this.assignationsModel.setSelectedAssignation(assignations);
          console.log(assignations);
          console.log(assignations['assignationsDB'].length);
        });

    }
  }
}
