<!-- se precisar rodar comando no console : npm run watch -->
<!-- npm run watch atualiza automatico se ouver alteração no codigo -->
<template>
    <div>
        <button class="btn btn-primary ml-4" @click="followUser" v-text="buttonText"></button>
    </div>
</template>

<script>

    export default {
        //busca o id do usario que foi passado no codigo do index.blade.php
                props: ['userId', 'follows'],

        mounted() {
            console.log('Component mounted.')
        },

        data: function () {
            return {
                status: this.follows,
            }

        },

        methods: {
            // vem do @click="followUser"
            followUser() {
                // axios vem do laravel para chamar uma view
                axios.post('/follow/' + this.userId)
                    .then(response => {             
                    //atualiza a pagina com verdadeiro status
                    this.status = ! this.status;
                    // alert(response.data); para mostrar o dado que o response carrega
                    console.log(response.data);
                    })
                    // para tratar erro 404 devido a entrada do public function __construct() no FollowsController.php
                    .catch(errors =>{
                        if(errors.response.status == 401) {
                            //se for um erro 401 redirecionar para a pagina de login
                            window.location = '/login';
                        }
                    });
            }
        },

        computed: {
            buttonText() {
                return (this.status) ? 'Não Seguir' : 'Seguir';
            }
        }

    }
</script>
