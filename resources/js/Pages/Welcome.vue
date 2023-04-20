<script>
import AppHeader from "../Components/MyComponents/AppHeader.vue";
import AppFooter from "../Components/MyComponents/AppFooter.vue";

export default {
    name: "App",
    components: {
        AppHeader,
        AppFooter,
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
                class="card h-[440px] w-[300px]"
            >
                <div class="image w-full">
                    <img
                        :src="apartment.full_cover_img_path"
                        alt="immagine casa"
                        class="w-full h-full object-cover rounded-t-2xl"
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
            </div>
        </div>
    </div>
    <AppFooter />
</template>

<style scoped lang="scss">
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
