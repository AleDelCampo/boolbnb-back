import './bootstrap';
import '~resources/scss/app.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])

const { createApp } =  Vue

  createApp({
    data() {
        return {
            filterStreet:'',
            filteredStreets:[],
        }
    },
    methods:{

        autocomplete(){
            console.log(this.filterStreet);

            axios.get('http://127.0.0.1:8000/api/autoComplete?query='+this.filterStreet+'').then(res=>{
                console.log(res);
            });
        }
    }
  }).mount('#app');