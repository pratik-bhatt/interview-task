<template>
    <div class="container mt-4">
        <button class="btn btn-primary mb-3" @click="openModalForNewEmployee">Add New Employee</button>

        <div class="mb-3">
            <button class="btn btn-success" @click="exportData('xlsx')">Export to Excel</button>
            <button class="btn btn-info" @click="exportData('csv')">Export to CSV</button>
        </div>

        <div v-if="showModal" class="modal fade show" style="display: block; background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ employee.id ? 'Edit' : 'Add' }} Employee</h5>
                        <button type="button" class="close" @click="closeModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length" class="alert alert-danger">
                            <ul>
                                <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                            </ul>
                        </div>

                        <form @submit.prevent="submitForm">
                            <input type="hidden" v-model="employee.id" />
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input id="name" type="text" class="form-control" v-model="employee.name" placeholder="Enter name"  />
                                <div v-if="errors.name" class="text-danger">
                                    {{ errors.name }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <select id="gender" class="form-control" v-model="employee.gender" >
                                    <option disabled>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>

                                <div v-if="errors.gender" class="text-danger">
                                    {{ errors.gender }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="country">Country:</label>
                                <select id="country" class="form-control" v-model="employee.country_id" @change="fetchStates" >
                                    <option disabled>Select Country</option>
                                    <option v-for="country in countries" :key="country.id" :value="country.id">
                                        {{ country.name }}
                                    </option>
                                </select>
                                <div v-if="errors.country_id" class="text-danger">
                                    {{ errors.country_id }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="state">State:</label>
                                <select id="state" class="form-control" v-model="employee.state_id" @change="fetchCities"  :disabled="!states.length">
                                    <option disabled>Select State</option>
                                    <option v-for="state in states" :key="state.id" :value="state.id">
                                        {{ state.name }}
                                    </option>
                                </select>
                                <div v-if="errors.state_id" class="text-danger">
                                    {{ errors.state_id }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="city">City:</label>
                                <select id="city" class="form-control" v-model="employee.city_id"  :disabled="!cities.length">
                                    <option disabled>Select City</option>
                                    <option v-for="city in cities" :key="city.id" :value="city.id">
                                        {{ city.name }}
                                    </option>
                                </select>
                                <div v-if="errors.city_id" class="text-danger">
                                    {{ errors.city_id }}
                                </div>
                            </div>

                            <div v-for="(skill, index) in employee.skills" :key="index" class="form-group">
                                <label :for="'skill-' + index">Skill {{ index + 1 }}:</label>
                                <div class="input-group">
                                    <input :id="'skill-' + index" type="text" class="form-control" v-model="employee.skills[index]" placeholder="Enter skill"  />
                                    <div class="input-group-append">
                                        <button class="btn btn-danger" type="button" @click="removeSkill(index)">-</button>
                                    </div>
                                </div>


                                <div v-if="validationErrors['skills.' + index]" class="text-danger">
                                    {{ validationErrors['skills.' + index] }}
                                </div>

                            </div>
                            <button type="button" class="btn btn-success mb-3" @click="addSkill">+</button>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">{{ employee.id ? 'Update' : 'Save' }} Employee</button>
                                <button type="button" class="btn btn-secondary" @click="closeModal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="employee in employees" :key="employee.id">
                <td>{{ employee.id }}</td>
                <td>{{ employee.name }}</td>
                <td>{{ employee.gender }}</td>
                <td>{{ employee.country.name }}</td>
                <td>{{ employee.state.name }}</td>
                <td>{{ employee.city.name }}</td>
                <td>
                    <button class="btn btn-warning" @click="editEmployee(employee)">Edit</button>
                    <button class="btn btn-danger" @click="deleteEmployee(employee.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        data() {
            return {
                employees: [],
                showModal: false,
                errors: [],
                validationErrors: {},
                employee: {
                    id: null,
                    name: "",
                    gender: "",
                    country_id: null,
                    state_id: null,
                    city_id: null,
                    skills: [""],
                },
                old: {
                    country: null,
                    state: null,
                },
                countries: [],
                states: [],
                cities: [],
            };
        },
        mounted() {
            this.fetchEmployees();
            this.fetchCountries();
        },
        methods: {
            async fetchEmployees() {
                const response = await axios.get("/api/employees");
                this.employees = response.data;
            },
            async fetchCountries() {
                const response = await axios.get("/api/countries");
                this.countries = response.data;
            },
            async fetchStates() {
                if (this.old.country != this.employee.country_id) {
                    this.employee.state_id = null;
                    this.employee.city_id = null;
                }

                const response = await axios.get(`/api/states/${this.employee.country_id}`);
                this.states = response.data;
            },
            async fetchCities() {
                if (this.old.state != this.employee.state_id) {
                    this.employee.city_id = null;
                }
                const response = await axios.get(`/api/cities/${this.employee.state_id}`);
                this.cities = response.data;
            },
            addSkill() {
                this.employee.skills.push("");
                this.validationErrors["skills." + (this.employee.skills.length - 1)] = "";
            },
            removeSkill(index) {
                this.employee.skills.splice(index, 1);
                delete this.validationErrors["skills." + index];
            },
            openModalForNewEmployee() {
                this.employee = {
                    id: null,
                    name: "",
                    gender: "",
                    country_id: null,
                    state_id: null,
                    city_id: null,
                    skills: [""],
                };
                this.states = [];
                this.cities = [];
                this.errors = [];
                this.validationErrors = {};
                this.showModal = true;
            },
            async submitForm() {
                try {
                    this.errors = [];
                    this.validationErrors = {};

                    if (this.employee.id) {
                        await axios.put(`/api/employees/${this.employee.id}`, this.employee);
                    } else {
                        await axios.post("/api/employees", this.employee);
                    }
                    this.showModal = false;
                    this.fetchEmployees();
                } catch (error) {
                    if (error.response && error.response.data.errors) {
                        this.errors = Object.keys(error.response.data.errors).reduce((result, key) => {
                            result[key] = error.response.data.errors[key][0];
                            return result;
                        }, {});;
                        console.log(this.errors);

                        for (let key in error.response.data.errors) {
                            if (key.startsWith("skills.")) {
                                const index = key.split(".")[1];
                                this.validationErrors[key] = error.response.data.errors[key][0];
                            }
                        }
                    }
                }
            },
            editEmployee(employee) {
                this.employee = { ...employee };
                this.old.country = this.employee.country_id;
                this.old.state = this.employee.state_id;
                this.fetchStates();
                this.fetchCities();
                this.showModal = true;
            },
            async deleteEmployee(id) {
                if(confirm("Do you really want to delete?")) {
                    await axios.delete(`/api/employees/${id}`);
                    this.fetchEmployees();
                }
            },
            closeModal() {
                this.showModal = false;
            },

            async exportData(format) {
                const link = document.createElement('a');
                link.href = `/api/export?format=${format}`;
                link.download = `employees.${format}`;
                link.click();
            },
        },
    };
</script>

<style scoped>

</style>
