class PollsComponent extends Fronty.ModelComponent {
  constructor(pollsModel, userModel, router) {
    super(Handlebars.templates.pollstable, pollsModel, null, null);
    
    
    this.pollsModel = pollsModel;
    this.userModel = userModel;
    this.addModel('user', userModel);
    this.router = router;

    this.pollsService = new PollsService();

  }

  onStart() {
    this.updatePolls();
  }

  updatePolls() {
    this.pollsService.findAllPolls().then((data) => {

      this.pollsModel.setPolls(
        // create a Fronty.Model for each item retrieved from the backend
        data.map(
          (item) => new PollModel(item.id, item.title, item.ubication, item.author, item.link)
      ));
    });
  }

  // Override
  createChildModelComponent(className, element, id, modelItem) {
    return new PollRowComponent(modelItem, this.userModel, this.router, this);
  }
}

class PollRowComponent extends Fronty.ModelComponent {
  constructor(pollModel, userModel, router, pollsComponent) {
    super(Handlebars.templates.pollrow, pollModel, null, null);
    
    this.pollsComponent = pollsComponent;
    
    this.userModel = userModel;
    this.addModel('user', userModel); // a secondary model
    
    this.router = router;

    // this.addEventListener('click', '.remove-button', (event) => {
    //   if (confirm(I18n.translate('Are you sure?'))) {
    //     var postId = event.target.getAttribute('item');
    //     this.pollsComponent.pollsService.deletePost(postId)
    //       .fail(() => {
    //         alert('post cannot be deleted')
    //       })
    //       .always(() => {
    //         this.pollsComponent.updatePosts();
    //       });
    //   }
    // });

    this.addEventListener('click', '.editPoll-button', (event) => {
      var pollLink = event.target.getAttribute('item');
      this.router.goToPage('edit-poll?link=' + pollLink);
    });
  }

}
