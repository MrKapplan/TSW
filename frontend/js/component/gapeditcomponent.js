class GapEditComponent extends Fronty.ModelComponent {
    constructor(pollsModel,gapsModel, userModel, router) {
      super(Handlebars.templates.gapedit, gapsModel);

      this.gapsModel = gapsModel; // gaps

      this.pollsModel = pollsModel;
      this.addModel('polls', pollsModel)
      this.userModel = userModel; // global
      this.addModel('user', userModel);

      this.router = router;
      this.pollsService = new PollsService();
      this.gapsService = new GapsService();

  
      this.addEventListener('click', '#savebutton', () => {
        var gaps = $('#gaps').val();
        var link = $('#poll-link').val();

        this.gapsService.editGaps(link, gaps)
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


    afterRender() {
  
      $.each(this.gapsModel.selectedGap, function(index, gap) {
        $.each(gap, function(index, value) {

          $('#date-es'.concat(value.id)).bootstrapMaterialDatePicker 
          ({
            format: 'DD/MM/YYYY',
            lang: 'es',
            time: false,
            weekStart: 1, 
            nowButton : true,
            switchOnClick : true,
            minDate : new Date()
          });


          $('#timeStart'.concat(value.id)).bootstrapMaterialDatePicker
          ({
            date: false,
            shortTime: false,
            format: 'HH:mm'
          });


          $('#timeEnd'.concat(value.id)).bootstrapMaterialDatePicker
          ({
            date: false,
            shortTime: false,
            format: 'HH:mm'
          });
        });
      }); 

    $.material.init()
    }


    onStart() {
        var selectedLink = this.router.getRouteQueryParam('link');
        if (selectedLink != null) {
          this.gapsService.findGapsPoll(selectedLink)
            .then((gaps) => {
              this.gapsModel.setSelectedGap(gaps);
            });

            this.pollsService.findPoll(selectedLink)
            .then((poll) => {
              this.pollsModel.setSelectedPoll(poll);
            });

        }
      }
  }
  