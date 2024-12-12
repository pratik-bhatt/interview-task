<template>
    <div>
        <!-- Header Section -->
        <header>
            <nav>
                <ul>
                    <li><router-link to="/">Home</router-link></li>
                    <li><router-link to="/manage">Manage Employees</router-link></li>
                    <li><router-link to="/import-employee">Import</router-link></li>
                </ul>
            </nav>
        </header>

        <!-- Main Content -->
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
    export default {
        name: "App",
    };
</script>

<style>
    /* Add some basic styling */
    header {
        background-color: #f8f9fa;
        padding: 1rem;
        border-bottom: 1px solid #ddd;
    }

    nav ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
    }

    nav ul li {
        margin-right: 1rem;
    }

    nav ul li a {
        text-decoration: none;
        color: #007bff;
    }

    nav ul li a:hover {
        text-decoration: underline;
    }
</style>
