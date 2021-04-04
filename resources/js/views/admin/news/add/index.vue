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
                            title="Lưu" 
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
                             <info-add-form ref="formAddUser"></info-add-form>
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

    import InfoAddForm from 'com@admin/Form/Infos/AddForm';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import TheBtnBackListPage from '../components/TheBtnBackListPage';

    export default {
        name: 'InformationAdd',
        components: {
            Breadcrumb,
            InfoAddForm,
            TheBtnBackListPage
        },
        data() {
            return {
                loading: false,
                fullPage: true
            }
        },
        methods: {
            _submitInfo() {
                this.$refs.formAddUser._submitInfo()
            }
        }
    };
</script>
