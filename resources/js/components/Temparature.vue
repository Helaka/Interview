<template>
    <div class="float-container">
            <div class="float-child green">
                <div class="form-group">
                    <label for="latitude">Latitude</label>
                    <input type="float" class="form-control":value="lat" name="latitude" placeholder="Enter Lattitude ">
                </div>
    
                <div class="form-group">
                    <label for="longitude">Longitude</label>
                    <input type="float" class="form-control"  :value="lon"  name="longitude" placeholder="Enter longitude">
                </div>
            </div>   
            <br>

            <div class="float-child green">
                <h3>Temparature Data</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Temparature</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="temparate in temparates">
                            <td>{{temparate.temparature}}</td>
                            <td>{{temparate.user_id}}</td>
                            
                        </tr>
                    </tbody>
  </table>

            </div> 
    </div>

    
</template>


<script>
    export default {
        name: "AddTemparature",
        data () {
            return {
                temparates : [],
                error:'',
                lat:'',
	            lon:''
            }
        },
        mounted:function(){
            console.log("im here");
                this.myFunction() 
        },
        created(){
            axios.get('api/temparatures')
            .then(function(response){

                  this.temparates = response.body.allitems;
            });
        },
        methods : {
            myFunction: function (){
                if(navigator.geolocation){
	               navigator.geolocation.getCurrentPosition(this.showPosition);
	            }else{
	                this.error = "Geolocation is not supported."; 
	            }
            },
            showPosition:function (position){	
                this.lat = position.coords.latitude;
                this.lon = position.coords.longitude;
                 axios.post('api/temparature/add', {lat: position.coords.latitude, long:position.coords.longitude})
                    .then(function (response) {
                        console.log(response.data);
                        // instance.$router.push("/categories");
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
	        },
            
        }
    }
</script>
 