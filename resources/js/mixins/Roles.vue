<script>
  export default {
    methods: {     
      $role(roleName) {
        return Roles.indexOf(roleName) !== -1;
      },
    },
  };
</script>