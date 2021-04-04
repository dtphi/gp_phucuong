<template>
   <div id="content">
        <template v-if="loading">
            <loading-over-lay :active.sync="loading"
                              :is-full-page="fullPage"></loading-over-lay>
        </template>
        <template v-else>
            <validation-observer ref="observerNewsGroup" @submit.prevent="_submitInfo">
                <div class="page-header">
                    <div class="container-fluid">
                      <div class="pull-right">
                        <button type="button" @click="_submitInfo"
                            data-toggle="tooltip" 
                            title="Cập nhật" 
                            class="btn btn-primary"><i class="fa fa-save"></i></button>

                        <the-btn-back-list-page></the-btn-back-list-page>
                      </div>
                      <h1>Nhóm Tin</h1>
                      <breadcrumb></breadcrumb>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-pencil"></i>Thêm Tin</h3>
                          </div>
                    
                        <div class="panel-body">
                                <info-edit-form ref="formEditUser"></info-edit-form>
                           </div>
                    </div>
                </div>
            </validation-observer>
        </template>
    </div>
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import TheBtnBackListPage from '../components/TheBtnBackListPage';
    import InfoEditForm from 'com@admin/Form/Infos/EditForm';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import {
        MODULE_INFO_EDIT,
    } from 'store@admin/types/module-types';
    import {
        ACTION_SHOW_MODAL_EDIT,
        ACTION_RESET_NOTIFICATION_INFO
    } from 'store@admin/types/action-types';

    export default {
        name: 'InformationEdit',
        components: {
            TheBtnBackListPage,
            Breadcrumb,
            InfoEditForm,
        },

        beforeCreate() {
            const infoId = parseInt(this.$route.params.infoId);
            this.$store.dispatch(MODULE_INFO_EDIT + '/' + ACTION_SHOW_MODAL_EDIT, infoId);
        },

        data() {
            return {
                fullPage: false
            }
        },

        computed: {
            ...mapState(MODULE_INFO_EDIT, [
                'loading',
                'updateSuccess'
            ])
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
                this.$store.dispatch(MODULE_INFO_EDIT + '/' + ACTION_RESET_NOTIFICATION_INFO, '');
            },
            _submitInfo() {
                this.$ref.formEditUser._submitInfo();
            }
        }
    };
</script>
