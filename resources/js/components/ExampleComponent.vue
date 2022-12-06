<template>
    <div v-show="this.name != null" class="alert alert-primary" role="alert">
        Добавлена новая статья: <strong>{{this.name}}</strong>
    </div>
    <!-- <div v-show="this.name != null" class="alert alert-primary" role="alert">
       Добавлена новая статья <strong>{{this.name}}</strong>
    </div> -->
</template>

<script>
    export default {
        data(){
            return {name:null}
        },
        // methods:{
        // showAlert() {
        //     // Use sweetalert2
        //     this.$swal({
        //         icon:'success',
        //         title:'Добавлена новая запись: ',
        //         text: this.name,
        //     });
        //     }
        // },
           created() {
            window.Echo.channel('test').listen('PublicArticleEvent', (name)=>{
                console.log(name[1]);
                this.name=name[1];
                // this.showAlert();
            });          
            
        }
    }
</script>