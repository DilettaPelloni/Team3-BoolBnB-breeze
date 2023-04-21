<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

export default {
    name: "Messages",
    props: {
        messages: Array,
    },
    components: {
        Head,
        AuthenticatedLayout,
        Link,
    },
};
</script>

<template>
    <Head :title="Messaggi" />

    <AuthenticatedLayout>
        <div class="main-container">
            <h1>I messaggi dell'appartamento:</h1>
            <ul>
                <li v-for="message in messages">
                    <div class="utente pb-[20px]">
                        <div class="nome flex items-center">
                            <font-awesome-icon
                                :icon="['fas', 'circle-user']"
                                style="
                                    color: rgb(254 91 95 / 78%);
                                    padding-right: 9px;
                                "
                            />
                            <p><b>Nome: </b>{{ message.sender_name }}</p>
                        </div>
                        <div class="mail flex items-center">
                            <font-awesome-icon
                                :icon="['fas', 'circle-user']"
                                style="
                                    color: rgb(254 91 95 / 78%);
                                    padding-right: 9px;
                                "
                            />
                            <p><b>Email: </b>{{ message.sender_email }}</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
@import "../../../scss/app.scss";
.main-container {
    width: 65%;
    margin: 60px auto;
}

h1 {
    font-size: 35px;
    padding: 50px 0px;
}

.utente {
    padding: 50px 0px;
    border-bottom: 1px solid #fe5b5f;
}
</style>
