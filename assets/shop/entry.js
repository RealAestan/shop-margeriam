// import 'sylius/bundle/ShopBundle/Resources/private/entry';
/* eslint-env browser */
import 'orejime/dist/orejime';
import '../styles/orejime.scss';

const orejimeConfig = {
  elementID: 'cookie-consent',
  appElement: '#app',
  cookieName: 'COOKIE_CONSENT',
  cookieExpiresAfterDays: 365,
  stringifyCookie: contents => JSON.stringify(contents),
  parseCookie: cookie => JSON.parse(cookie),
  privacyPolicy: '/privacy-policy',
  default: true,
  mustConsent: false,
  mustNotice: false,
  logo: false,
  debug: false,
  translations: {
    ru: {
      consentModal: {
        title: 'Управление cookies',
        description: 'Cookie - это текстовый файл, который сохраняется на вашем компьютере при посещении сайта. \nОн позволяет сохранять пользовательские данные для упрощения навигации и обеспечения определенных функций. \nДля некоторых из них необходимо ваше согласие; вы можете включить или отключить их. \nОднако, чтобы воспользоваться всеми функциями сайта, рекомендуется оставить cookies включенными.\n',
        privacyPolicy: {
          name: 'политику конфиденциальности',
          text: 'Чтобы узнать больше, прочтите нашу {privacyPolicy}.\n',
        },
      },
      consentNotice: {
        changeDescription: 'Произошли некоторые изменения со времени вашего последнего визита, пожалуйста, обновите согласие на принятие файлов cookie.',
        description: 'Мы используем cookies, чтобы вам было удобнее пользоваться нашим сайтом. Если вы не хотите принимать все cookies или хотите узнать больше о том, как мы используем cookies, нажмите «Управление cookies».\n',
        learnMore: 'Управление cookies',
        title: '',
        privacyPolicy: {
          name: '',
          text: '',
        },
      },
      accept: 'Принять',
      acceptTitle: 'Принять cookies',
      acceptAll: 'Принять все программы',
      save: 'Сохранить',
      saveData: 'Сохранять мою конфигурацию на основе собранной информации',
      decline: 'Отклонить',
      declineAll: 'Отклонить все программы',
      close: 'Закрыть',
      enabled: 'Включено',
      disabled: 'Отключено',
      app: {
        optOut: {
          title: '(отказаться)',
          description: 'Это приложение загружено по умолчанию (но вы можете отказаться)',
        },
        required: {
          title: '(всегда требуется)',
          description: 'Это приложение необходимо для корректной работы сайта',
        },
        purposes: 'Цели',
        purpose: 'Цель',
      },
      poweredBy: '',
      newWindow: 'новое окно',
      purposes: {
        internal: 'Они гарантируют правильную работу сайта и позволяют его оптимизировать. Без них он не может нормально функционировать. Они включены по умолчанию и не могут быть отключены.',
      },
      'internal-tracker': {
        title: 'Технические cookies необходимы для правильного функционирования сайта',
        description: '',
      },
    },
    en: {
      consentModal: {
        title: 'Managing cookies',
        description: 'A cookie is a text file placed on your computer when you visit a site. \nIt allows user data to be stored in order to facilitate navigation and allow certain functionalities. \nFor some of them, your agreement is necessary; you can enable or disable them. \nHowever, to benefit from all of the site\'s features, it is advisable to keep cookies enabled.\n',
        privacyPolicy: {
          name: 'privacy policy',
          text: 'To learn more, please read our {privacyPolicy}.\n',
        },
      },
      consentNotice: {
        changeDescription: 'There were changes since your last visit, please update your consent.',
        description: 'We use cookies to give you the best experience on our website. If you do not want to accept all cookies or if you want to know more about how we use cookies, click on "Manage cookies".\n',
        learnMore: 'Manage cookies',
        title: '',
        privacyPolicy: {
          name: '',
          text: '',
        },
      },
      accept: 'Accept',
      acceptTitle: 'Accept cookies',
      acceptAll: 'Accept all apps',
      save: 'Save',
      saveData: 'Save my configuration on collected information',
      decline: 'Decline',
      declineAll: 'Decline all apps',
      close: 'Close',
      enabled: 'Enabled',
      disabled: 'Disabled',
      app: {
        optOut: {
          title: '(opt-out)',
          description: 'This app is loaded by default (but you can opt out)',
        },
        required: {
          title: '(always required)',
          description: 'This application is always required',
        },
        purposes: 'Purposes',
        purpose: 'Purpose',
      },
      poweredBy: '',
      newWindow: 'new window',
      purposes: {
        internal: 'They guarantee the proper functioning of the site and allow its optimization. Without them, it cannot function properly. They are enabled by default and cannot be disabled.',
      },
      'internal-tracker': {
        title: 'Technical cookies necessary for the proper functioning of the site',
        description: '',
      },
    },
  },
  apps: [
    {
      name: 'internal-tracker',
      title: 'Technical cookies necessary for the proper functioning of the site',
      cookies: [
        'COOKIE_CONSENT',
        'APP_SHOP_REMEMBER_ME',
        'SESSIONID',
      ],
      purposes: ['internal'],
      required: true,
    },
  ],
};

const Orejime = require('orejime');

Orejime.init(orejimeConfig);
