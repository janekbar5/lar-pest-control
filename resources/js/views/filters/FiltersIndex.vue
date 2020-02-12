<template>
    <div id="app">
        <!-- <vue-bootstrap4-table :rows="rows" :columns="columns" :config="config" :actions="actions">
        </vue-bootstrap4-table> -->
        <vue-bootstrap4-table :rows="rows"
                                :columns="columns"
                                :config="config"
                                :actions="actions"
                                @on-download="onDownload">

        <template slot="name_first_name" slot-scope="props">        
            {{props.cell_value}} ggg        
      </template>

        </vue-bootstrap4-table>
    </div>
</template>

<script>
    import VueBootstrap4Table from 'vue-bootstrap4-table'

    export default {
        name: 'App',
         components: {
            VueBootstrap4Table
        },
        data: function() {
            return {
                rows: [],
                columns: [{label: "id", name: "id", filter: {type: "simple", placeholder: "id"},sort: true,},
                        {label: "Name", name: "name",filter: {type: "simple",placeholder: "Enter name"},sort: true,},
                        {label: "Surname", name: "last_name",filter: {type: "simple",placeholder: "Enter surname"},sort: true,},
                        {label: "Email", name: "email",filter: {type: "simple",placeholder: "Enter email"},sort: true,},
                        {label: "Work Phone", name: "work_phone",filter: {type: "simple",placeholder: "Enter phone"},sort: true,},
                        {label: "Leaves Days", name: "leaves_day",filter: {type: "simple",placeholder: "Enter days"},sort: true,},
                        {label: "Personal Phone", name: "personal_phone",filter: {type: "simple",placeholder: "Enter phone"},sort: true,},
                        {
                        label: "Last Name",
                        name: "id", // access nested objects properties with "."
                        slot_name: "name_first_name" // optional, if you don't provide slot name 
                                            //then default slot name will be name_last_name
                        },
                        {
                        label: "Role",
                        name: "roles[0].name",
                        filter: {
                            type: "simple",
                            placeholder: "Enter Role"
                        },
                        sort: true,
                    },
                   
                   ],
                    actions: [
                        {
                            btn_text: "Download",
                            event_name: "on-download",
                            class: "btn btn-primary my-custom-class",
                            event_payload: {
                                msg: "my custom msg"
                            }
                        }
                    ],
                    config: {
                        checkbox_rows: true,
                        rows_selectable: true,
                        card_title: "Vue Bootsrap 4 advanced table"
                    }
            }
        },
        //
         mounted() {   
             this.onFilter()             
        // this.rows = [
        // { "id": 1,"name": "Jan","last_name": "Dan" },
        // { "id": 2,"name": "Jan 1","last_name": "Dan 1" },
        // { "id": 3,"name": "Jan 2","last_name": "Dan 2" },
       
        // ]  
      },
      //
    methods: {    
       onFilter() {      
         axios    
            .get('/v1/api/users/filterusers')
                .then((res) => {
                    this.setData(res)                   
            })
            .catch(error => {				
					this.errored = true
					})
			.finally(() => this.loading = false)                   
        },
        setData(res) {            
            this.rows = res.data.results
            //this.$bar.finish()
        },
    

    


    }
       
    }
</script>