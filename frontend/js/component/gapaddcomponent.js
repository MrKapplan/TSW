class GapAddComponent extends Fronty.ModelComponent {
    constructor(gapsModel, userModel, router) {
      super(Handlebars.templates.gapadd, gapsModel);
      this.gapsModel = gapsModel; // polls
      
      this.userModel = userModel; // global
      this.addModel('user', userModel);
      this.router = router;
  
      this.gapssService = new GapsService();
  
      this.addEventListener('click', '#savebutton', () => {
        var newGap = {};
        newGap.date = $('#date').val();
        newGap.timeStart = $('#ubication').val();
        newGap.timeEnd = this.userModel.currentUser;
        // newGap.poll_id =
        console.log(  newGap.date);
        console.log(newGap.timeStart);
        console.log(nnewGap.timeEnd);
        // console.log(newGap.poll_id);
        this.gapsService.addPoll(newGap)
          .then(() => {
            this.router.goToPage('polls');
          })
          .fail((xhr, errorThrown, statusText) => {
            if (xhr.status == 400) {
              this.gapsModel.set(() => {
                this.gapsModel.errors = xhr.responseJSON;
              });
            } else {
              alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
            }
          });
      });
    }
    
    onStart() {
      this.gapsModel.setSelectedGap(new GapModel());
    }
  }
  