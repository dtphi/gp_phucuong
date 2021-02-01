<template>
  <tr>
    <td>1</td>
    <td>Admin</td>
    <td>admin@mail.com</td>
    <td>24/12/2020</td>
    <td>18/01/2021</td>
    <td>
      <div class="icheck-primary">
        <input type="checkbox" id="key_01" name="Key" value="">
        <label for="key_01"></label>
      </div>
    </td>
    <td>
      <BtnEdit />
    </td>
  </tr>
</template>

<script>
    import { mapActions } from 'vuex';
    import BtnEdit from './BtnEdit';

    export default {
        name: 'ItemUser',
        components: {BtnEdit},
        data() {
            return {
            };
        },
        methods: {
        }
    };
</script>