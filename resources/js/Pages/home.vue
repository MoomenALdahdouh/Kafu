<template>
    <main-layout>
        <v-banner class="mb-4">
            <div class="d-flex flex-wrap justify-space-between">
                <h5 class="text-h5 font-weight-bold">Home</h5>
                <v-breadcrumbs :items="breadcrumbs" class="pa-0"></v-breadcrumbs>
            </div>
        </v-banner>
        <v-card>
            <v-card-title>You're Loggin!</v-card-title>
        </v-card>
    </main-layout>
</template>
<script>
export default {
    data() {
        return {
            breadcrumbs: [
                {
                    text: "Dashboard",
                    disabled: false,
                    href: "/home",
                },
                {
                    text: "Home",
                    disabled: true,
                    href: "/home",
                },
            ],
        }
    }
};
</script>
