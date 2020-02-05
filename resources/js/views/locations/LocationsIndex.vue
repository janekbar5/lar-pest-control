<template>
    <div class="panel">

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


    <table class="table">
	  <thead>
		<tr>
		  <th scope="col">#</th>
		  <th scope="col">First</th>
		  <th scope="col">Last</th>
		  <th scope="col">Handle</th>
		</tr>
	  </thead>
	  <tbody>
		<tr>
		  <th scope="row">1</th>
		  <td>
		   <select @change="doFilter()" v-model="perpage" class="form-control">
					<option value="" selected>Select per page</option>
					<option value="10">10</option>
					<option value="20">20</option>
                    <option value="40">40</option>
                    <option value="60">60</option>								
			</select>
		  </td>
		  <td>
									<!-- <select @change="doFilter()" v-model="location" class="form-control">
										<option value="" selected>Select Location</option>
										<option :value="location.locations.id" v-for="location in records" >{{ location.locations.title }}</option>
										
									  </select> -->
		  
		  </td>
		  <td>					<div class="ct-form--item ct-u-marginBottom10">
								
								<label class="container_check">Reset
								  <input type="radio" @change="changeColor(color,$event)" :value="0" name="radio">
								  <span class="checkmark"></span>
								</label>
								<label class="container_check">Red
								  <input type="radio" @change="changeColor(color,$event)" :value="1" name="radio">
								  <span class="checkmark"></span>
								</label>
								<label class="container_check">Blue
								  <input type="radio" @change="changeColor(color,$event)" :value="2" name="radio">
								  <span class="checkmark"></span>
								</label>
								<label class="container_check">Green
								  <input type="radio" @change="changeColor(color,$event)" :value="3" name="radio">
								  <span class="checkmark"></span>
								</label>
								<label class="container_check">Yellow
								  <input type="radio" @change="changeColor(color,$event)" :value="4" name="radio">
								  <span class="checkmark"></span>
								</label>
								</div></td>
		</tr>
		<tr>
		  <th scope="row"></th>
		  <td>
									<select @change="doFilter()" v-model="client" class="form-control">
                                        <option value="" selected>Select Make</option>
                                        <option :value="client.id" v-for="(client, index) in clients" :key="index">
										{{ client.title }} 
										</option>                                       
                                    </select>
		  </td>
		  <td>
		  <select @change="doFilter();" v-model="sort" class="form-control">
                                        <option value="" selected>Sort By</option> 
										<option value="price|asc" >Price (Lowest)</option>
                                        <option value="price|desc" >Price (Highest)</option>
                                        <!--<option value="age|desc" >Age (Newest)</option>
                                        <option value="age|asc" >Age (Oldest)</option>-->
                                        <option value="mileage|asc" >Mileage (Lowest)</option>
                                        <option value="mileage|desc" >Mileage (Highest)</option>
                                    </select>
									</td>
		  <td>c</td>
		</tr>
		<tr>
		  <th scope="row">3</th>
		  <td>
									<select @change="doFilter()" v-model="model" class="form-control">
                                        <option value="" selected>Select Model</option>
                                        <option :value="model.id" v-for="(model, index) in models" :key="index">
										{{ model.title }} ({{ model.count }})
										</option> 
                                    </select>
		  </td>
		  <td></td>
		  <td></td>
		</tr>
	  </tbody>
	</table>





								
								
								
								
								
		
	<table class="table">
	  <thead>
		<tr>
		  <th scope="col">#id</th>
		  <th scope="col">title</th>
		  <th scope="col">price</th>
		  <th scope="col">mileage</th>
		  <th scope="col">reg_year</th>
		  <th scope="col">price</th>
		  <th scope="col">location</th>
		</tr>
	  </thead>
	  <tbody>
		
		  <tr v-for="record in records">		  
		  <td>{{ record.id }}</td>
		  <td>{{ record.title }}</td>
		  <td>{{ record.price }} </td>
		  <td>{{ record.mileage }} </td>
		  <td>{{ record.reg_year }} </td>
		  <td>{{ record.price }} </td>
		  <td>{{ record.location }} </td>
		</tr>
		
	  </tbody>
	</table>
    </div>
</template>


