<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    firstname: "",
    surname: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="firstname" value="Nome" />

                <TextInput id="firstname" type="text" class="mt-1 block w-full" v-model="form.firstname" autofocus
                    autocomplete="firstname" />

                <InputError class="mt-2" :message="form.errors.firstname" />
            </div>

            <div class="mt-4">
                <InputLabel for="surname" value="Cognome" />

                <TextInput id="surname" type="text" class="mt-1 block w-full" v-model="form.surname" autofocus
                    autocomplete="surname" />

                <InputError class="mt-2" :message="form.errors.surname" />
            </div>

            <div class="mt-4">
                <InputLabel for="birthday" value="Data di Nascita" />

                <TextInput id="birthday" type="date" class="mt-1 block w-full" v-model="form.birthday" autofocus
                    autocomplete="birthday" />

                <InputError class="mt-2" :message="form.errors.birthday" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email*" />

                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                    autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password*" />

                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="new-password" />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Conferma Password*" />

                <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                    v-model="form.password_confirmation" required autocomplete="new-password" />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <p class="text-sm mt-2">*Tutti i campi contrassegnati con l'asterisco sono obbligatori</p>


            <div class="flex flex-col items-center justify-end mt-3">
                <PrimaryButton
                    class="rounded-e-full rounded-s-full flex pink items-center justify-center w-40 px-4 py-2 mt-4 text-sm font-medium text-white transition duration-150 ease-in-out border border-transparent rounded-md group focus:outline-none focus:shadow-outline-pink disabled:opacity-50"
                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrati
                </PrimaryButton>

                <Link :href="route('login')"
                    class="mt-4 text-pink underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Già registrato?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>

<style scoped>
.text-pink {
    color: #fe5b5f;
}

.pink {
    background-color: #fe5b5f;
}

[type="text"]:focus,
[type="email"]:focus,
[type="url"]:focus,
[type="password"]:focus,
[type="number"]:focus,
[type="date"]:focus,
[type="datetime-local"]:focus,
[type="month"]:focus,
[type="search"]:focus,
[type="tel"]:focus,
[type="time"]:focus,
[type="week"]:focus,
[multiple]:focus,
textarea:focus,
select:focus {
    --tw-ring-color: #fe5b5f;
    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) rgb(254 91 95);
    border-color: #fe5b5f;
}
</style>
