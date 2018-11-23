class LoginComponent extends Fronty.ModelComponent {
  constructor(userModel, router) {
    super(Handlebars.templates.login, userModel);
   
    this.userModel = userModel;
    this.userService = new UserService();
    this.router = router;

   // alert(this.router.getRouteQueryParam('redirectUrl'))
    this.addEventListener('click', '#loginbutton', (event) => {
      this.userService.login($('#username').val(), $('#passwd').val())
        .then(() => {
          var redirectUrl = this.router.getRouteQueryParam('redirectUrl');
          if (redirectUrl === undefined || redirectUrl === null) {
            redirectUrl = 'polls';
          }
          this.router.goToPage(redirectUrl);
          this.userModel.setLoggeduser($('#username').val());
        })
        .catch((error) => {
          this.userModel.set((model) => {
            model.loginError = error.responseText;
          });
          this.userModel.logout();
        });
    });

    this.addEventListener('click', '#registerlink', () => {
      this.userModel.set(() => {
        this.userModel.registerMode = true;
      });
    });

    this.addEventListener('click', '#registerbutton', () => {
      this.userService.register({
          username: $('#username').val(),
          password: $('#passwd').val(),
          confirmPassword: $('#confirmPasswd').val()

        })
        .then(() => {
         
          this.userModel.set((model) => {
            //model.registerErrors = {};
            model.message = I18n.translate('User registered! Please login');
            model.registerMode = false;
          });
        })
        .fail((xhr, errorThrown, statusText) => {
          if (xhr.status == 400) {
            this.userModel.set((model) => {
              model.loginError = xhr.responseJSON;
              console.log(model.loginError);
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
}

