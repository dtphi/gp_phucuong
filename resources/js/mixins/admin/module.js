import {
    ACTION_RESET_NOTIFICATION_INFO
} from 'store@admin/types/action-types';

export default {
    data() {
      return {
        fullPage: true
      }
    },
    computed: {
        _errors() {
            return this.errors.length;
        }
    },
    watch: {
        'updateSuccess'(newValue, oldValue) {
            if (newValue) {
                this._notificationUpdate(newValue);
            }
        }
    },
    methods: {
        _notificationUpdate(notification) {
            this.$notify(notification);
            this.[ACTION_RESET_NOTIFICATION_INFO]('');
        },
        _errorToArrs() {
            let errs = [];
            if (this.errors.length && typeof this.errors[0].messages !== "undefined") {
                errs = Object.values(this.errors[0].messages);
            }

            if (Object.entries(errs).length === 0 && this.errors.length) {
                errs.push(this.$options.setting.error_msg_system);
            }

            return errs;
        },
        _submitInfo() {
            const _self = this;
            _self.$refs.observerInfo.validate().then((isValid) => {
                if (isValid) {
                    _self.$refs.formAddSetting._submitInfo();
                }
            });
        },
    }
  };