<script>
export default {
    data () {
        return {
            url:'',
            settings: {},
            urlList: '',
            urlEdit: '',
            apiList: '',
            //    
            editMode: this.$route.meta.mode,

            records: {},
            loading: true,
            errored: false,
            perpage:10,
            clients: this.clients,
            client: "",
            models: "",
            model: "",
            location: "",
            color: null,
            col: "",
            sort: "",
            next_page_url:'',
            prev_page_url:'',
            page:'',
            total:'',
            from:'',
            to:'',
            }

    },

  computed: {
	  filteredBancodedaos () {
		return this.bancodedados.filter(() => {
		  // using this.mySearch
		})
	  },
	  filteredRecords: function () {
		var self = this
		return self.records.filter(function (rec) {
		  return rec.name.indexOf(self.searchQuery) !== -1
		})
	  },
	   unique () {
		  return function (arr, key) {
			var output = []
			var usedKeys = {}
			for (var i = 0; i < arr.length; i++) {
			  if (!usedKeys[arr[i][key]]) {
				usedKeys[arr[i][key]] = true
				output.push(arr[i])
			  }
			}
			return output
		  }
		},
	  
	},
  
  filters: {
    currencydecimal (value) {
      return value.toFixed(2)
    }
  },
  
  mounted () {
    this.doFilter()
    //this.getClients()
    this.clients = [
                        {id: 1,title: 'Clent 1',age: 30 },
                        {id: 2,title: 'Clent 2',age: 30 },
                        {id: 3,title: 'Clent 3',age: 30 },
                ]
  },
  created() {
    this.$eventHub.$on('settings', this.modelSettings) 
},
  methods: {
           modelSettings(settings){
            //return name
            this.settings = settings;
            this.urlList = settings.urlList
            this.urlEdit = settings.urlEdit
            //
            this.apiList = settings.apiList
            this.apiDelete = settings.apiDelete
            //console.log(settings)  
        },
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
            .get('v1/api/locations/filter?'+'perpage='+this.perpage+'&loc='+this.client+'&page='+this.page)
                .then((response) => {
                    this.setData(response)
                   
            })
            .catch(error => {				
						this.errored = true
						})
						.finally(() => this.loading = false)	


			//  axios
            //   .get('v1/api/locations/filter?'+'perpage='+this.perpage+'&loc='+this.client)
            //   //.get('v1/api/locations/filter?&loc='+this.client)
            //   //.get('/v1/locations/filter')
			//   .then(response => {
            //     this.records = response.data.data
            //     this.next_page_url = response.data.next_page_url
            //     this.prev_page_url = response.data.prev_page_url
            //     console.log(this.prev_page_url)
			//   })
			//   .catch(error => {
			// 	console.log(error)
			// 	this.errored = true
			//   })
            //   .finally(() => this.loading = false)
              
              
            },
             setData(response) {
                this.records = response.data.data
                this.next_page_url = response.data.next_page_url
                this.prev_page_url = response.data.prev_page_url
                this.total = response.data.total
                this.from = response.data.from
                this.to = response.data.to
                //console.log(response.data.prev_page_url)
            },
            
			getClents() {
                //alert('ffff')			
				this.clients = [
                        {id: 1,title: 'Clent 1',age: 30 },
                        {id: 2,title: 'Clent 2',age: 30 },
                        {id: 3,title: 'Clent 3',age: 30 },
                ]  
			},
			getModels: function() {

                this.models = [
                        {id: 1,title: 'Model 1',age: 30 },
                        {id: 2,title: 'Model 2',age: 30 },
                        {id: 3,title: 'Model 3',age: 30 },
                ]
                //alert('ffff')			
				// axios				  
				//    .get("http://www.grand-cars.une/v1/getmodels/"+this.make)
				//    .then(res => {
				// 	this.models = res.data;
				//   })
				  //console.log(this.models);  
			},
			getLocations: function() {
			  //return uniq(this.records.map(p => p.locations.title))
			  //return this.records;
			  //return 'ddddd'; 
			  //this.records;
			  let items = ['a', 'b', 'c']
			   
			},
			changeColor: function(item, event){			  
			  this.col = event.target.value;
			  this.doFilter();
			},
  
  }

}
  
  
  

</script>
