<template>
<v-container >
    <v-row >
      <div class="div" md="6">
          <p>Please select one: </p>   
          <input type="radio" id="Uno" value="Uno" v-model="picked" >
          <label for="Uno" >Country</label>          
          <input type="radio" id="Dos" value="Dos" v-model="picked" class="inp">
          <label for="Dos" >City</label>          
          <input type="radio" id="Tres" value="Tres" v-model="picked" class="inp">
          <label for="Tres" >Location</label>

          <div v-show="picked==='Uno'">
          <p>Country: </p>   
          <input v-model="countries.name" placeholder="Country" >    
          <button v-on:click="AddCountry" class="inp btm">Add Country</button>    
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
      </div>
      
      <div class="div" md="6">
          <p>Select File to Import: </p>
          <input type="file" id="file" name="fileSubmit" @change="SaveFile">
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
      {
        alert("Country success");
        await this.getListCountries();  
      }
      if(result.data.status == 'warning')
      alert(result.data.message); 

    },
    
    async AddCity() {        
      this.cities.idcountry = this.selectedcountry;
      const result = await axios.post(this.url + '/api/city/add', this.cities);
      if(result.data.status == 'success')
      {
        alert("City success");
        await this.getListCities();
      }
      if(result.data.status == 'warning')
      alert(result.data.message);  
    },

    async AddLocation() {        
      this.locations.idcity = this.selectedcity;        
      const result = await axios.post(this.url + '/api/locations/add', this.locations);
      if(result.data.status == 'success')
      {
        alert("Location success");
        await this.getListCities(); 
        await this.getListLocation(); 
      }
      if(result.data.status == 'warning')
      alert(result.data.message); 
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

    async SaveFile(event){
      const file = event.target.files[0];
      const formData = new FormData();
      formData.append("file", file);
      
      const result =  await axios.post(this.url + '/api/locations/saveFile', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
      })
      if(result.data.status == 'success')
      { 
        await this.getListLocation(); 
      }
    },
  }
 
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

.div {
  font-family: '微软雅黑',arail; 
  border: 1px solid #eee;
  border-radius: 2px;
  padding: 20px 20px;
  margin-top: 1em;
  margin-bottom: 30px;
  user-select: none;
  overflow-x: auto;   
} 

.inp {  
  margin-left: 1em; 
} 

select{
  padding: 3px 10px;
  font-family: '微软雅黑',arail;
  border-color: rgb(151, 192, 135);
}

input {
  padding: 3px 10px;
  font-family: '微软雅黑',arail;
  border-color: rgb(151, 192, 135);
}

button {
  padding: 3px 10px;
  border: 2px solid rgb(151, 192, 135); 
  border-radius: 2px;
  color: #333;
  background-color:rgb(151, 192, 135);  
  font-size: 14px;
  font-family: '微软雅黑',arail;   
}

.btn {
  padding: 3px 10px;  
  border-radius: 2px;
  color: #333;    
  font-size: 14px;
  font-family: '微软雅黑',arail; 
}


table {
  table-layout: fixed;
  width: 100%;
  border-collapse: collapse;
  border: 1px solid rgb(151, 192, 135);
  border-radius: 10px;
}

thead th {
  width: 30%;
  background-color:rgb(151, 192, 135);
  font-family: '微软雅黑',arail; 
}

body th{
  border: 0.5px solid rgb(151, 192, 135);
  font-family: '微软雅黑',arail; 
}

</style>
