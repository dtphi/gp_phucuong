<template>
    <button type="button" class="btn btn-default mb-3" @click="showDiaglogConfirm()">
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
        name: 'ButtonDelete',
        props: {
            userId: { type: Number, dafault: 0 }
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

            showDiaglogConfirm() {
                console.log(this);
                this.setUserDeleteById(this.userId);
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
                        this.deleteUserById();
                        this.$modal.hide('dialog')
                      }
                    }
                  ]
                })
            }
        }
    };
</script>