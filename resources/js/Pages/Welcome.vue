<script>
import AppHeader from "../Components/MyComponents/AppHeader.vue";
import AppFooter from "../Components/MyComponents/AppFooter.vue";
import { Link } from '@inertiajs/vue3';

export default {
    name: "App",
    components: {
        AppHeader,
        AppFooter,
        Link
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        apartments: Array,
    },
};
</script>

<template>
    <AppHeader :canLogin="canLogin" :canRegister="canRegister" />
    <div class="container-main">
        <div
            class="container-cards justify-items-center h-full overflow-y-scroll py-10 grid 2xl:grid-cols-5 lg:grid-cols-3 md:grid-cols-2 sm:grid-col-1 gap-10"
        >
            <div
                v-for="apartment in apartments"
                class="card w-[300px]"
            >
                <div class="image w-full">
                    <img
                        :src="apartment.full_cover_img_path"
                        alt="immagine casa"
                        class="w-full h-20 object-cover rounded-t-2xl"
                    />
                </div>
                <div
                    class="card-info h-[130px] px-4 flex flex-col justify-evenly"
                >
                    <div>
                        <span>
                            <b>{{ apartment.title }}</b>
                        </span>
                    </div>
                    <div>tante belle info here</div>
                    <div>
                        tante belle altre info here
                        <span> ⭐ 4,8 </span>
                    </div>
                </div>
        <Link :href="route('guest_show', apartment.title_slug)" class="mt-8 px-4 py-2 rounded-full button text-white">
            Vedi appartamento
        </Link>
            </div>
        </div>
    </div>
    <AppFooter />
</template>

<style scoped lang="scss">
@import "../../scss/app.scss";
.button {
    background-color: $main-color;
  }
.container-main {
    height: calc(100vh - 100px);
    background-color: #f1f1f1;
    .card {
        background-color: #ffffff;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease-in-out;

        img {
            aspect-ratio: 1/1;
            width: 100%;
            object-fit: cover;
        }
    }
}
.card:hover {
    @apply hover:shadow-lg;
    @apply hover:shadow-lg hover:scale-105;
}
</style>
