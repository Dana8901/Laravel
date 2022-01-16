<template>
<v-container class="mx-3 card-general">
    <v-row>
      <v-col md="6" class="mx-5">
          <v-card xs12 sm12 md12 lg12 xl12 >
            <p>Please select one: </p>   
            <input type="radio" id="Uno" value="Uno" v-model="picked">
            <label for="Uno">Country</label>
            <br>
            <input type="radio" id="Dos" value="Dos" v-model="picked">
            <label for="Dos">City</label>
            <br>
            <input type="radio" id="Tres" value="Tres" v-model="picked">
            <label for="Tres">Location</label>
            <br>
          </v-card>
      </v-col>
      <v-col md="6" class="mx-5">
        <v-card xs12 sm12 md12 lg12 xl12 >
        <v-form id="uploadForm" enctype="multipart/form-data" v-on:change="SaveFile">
          <input type="file" id="file" name="file">
        </v-form> 
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <div v-show="picked==='Uno'">
          <p>Country: </p>   
          <input v-model="countries.name" placeholder="Country" >    
          <button v-on:click="AddCountry" class="inp">Add Country</button>    
        </div>
        <div v-show="picked==='Dos'">
          <p>Select a Country: </p>   
          
            <select v-model="selectedcountry" 
                        name="country" style="width: 150px; margin-bottom: 10px; ">
              <option v-for="c in countrylist"
                              :value="c.idcountry"
                              v-text="c.name" v-bind:key="c.idcountry"></option>
          </select>
          
          <input v-model="cities.name" placeholder="City" class="inp">    
          <button v-on:click="AddCity" class="inp">Add City</button>
        </div>
        <div v-show="picked==='Tres'">
          <p>Select a City: </p> 
            <select v-model="selectedcity" 
                        name="city" style="width: 150px; margin-bottom: 10px; ">
              <option v-for="c in citylist"
                              :value="c.idcity"
                              v-text="c.name" v-bind:key="c.idcity"></option>
          </select>
            <input v-model="locations.name" placeholder="Location" class="inp">    
          <button v-on:click="AddLocation" class="inp">Add Location</button>
        </div>
    </v-row>

    <v-row>
      <div class="div" >
        <div > 
          <table >
            <thead>
              <tr>
                <th>Country</th>
                <th>City</th>
                <th>Location</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="pl in locationlist" v-bind:key="pl.idplace">
                <th>{{pl.nameCountry}}</th>
                <th>{{pl.nameCity}}</th>
                <th>{{pl.nameLocation}}</th>
              </tr>
            </tbody>
          </table>
        
        </div>      
      </div>
    </v-row>
</v-container>
</template>

<script>
import axios from "axios";
export default {
  name: 'CitiesView',  
  data() {
      return {   
        url: "http://127.0.0.1:8000", 
        picked: '',       
        countries: {
          idcountry:0,
          name: ''
        },
        cities: {
          idcity:0,
          name: '',
          idcountry:0,
        },
        locations: {
          idlocation:0,
          name: '',
          idcity:0,
        },
        selectedcountry: 1,      
        selectedcity: 1,       
        countrylist: [],       
        citylist: [],       
        locationlist: [],    
        file: ''   
      }
  },
  async mounted(){
    await this.getListCountries();
    await this.getListCities();
    await this.getListLocation();
  },
  methods: {
    async AddCountry() {           
      const result = await axios.post(this.url + '/api/country/add', this.countries);
      if(result.data.status == 'success')
        await this.getListCountries();      
    },
    
    async AddCity() {        
      this.cities.idcountry = this.selectedcountry;
      const result = await axios.post(this.url + '/api/city/add', this.cities);
      if(result.data.status == 'success')
        await this.getListCities();  
    },

    async AddLocation() {        
      this.locations.idcity = this.selectedcity;        
      const result = await axios.post(this.url + '/api/locations/add', this.locations);
      if(result.data.status == 'success')
        await this.getListCities(); 
    },

    async getListCountries() {  
      const result = await axios.post(this.url + '/api/country/all') 
      this.countrylist = result.data.data;
    },

    async getListCities() {  
      const result = await axios.post(this.url + '/api/city/all') 
      this.citylist = result.data.data;
    },

    async getListLocation() {  
      const result = await axios.post(this.url + '/api/locations/all') 
      this.locationlist = result.data.data;
    },

    async SaveFile(){
        let formData = new FormData();
        formData.append('file', this.file);
        axios.post(this.url + '/api/locations/saveFile', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
        })
    },
  }
 
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.div {
  font-family: sans-serif;
  border: 1px solid #eee;
  border-radius: 2px;
  padding: 20px 30px;
  margin-top: 1em;
  margin-bottom: 40px;
  user-select: none;
  overflow-x: auto;
}

.inp {  
  margin-left: 1em; 
  
}

body {
  font-family: Helvetica Neue, Arial, sans-serif;
  font-size: 14px;
  color: #444;
}

table {
  border: 2px solid #568570;
  border-radius: 5px;
  background-color: #fff;
}

th {
  color: rgba(49, 48, 48, 0.66);  
  }

/* th {
  background-color: #42b983;
  color: rgba(255,255,255,0.66);
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
} */

/* td {
  background-color: #f9f9f9;
} */

th, td {
  min-width: 120px;
  padding: 10px 20px;
}

.arrow {
  display: inline-block;
  vertical-align: middle;
  width: 0;
  height: 0;
  margin-left: 5px;
  opacity: 0.66;
}








</style>
