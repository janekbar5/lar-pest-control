<template>
    <div id="app">
        <vue-bootstrap4-table :rows="rows"
                              :columns="columns"
                              :config="config"
                              @on-change-query="onChangeQuery"
                              :total-rows="total_rows">
        </vue-bootstrap4-table>
    </div>
</template>

<script>
    import VueBootstrap4Table from 'vue-bootstrap4-table'
    import Repository from "../../repositories/RepositoryFactory";
    const RecordsRepository = Repository.get("records");
    export default {
        name: 'App',
        components: {VueBootstrap4Table},
        data: function() {
            return {
                model:'locations',
                rows: [],
                columns: [
                     {label: "Id",name: "id",filter: {type: "simple",placeholder: "id"},sort: true,initial_sort: true, initial_sort_order: "asc", },
                     {label: "Title",name: "title",filter: {type: "simple",placeholder: "title"},sort: true },
                     {label: "Surface",name: "surface",filter: {type: "simple",placeholder: "surface"},sort: true },
                     {label: "Price",name: "price",filter: {type: "simple",placeholder: "price"},sort: true },                
                ],
                config: { server_mode: true },
                queryParams: {sort: [],filters: [],global_search: "",per_page: 10,page: 1,},
                total_rows: 0,
                //////
                serverParams:[],querySorting:[],queryFilters:[]
            }
        },
        mounted() {
            this.fetchData();
        },
        methods: {
            onChangeQuery(queryParams) {
                this.queryParams = queryParams
                //this.querySorting = Object.keys(params).map(key => key + '=' + params[key]).join('&')                      
                this.fetchData();                   
            },
            fetchData: async function() {
                let self = this;
                this.serverParams = Object.assign({}, this.serverParams, this.queryParams)                
                //sorting params   
                var params = { field: this.serverParams.sort[0].name,order: this.serverParams.sort[0].order }                       
                this.querySorting = Object.keys(params).map(key => key + '=' + params[key]).join('&')
                // filter params
                var costam = []
                this.serverParams.filters.forEach(element => {
                    costam.push(element.name+'='+element.text)                   
                });
                //per page
                var perpage = { perPage: this.serverParams.perPage };
                var queryPer = Object.keys(params2).map(key => key + '=' + params2[key]).join('&'); 
                

                const { data } = await RecordsRepository.sortFilter(this.model,this.querySorting+'&'+costam.join('&')); 
                self.rows = data.rows.data;
                self.total_rows = data.rows.total;      
            }

        }//meth
        
        
    }
</script>

<style>
/* .table form-control {
    display: none;
    width: 100%;
    height: calc(1.5em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    padding-right: 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color:
    #fff;
    background-clip: padding-box;
    border: 1px solid
    #ced4da;
    border-radius: 0.25rem;
    -webkit-transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.table th, .table td {
    font-size:12px;
    padding: 0rem;
    vertical-align: top;
    border-top: 1px solid 
    #dee2e6;
}
.table th, .table td {
    padding: 0rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
.table th, .table td {
    padding: 0rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
} */
</style>