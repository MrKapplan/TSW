class PollAddComponent extends Fronty.ModelComponent {
  constructor(pollsModel, userModel, router) {
    super(Handlebars.templates.polladd, pollsModel);
    this.pollsModel = pollsModel; // polls
    
    this.userModel = userModel; // global
    this.addModel('user', userModel);
    this.router = router;

    this.pollsService = new PollsService();

    this.addEventListener('click', '#savebutton', () => {
      var newPoll = {};
      newPoll.title = $('#title').val();
      newPoll.ubication = $('#ubication').val();
      newPoll.author = this.userModel.currentUser;
      this.pollsService.addPoll(newPoll)
        .then(() => {

          this.router.goToPage('add-gaps');
        })
        .fail((xhr, errorThrown, statusText) => {
          if (xhr.status == 400) {
            this.pollsModel.set(() => {
              this.pollsModel.errors = xhr.responseJSON;
            });
          } else {
            alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
          }
        });
    });
  }
  
  onStart() {
    this.pollsModel.setSelectedPoll(new PollModel());
  }
}
