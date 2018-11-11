class PollsService {
  constructor() {

  }

  findAllPolls() {
    return $.get(AppConfig.backendServer+'/meetPoll_TSW/rest/poll');
  }

  findPoll(link) {
    return $.get(AppConfig.backendServer+'/meetPoll_TSW/rest/poll/' + link);
  }

  // deletePost(id) {
  //   return $.ajax({
  //     url: AppConfig.backendServer+'/rest/post/' + id,
  //     method: 'DELETE'
  //   });
  // }

  updatePoll(poll) {
    return $.ajax({
      url: AppConfig.backendServer+'/meetPoll_TSW/rest/poll/' + poll.link,
      method: 'PUT',
      data: JSON.stringify(poll),
      contentType: 'application/json'
    });
  }

  // addPost(post) {
  //   return $.ajax({
  //     url: AppConfig.backendServer+'/rest/post',
  //     method: 'POST',
  //     data: JSON.stringify(post),
  //     contentType: 'application/json'
  //   });
  // }

  // createComment(postid, comment) {
  //   return $.ajax({
  //     url: AppConfig.backendServer+'/rest/post/' + postid + '/comment',
  //     method: 'POST',
  //     data: JSON.stringify(comment),
  //     contentType: 'application/json'
  //   });
  // }

}
