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


    this.addEventListener('click', '#addParticipation-button', (event) => {
      var pollLink = event.target.getAttribute('item');
      this.router.goToPage('add-assignation?link=' + pollLink);
    });

    this.addEventListener('click', '#modifyParticipation-button', (event) => {
      var pollLink = event.target.getAttribute('item');
      this.router.goToPage('modify-assignation?link=' + pollLink);
    });

  }



  afterRender() {
  
    $.each(this.gapsModel.selectedGap, function(index, gap) {
          var d = new Date(gap.date);
          $('#gap-date-item-'.concat(gap.id)).html(I18n.translate(d.toString().substr(0,3).toUpperCase()).concat(',').concat(d.toString().substr(7,3)).concat(d.toString().substr(3,5))); 
    }); 

         var table = document.getElementById('dataTable');
         if(table !== null){
           this.checkboxes(table);
         }
         
  }



  loadPoll(pollLink) {
    if (pollLink != null) {
      this.pollsService.findPoll(pollLink)
        .then((poll) => {
          this.pollsModel.setSelectedPoll(poll);
        });

    }
  }

  loadGapsPoll(pollLink) {
    if (pollLink != null) {
      this.gapsService.findGapsPoll(pollLink)
        .then((gaps) => {
          this.gapsModel.setSelectedGap(gaps.map((gap) => new GapModel(gap.id, gap.date, gap.timeStart, gap.timeEnd, gap.poll_id)));
        });

    }
  }

  loadAssignationsPoll(pollLink) {
    if (pollLink != null) {
      this.assignationsService.findAssignationsPoll(pollLink)
        .then((assignations) => {
          this.assignationsModel.setSelectedAssignation(assignations);
        });

    }
  }


  onStart() {
    var selectedLink = this.router.getRouteQueryParam('link');
    this.loadPoll(selectedLink);
    this.loadGapsPoll(selectedLink);
    this.loadAssignationsPoll(selectedLink);
  }

  // Override
  createChildModelComponent(className, element, id, modelItem) {
    return new PollViewRowComponent(modelItem, this.assignationsModel, this);
  }



  removeCheckboxSuccess() {
    var filaSuccess = document.getElementsByClassName("table-success"); 
    for (var i = 0; i < filaSuccess.length; i++) {
        document.getElementById(filaSuccess[i].id).setAttribute("class",""); 
    }
  }

  removeCheckboxWarning() {
    var filaWarning = document.getElementsByClassName("table-warning"); 
    for (var i = 0; i < filaWarning.length; i++) {
        document.getElementById(filaWarning[i].id).setAttribute("class","");
    }
  }

  checkboxes(table){
    var rowCount = table.rows.length - 1;
    var inputElems = document.getElementsByTagName("input");
    var numInputsForRow = (inputElems.length - 1) / rowCount;
    var count = 0, max = 0, maxAbs = 0, trSelected = -1, trSelectedArray = new Array();
  
      
    for (var j = 1; j < inputElems.length; j++) {
      if(inputElems[j].type === "checkbox" && inputElems[j].checked) {
        count++;
      }
      if (j % numInputsForRow == 0) {
        if (count > maxAbs) {
          max = count;
          maxAbs = count;
          trSelected = inputElems[j].parentNode.parentNode.parentNode.id;
        } else if (count == max) {
            max = -1;
        }
          count = 0;
      }
    }
  
    if (trSelected != -1 && max != -1) {
      this.removeCheckboxWarning();
      document.getElementById(trSelected).setAttribute("class", "table-success");
    }
      
    for (var j = 1; j < inputElems.length; j++) { 
      if (inputElems[j].type === "checkbox" && inputElems[j].checked) {
        count++;
      }
      if (j % numInputsForRow == 0) {  
        if (count == maxAbs) {
          trSelectedArray.push(inputElems[j].parentNode.parentNode.parentNode.id);
        } 
        count = 0;
      }
    }
  
    if(trSelectedArray.length > 1){
      this.removeCheckboxSuccess();
      this.removeCheckboxWarning();
      for(var y=0; y<trSelectedArray.length; y++){
        document.getElementById(trSelectedArray[y]).setAttribute("class", "table-warning");
      }
    } 
  }

}


class PollViewRowComponent extends Fronty.ModelComponent {
  constructor(gapsModel, assignationsModel, pollViewComponent) {
    super(Handlebars.templates.pollviewrow, gapsModel);
    
    this.assignationsModel = assignationsModel;
    this.addModel('assignations', assignationsModel)

  }

}



