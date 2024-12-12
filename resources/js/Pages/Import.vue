<template>
    <div class="container">
        <h2>Import Employees</h2>

        <div v-if="message" class="alert" :class="messageType">
            {{ message }}
        </div>

        <form @submit.prevent="importEmployees" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file">Select File (CSV or Excel)</label>
                <input type="file" id="file" ref="fileInput" @change="handleFileChange" class="form-control" />
            </div>
            <button type="submit" class="btn btn-primary">Import</button>
        </form>
    </div>
</template>

<script>
    import axios from "axios";
    export default {
        name: 'Import',
        data() {
            return {
                file: null,
                message: null,
                messageType: '',
            };
        },
        methods: {
            handleFileChange(event) {
                this.file = event.target.files[0];
            },
            async importEmployees() {
                if (!this.file) {
                    this.message = 'Please select a file first!';
                    this.messageType = 'alert-danger';
                    return;
                }

                const formData = new FormData();
                formData.append('file', this.file);

                try {
                    const response = await axios.post('/api/import', formData, {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    });
                    console.log(response);

                    this.message = response.data.message;
                    this.messageType = 'alert-success';
                } catch (error) {

                    if (error.response && error.response.data.message) {
                        this.message = error.response.data.message;
                    } else {
                        this.message = 'An error occurred during the import.';
                    }
                    this.messageType = 'alert-danger';
                }
            }
        }
    };
</script>

<style scoped>
    .alert {
        margin-top: 15px;
    }
    .alert-success {
        color: green;
    }
    .alert-danger {
        color: red;
    }
</style>
