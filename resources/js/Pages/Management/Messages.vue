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
    data() {
        return {
        };
    },
};
</script>

<template>
    <Head>
        <title>
            Messaggi - BoolBnB
        </title>
        <link rel="icon" href="/favicon.svg" />
    </Head>

    <AuthenticatedLayout>
        <div class="main-container w-[65%] mt-[60px] mx-auto pb-[100px]">

            <h1 class="pt-[50px] text-[25px]">I tuoi messaggi:</h1>
            <ul class=" overflow-y-auto h-[60vh] my-[70px]" >
                <li v-for="message in messages" class="pe-[50px]">
                    <div class="utente py-[50px] border-b border-mainColor-300">
                        <div class="appartamento flex items-center">
                            <font-awesome-icon :icon="['fas', 'house-chimney']" style="
                                    color: rgb(254 91 95 / 78%);
                                    padding-right: 9px;
                                " />
                            <p><b>Appartamento: </b>{{ message.title }}</p>
                        </div>
                        <div class="nome flex items-center">
                            <font-awesome-icon :icon="['fas', 'circle-user']" style="
                                    color: rgb(254 91 95 / 78%);
                                    padding-right: 9px;
                                " />
                            <p><b>Nome: </b>{{ message.sender_name }}</p>
                        </div>
                        <div class="mail flex items-center mb-[3px]">
                            <font-awesome-icon :icon="['far', 'envelope']" style="
                                    color: rgb(254 91 95 / 78%);
                                    padding-right: 9px;
                                " />
                            <p><b>Email: </b>{{ message.sender_email }}</p>
                        </div>
                        <div class="mail flex" style="align-items: baseline">
                            <font-awesome-icon :icon="['far', 'message']" style="
                                    color: rgb(254 91 95 / 78%);
                                    padding-right: 9px;
                                " />
                            <p><b>Messaggio: </b>{{ message.content }}</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
</style>
