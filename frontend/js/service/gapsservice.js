class GapsService {
    constructor() {
  
    }
  
    findGapsPoll(pollLink) {
      return $.get(AppConfig.backendServer+'/meetPoll_TSW/rest/gap/' + pollLink);
    }
  
    addGaps(pollLink, gaps) {
      return $.ajax({
        url: AppConfig.backendServer+'/meetPoll_TSW/rest/gap/' + pollLink,
        method: 'POST',
        data: gaps,
        contentType: 'application/json'
      });
    }

    // updatePoll(poll) {
    //   return $.ajax({
    //     url: AppConfig.backendServer+'/meetPoll_TSW/rest/poll/' + poll.link,
    //     method: 'PUT',
    //     data: JSON.stringify(poll),
    //     contentType: 'application/json'
    //   });
    // }
  

  
  
  }
  