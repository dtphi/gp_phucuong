<template>
    <tr>
        <td>{{_getNo()}}</td>
        <td>{{user.name}}</td>
        <td>{{user.email}}</td>
        <td>{{user.createdAt}}</td>
        <td>
            <div class="icheck-primary">
                <input type="checkbox" :id="`user_id_${user.id}`" :value="user.id">
                <label :for="`user_id_${user.id}`"></label>
            </div>
        </td>
        <td>
            <div>
                <btn-edit :user-id="user.id"></btn-edit>
                <btn-delete :user-id="user.id"></btn-delete>
            </div>
        </td>
    </tr>
</template>

<script>
    import {
        mapState,
        mapActions
    } from 'vuex';
    import BtnEdit from './TheBtnEdit';
    import BtnDelete from './TheBtnDelete';

    export default {
        name: 'TheItemUser',
        components: {
            BtnEdit,
            BtnDelete
        },
        props: {
            user: {
                type: Object,
                default: {},
                validator: function (value) {
                    var id = (value.id && Number.isInteger(value.id));
                    var name = (value.name && value.name.length);

                    return (id && name);
                }
            },
            no : {
                default: 1
            }
        },
        computed: {
            ...mapState({
                meta: state => state.cfApp.meta
            })
        },
        data() {
            return {};
        },
        methods: {
            _getNo() {
                return (this.no + this.meta.from);
            }
        }
    };
</script>
