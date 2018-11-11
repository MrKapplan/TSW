class GapsService {
    constructor() {
  
    }
  
    findGapsPoll(pollLink) {
      return $.get(AppConfig.backendServer+'/meetPoll_TSW/rest/gap/' + pollLink);
    }
  

    // updatePoll(poll) {
    //   return $.ajax({
    //     url: AppConfig.backendServer+'/meetPoll_TSW/rest/poll/' + poll.link,
    //     method: 'PUT',
    //     data: JSON.stringify(poll),
    //     contentType: 'application/json'
    //   });
    // }
  
    // addPoll(poll) {
    //   return $.ajax({
    //     url: AppConfig.backendServer+'/meetPoll_TSW/rest/poll',
    //     method: 'POST',
    //     data: JSON.stringify(poll),
    //     contentType: 'application/json'
    //   });
    // }
  
  
  }
  