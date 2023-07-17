<template>
    <main-layout>
        <v-banner class="mb-4">
            <div class="d-flex flex-wrap justify-space-between">
                <h5 class="text-h5 font-weight-bold">Jobs List</h5>
                <v-breadcrumbs :items="breadcrumbs" class="pa-0"></v-breadcrumbs>
            </div>
        </v-banner>
        <v-snackbar v-model="snackbar" :color="snackbarColor" :timeout="timeout" top>
            {{ snackbarMessage }}
            <v-btn color="white" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>
        <!--<v-alert v-if="$page.props.flash.message" :type="$page.props.flash.message.type">{{$page.props.flash.message.text}}</v-alert>-->
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
            <!--            <template #item.company="{ item }">
                            {{ item.company.name }}
                        </template>-->
            <template #[`item.action`]="{ item }">
                <v-btn x-small color="yellow" @click="editItem(item)">
                    <v-icon small> mdi-pencil</v-icon>
                </v-btn>
                <!--                <v-btn x-small color="red" dark @click="deleteItem(item)">
                                    <v-icon small> mdi-delete</v-icon>
                                </v-btn>-->
            </template>
        </v-data-table>
        <v-dialog v-model="dialog" max-width="500px" scrollable>
            <v-card>
                <v-toolbar dense dark color="primary" class="text-h6">{{
                        formTitle
                    }}
                </v-toolbar>
                <v-card-text class="pt-4">
                    <v-form>
                        <v-text-field
                            v-model="form.name"
                            label="Job name"
                            :error-messages="form.errors.name"
                            type="text"
                            outlined
                            dense
                        ></v-text-field>
                        <v-textarea
                            v-model="form.description"
                            label="Job Description"
                            :error-messages="form.errors.description"
                            type="text"
                            outlined
                            dense
                        ></v-textarea>
                        <v-select
                            v-if="hasCompanies"
                            label="Company"
                            v-model="form.company_id"
                            :items="companies"
                            item-value="id"
                            item-text="name"
                            variant="outlined"
                            :error-messages="form.errors.company_id"
                            outlined
                            dense
                        ></v-select>
                        <v-text-field
                            v-model="form.salary"
                            label="Job Salary"
                            type="number"
                            :error-messages="form.errors.salary"
                            outlined
                            dense
                        ></v-text-field>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn :disabled="form.processing" text color="error" @click="dialog = false">Cancel</v-btn>
                    <v-spacer/>
                    <v-btn color="primary" @click="confirmSubmit"
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
        <v-dialog v-model="confirmDialog" max-width="400px">
            <v-card>
                <v-card-title class="headline">Confirmation</v-card-title>
                <v-card-text>
                    Are you sure you want to post the job?
                    <strong class="red--text text--darken-2 font-weight-bold">$50 </strong><strong>will be deducted from the wallet for this job.</strong>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red darken-1" text @click="confirmDialog = false">Cancel</v-btn>
                    <v-btn color="green darken-1" :loading="form.processing" text @click="submit">Submit</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </main-layout>
</template>

<script>

export default {
    props: {
        items: Object,
        companies: Array,
        permissions: Array,
    },
    data() {
        return {
            headers: [
                {text: "No", value: "index", sortable: false},
                {text: "name", value: "name"},
                {text: "Description", value: "description"},
                /*{text: "Company", value: "company"},*/
                {text: "Salary", value: "salary"},
                {text: "Status", value: "status"},
                {text: "Created At", value: "created_at"},
                {text: "Actions", value: "action", sortable: false},
            ],
            breadcrumbs: [
                {
                    text: "Dashboard",
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
            confirmDialog: false,
            isUpdate: false,
            isLoading: false,
            isLoadingTable: false,
            itemId: null,
            options: {},
            search: null,
            params: {},
            snackbar: false,
            snackbarMessage: '',
            snackbarColor: '',
            timeout: 3000,
            form: this.$inertia.form({
                name: null,
                description: null,
                salary: null,
                company_id: null,
                status: null,
            }),
        };
    },
    computed: {
        formTitle() {
            return this.isUpdate ? "Edit Job" : "Create Job";
        },
        hasCompanies() {
            return this.companies.length > 0;
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
            this.isUpdate = false;
            this.form.reset();
            this.form.clearErrors();
        },
        editItem(item) {
            this.form.clearErrors();
            this.form.name = item.name;
            this.form.description = item.description;
            this.form.salary = item.salary;
            this.form.company_id = item.company_id;
            this.isUpdate = true;
            this.itemId = item.id;
            this.dialog = true;
        },
        deleteItem(item) {
            this.itemId = item.id;
            this.dialogDelete = true;
        },
        confirmSubmit() {
            this.confirmDialog = true;
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
            this.confirmDialog = false;
            if (this.isUpdate) {
                this.form.put(route("job.update", this.itemId), {
                    preverseScroll: true,
                    onSuccess: (response) => {
                        this.isLoading = false;
                        this.dialog = false;
                        this.isUpdate = false;
                        this.itemId = null;
                        this.form.reset();
                        this.handleMessage(response);
                    },
                });
            } else {
                this.form.post(route("job.store"), {
                    preverseScroll: true,
                    onSuccess: (response) => {
                        this.isLoading = false;
                        this.dialog = false;
                        this.confirmDialog = false;
                        this.form.reset();
                        this.handleMessage(response);
                    },
                    onError: (response) => {
                        //this.handleMessage(response);
                    }
                });
            }
        },
        handleMessage(response) {
            this.isLoading = false;
            this.dialog = false;
            this.isUpdate = false;
            this.itemId = null;
            this.form.reset();
            this.snackbarMessage = response.props.flash.message.text;
            this.snackbarColor = response.props.flash.message.type;
            this.snackbar = true;
        },
    },
};
</script>
