import { mapGetters, mapMutations } from 'vuex';
import * as Mutation from '../stores/mutation.types';

export default {
    computed: {
        ...mapGetters([ 'isLoading', 'errorMessages', 'passwordLastChangedAt' ])
    },
    mounted() {
        this.SET_ERRORS(null);
    },
    methods: {
        ...mapMutations([ Mutation.SET_ERRORS ]),
        setSystemErrors: error => localStorage.setItem('system_error', error),
        getSystemErrors: () => localStorage.getItem('system_error'),
        clearSystemErrors: () => localStorage.removeItem('system_error'),
        resetFormData() {
            if (this.$refs.observer) {
                this.$refs.observer.reset();
            }
            Object.assign(this.$data, this.$options.data.call(this));
        },
        datetimeFormatter(value, format = 'YYYY年M月D日 H時mm分') {
            if (!value) {
                return '';
            }
            return moment(new Date(value)).format(format);
        },
        serialize(obj) {
            let str = [];

            for (let p in obj) {
                if (obj.hasOwnProperty(p)) {
                    str.push(encodeURIComponent(p) + '=' + encodeURIComponent(obj[p]));
                }
            }
            return str.join('&');
        },
        highlight(words, query) {
            if (query === '') {
                return words;
            }
            const iQuery = new RegExp(query, 'ig');

            return words.toString().replace(iQuery, matchedTxt => {
                return '<span class="search-target">' + matchedTxt + '</span>';
            });
        },
        calculateHeight() {
            const wh = $(window).height();
            const header = $('#header .header-inner').outerHeight();
            const breadcrumb = $('#header .breadcrumb').outerHeight(true);
            const footer = $('footer').outerHeight();

            return `${wh - header - breadcrumb - footer - 68}px`;
        },
        styleHeight(isLogin = false) {
            const wh = $(window).height();
            let header = 0;

            if (!isLogin) {
                header = $('#header .header-inner').outerHeight();
            }
            const footer = $('footer').outerHeight();

            return `${wh - header - footer}px`;
        },
        convertToMB(size) {
            return (size / 1048576).toFixed(1);
        }
    }
};