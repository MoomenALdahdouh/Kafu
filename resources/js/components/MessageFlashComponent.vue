<template>
    <v-snackbar v-model="snackbar" :color="snackbarColor" :timeout="timeout" top>
        {{ snackbarMessage }}
        <v-btn color="white" text @click="snackbar = false">Close</v-btn>
    </v-snackbar>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            required: true
        },
        color: {
            type: String,
            default: 'success'
        }
    },
    data() {
        return {
            snackbar: false,
            snackbarMessage: '',
            snackbarColor: '',
            timeout: 3000,
        };
    }
};
</script>
