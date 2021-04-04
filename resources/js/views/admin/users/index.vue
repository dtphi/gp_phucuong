<template>
    <div id="content">
        <the-header-page></the-header-page>
        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                    <i class="fa fa-list"></i> Danh sách người dùng</h3>
                </div>
                <div class="panel-body">
                    <div id="form-category">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr role="row">
                                    <th style="width: 1px;" class="text-center">No</th>
                                    <th style="width: 1px;" class="text-center">
                                        <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
                                    </th>
                                    <th>Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-right">Created from</th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <template v-if="loading">
                                    <loading-over-lay
                                        :active.sync="loading"
                                        :is-full-page="fullPage"></loading-over-lay>
                                </template>
                                <template v-if="_notEmpty">
                                    <item
                                        v-for="(item,index) in _userList"
                                        :no="index"
                                        :user="item"
                                        :key="item.id"></item>
                                </template>
                                </tbody>
                            </table>
                        </div>
                        <paginate></paginate>
                    </div>
                </div>
            </div>
        </div>
        <user-add-form></user-add-form>
        <user-edit-form></user-edit-form>
    </div>
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import TheHeaderPage from './components/TheHeaderPage';
    import UserAddForm from 'com@admin/Modal/Users/AddForm';
    import UserEditForm from 'com@admin/Modal/Users/EditForm';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import Item from './components/TheItem';
    import BtnAdd from './components/TheBtnAdd';
    import Paginate from 'com@admin/Pagination';
    import {
        MODULE_USER,
        MODULE_USER_MODAL,
        MODULE_USER_EDIT_MODAL
    } from 'store@admin/types/module-types';
    import {
        USERS_SET_USER_LIST
    } from 'store@admin/types/mutation-types';
    import {
        ACTION_GET_USER_LIST,
        ACTION_RESET_NOTIFICATION_INFO
    } from 'store@admin/types/action-types';

    export default {
        name: 'UserList',
        beforeCreate() {
            this.$store.dispatch(MODULE_USER + '/' + ACTION_GET_USER_LIST);
        },
        components: {
            TheHeaderPage,
            Breadcrumb,
            UserAddForm,
            UserEditForm,
            Item,
            BtnAdd,
            Paginate
        },
        data() {
            return {
                fullPage: false
            };
        },
        computed: {
            ...mapGetters(['isNotEmptyList']),

            ...mapState(MODULE_USER, [
                'users',
                'loading'
            ]),

            ...mapState(MODULE_USER_MODAL, [
                'insertSuccess'
            ]),

            ...mapState(MODULE_USER_EDIT_MODAL, [
                'updateSuccess'
            ]),

            _userList() {
                return this.users;
            },

            _notEmpty() {
                return this.isNotEmptyList;
            }
        },
        watch: {
            'insertSuccess'(newValue, oldValue) {
                if (newValue) {
                    this._notificationUpdate(newValue);
                }
            },
            'updateSuccess'(newValue, oldValue) {
                if (newValue) {
                    this._notificationUpdate(newValue);
                }
            }
        },
        mounted() {
            window.Echo.channel('search-user')
            .listen('.searchAllResults', (e) => {
                this.$store.commit(MODULE_USER + '/' + USERS_SET_USER_LIST, e.users.results)
            })
        },
        methods: {
            ...mapActions(['getNo']),
            _notificationUpdate(notification) {
                this.$notify(notification);
                this.$store.dispatch(MODULE_USER_MODAL + '/' + ACTION_RESET_NOTIFICATION_INFO, '');
            }
        }
    };
</script>
