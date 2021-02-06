<template>
  <tr>
    <td>{{infoId}}</td>
    <td>{{name}}</td>
    <td>{{email}}</td>
    <td>{{createdAt}}</td>
    <td>18/01/2021</td>
    <td>
      <div class="icheck-primary">
        <input type="checkbox" :id="`key_${infoId}`" name="Key" :value="infoId">
        <label :for="`key_${infoId}`"></label>
      </div>
    </td>
    <td>
      <BtnEdit :info-id="infoId"/>
      <BtnDelete :info-id="infoId"/>
    </td>
  </tr>
</template>

<script>
    import { mapActions } from 'vuex';
    import BtnEdit from './TheBtnEdit';
    import BtnDelete from './TheBtnDelete';

    export default {
        name: 'TheItemInfo',
        components: {BtnEdit, BtnDelete},
        props: {
            infoId: { type: Number, dafault: 0 },
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