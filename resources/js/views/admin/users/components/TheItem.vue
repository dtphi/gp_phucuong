<template>
    <tr>
        <td>{{user.id}}</td>
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
            <BtnEdit :user-id="user.id"/>
            <BtnDelete :user-id="user.id"/>
        </td>
    </tr>
</template>

<script>
    import {mapActions} from 'vuex';
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
            }
        },
        data() {
            return {};
        },
        methods: {}
    };
</script>
