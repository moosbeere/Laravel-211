<template>
<div>
<div class="alert alert-success" role="alert">
    <strong>{{ name }}</strong>
</div>
        <!-- <div class="alert alert-success" role="alert">
            <h4 class="alert-heading"></h4>
            <p>{{ name }}</p>
        </div> -->
</div>
</template>
<script>
export default {
        data(){
            return {
                name: null,
            }
        },

        created() {
            window.Echo.channel('test').listen('NewArticleEvent', ( name ) => {
               this.name=name;
            });
        }
}
</script>
