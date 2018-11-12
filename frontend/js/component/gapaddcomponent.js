class GapAddComponent extends Fronty.ModelComponent {
    constructor(gapsModel, userModel, router) {
      super(Handlebars.templates.gapadd, gapsModel);
      this.gapsModel = gapsModel; // gaps
      this.userModel = userModel; // global
      this.addModel('user', userModel);
      this.router = router;
      this.gapsService = new GapsService();
  
      this.addEventListener('click', '#savebutton', () => {
        var newGaps = $('#gaps').val();
        var linkPoll = $('#link').val();
        
        this.gapsService.addGaps(linkPoll, newGaps)
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
  