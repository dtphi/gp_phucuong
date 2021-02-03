<template>
  <tr>
    <td>{{userId}}</td>
    <td>{{name}}</td>
    <td>{{email}}</td>
    <td>{{createdAt}}</td>
    <td>18/01/2021</td>
    <td>
      <div class="icheck-primary">
        <input type="checkbox" :id="`key_${userId}`" name="Key" :value="userId">
        <label :for="`key_${userId}`"></label>
      </div>
    </td>
    <td>
      <BtnEdit :user-id="userId"/>
    </td>
  </tr>
</template>

<script>
    import { mapActions } from 'vuex';
    import BtnEdit from './BtnEdit';

    export default {
        name: 'ItemUser',
        components: {BtnEdit},
        props: {
            userId: { type: Number, dafault: 0 },
            name: { type: String, default: '' },
            email: { type: String, default: '' },
            createdAt: { type: String, default: '' }
        },
        data() {
            return {
            };
        },
        methods: {
        }
    };
</script>