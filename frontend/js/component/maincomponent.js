class MainComponent extends Fronty.RouterComponent {
  constructor() {
    super('frontyapp', Handlebars.templates.main, 'maincontent');

    // models instantiation
    // we can instantiate models at any place
    this.userModel = new UserModel();
    var pollsModel = new PollsModel();
    var gapsModel = new GapsModel();
    var assignationsModel = new AssignationsModel();
    this.routerConfig = 
    {
      
      polls: {
        component: new PollsComponent(pollsModel, this.userModel, this),
        title: 'Polls',
        private: true
      },
      'view-poll': {
        component: new PollViewComponent(pollsModel, gapsModel, assignationsModel, this.userModel, this),
        title: 'Poll',
        private: true
      },
      'edit-poll': {
        component: new PollEditComponent(pollsModel, this.userModel, this),
        title: 'Edit Poll',
        private: true
      },
      'add-poll': {
        component: new PollAddComponent(pollsModel, this.userModel, this),
        title: 'Add Poll',
        private: true
      },
      'add-gaps': {
        component: new GapAddComponent(pollsModel, gapsModel, this.userModel, this),
        title: 'Add Gaps',
        private: true
      },
      'edit-gaps': {
        component: new GapEditComponent(pollsModel, gapsModel, this.userModel, this),
        title: 'Edit Gaps',
        private: true
      },
      'add-assignation': {
        component: new AssignationAddComponent(pollsModel, gapsModel, assignationsModel, this.userModel, this),
        title: 'Add Assignation',
        private: true
      },
      login: {
        component: new LoginComponent(this.userModel, this),
        title: 'Login'
      },
      defaultRoute: 'login'
    };

    this.setRouterConfig(this.routerConfig);

    
    Handlebars.registerHelper('currentPage', () => {
          return super.getCurrentPage();
    });

    var userService = new UserService();
    this.addChildComponent(this._createUserBarComponent(this.userModel, userService));
    this.addChildComponent(this._createLanguageComponent());

   
  }

  onStart() {
    if(
      this.routerConfig[this.getRouterModel().currentPage].private !== undefined && 
      this.routerConfig[this.getRouterModel().currentPage].private === true &&
      !this.userModel.isLogged)
      {
        //alert("is private");
        var redirectOnLogin = window.location.hash.substring(1);
        this.goToPage('login?redirectUrl='+encodeURI(redirectOnLogin));
        
      }

    this.getRouterModel().addObserver( () => {
      if(
      this.routerConfig[this.getRouterModel().currentPage].private !== undefined && 
      this.routerConfig[this.getRouterModel().currentPage].private === true &&
      !this.userModel.isLogged)
      {
        var redirectOnLogin = window.location.hash.substring(1);
        this.goToPage('login?redirectUrl='+encodeURI(redirectOnLogin));
        
      }
    });
    super.onStart();
  } 
    
   
  
  _createUserBarComponent(userModel, userService) {
    var userbar = new Fronty.ModelComponent(Handlebars.templates.user, userModel, 'userbar');

    userbar.addEventListener('click', '#logout', () => {
      userModel.logout();
      userService.logout();
      this.goToPage("login");
      
    });

    // do relogin
    userService.loginWithSessionData()
      .then(function(logged) {
        if (logged != null) {
          userModel.setLoggeduser(logged);
        }
      });

    return userbar;
  }

  _createLanguageComponent() {
    var languageComponent = new Fronty.ModelComponent(Handlebars.templates.language, this.routerModel, 'languagecontrol');
    // language change links

    languageComponent.addEventListener('click', '#englishlink', () => {
      I18n.changeLanguage('default');
      document.location.reload();
    });

    languageComponent.addEventListener('click', '#spanishlink', () => {
      I18n.changeLanguage('es');
      document.location.reload();
    });

    return languageComponent;
  }
}
