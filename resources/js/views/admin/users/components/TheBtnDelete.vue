<template>
    <button type="button" class="btn btn-default mb-3" @click="_showConfirm()">
    	<font-awesome-layers class="fa-1x" style="background:MistyRose">
			  <font-awesome-icon icon="circle" style="color:Tomato" />
			  <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-6" />
			</font-awesome-layers>
    </button>
</template>

<script>
    import { mapActions } from 'vuex';
    import {
      MODULE_USER,
      MODULE_USER_MODAL
    } from 'store@admin/types/module-types';
    import {
      ACTION_SET_USER_DELETE_BY_ID,
      ACTION_DELETE_USER_BY_ID
    } from 'store@admin/types/action-types';

    export default {
        name: 'TheButtonDelete',
        props: {
          userId: {
            type: Number,
            default: 0,
            validator: function(value) {
                return (value && Number.isInteger(value))
            }
          }
        },
        data() {
            return {
            };
        },
        methods: {
            ...mapActions(MODULE_USER, [
                ACTION_SET_USER_DELETE_BY_ID,
                ACTION_DELETE_USER_BY_ID
            ]),

            _showConfirm() {
                console.log(this);
                this.[ACTION_SET_USER_DELETE_BY_ID](this.userId);
                this.$modal.show('dialog', {
                  title: 'Delete Confirm',
                  text: 'Are you sure delete !',
                  buttons: [
                    {
                      title: 'Cancel',
                      handler: () => {
                        this.$modal.hide('dialog')
                      }
                    },
                    {
                      title: 'Delete',
                      handler: () => {
                        this.[ACTION_DELETE_USER_BY_ID]();
                        this.$modal.hide('dialog')
                      }
                    }
                  ]
                })
            }
        }
    };
</script>