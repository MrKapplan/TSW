class PollEditComponent extends Fronty.ModelComponent {
  constructor(pollsModel, userModel, router) {
    super(Handlebars.templates.polledit, pollsModel);
    
    this.pollsModel = pollsModel; // posts
    this.userModel = userModel; // global
    this.addModel('user', userModel);
    this.router = router;

    this.pollsService = new PollsService();

    this.addEventListener('click', '#savebutton', () => {
      this.pollsModel.selectedPoll.title = $('#title').val();
      this.pollsModel.selectedPoll.ubication = $('#ubication').val();
      this.pollsService.updatePoll(this.pollsModel.selectedPoll)
        .then(() => {
          this.pollsModel.set((model) => {
            model.errors = []
          });
          this.router.goToPage('polls');
        })
        .fail((xhr, errorThrown, statusText) => {
          if (xhr.status == 400) {
            this.pollsModel.set((model) => {
              model.errors = xhr.responseJSON;
            });
          } else {
            alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
          }
        });

    });
  }

  onStart() {
    var selectedLink = this.router.getRouteQueryParam('link');
    if (selectedLink != null) {
      this.pollsService.findPoll(selectedLink)
        .then((poll) => {
          this.pollsModel.setSelectedPoll(poll);
        });
    }
  }
}
