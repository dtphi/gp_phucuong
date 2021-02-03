import { extend } from 'vee-validate';
import { required, max, min } from 'vee-validate/dist/rules';

extend('url', {
  validate: (value) => {
    if (value) {
      return /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(value);
    }

    return false;
  },
  message: 'This value must be a valid URL',
});

extend('extPdf', {
  message: 'This field must be a valid pdf',
  validate: (val, args) => {
    var exts = val[0].type.split("/");
    if (exts.slice(-1)[0] == 'pdf') {
      return true;
    }

    return false;
  }
});

extend('required', {
  ...required,
  message: 'This {_field_} is required'
});
extend('max', {
  ...max,
  message: 'This {_field_} Max {length}'
});
extend('min', {
  ...max,
  message: 'This {_field_} Min {length}'
});
extend('requiredPassword', {
  ...required,
  message: 'This password is required'
});
extend('minLength', {
  validate(value, args) {
    const length = value.length;

    return length >= args.min;
  },
  params: ['min'],
  message: 'This {_field_} min {min}'
});
  
export default {
  data: () => {
      return {
        isToggle: false,
        achivementAddLists: []
      }
  },
  methods: {
    generateUUID() {
        var d = new Date().getTime();
        var d2 = (performance && performance.now && (performance.now()*1000)) || 0;
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16;
            if(d > 0){
                r = (d + r)%16 | 0;
                d = Math.floor(d/16);
            } else {
                r = (d2 + r)%16 | 0;
                d2 = Math.floor(d2/16);
            }
            return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
        });
    },
    joinDivistionNameArray(division) {
      if(division.length) {
        let result = division.map(val => val.name);
        return result.join(', ')
      } else {
        return '';
      }
    },
    appendOverLay() {
      var elem = document.createElement('div');
          elem.setAttribute("id", "overLay");
          elem.style.cssText = 'display: block';
          document.body.appendChild(elem);
    },
    removeOverLay() {
      if (document.getElementById("overLay")) {
        document.getElementById("overLay").remove();
      }
    },
    decodeHtml(html) {
      let txt = document.createElement("textarea");
      txt.innerHTML = html;
      return txt.value;
    },
    toggleHtml() {
      if (this.isToggle) {
        this.isToggle = false;
      } else {
        this.isToggle = true;
      }

      return this.isToggle;
    },
    toggleRadioCheckbox(sender) {
      const el = sender.target;
      if (!el.checked) return 0;

      var fields = document.getElementsByName(el.name);
      
      for(var idx=0; idx<fields.length; idx++) {
          var field = fields[idx];
          if (field && (parseInt(field.value) != parseInt(el.value))) {
            field.checked=false;
          }
      }
      return parseInt(el.value);
    },
    getStatusClass(status) {
      if (status == 1) {
        return [this.$options.css.showClass, this.$options.css.notShowClass];
      } else {
        return [this.$options.css.notShowClass, this.$options.css.showClass];
      }

      return [this.$options.css.showClass, this.$options.css.notShowClass];
    },
    addSelectAchivement(data) {
      data['index'] = this.generateUUID();
      data['id'] = data['index'];

      return data;
    },
    getImgUrl(url) {
      if (url) {
        return url;
      }

      return 'https://placehold.jp/100x100.png';
    }
  },
  css: {
    menuOpen: 'is-open',
    fullTimes: ['p-divisions__badge fulltimer', 'p-divisions__badge pluralOffices'],
    achivementTypes: ['', 'p-activities__performance--head idividual', 
      'p-activities__performance--head team'
    ],
    statusTypes: ['', 'p-activities__performance--hide', 'p-activities__performance--hide'],
    achievementTypeTwo:'p-activities__performance--head team',
    achievementTypeiOne: 'p-activities__performance--head idividual',
    showModalClass: 'modalWindow is-open',
    hideModalClass: 'modalWindow',
    showClass: 'w3-button w3-green w3-hover-green',
    notShowClass: 'w3-button w3-grey w3-hover-green',
    noImage: 'https://placehold.jp/100x100.png',
  },
  contains: {
    fullTimes: ['専任', '兼任'],
    achivementType:[{id:1, type:'個⼈成果'},{id:2, type:'チー ム成果'}],
    achivementTypes: ['', '個⼈成果', 'チー ム成果'],
    statusType: [{id:1, type: '非公開'}, {id: 2, type: '公開'}],
    statusTypes: ['', '非公開', '公開']
  }
};
