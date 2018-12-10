class ProfileComponent extends Fronty.ModelComponent {
    constructor(userModel, router) {
      super(Handlebars.templates.profile, userModel);
     
      this.userModel = userModel;
      this.userService = new UserService();
      this.router = router;
  

      this.addEventListener('click', '#dropOut', () => {
        this.userModel.set(() => {
          this.userModel.registerMode = true;
        });
      });
  
      this.addEventListener('click', '#modifyprofile', () => {
        this.userService.updateUser({
            username: $('#username').val(),
            password: $('#passwd').val(),
            confirmPassword: $('#confirmPasswd').val()
          })
          .then(() => {
            this.userModel.set((model) => {
              model.message = I18n.translate('User updated!');
              this.router.goToPage('polls');
            });
          })
          .fail((xhr, errorThrown, statusText) => {
            if (xhr.status == 400) {
              this.userModel.set((model) => {
                model.error = I18n.translate(xhr.responseJSON);
              });
            } else {
              alert('An error has occurred during request: ' + statusText + '.' + xhr.responseText);
            }
          });
      });
    }
    
  
    afterRender(){
      
      setTimeout(function() {
        $(".alert-success").alert('close');
        }, 7000);
    }

    onStart() {
  
      }
  }
  
  