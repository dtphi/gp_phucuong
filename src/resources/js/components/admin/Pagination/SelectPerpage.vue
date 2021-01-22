<template>
    <div class="dataTables_length">
	    <label>Show 
	      <select aria-controls="example1" class="custom-select custom-select-sm form-control form-control-sm">
	        <option value="10">10</option>
	        <option value="25">25</option>
	        <option value="50">50</option>
	        <option value="100">100</option>
	      </select> entries</label>
    </div>
</template>

<script>

    export default {
        name: 'SelectPerpage',
        components: {
        }
    };
</script>