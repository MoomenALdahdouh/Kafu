<template>
    <main-layout>
        <v-banner class="mb-4">
            <div class="d-flex flex-wrap justify-space-between">
                <h5 class="text-h5 font-weight-bold">Jobs List</h5>
                <v-breadcrumbs :items="breadcrumbs" class="pa-0"></v-breadcrumbs>
            </div>
        </v-banner>
        <div class="d-flex flex-wrap align-center">
            <v-text-field
                v-model="search"
                prepend-inner-icon="mdi-magnify"
                label="Search"
                single-line
                dense
                clearable
                hide-details
                class="py-4"
                solo
                style="max-width: 300px"
            />
            <v-spacer/>
            <v-btn color="primary" @click="create">
                <v-icon dark left> mdi-plus</v-icon>
                New
            </v-btn>
        </div>
        <v-data-table
            :items="items.data"
            :headers="headers"
            :options.sync="options"
            :server-items-length="items.total"
            :loading="isLoadingTable"
            class="elevation-1"
        >
            <template #[`item.index`]="{ index }">
                {{ (options.page - 1) * options.itemsPerPage + index + 1 }}
            </template>
            <template #[`item.action`]="{ item }">
                <v-btn x-small color="yellow" @click="editItem(item)">
                    <v-icon small> mdi-pencil</v-icon>
                </v-btn>
                <v-btn x-small color="red" dark @click="deleteItem(item)">
                    <v-icon small> mdi-delete</v-icon>
                </v-btn>
            </template>
        </v-data-table>
        <v-dialog v-model="dialog" max-width="500px" scrollable>
            <v-card>
                <v-toolbar dense dark color="primary" class="text-h6">{{
                        formTitle
                    }}
                </v-toolbar>
                <v-card-text class="pt-4">
                    <v-text-field
                        v-model="form.title"
                        label="Job title"
                        :error-messages="form.errors.title"
                        type="text"
                        outlined
                        dense
                    />
                    <v-text-field
                        v-model="form.description"
                        label="Job Description"
                        :error-messages="form.errors.description"
                        type="text"
                        outlined
                        dense
                    />
                    <v-text-field
                        v-model="form.salary"
                        label="Job Salary"
                        type="number"
                        :error-messages="form.errors.salary"
                        outlined
                        dense
                    />
                    <div class="d-flex"></div>
                </v-card-text>
                <v-card-actions>
                    <v-btn :disabled="form.processing" text color="error" @click="dialog = false">Cancel</v-btn>
                    <v-spacer/>
                    <v-btn :loading="form.processing" color="primary" @click="submit"
                    >Save
                    </v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500">
            <v-card>
                <v-toolbar dense dark color="primary" class="text-h6"
                >Delete Job
                </v-toolbar
                >
                <v-card-text class="text-h6"
                >Are you sure delete this item ?
                </v-card-text
                >
                <v-card-actions>
                    <v-spacer/>
                    <v-btn :disabled="form.processing" text color="error" @click="dialogDelete = false">Cancel</v-btn>
                    <v-btn :loading="form.processing" text color="primary" @click="destroy">Yes</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </main-layout>
</template>

<script>

export default {
    props: ["items"],
    data() {
        return {
            headers: [
                {text: "No", value: "index", sortable: false},
                {text: "Title", value: "title"},
                {text: "Description", value: "description"},
                {text: "Salary", value: "salary"},
                {text: "Created At", value: "created_at"},
                {text: "Actions", value: "action", sortable: false},
            ],
            breadcrumbs: [
                {
                    text: "App",
                    disabled: false,
                    href: "/home",
                },
                {
                    text: "Jobs",
                    disabled: true,
                    href: "/job",
                },
            ],
            dialog: false,
            dialogDelete: false,
            isUpdate: false,
            isLoading: false,
            isLoadingTable: false,
            itemId: null,
            options: {},
            search: null,
            params: {},
            form: this.$inertia.form({
                title: null,
                description: null,
                salary: null,
            }),
        };
    },
    computed: {
        formTitle() {
            return this.isUpdate ? "Edit Job" : "Create Job";
        },
    },
    watch: {
        options: function (val) {
            this.params.page = val.page;
            this.params.page_size = val.itemsPerPage;
            if (val.sortBy.length != 0) {
                this.params.sort_by = val.sortBy[0];
                this.params.order_by = val.sortDesc[0] ? "desc" : "asc";
            } else {
                this.params.sort_by = null;
                this.params.order_by = null;
            }
            this.updateData();
        },
        search: function (val) {
            this.params.search = val;
            this.updateData();
        },
    },
    methods: {
        updateData() {
            this.isLoadingTable = true
            this.$inertia.get("/job", this.params, {
                preserveState: true,
                preverseScroll: true,
                onSuccess: () => {
                    this.isLoadingTable = false
                },
            });
        },
        create() {
            this.dialog = true;
            this.form.reset();
            this.form.clearErrors();
        },
        editItem(item) {
            this.form.clearErrors();
            this.form.title = item.title;
            this.form.description = item.description;
            this.form.salary = item.salary;
            this.isUpdate = true;
            this.itemId = item.id;
            this.dialog = true;
        },
        deleteItem(item) {
            this.itemId = item.id;
            this.dialogDelete = true;
        },
        destroy() {
            this.form.delete(route("job.destroy", this.itemId), {
                preverseScroll: true,
                onSuccess: () => {
                    this.dialogDelete = false;
                    this.itemId = null;
                },
            });
        },
        submit() {
            if (this.isUpdate) {
                this.form.put(route("job.update", this.itemId), {
                    preverseScroll: true,
                    onSuccess: () => {
                        this.isLoading = false;
                        this.dialog = false;
                        this.isUpdate = false;
                        this.itemId = null;
                        this.form.reset();
                    },
                });
            } else {
                this.form.post(route("job.store"), {
                    preverseScroll: true,
                    onSuccess: () => {
                        this.isLoading = false;
                        this.dialog = false;
                        this.form.reset();
                    },
                });
            }
        },
    },
};
</script>
