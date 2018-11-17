class GapAddComponent extends Fronty.ModelComponent {
    constructor(pollsModel, gapsModel, userModel, router) {
      super(Handlebars.templates.gapadd, gapsModel);
      this.gapsModel = gapsModel; // gaps

      this.pollsModel = pollsModel; // global
      this.addModel('poll', pollsModel);
      this.userModel = userModel; // global
      this.addModel('user', userModel);
      this.router = router;
      this.gapsService = new GapsService();
      this.pollsService = new PollsService();
  
      this.addEventListener('click', '#addGap', () => {
        var newGaps = $('#gaps').val();
        var linkPoll = $('#poll').val();
        
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
    
    
    afterRender() {

      $('#date-item-0').bootstrapMaterialDatePicker 
      ({
        format: 'DD/MM/YYYY',
        lang: 'es',
        time: false,
        weekStart: 1, 
        nowButton : true,
        switchOnClick : true,
        minDate : new Date()
      });


      $('#timeStart-item-0').bootstrapMaterialDatePicker
      ({
        date: false,
        shortTime: false,
        format: 'HH:mm'
      });


      $('#timeEnd-item-0').bootstrapMaterialDatePicker
      ({
        date: false,
        shortTime: false,
        format: 'HH:mm'
      });
  
      // $.each(this.gapsModel.selectedGap, function(index, gap) {

      //     $('#date-item-'.concat(gap.id)).bootstrapMaterialDatePicker 
      //     ({
      //       format: 'DD/MM/YYYY',
      //       lang: 'es',
      //       time: false,
      //       weekStart: 1, 
      //       nowButton : true,
      //       switchOnClick : true,
      //       minDate : new Date()
      //     });


      //     $('#timeStart-item-'.concat(gap.id)).bootstrapMaterialDatePicker
      //     ({
      //       date: false,
      //       shortTime: false,
      //       format: 'HH:mm'
      //     });


      //     $('#timeEnd-item-'.concat(gap.id)).bootstrapMaterialDatePicker
      //     ({
      //       date: false,
      //       shortTime: false,
      //       format: 'HH:mm'
      //     });
      // }); 

    $.material.init()
    }

    onStart() {
      var selectedLink = this.router.getRouteQueryParam('poll');
      this.pollsService.findPoll(selectedLink)
      .then((poll) => {
        this.pollsModel.setSelectedPoll(poll);
      });

      this.gapsModel.setSelectedGap(new GapModel());
    }
  }
  