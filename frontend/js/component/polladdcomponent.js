class PollAddComponent extends Fronty.ModelComponent {
  constructor(pollsModel, userModel, router) {
    super(Handlebars.templates.polladd, pollsModel);
    this.pollsModel = pollsModel; // polls
    
    this.userModel = userModel; // global
    this.addModel('user', userModel);
    this.router = router;
    this.pollsService = new PollsService();

    this.addEventListener('click', '#addPoll', () => {
      var newPoll = {};
      newPoll.title = $('#title').val();
      newPoll.ubication = $('#ubication').val();
      newPoll.author = this.userModel.currentUser;
      this.pollsService.addPoll(newPoll)
        .then((xhr) => {
          //console.log(this.pollsService.addPoll(newPoll));
          //console.log(xhr.link);
          
        //   if (xhr.status === 201) {
        //     var data = xhr.response;
        //     var parsed = JSON.parse(data);
        //     console.log(parsed);
        // }
          this.router.goToPage('add-gaps?poll='.concat(xhr.link));
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
