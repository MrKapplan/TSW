class GapEditComponent extends Fronty.ModelComponent {
    constructor(pollsModel,gapsModel, userModel, router) {
      super(Handlebars.templates.gapedit, gapsModel);

      this.gapsModel = gapsModel;

      this.pollsModel = pollsModel;
      this.addModel('polls', pollsModel)
      this.userModel = userModel;
      this.addModel('user', userModel);

      this.router = router;
      this.pollsService = new PollsService();
      this.gapsService = new GapsService();

  


      this.addEventListener('click', '#addrow-button', () => {
        this.gapsModel.set(() => {
          this.gapsModel.emptyGap += 1;
          this.gapsModel.emptyGaps.push({"gap":this.gapsModel.emptyGap});
          console.log(this.gapsModel.emptyGaps);
        });

      });



      this.addEventListener('click', '#editGap', () => {
        var gaps = $('#gaps').val();
        var link = $('#poll-link').val();

        this.gapsService.editGaps(link, gaps)
          .then(() => {
            this.router.goToPage('view-poll?link='.concat(link));
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

          $('#date-item-'.concat(gap.id)).bootstrapMaterialDatePicker 
          ({
            format: 'DD/MM/YYYY',
            lang: 'es',
            time: false,
            weekStart: 1, 
            nowButton : true,
            switchOnClick : true,
            minDate : new Date()
          });


          $('#timeStart-item-'.concat(gap.id)).bootstrapMaterialDatePicker
          ({
            date: false,
            shortTime: false,
            format: 'HH:mm'
          });


          $('#timeEnd-item-'.concat(gap.id)).bootstrapMaterialDatePicker
          ({
            date: false,
            shortTime: false,
            format: 'HH:mm'
          });
      });
      

      $.each(this.gapsModel.emptyGaps, function(index, gap) {

        $('#date-item-'.concat(gap.gap)).bootstrapMaterialDatePicker 
        ({
          format: 'DD/MM/YYYY',
          lang: 'es',
          time: false,
          weekStart: 1, 
          nowButton : true,
          switchOnClick : true,
          minDate : new Date()
        });


        $('#timeStart-item-'.concat(gap.gap)).bootstrapMaterialDatePicker
        ({
          date: false,
          shortTime: false,
          format: 'HH:mm'
        });


        $('#timeEnd-item-'.concat(gap.gap)).bootstrapMaterialDatePicker
        ({
          date: false,
          shortTime: false,
          format: 'HH:mm'
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


    createChildModelComponent(className, element, id, modelItem) {
      console.log(modelItem);
      return new GapRowComponent(modelItem, this.router, this);
    }
  }


  class GapRowComponent extends Fronty.ModelComponent {
    constructor(gapModel, router, gapEditComponent) {
      //console.log(gapModel);
      super(Handlebars.templates.gaprow, gapModel, null, null);
      
      this.gapEditComponent = gapEditComponent;
      this.router = router;
  
      this.addEventListener('click', '.deleteRow', (event) => {
        // var pollLink = event.target.getAttribute('item');
        // this.router.goToPage('edit-poll?link=' + pollLink);
      });
  
    }
  
  }
  