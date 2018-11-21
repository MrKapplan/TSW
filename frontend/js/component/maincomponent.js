class MainComponent extends Fronty.RouterComponent {
  constructor() {
    super('frontyapp', Handlebars.templates.main, 'maincontent');

    // models instantiation
    // we can instantiate models at any place
    var userModel = new UserModel();
    var pollsModel = new PollsModel();
    var gapsModel = new GapsModel();
    var assignationsModel = new AssignationsModel();

    super.setRouterConfig({
      polls: {
        component: new PollsComponent(pollsModel, userModel, this),
        title: 'Polls'
      },
      'view-poll': {
        component: new PollViewComponent(pollsModel, gapsModel, assignationsModel, userModel, this),
        title: 'Poll'
      },
      'edit-poll': {
        component: new PollEditComponent(pollsModel, userModel, this),
        title: 'Edit Poll'
      },
      'add-poll': {
        component: new PollAddComponent(pollsModel, userModel, this),
        title: 'Add Poll'
      },
      'add-gaps': {
        component: new GapAddComponent(pollsModel, gapsModel, userModel, this),
        title: 'Add Gaps'
      },
      'edit-gaps': {
        component: new GapEditComponent(pollsModel, gapsModel, userModel, this),
        title: 'Edit Gaps'
      },
      // 'add-assignation': {
      //   component: new AssignationAddComponent(pollsModel, gapsModel, userModel, this),
      //   title: 'Add Assignation'
      // },
      // 'edit-assignation': {
      //   component: new AssignationEditComponent(pollsModel, gapsModel, userModel, this),
      //   title: 'Edit Assignation'
      // },
      login: {
        component: new LoginComponent(userModel, this),
        title: 'Login'
      },
      defaultRoute: 'login'
    });
    
    Handlebars.registerHelper('currentPage', () => {
          return super.getCurrentPage();
    });

    var userService = new UserService();
    this.addChildComponent(this._createUserBarComponent(userModel, userService));
    this.addChildComponent(this._createLanguageComponent());

  }

  _createUserBarComponent(userModel, userService) {
    var userbar = new Fronty.ModelComponent(Handlebars.templates.user, userModel, 'userbar');

    userbar.addEventListener('click', '#logout', () => {
      userModel.logout();
      userService.logout();
      
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
