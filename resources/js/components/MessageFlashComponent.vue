<template>
    <div>
        <!-- Your component content -->
        <v-snackbar v-model="snackbar" :color="snackbarColor" :timeout="timeout" top>
            {{ snackbarMessage }}
            <v-btn color="white" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>
    </div>
</template>

<script>
export default {
    data() {
        return {
            snackbar: false,
            snackbarMessage: '',
            snackbarColor: '',
            timeout: 3000, // Adjust the timeout as needed
        };
    },
    methods: {
        someAction() {
            // Perform your action that triggers the server request
            axios.post('/your-url')
                .then(response => {
                    // Handle the success response
                    this.snackbarMessage = response.data.message;
                    this.snackbarColor = 'success';
                    this.snackbar = true;
                })
                .catch(error => {
                    // Handle the error response
                    this.snackbarMessage = 'An error occurred.';
                    this.snackbarColor = 'error';
                    this.snackbar = true;
                });
        },
    },
};
</script>
