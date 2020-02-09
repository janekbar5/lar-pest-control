<template>
<div>
       <div class="row">
          <div class="col-md-2">
            <select @change="doFilter()" v-model="perpage" class="form-control">
                <option value="" selected>Select per page</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="40">40</option>
                    <option value="60">60</option>								
                </select>
           </div>
           
          
            <div class="col-md-2">
            <select @change="doFilter()" v-model="client" class="form-control">
                <option value="" selected>Select Client</option>
                    <option :value="client.id" v-for="(client, index) in clients" :key="index">
						{{ client.name }} 
				</option>                                       
            </select>   
            </div>
            <div class="col-md-2">
             <select @change="doFilter();" v-model="sort" class="form-control">
                    <option value="" selected>Sort By</option> 
					<option value="price|asc" >Price (Lowest)</option>
                    <option value="price|desc" >Price (Highest)</option>
                    <option value="age|desc" >Age (Newest)</option>
                    <option value="age|asc" >Age (Oldest)</option>
                    <option value="mileage|asc" >Mileage (Lowest)</option>
                    <option value="mileage|desc" >Mileage (Highest)</option>
            </select>
             </div>                    
        </div>

       
       <div class="panel-footer flex-between">
            <div>
                <small>Showing {{from}} - {{to}} of {{total}}</small>
            </div>
            <div>
                <button class="btn btn-sm" :disabled="!prev_page_url" @click="prevPage">
                    Prev
                </button>
                <button class="btn btn-sm" :disabled="!next_page_url" @click="nextPage">
                    Next
                </button>
            </div>
        </div>


    <!-- 
		 
									</td>
		  -->

</div>
</template>

<script>
module.exports = {
  props: {        
        //editMode: { required: true },
  },  
  //props
  data: function () {   
    return {         
            col: "",
            sort: "",
            next_page_url:'',
            prev_page_url:'',
            page:'',
            total:'',
            from:'',
            to:'',
            perpage:10,
            clients: this.clients,
            client: "",
            models: "",
            model: "",
      }       
  },
  //data
  mounted() {
    this.doFilter()    
   // axios.get('v1/api/clients/index').then((res) => { this.setData2(res)  })    
  },
  //mounted
  methods: {  
        nextPage() {
                if(this.next_page_url) {
                    //console.log(this.model.next_page_url)
                    const query = Object.assign({}, this.$route.query)
                    query.page = query.page ? (Number(query.page) + 1) : 2
                    this.$router.push({
                        path: this.urlList,
                        query: query
                    })
                    this.page = query.page
                    this.doFilter()
                }
            },
            prevPage () {
                if(this.prev_page_url) {
                    const query = Object.assign({}, this.$route.query)
                    query.page = query.page ? (Number(query.page) - 1) : 1
                    this.$router.push({
                        path: this.urlList,
                        query: query
                    })
                    this.page = query.page
                    this.doFilter()
                }
            },
			doFilter: function() {
            axios    
            .get('v1/api/locations/index?'+'perpage='+this.perpage+'&loc='+this.client+'&page='+this.page)
                .then((res) => {
                    this.setData(res)                   
            })
            .catch(error => {				
					this.errored = true
					})
			.finally(() => this.loading = false)	
                           
            },
             setData(res) {
                this.records = res.data.results.data
                this.$emit('childToParent', this.records)
                this.next_page_url = res.data.results.next_page_url
                this.prev_page_url = res.data.results.prev_page_url
                this.total = res.data.results.total
                this.from = res.data.results.from
                this.to = res.data.results.to
                //filters
                this.clients = res.data.filterAllClients
               
                //console.log(this.records)
            },
            setData2(res) {
                //this.clients = res.data.results.data
            }  
  }
  //methods
}
</script>