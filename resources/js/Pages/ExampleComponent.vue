<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <v-alert>Button</v-alert>
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component. {{message}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data (){
            return {
                message:'Hello Moomen'
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
