import Vue from 'vue';
import { ValidationObserver, ValidationProvider, setInteractionMode, extend, localize } from 'vee-validate';
import ja from 'vee-validate/dist/locale/ja.json';
import * as rules from 'vee-validate/dist/rules';

// Custom validation text
const validationText = {
    ja: {
        messages: {
            min: '{_field_}は{length}文字以上で入力してください',
            max: '{_field_}は{length}文字以内で入力してください',
            digits: '{_field_}は{length}桁の数字で入力してください',
            alpha_num: '{_field_}は半角英数字で入力してください'
        }
    }
};

// Install VeeValidate rules and localization
Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});

extend('email', value => {
    return /^[a-z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?(?:\.[a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?)*$/.test(value);
});
extend('katakana', value => {
    if (/^([ァ-ヶー 　]+)$/.test(value)) {
        return true;
    }
    return '全角カナで入力してください。';
});
extend('phone', value => {
    if (/^(?:\d{2}-\d{4}-\d{4}|\d{3}-\d{3}-\d{4}|\d{3}-\d{4}-\d{4}|\d{3}-\d{4}-\d{5}|\d{4}-\d{2}-\d{4}|\d{4}-\d{3}-\d{3})$/.test(value)) {
        return true;
    }
    return '{_field_}の形式が正しくありません';
});

localize('ja', ja);
localize(validationText);
setInteractionMode('lazy');

Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);